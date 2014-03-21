<?php

$requrl = $_GET['q'];
$requrl = str_replace('http://', '', $requrl);
echo $url = "http://who.is/whois/$requrl/";
$result = file_get_contents($url);
if (preg_match('~<div id=\'site_info\'>(.+) </div>~Usi', $result, $match)) {
    $result = $match[1];
    $result = str_replace('</br>', '***', $result);
    $result = strip_tags($result);
    $result = str_replace('***', "\n", $result);
    $result = html_entity_decode($result);
    $result = str_replace(" \n", "\n", $result);
    echo $result;
}
?>
