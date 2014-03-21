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

function kript($num, $id, $sep = 'c') {
    if (strlen($num) < 10 || !is_numeric($num))
        $num = '6666666666';
    $convertedstr = ($num - $id) - 5555555555;
    $convertedstr = $convertedstr . $sep . $id;
    return $convertedstr;
}

function dkript($str) {
    $ret = array();
    $pos = stripos($str, "c");
    if ($pos === false) {
        $rev = substr($str, 0, stripos($str, "d"));
        $ret["image"] = $revid = substr($str, stripos($str, "d") + 1);
        $ret["mobile"] = $rev + 5555555555 + $revid;
        $ret["opr"] = 'docomo';
    } else {
        $rev = substr($str, 0, stripos($str, "c"));
        $ret["image"] = $revid = substr($str, stripos($str, "c") + 1);
        $ret["mobile"] = $rev + 5555555555 + $revid;
        $ret["opr"] = 'airtel';
    }
    return $ret;
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
    $header[] = "Accept-Charset: ISO-8859-1;q=0.7,*;q=0.7";    //ISO-8859-1
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // browsers keep this blank.

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);

    $html = curl_exec($curl); // execute the curl command
    if (curl_error($curl)) {
        trigger_error(curl_error($curl), E_USER_WARNING);
    }
    curl_close($curl); // close the connection
    return $html; // and finally, return $html
}

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

function checkSpelling2($sword) {
    $sword = trim($sword);
    $corrected = $sword;
    if (preg_match("~([\w]+)\b~U", $sword, $matches)) {
        $key = $matches[1];
    } else {
        $key = '';
    }
    echo "<br>Matched Keyword : $key";
    if ($sword == 'cri' || $sword == 'score' || $sword == 'live score' || $sword == 'chat' || $sword == 'help' || is_numeric($sword) || substr($sword, 0, 1) == '@' || substr($sword, 0, 1) == '#' || in_array($key, array('train', 'fc', 'tran', 'love', 'flame', 'flames', 'gc', 'tc', 'expand', 'trace', 'friend'))) {
        echo "<br>Spellcheck Skiped<br>";
        return $sword;
    }
    $spellq = "SELECT corrected FROM spelling WHERE word_in = '" . mysql_real_escape_string($sword) . "'";
    $spellresult = mysql_query($spellq) or trigger_error(mysql_error() . " in $spqellq", E_USER_ERROR);
    if (mysql_num_rows($spellresult) > 0) {
        $row = mysql_fetch_row($spellresult);
        $corrected = $row[0];
        return $corrected;
    }

    echo "<h2><br>GOOGLE NOT WORKING</h2>";
    /** SPELL CHECK BING * */
    $url = "API";
    $text = httpGet($url);
    //    echo "$text\n";
    echo"<br>Spell Check BING<br>";
    $pl = xml_parser_create();
    $xmlObj = xml_parse_into_struct($pl, $text, $vals, $index);
    xml_parser_free($pl);
    print_r($vals);
    foreach ($vals as $key => $item) {
        if ($item['tag'] == "SPL:VALUE") {
            $match = $key;
        }
    }
    if (isset($match) && isset($vals[$match]['value']) && $vals[$match]['value']) {
        echo "<br>..corrected match : " . $vals[$match]['value'] . "<br>";
        $corrected = strtolower($vals[$match]['value']);
    }
    else
        $corrected = strtolower($sword);
//    }

    $spellq = "INSERT IGNORE INTO spelling VALUES ('" . mysql_real_escape_string($sword) . "','" . mysql_real_escape_string($corrected) . "')";
    mysql_query($spellq) or trigger_error(mysql_error() . " in $spqellq", E_USER_ERROR);

    echo "<br>SPELL CHECKED RETURNING: $corrected<br>";

    return $corrected;
}

