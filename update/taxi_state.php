<?php

set_time_limit(0);
include 'configdb.php';

//$query = "DELETE FROM `bikedekho`";
//if (mysql_query($query)) {
//    echo "Recode Deleted<br>";
//}

$out = '';
$url = "http://www.taxiautofare.com/";
$content = file_get_contents($url);

if (!empty($content)) {
    preg_match("~<td class=\"DDMediumH\" colspan=\"3\">(.+)</select>~Usi", $content, $match);
    preg_match_all("~<option value=\"(.+)\">(.+)</option>~Usi", $match[1], $match1);

    for ($i = 0; $i < count($match1[1]); $i++) {
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($match1[2][$i]) . "&sensor=true";
        $json_data = html_entity_decode(file_get_contents($url));
        $json_dec = json_decode($json_data, true);
//        print_r($json_dec);
        if ($json_dec['status'] == 'OK') {        //If result found
            foreach ($json_dec['results'] as $key => $rst) {
                $lat = $rst['geometry']['location']['lat'];
                $lng = $rst['geometry']['location']['lng'];
            }
        }
        
        $query = "Replace into taxi_state(sval,state,lat,lng) values ('" . mysql_real_escape_string($match1[1][$i]) . "','" . mysql_real_escape_string(str_replace(",", " ", $match1[2][$i])) . "',$lat,$lng)";
        if (mysql_query($query)) {
            echo "Recode inserted<br>";
        }
    }
}
?>
