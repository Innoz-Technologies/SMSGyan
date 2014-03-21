<?php

set_time_limit(0);
include 'configdb.php';

//$query = "DELETE FROM `msi_cities`";
//if (mysql_query($query)) {
//    echo "Recode Deleted<br>";
//}

$url = "http://book.mustseeindia.com/javascripts/widget_v71.js";
$content = file_get_contents($url);
$out = "";
preg_match_all("~collection_all_cities=\[(.+)var hash_yatra_city_names~Usi", $content, $gmt);
$arPlace = array();

if (!empty($gmt)) {
    $out = serialize($gmt[1]);
    $out = str_replace('"', "", $out);
    $out = str_replace("a:1:{i:0;s:73219:", "", $out);
    $out = str_replace("];;}", "", $out);
    $arPlace = explode(",", $out);
    foreach ($arPlace as $val) {
        if (!empty($val)) {
            $query = "Replace into msi_cities(city) values ('" . mysql_real_escape_string($val) ."')";
            if (mysql_query($query)) {
                echo "Recode inserted<br>";
            }
        }
    }
}
?>