function checkSpelling($sword) {
    global $google_results;
    $sword = trim($sword);
    $corrected = $sword;
    global $is_ussd;
    if (preg_match("~([\w]+)\b~U", $sword, $matches)) {
        $key = $matches[1];
    } else {
        $key = '';
    }
    echo "<br>Matched Keyword : $key";
    if ($is_ussd || $sword == 'cri' || $sword == 'score' || $sword == 'live score' || $sword == 'chat' || $sword == 'help' || is_numeric($sword) || substr($sword, 0, 1) == '@' || substr($sword, 0, 1) == '#' || in_array($key, array('train', 'fc', 'tran', 'love', 'flame', 'flames', 'gc', 'tc', 'expand', 'trace', 'friend', 'bse', 'obse', 'chse'))) {
        echo "<br>Spellcheck Skiped<br>";
        return $sword;
    }


    $spellq = "SELECT corrected FROM spelling WHERE word_in = '" . mysql_real_escape_string($sword) . "'";
    $spellresult = mysql_query($spellq) or trigger_error(mysql_error() . " in $spqellq", E_USER_ERROR);
    if (mysql_num_rows($spellresult) > 0) {
        $row = mysql_fetch_row($spellresult);
        var_dump($row);
        $corrected = html_entity_decode($row[0]);
        echo "Spelling From Db";
        if (strpos($corrected, 'Including results for') !== false) {

            $corrected = trim(str_replace('Including results for', '', $corrected));

            echo $spellq = "update spelling set corrected='" . mysql_real_escape_string($corrected) . "' where word_in = '" . mysql_real_escape_string($sword) . "'";
            mysql_query($spellq) or trigger_error(mysql_error() . " in $spqellq", E_USER_ERROR);

            echo "Exexuted Succesfuly";
        }
        $isspellnew = 0;
    } else {

        $scrap_ips = array('IP');
        $rnd = rand(0, count($scrap_ips) - 1);
        echo $url = "http://$scrap_ips[$rnd]/scraper/ggle.php?q=" . urlencode($sword);
        $data = file_get_contents($url);
        if ($data == 'NULL') {
            $query = "insert ignore into ip_blocked(ip,url) values('$scrap_ips[$rnd]','" . mysql_real_escape_string($url) . "')";
            mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            $corrected = $sword;
        } else {
            $google_results = $out = json_decode(trim($data), TRUE);
            echo "<br>SPELL OUT <br>";
            var_dump($out);
            if ($out['s']) {
                $corrected = $out['s'];
                $spellq = "INSERT IGNORE INTO spelling VALUES ('" . mysql_real_escape_string($sword) . "','" . mysql_real_escape_string($corrected) . "')";
                mysql_query($spellq) or trigger_error(mysql_error() . " in $spqellq", E_USER_ERROR);
            }
        }
        echo "<br>SPELL CHECKED RETURNING: $corrected<br>";
        $isspellnew = 1;
    }

    echo "<br>SPELL CHECKED RETURNING 2: $corrected<br>";
    return $corrected;
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

    $encoded = $toClean;
    while (stripos($encoded, "  ") !== false) {
        $encoded = str_replace("  ", " ", $encoded);
    }
    $encoded = str_replace("' '", "", $encoded);
    $encoded = str_replace("( )", "", $encoded);
    $encoded = str_replace("{{", "", $encoded);
    $encoded = str_replace("}}", "", $encoded);
    if (left($encoded, 1) == ":") {
        $encoded = substr($encoded, 2);
    }
    $input_encoding = iconv_get_encoding();
    $encoded = iconv($input_encoding['input_encoding'], 'ASCII//IGNORE', $encoded); //ISO-8859-1
    if ($encoded !== false)
        return $encoded;
    else
        return $encoded;
}

function clean($string) {
    if (!(stripos($string, "CHACHA NEHRU") !== false))
        $string = str_ireplace("chacha", "", $string);
    $string = preg_replace("~\b&?quot;?\b~", "'", $string);
    $string = str_replace("&#146;", "'", $string);
    $string = str_replace("&#39;", "'", $string);
    $string = str_replace("&#8212;", "-", $string);
    $string = str_replace("&raquo;", "", $string);
    $string = str_replace("&nbsp;", " ", $string);
    $string = str_replace("&#x27;", "'", $string);
    $string = str_replace("&ndash", "-", $string);
    $string = str_replace("&241;", "n", $string);

    $string = preg_replace("~'{2,}~", "'", $string);

    $string = str_replace(":(", ": ( ", $string);
    $string = str_replace(":)", ": )", $string);

    $string = str_replace("\t", " ", $string);
    while (stripos($string, "  ") !== false) {
        $string = str_replace("  ", " ", $string);
    }

    $string = str_replace("\n\n", "\n", $string);
    $string = preg_replace("`\n\s*\n`", "\n", $string);

    $string = preg_replace("~\(\s*\)~", "", $string);
    $string = str_replace("( ", "(", $string);
    $string = str_replace("(,", "(", $string);
    $string = str_replace("(;", "(", $string);
    $string = str_replace("\"'", "'", $string);
    $string = str_replace("'\"", "'", $string);
    $string = str_replace(" )", ")", $string);

    $string = preg_replace("~,\s*\)~", ")", $string);
    $string = preg_replace("~,\s*,~", ",", $string);

    $string = str_replace("LINK::", "", $string);
    $string = str_replace("LINK:", "", $string);

    preg_match_all("~\([^\w]+\)~", $string, $match);

    foreach ($match[0] as $m) {
        $string = str_replace($m, "", $string);
    }
    return $string;
}

