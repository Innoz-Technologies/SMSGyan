<?php

function httpGet($url, $followRedirects = true) {
    $curl = curl_init();

    // Setup headers - I used the same headers from Firefox version 2.0.0.6
    // below was split up because php.net said the line was too long. :/
    $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
    $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: close";
//  $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: UTF-8;q=0.7,*;q=0.7";    //ISO-8859-1
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

$image_title = urlencode($_GET["q"]);
$url = "API";
$content = httpGet($url);
$xml_in = objectsIntoArray(simplexml_load_string($content));
if (isset($xml_in['query']['pages']['page']['imageinfo']['ii'])) {
    $image_info = $xml_in['query']['pages']['page']['imageinfo']['ii']['@attributes'];
    preg_match("~\|description\s*=(.+)~i", $image_info['comment'], $match_dec);
    var_dump($match_dec);
    $image_dec = preg_replace('~{{en\|[0-9]?~si', '', $match_dec[1]);
    $image_dec = preg_replace('~\|(.+)\]\]~Usi', '', $image_dec);
    $image_dec = preg_replace('~\ben|w\b~Usi', '', $image_dec);
    $image_dec = preg_replace('~[^a-zA-Z0-9,\s,\(,\),\.]~Usi', '', $image_dec);

    echo '<br> '.$image_dec;
    $image = $image_info['url'];
    $desc_url = $image_info['descriptionurl'];

    $new_image = file_get_contents("http://gyan.mobi/wiki/new_image.php?imageurl=" . urlencode($image) . "&otherimages=" . urlencode($desc_url) . "&desc=" . urlencode($image_dec));
    if (is_numeric($new_image)) {
        echo "<h3>Image entered: $new_image</h3>";
    }
    echo "\n<br>";
} else {
    $image_dec = ' ';
}
?>