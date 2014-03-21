<?php

function left($str, $length) {
    return substr($str, 0, $length);
}

function right($string, $count) {
    $string = substr($string, -$count, $count);
    return $string;
}

function strpos_arr($haystack, $needle) {
    if (!is_array($needle))
        $needle = array($needle);
    foreach ($needle as $what) {
        if (($pos = stripos($haystack, $what)) !== false)
            return $pos;
    }
    return false;
}

function httpGet($url, $followRedirects = true) {
    $curl = curl_init();

    // Setup headers - I used the same headers from Firefox version 2.0.0.6
    // below was split up because php.net said the line was too long. :/
    $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
    $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: close";
//  $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // browsers keep this blank.

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    $html = curl_exec($curl); // execute the curl command
    curl_close($curl); // close the connection

    return $html; // and finally, return $html
}

//a
/* function _httpGet($url, $followRedirects=true) {
  global $final_url;
  $url_parsed = @parse_url($url);
  if (empty($url_parsed['scheme'])) {
  $url_parsed = @parse_url('http://' . $url);
  }
  $final_url = $url_parsed;

  //$port = $url_parsed["port"];
  //if (!$port) {
  $port = 80;
  //}
  $rtn['url']['port'] = $port;
  $path = $url_parsed["path"];
  if (empty($path)) {
  $path = "/";
  }
  if (!empty($url_parsed["query"])) {
  $path .= "?" . $url_parsed["query"];
  }
  $rtn['url']['path'] = $path;
  $host = $url_parsed["host"];
  $foundBody = false;
  $out = "GET $path HTTP/1.0\r\n";
  $out .= "Host: $host\r\n";
  $out .= "User-Agent:      Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
  $out .= "Connection: Close\r\n\r\n";

  if (!$fp = @fsockopen($host, $port, $errno, $errstr, 30)) {
  $rtn['errornumber'] = $errno;
  $rtn['errorstring'] = $errstr;
  return '';
  } else {
  fwrite($fp, $out);
  $start = microtime(true);
  $body='';
  $timeout = ini_get('default_socket_timeout');
  while (!feof($fp) && (microtime(true) - $start) < $timeout) {
  $s = @fgets($fp, 128);
  if ($s == "\r\n") {
  $foundBody = true;
  continue;
  }
  if ($foundBody) {
  $body .= $s;
  } else {
  if (($followRedirects) && (stristr($s, "location:") != false)) {
  $redirect = preg_replace("/location:/i", "", $s);
  fclose($fp);
  return httpGet(trim($redirect));
  break;
  }

  }
  }
  fclose($fp);
  return(trim($body));
  }
  }
 */
function rem_Entities($str) {
    if (substr_count($str, '&') && substr_count($str, ';')) {
        $amp_pos = strpos($str, '&');
        $semi_pos = strpos($str, ';');
        if ($semi_pos > $amp_pos) {
            $tmp = substr($str, 0, $amp_pos);
            $tmp = $tmp . substr($str, $semi_pos + 1, strlen($str));
            $str = $tmp;
            if (substr_count($str, '&') && substr_count($str, ';'))
                $str = rem_Entities($tmp);
        }
    }
    return $str;
}

function checkSpelling($sword) {
    /** SPELL CHECK FROM DATABASE * */
    $spellq = "SELECT corrected FROM spelling WHERE word_in = '$sword'";
    $spellresult = mysql_query($spellq) or trigger_error(mysql_error() . " in $spqellq", E_USER_ERROR);
    if (mysql_num_rows($spellresult) > 0) {
        $row = mysql_fetch_row($spellresult);
        $corrected = $row[0];
        return $corrected;
    }

    $wordnik = '';
    $req = rawurlencode($sword);
    $c = count(explode(" ", $sword));
    if ($c > 1) {
        /** SPELL CHECK WORDNIK * */
        $url = "API";
        $response = httpGet($url);
        $xmlObj = simplexml_load_string($response);
        $arrXml = objectsIntoArray($xmlObj);
        if (isset($arrXml['suggestions']['suggestion'])) {
            $wordnik = $arrXml['suggestions']['suggestion'];
        }
    }

    if ($wordnik == '') {
        /** SPELL CHECK GOOGLE* */
        $url = "API";
        $text = httpGet($url);
        $text = strip_tags($text);
        $text = rem_Entities($text);
        $pos = stripos($text, 'Did you mean:');
        if ($pos !== false) {
            $text = substr($text, $pos);
            $pos = stripos($text, '&nbsp;');
            $text = left($text, $pos);
            $text = substr($text, 14);
            $req = $text;
        } else {
            $pos = stripos($text, 'Showing results for');
            if ($pos !== false) {
                $text = substr($text, $pos);
                $pos = stripos($text, '.');
                $text = left($text, $pos);
                $text = trim(substr($text, 19));
                $req = $text;
            } else {
                $req = $sword;
            }
        }
    }
    $req = urldecode($req);
    $spellq = "INSERT INTO spelling VALUES ('$sword','$req')";
    mysql_query($spellq) or trigger_error(mysql_error() . " in $spqellq", E_USER_ERROR);
    return $req;
}