/* Gets links from formatted Gyan Text */

function getLinks($mwiki_text) {
    global $query_id;
    global $list_opt;
    global $addon;
    global $options;
    global $direct;
    global $has_options;
    global $req;
    $output = $mwiki_text;

    //Lists
    preg_match_all("|[*]([^\n]*)|", $output, $matches);

    //$options = array();
    $i = count($options); //0;//$list_opt;
    foreach ($matches[1] as $index => $li) {
        unset($links);
        if (stripos($li, 'LINK:') !== false && $direct === true) {
            if (preg_match_all("|LINK:([^:]*):([^:]+):|", $li, $links, PREG_SET_ORDER)) {
                $link = $links[0];
                $has_options = true;
                //Replace * by numbers
                $i++;
                $li_new = preg_replace("|\*+\s?(.*)|", "$i: $1", $matches[0][$index], 1);
                $output = str_replace($matches[0][$index], $li_new, $output, $c);

                //ADD OPTION
                $the_page = ( $link[1] == "" ) ? $link[2] : $link[1];
                //$the_page = str_replace(" ", "_", $the_page);


                $options[] = array("count" => $i, "content" => $the_page, "type" => 'wiki');

                //$addon = "";
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
        } else {
            $li_new = preg_replace("|\*+\s?(.*)|", "- $1", $matches[0][$index], 1);
            $output = str_replace($matches[0][$index], $li_new, $output, $c);
        }
    }

    if (preg_match_all("~LINK:([^:]*):([^:]+):~U", $output, $links, PREG_SET_ORDER)) { //LINK:([#\w\s\)\(_\&.,!'-]*):([#\w\s\)\(_\.&,!'-]+):
        foreach ($links as $link) {
            $output = str_replace($link[0], $link[2], $output);
        }
    }
    return $output;
}

function getLinksNew($mwiki_text) {
    global $options;
    global $options_l;
    global $direct;
    global $has_options;
    global $to_logserver;

    if ($to_logserver['source'] == "wiki" || $to_logserver['source'] == "wiki_ext" || $to_logserver['source'] == "wans") {
        echo "Inside getLink function";
        $output = $mwiki_text;

        //Lists
        echo "Before " . $output;

        preg_match_all("|[*]([^\n]*)|", $output, $matches);

        //$options = array();
        $i = count($options); //0;//$list_opt;
        foreach ($matches[1] as $index => $li) {
            unset($links);
            echo "<br>$li<br>";
            if (stripos($li, 'LINK:') !== false && $direct === true) {
                if (preg_match_all("|LINK:([^:]*):([^:]+):|", $li, $links, PREG_SET_ORDER)) {
                    $link = $links[0];
                    $has_options = true;
                    //Replace * by numbers
                    $i++;
                    $li_new = preg_replace("|\*+\s?(.*)|", "$i: $1", $matches[0][$index], 1);
                    $output = str_replace($matches[0][$index], $li_new, $output, $c);
                    echo "After0 " . $output;
                    //ADD OPTION
                    $the_page = ( $link[1] == "" ) ? $link[2] : $link[1];
                    //$the_page = str_replace(" ", "_", $the_page);

                    $options[] = $the_page;
                    $options_l[] = array("count" => $i, "content" => $the_page, "type" => 'wiki');

                    //$addon = "";
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
            } else {
                $li_new = preg_replace("|\*+\s?(.*)|", "$1", $matches[0][$index], 1);
                $output = str_replace($matches[0][$index], $li_new, $output, $c);
            }
        }

        if ($has_options == true)
            $output = "Matching following results";

        //Replace Links
        if (preg_match_all("~LINK:([^:]*):([^:]+):~U", $output, $links, PREG_SET_ORDER)) { //LINK:([#\w\s\)\(_\&.,!'-]*):([#\w\s\)\(_\.&,!'-]+):
            foreach ($links as $link) {
                $output = str_replace($link[0], $link[2], $output);
            }
        }

        if (stripos($output, '321*552#') !== false) {
            $output = str_replace("321*552#", "*321*552#", $output);
        }

        $arData["result"] = $output;
        $arData["list"] = $options_l;
        $arData["options"] = $options;
    } else {
        $arData["result"] = $mwiki_text;
    }
    return $arData;
}

/**
 * Searches bing
 * @param <type> $query
 * @param <type> $count no of results
 * @param <type> $source web,spell,news
 * @return array titles, urls
 */
function bing_search($query, $count = 10, $source = "web") {
    $query = urlencode($query);
    $source = urlencode($source);
    $search_results['titles'] = array();
    $search_results['urls'] = array();

    $url = 'API';
    echo "$url";
    $content = httpGet($url);

    $pl = xml_parser_create();
    $xmlObj = xml_parse_into_struct($pl, $content, $vals, $index);
    xml_parser_free($pl);
    foreach ($vals as $items) {
        if ($items['tag'] == "WEB:TITLE") {
            $search_results['titles'][] = $items['value'];
        } else if ($items['tag'] == 'WEB:URL') {
            $search_results['urls'][] = $items['value'];
        }
    }
    return($search_results);
}

//Profanity Filter

function SafeSearch($string) {
    echo "<h3>Safe search</h3>";
    require_once 'binary_search.php';
    $tree = new BinarySearch('safesearch', 'words', 1);

    $split = preg_split("~[\n,. ]+~", $string);
    print_r($split);
    foreach ($split as $key => $wrd) {
        $searchword = $tree->search($wrd, 1);
        if (!empty($searchword))
            $string = str_replace(trim($searchword), '', $string);
    }
    echo $string;

    return $string;
}

function matchdate($string) {
    echo "<br> $string";
    $string = str_ireplace("\\", "/", $string);
    $return_array[0] = $string;
    $isfound = false;
    $count = 0;

    while (!$isfound && $count < 2) {
        if ($count == 1)
            $string = checkSpelling($string);
        $count +=1;
        $isweekname = false;
        if (preg_match("~([ ,.]on[ ,.])?([12][0-9]|3[01]|0?[1-9])[- /.](1[012]|0?[1-9])[- /.](\d{4})~", $string, $match)) {
            $matched = "$match[3]/$match[2]/$match[4]";
        } elseif (preg_match("~([ ,.]on[ ,.])?(1[012]|0?[1-9])[- /.]([12][0-9]|3[01]|0?[1-9])[- /.](\d{4})~", $string, $match)) {
            $matched = "$match[2]/$match[3]/$match[4]";
        } elseif (preg_match("~([ ,.]on[ ,.])?([12][0-9]|3[01]|0?[1-9])(rd|th|st|nd|)? ?(of)? ?(january|jan|february|feb|march|mar|april|apr|may|june?|july?|august|aug|september|sep|october|oct|november|nov|december|dec)[ ,.]*(\d{4})?~", $string, $match)) {
            $matched = "$match[2] $match[5]";
            if (isset($match[6])) {
                $matched .= " $match[6]";
            }
        } elseif (preg_match("~([ ,.]on[ ,.])?(january|jan|february|feb|march|mar|april|apr|may|june?|july?|august|aug|september|sep|october|oct|november|nov|december|dec) ?([12][0-9]|3[01]|0?[1-9])(rd|th|st|nd|)?[ ,.]*(\d{4})?~", $string, $match)) {
            $matched = "$match[3] $match[2]";
            if (isset($match[5])) {
                $matched .= " $match[5]";
            }
        } elseif (preg_match("~([ ,.]on[ ,.])?(today|tomorrow|day after tomorrow|next week|this week|monday|tuesday|wednesday|thursday|friday|saturday|sunday) ?~", $string, $match)) {
            $matched = "$match[2]";
            $isweekname = true;
        }

        if (isset($match[0])) {
            $isfound = true;
            $return_array[0] = str_replace($match[0], '', $string);
            $return_array[1] = $match[0];
            $return_array[2] = strtotime($matched);
            if ($return_array[2] < strtotime("today") && $isweekname) {
                $return_array[2] += 604800; //60 * 60 * 24 * 7;
            }
            echo '<br><b>' . date('F j, Y', strtotime($matched)) . '</b>';
        }
    }
    echo "<br>";
    return $return_array;
}

function matchtime($string) {
    echo "<br> $string";
    $string = str_ireplace("\\", "/", $string);
    $return_array[0] = $string;
    $isfound = false;
    $count = 0;

    while (!$isfound && $count < 2) {
        if ($count == 1)
            $string = checkSpelling($string);
        $count +=1;

        if (preg_match("~((\d{1,2})([ :.,-/](\d{1,2}))? ?(am|pm)?)~", $string, $match)) {
            $matched = $match[2];
            if ($match[4] == '') {
                $matched .= ":00";
            } else if (strlen($match[4]) == 1) {
                $matched .= ":0$match[4]";
            } else {
                $matched .= ":$match[4]";
            }
            if ($match[5] == '') {
                if ($match[2] < 10 && date('H') > 11) {
                    $matched .= ' pm';
                }
            } else {
                $matched .= " $match[5]";
            }
            echo $matched;
            $isfound = true;
            $return_array[0] = str_replace($match[0], '', $string);
            $return_array[1] = $match[0];
            $return_array[2] = strtotime($matched);
            echo '<br><b>' . date('h:i A', strtotime($matched)) . '</b>';
        }
    }
    echo "<br>";
    return $return_array;
}

function remcity($string) {
    if (strlen($string) > 0) {
        $words = explode(' ', $string);
        $orcond = "city_name = '" . $words[0] . "'";
        for ($i = 1; $i < count($words); $i++) {
            $orcond .= " or city_name = '" . $words[$i] . "'";
        }
        echo $query = "select city_name from citylist where $orcond";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_array($result)) {
                $string = str_replace(strtolower($row['city_name']), '', $string);
                echo "<br>city Removed:" . $row['city_name'];
            }
        }
    }
    return $string;
}

