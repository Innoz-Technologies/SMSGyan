<?php
error_reporting (E_ALL ^ E_NOTICE);

define('API_KEY','KEY');

class Wordnik {
	var $query;
	function __construct($word_in) {
		$this->query = $word_in;
	}
	function spellSuggest() {		
		$has_result = true;
		$search = rawurlencode($this->query);
		$url = "API";
		$response = httpGet($url);
		die($response);
		$xmlObj = simplexml_load_string($response);
		$arrXml = objectsIntoArray($xmlObj);
		print_r($arrXml);
		die();
		if ( isset($arrXml['suggestions']['suggestion']) ) {
			echo "Suggestion: ".$arrXml['suggestions']['suggestion'];
		} else {
			echo "No suggestions";
		}
	}
	function definition() {
		$search = rawurlencode($this->query);
		$url = "API";
		$response = httpGet($url);
		$xmlObj = simplexml_load_string($response);
		$arrXml = objectsIntoArray($xmlObj);
		//print_r($arrXml);
		//echo count($arrXml['definitions']); 
		if ( count($arrXml) > 0) {
		  if ( isset($arrXml['definition']['text']) ) {
			  echo $arrXml['definition']['text'];
		  } else {
			  foreach($arrXml['definition'] as $i => $definition) {
				  echo ($i+1).". ".$definition['text']."\n";
			  }
		  }
		}
	}
}

$wordnik = new Wordnik($_GET['q']);
$wordnik->spellSuggest();


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
function httpGet( $url, $followRedirects=true ) {
    global $final_url;
    $url_parsed = parse_url($url);
    if ( empty($url_parsed['scheme']) ) {
        $url_parsed = parse_url('http://'.$url);
    }
    $final_url = $url_parsed;

    $port = $url_parsed["port"];
    if ( !$port ) {
        $port = 80;
    }
    $rtn['url']['port'] = $port;
    $path = $url_parsed["path"];
    if ( empty($path) ) {
        $path="/";
    }
    if ( !empty($url_parsed["query"]) ) {
        $path .= "?".$url_parsed["query"];
    }
    $rtn['url']['path'] = $path;
    $host = $url_parsed["host"];
    $foundBody = false;
    $out = "GET $path HTTP/1.0\r\n";
    $out .= "Host: $host\r\n";
    $out .= "User-Agent:      Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
    $out .= "Connection: Close\r\n\r\n";
    if ( !$fp = @fsockopen($host, $port, $errno, $errstr, 30) ) {
        $rtn['errornumber'] = $errno;
        $rtn['errorstring'] = $errstr;
        return '';
    } else {
        fwrite($fp, $out);
        $start =microtime(true);
        $timeout = ini_get('default_socket_timeout');
        while(!feof($fp) && (microtime(true) - $start) < $timeout) {
            $s = @fgets($fp, 128);
            if ( $s == "\r\n" ) {
                $foundBody = true;
                continue;
            }
            if ( $foundBody ) {
                $body .= $s;
            } else {
                if ( ($followRedirects) && (stristr($s, "location:") != false) ) {
                    $redirect = preg_replace("/location:/i", "", $s);
                    fclose($fp);
                    return httpGet( trim($redirect) );
                    break;
                }
                $header .= $s;
            }
        }
        fclose($fp);
        return(trim($body));
    }
}
?>