function objectsIntoArray($arrObjData, $arrSkipIndices = array()) {
    $arrData = array();
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}

function normalize($toClean) {

    setlocale(LC_CTYPE, 'de_DE.UTF-8');
    $input_encoding = mb_detect_encoding($toClean);


    $encoded = @iconv($input_encoding, 'ASCII//IGNORE//TRANSLIT', $toClean);

    if ($encoded !== false)
        return $encoded;
    else
        return $toClean;
}

function clean($string) {

    $string = str_replace("&#146;", "'", $string);
    $string = str_replace("&#39;", "'", $string);
    $string = str_replace("&nbsp;&nbsp;", "&nbsp;", $string);
    $string = str_replace("&nbsp;", " ", $string);
    $string = str_replace("&#x27;", "'", $string);

    $string = str_replace("\t", " ", $string);
    $string = str_replace("  ", " ", $string);
    $string = str_replace("\n\n", "\n", $string);
    $string = preg_replace("`\n\s*\n`", "\n", $string);

    $string = preg_replace("~\(\s*\)~", "", $string);
    $string = str_replace("(,", "(", $string);
    $string = str_replace("( ,", "(", $string);
    $string = str_replace("(;", "(", $string);

    $string = str_replace("\n ", "\n", $string);
    $string = str_replace("( ;", "(", $string);
    $string = preg_replace("~,\s*\)~", ")", $string);
    $string = str_replace(", ,", ",", $string);

    $string = str_replace("LINK::", "", $string);
    $string = str_replace("LINK:", "", $string);

    preg_match_all("~\([^\w]+\)~", $string, $match);
    foreach ($match[0] as $m)
        $string = str_replace($m, "", $string);
    return $string;
}

/* FUNCTION FOR FORMATTING MEDIAWIKI OUTPUT */

function getLinks($mwiki_text) {
    global $query_id;
    global $list_opt;
    global $addon;
    $output = $mwiki_text;
    $has_options = false;
    //Lists
    preg_match_all("|[*]([^\n]*)|", $output, $matches);

    $options = array();
    $i = 1; //$list_opt;
    foreach ($matches[1] as $index => $li) {
        unset($links);
        if (stripos($li, 'LINK:') !== false) {
            preg_match_all("|LINK:([^:]*):([^:]+):|", $li, $links, PREG_SET_ORDER);
            $link = $links[0];

            $has_options = true;
            //Replace * by numbers
            $li_new = preg_replace("|\*\s?(\w)|", $i . ". $1", $matches[0][$index], 1);
            $output = str_replace($matches[0][$index], $li_new, $output, $c);

            //ADD OPTION
            $the_page = ( $link[1] == "" ) ? $link[2] : $link[1];
            $the_page = str_replace(" ", "_", $the_page);
            $query = "INSERT INTO lists (sender,number,page,type,query_id) VALUES ('" . $_GET['MN'] . "','$i','" . addslashes($the_page) . "','mwiki','$query_id')";
            mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
            $addon = "";
            //Replace links
            /*
              Array
              (
              [0] => LINK:Public_limited_company#Share_capital:share warrant:
              [1] => Public_limited_company#Share_capital
              [2] => share warrant
              )
             */
            $replacement = $link[2];
            $output = str_replace($link[0], $replacement, $output);
        }
        $i++;
    }

    //Replace Links
    if (preg_match_all("~LINK:([^:]*):([^:]+):~m", $output, $links, PREG_SET_ORDER)) { //LINK:([#\w\s\)\(_\&.,!'-]*):([#\w\s\)\(_\.&,!'-]+):
        foreach ($links as $link) {
            $output = str_replace($link[0], $link[2], $output);
        }
    }
    if ($has_options)
        $output = "Type the option you wish to select & reply e.g. 1\n" . $output;
    return $output;
}

?>