function put_file_contents($file, $data, $max = 5000000) {
    clearstatcache();
    $file_size = filesize($file);
    if ($file_size >= $max) {
        $info = pathinfo($file);
        $file_name = basename($file, '.' . $info['extension']);
        $new_name = dirname($file) . "/" . $file . "." . time();
        $ren = rename($file, $new_name);
    }
    file_put_contents($file, $data, FILE_APPEND);
}

function adscript() {
    global $circle_short, $operator, $userid;
    global $circle_state;
    global $shortcode;
    global $isemp, $isblacklisted, $operator;
    global $add_below;
    global $count_script, $charge_currency, $charge_per_query, $blockINDSpec;  

    if ($isblacklisted == 0 && $operator != 'wapapi' && $isemp != 1 && $circle_short != 'DL') {
        if (empty($add_below)) {
            $script = apc_fetch($cachekey, $success);
//            var_dump($script_data);
//            $script = json_decode($script_data, TRUE);
            if (!$success) {
                unset($script);
                $query = "select * from $tbl";
                $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                while ($row = mysql_fetch_array($result)) {
                    $script[] = $row['script'];
                }
                $count_script = 0;
//                echo "<h2>count of array<h2>" . $count_script = count($script);
//                $script_data = json_encode($script);


                apc_store($cachekey, $script);
                echo "from DB";
            }
            echo $count_script = count($script) - 1;
            $rnd = rand(0, $count_script);
            $script = "\n--\n" . $script[$rnd];
            $script = str_replace('55444', $shortcode, $script);
            $script = str_replace('Re1.5', $charge_currency . $charge_per_query, $script);
            return $script;
        } else {
            return $add_below;
        }
    } else {
        return $add_below = '';
    }
//    }
//    return $script = "\n--\nTo know AIEEE result SMS AIEEE <your register number> <date of birth> as ddmmyyyy to $shortcode";
}

