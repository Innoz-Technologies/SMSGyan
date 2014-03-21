<?php
$weather_req=urlencode($word);
$url='API';
$content=httpGet($url);
$tt=stripos($content,"Add to iGoogle");
if ($tt!==false) {
    $content=substr($content,$tt+14);
    $tt=stripos($content,"<div align=center");
    if ($tt!==false) {
        $content=left($content,$tt);
        $content=str_ireplace("<b>"," ",$content);
        $content=str_ireplace("<br>"," \n",$content);
        $content=strip_tags($content);
        $content=rem_Entities($content);
        $content = utf8_encode( $content ) ; 
        $content=str_replace("Â°C"," Degree Celsius \n","$content");
        while (stripos($content,"  ")!==false) {
            $content=str_ireplace("  "," ",$content);
        }
        $content=trim($content);
        $word=ucwords($word);
        $weather_return=$word." right now: ".$content;
    }
    else {
        $weather_return='';
    }
}
else {
    $weather_return='';
}
?>