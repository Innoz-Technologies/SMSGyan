<?php

include 'configdb.php';
$url = "http://movies.justdial.com/movies/city_list.php";
$content = file_get_contents($url);
if (preg_match("~<div style=\"float:left\;clear:left\;width:840px\;\">(.+)</div>~Usi", $content, $match)) {
    if (preg_match_all("~<a href=\"(.+)\">(.+)</a>~Usi", $match[1], $matches)) {
        var_dump($matches);
        print_r($matches[1]);
        for ($i = 0; $i < count($matches[2]); $i++) {
            $query = "replace into justdial_city(url,city) values('" . mysql_real_escape_string($matches[1][$i]) . "','" . mysql_real_escape_string($matches[2][$i]) . "')";
            if (mysql_query($query)) {
                echo "<br>Record inserted";
            }
        }
    }
}
?>