function srchstring_trim($mystring) {
    $words = explode(" ", $mystring);
    $ret = $words[0];
    for ($i = 1; $i < count($words); $i++) {
        if (strlen($words[$i - 1]) == 1 && strlen($words[$i]) == 1) {
            $ret .= $words[$i];
        } else {
            $ret .= " " . $words[$i];
        }
    }
    return $ret;
}

function existsCache($msisdn) {
    $success = FALSE;
    //deleting User data from cache
    $url = "http://IP/cache/exists.php?name=" . $msisdn;
    $content = file_get_contents($url);
    if ($content == "T") {
        $success = TRUE;
    }
    return $success;
}

function insertToCache($msisdn, $data, $seconds) {
    $success = false;
    
    $url = "http://IP/cache/write1.php";
    $fields_string = "name=" . $msisdn . "&data=" . urlencode($data) . "&ttl=$seconds";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content = curl_exec($ch);

    if ($content == "OK") {
        $success = TRUE;
    }
    return $success;
}

function getCacheData($msisdn) {

    //fetching User data from cache
    $url = "http://IP/cache/read.php?name=" . $msisdn;
    $content = file_get_contents($url);

    return $content;
}

function deleteCacheData($msisdn) {
    $success = FALSE;

    //deleting User data from cache
    $url = "http://IP/cache/delete.php?name=" . $msisdn;
    $content = file_get_contents($url);
    if ($content == "T") {
        $success = TRUE;
    }
    return $success;
}

function timeOutCheck($arData) {
    $current_time = date("Y-m-d H:i:s");
    if (!empty($arData)) {
        if (!empty($arData["q"])) {
            unset($arData);
            $arData["ca"] = $arData;
        } else {
            foreach ($arData as $id => $arValues) {
                if ($current_time > $arValues["expiry"]) {
                    unset($arData[$id]);
                }
            }
        }
    }
    return $arData;
}

function putOutput($reply) {
    global $query_id;
    global $chatBill;
    global $query_in;
    global $free, $circle;
    global $time_start;
    global $no_result_string;
    global $debug;
    global $charge_per_query;
    global $service_name;
    global $toLog;
    global $product_name_tag;
    global $to_logserver;
    global $cri_bill;
    global $wiki_output;
    global $operator;
    global $spcl_bill;
    global $api_response;
    global $isReturn, $isCampaing, $isAppSet, $isAppQuery, $isgmobi;
    global $add_below;
    global $arCacheData, $outPutType;
    global $current_folder;
    global $number, $chargeMT, $appStore, $prefixQuery;
    global $shortcode, $listAll;
    global $isEvernote;
    global $akosha;
    global $blockINDSpec;

    if (!$free && $to_logserver['isresult'] == 0) {
        $free = true;
    }


    $listAll["expiry"] = date("Y-m-d H:i:s", strtotime("+1 day"));

    $arCacheData["ls"] = $listAll;

    $reply = preg_replace("~\b(55444)\b~i", $shortcode, $reply);

    if ($operator == "dialog") {
        $reply = str_replace(" @Rs 2.449/query", "", $reply);
    }

    var_dump($arCacheData);

    if ($isEvernote) {
        $arCacheData["en"]["c"] = $reply;
        $arCacheData["en"]["expiry"] = date("Y-m-d H:i:s", strtotime("+1 day"));
    }

    if (insertToCache("ls" . $number, json_encode($arCacheData), "86400")) {
        echo "<br>Insertded To Cache\n";
    }

    $billable = 0;

    $time_output = microtime(true);
    $time = $time_output - $time_start;

    echo "<br>Output is" . $reply;
    $reply = normalize(clean(trim(clean(html_entity_decode($reply)))));
    echo "<br>Output is" . $reply;
    if (!preg_match("~[\w\d]+~", $reply)) {
        $reply = $no_result_string . $add_below;
    }

    if ($akosha && !$blockINDSpec) {
        $reply = $add_below;
    }

    $r_in = $reply;
    $numbs = $_GET["mobile"];
    $myid = "AUU";
    //Log
    $response_length = strlen($reply);

    $to_log = array("Qid" => $query_id, "T" => $time, "L" => $response_length, "R" => addslashes($reply), "TS" => time());
    $log = serialize($to_log);
    file_put_contents(LOG_DIR . "response.log", $log . "\n", FILE_APPEND);
    //Billing
    if ($r_in != $no_result_string && $free == false) {
        $billable = $charge_per_query;
        echo "<br>ADDING TO BILL_Q<bR>";
        var_dump($no_result_string);
        var_dump($free);
        var_dump($r_in);
        $ttime = microtime(true);
//        $query = 'INSERT INTO bill_queue (msisdn, query) VALUES ("' . $numbs . '","' . mysql_real_escape_string($query_in) . '")';
//        mysql_query($query) or trigger_error("Error in $query: " . mysql_error(), E_USER_ERROR);
        $ttime = microtime(true) - $ttime;
    } else {
        echo "<br>Not charged - $free<br>";
    }

    if ($operator != 'api' && $operator != 'wap' && $outPutType != "xml") {
        include_once 'ConvertCharset.class.php';

        echo '<br>Befor Conver: ' . $reply;
        $encoding_in = mb_detect_encoding($reply);
        if ($encoding_in != 'ASCII') {
            echo "<br> Not ASCII";
            $utf2gsm = new ConvertCharset($encoding_in, 'gsm0338');
            $reply = $utf2gsm->Convert($reply);
        }
    }

    if ($isAppQuery) {
        echo "<h3>APPQuery $isAppSet</h3>";
        $chargeMT = 0;
        $txnid = uniqid();
        
        if (!$isAppSet) {
            echo "<h3>PrefixSet in functions</h3>";
            $reply = $prefixQuery . " " . trim($reply);
            $reply = trim($reply);
        }
    }

    echo '<br>After Conver: ' . $reply;
    $tagtolog = '';
    foreach ($toLog as $key => $logdata) {
        $tagtolog .= "<$key>$logdata</$key>";
    }
    echo "<br><br>--------------------<br>";
//    if(strlen($reply) <= 465){
//        $reply .= "\n--\nHappy Xmas.";
//    }
    //----------TO LOG-------------------------------
    $time_output = microtime(true);
    $time = $time_output - $time_start;
    $to_logserver['rtime'] = $time;
    $log_json = urlencode(json_encode($to_logserver));
    
//    if (basename(dirname(__FILE__)) == 'test') {
    $ttime = microtime();
    $data = file_get_contents($log_url);
    $ttime = microtime() - $ttime;
    if (basename(dirname(__FILE__)) == 'test') {
        echo "<br>LOG TIME: $ttime";
    }
    if (!is_numeric($data)) {
        $query = "insert into log_buffer(log_data) values('" . mysql_real_escape_string(urldecode($log_json)) . "')";
        mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

        $data = mysql_insert_id();
    }
    if (($to_logserver['source'] == 'keyword' || $appStore) && $to_logserver['isresult'] == 1 && !$free) {
        $hashbill = $data;
    } else {
        $hashbill = '';
    }
    

    if ($debug) {
        ob_end_flush();
    } else {
        ob_end_clean();
    }

    
        $time_output = microtime(true);
        $time = $time_output - $time_start;
        $time_in = date("Y-m-d H:i:s", $time_start);
        echo "<pre><bill>$billable</bill><ubill>$spcl_bill</ubill><tolog>$tagtolog</tolog><time_in>$time_in</time_in><query_id>$query_id</query_id><response_time>$time</response_time><product_name>$product_name_tag</product_name><service>$service_name</service><must_bill>$hashbill</must_bill><cri_bill>$cri_bill</cri_bill><send>$isReturn</send><chargeMT>$chargeMT</chargeMT><chat_bill>$chatBill</chat_bill><innoz_response>$reply</innoz_response></pre>";
    

    if ($isAppQuery) {
        insertToAppLog($number, $query_in, $circle, $reply, $time, $query_id, $operator);
    }
    ob_start();

}

function getAllBingUrls($local_word) {

    $url = "http://IP/search?q=" . urlencode($local_word) . "&go=&qb=1&format=rss";
    $content = file_get_contents($url);

    $arXml = objectsIntoArray(simplexml_load_string($content));

    if (!empty($arXml["channel"]["item"])) {
        foreach ($arXml["channel"]["item"] as $value) {
            $arUrl[] = $value["link"];
        }
        $arUrls["url"] = $arUrl;
    }

    if (empty($arUrls["url"])) {
        echo "<h1>After BING RSS</h1>";
        echo $bing_url = "http://IP/search?q=" . urlencode($local_word) . "&mkt=en-in&go=&qs=n&sk=&form=QBLH&filt=all&cc=in";
        $data = file_get_contents($bing_url);
        $arUrls = $arUrl = array();
        $arUrls["content"] = $data;

        if (preg_match_all("~class=\"sb_meta\"><cite>(.+)</cite>~Usi", $data, $matches)) {
            foreach ($matches[1] as $url) {
                $url = strip_tags($url);
                $arUrl[] = "http://" . $url;
            }
            $arUrls["url"] = $arUrl;
        }
    }
    return $arUrls;
}

function getAllBingNews($local_word) {

    echo $bing_url = "http://www.bing.com/news/search?q=" . urlencode($local_word) . "&mkt=en-in&go=&qs=n&sk=&form=QBLH&filt=all&cc=in";
//    $data = file_get_contents($bing_url);
    $data = httpGet($bing_url);
    $arUrls = $arUrl = array();
    $arUrls["content"] = $data;

    if (preg_match_all("~<a href=\"(.+)\" h=\"ID=news,.+>~Usi", $data, $matches)) {
        foreach ($matches[1] as $url) {
            $url = strip_tags($url);
            $start = strpos($url, "\" class=\"");
            if ($start != false) {
                $url = substr($url, 0, $start);
            }
            if (preg_match("~^http://~si", $url)) {
                $url = substr($url, 0, strpos($url, "\""));
                $arUrl[] = $url;
            }
        }
        $arUrls["url"] = $arUrl;
    }
//    }
    return $arUrls;
}

function string_between($string, $start, $end) {
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return false;
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    if (strpos($string, $end)) {
        return substr($string, $ini, $len);
    } else {
        return false;
    }
}

function writetest($data) {
    file_put_contents("log/testwrite.log", date("Y-m-d H:i:s") . " " . $data . "\n", FILE_APPEND);
}

function getLocAPI($number, $valid = 43200) {


    echo $url = "http://IP/locationAPI/locate?msisdn=91$number&validity=$valid&address=true";
    $content = file_get_contents($url);

    $address = array();

    $data = json_decode($content, TRUE);
    //$data = objectsIntoArray($data);

    var_dump($data);

    if (isset($data['code'])) {
        $address["no"] = "Location for this msisdn could not be obtained right now";
    } else if (!empty($data)) {
        $address["msisdn"] = $data["msisdn"];
        $address["long"] = $data["long"];
        $address["lat"] = $data["lat"];
        if (!empty($data["address"])) {
            $address["state"] = $data["address"]["state"];
            $address["district"] = $data["address"]["district"];
            $address["city"] = $data["address"]["city"];
            $address["street"] = $data["address"]["street"];
            $address["info"] = $data["address"]["info"];
            $address["zip"] = $data["address"]["zip"];
        }
    }
    $log_data = date("Y-m-d H:i:s") . "," . $number . "," . serialize($address) . "\n";

    if (filesize("log/locapi.log") > 5000000) {
        $new_name = "log/locapi.log." . time();
        $ren = rename("log/locapi.log", $new_name);
    }
    file_put_contents("log/locapi.log", $log_data, FILE_APPEND);

    return $address;
}


function getNepaldetails($pdt_url) {

    $pdt_info = httpGet($pdt_url);
    echo "Inside Nepal Functions";
    if (preg_match('~<div id="idTab1" class="rte">(.+)</div>~Usi', $pdt_info, $info)) {
        echo "Inside Nepal Functions Preg Match";

        $details = $info[1];
        $details = trim(preg_replace("~[\s]+~", " ", $details));
        $details = str_replace('</tr>', "+++", $details);
        $details = str_replace('</td>', '***', $details);
        $details = strip_tags($details);
        $details = html_entity_decode($details);
        $details = trim(preg_replace("~[\s]+~", " ", $details));
        $details = str_replace('+++', "\n", $details);
        $details = str_replace('***', '', $details);
        $details = str_replace('\n\n', "\n", $details);
        $details = str_replace('\n ', "\n", $details);
        $details = clean($details);
    } else {
        $details = 'Sorry no details found for the product';
        $to_logserver['isresult'] = 0;
        $free = true;
    }
    return $details;
}

function getAppDB2Con() {
    //db connection
}

function insertToAppLog($msisdn, $query, $circle, $response, $fetchtime, $qid, $op) {
    $success = false;
    global $appQueryFrom;

    $url = "API";
    $fields_string = "s=$msisdn&q=" . urlencode($query) . "&r=" . urlencode($circle) . "&res=" . urlencode($response) . "&f=$fetchtime&qid=$qid&op=" . urlencode($op) . "&from=$appQueryFrom";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content = curl_exec($ch);

    if ($content == "OK") {
        $success = TRUE;
    }
    return $success;
}

function Push_q($con, $number, $circle, $operator, $msg, $bill = 0) {
    //inserting message to push q
    $q_p = "INSERT INTO `push_q`(`msisdn`, `circle`, `operator`, `response`,bill) VALUES ('$number','$circle','$operator','" . mysqli_real_escape_string($con, $msg) . "','$bill')";
    if (mysqli_query($con, $q_p)) {
        return true;
    }
    return false;
}

function recomndapp() {
    global $shortcode;
    $recapps = apc_fetch('recomnd', $success);
    if (!$success) {
        $content = file_get_contents('http://IP/feed/?post_type=apps&cat=26');

        if (preg_match_all('~<example><\!\[CDATA\[(.+)\]\]></example>~Usi', $content, $match)) {
            foreach ($match[1] as $value) {
                $recapps[] = trim($value);
            }
        }
        apc_store('recomnd', $recapps, 3600);
    }
    $count = count($recapps);
    $rand = rand(0, $count - 1);

    $recomnd = $recapps["$rand"];
    $recomnd = preg_replace('~\bsms\b~', 'SMS', $recomnd);
    $recomnd = preg_replace('~\b55444\b~', $shortcode, $recomnd);
    return $recomnd;
}

function writeToFile($machine, $current_file, $data) {
    $private_ip = array("IPs");

    $host = "http://" . $private_ip[$machine] . "/gyan/writeToFile.php";
    $fields_string = "path=" . urlencode($current_file) . "&data=" . urlencode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content = curl_exec($ch);
    return true;
}

function getGoogleNews($search) {
    echo $url = "http://IP/google/news.php?q=$search";
    $content = httpGet($url);
    $arUrls = array();
    $arUrls["url"] = json_decode($content);
//    if (preg_match_all('~<a href="/url\?q=(.+)&amp;.+>~Usi', $content, $matches)) {
////        var_dump($matches);
//        $arUrls["url"] = $matches[1];
//    }
    var_dump($arUrls);
    return $arUrls;
}

function setUserCountry($id) {
    global $user_country;
    if (empty($user_country)) {
        $user_country = $id;
    }
}

?>