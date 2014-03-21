<?php

set_time_limit(0);
$sid = $_GET["s"];
include "configdb2.php";
$query = "";

$q = "select pin_state.url as surl,pin_state.id as sid,pin_district.url as durl,pin_district.id as disid from pin_state,pin_district where pin_state.id=pin_district.state_id and state_id=$sid";
$result = mysql_query($q);

while ($row = mysql_fetch_array($result)) {
    $state = trim($row["surl"]);
    echo "<br>" . $district = trim($row["durl"]);
    echo "<br>";
    $state_id = $row["sid"];
    $district_id = $row["disid"];

    $url = "http://www.mapsofindia.com/pincode/india/$state/$district/";
    $content = file_get_contents($url);

    preg_match_all("~<a href=\"../../../../../pincode/india/$state/$district/(.+)\">(.+)</a></td><td ><b>(.+)</b></td>~Usi", $content, $matches);
//    var_dump($matches);
    if (!empty($matches[1])) {
        for ($i = 0; $i < count($matches[1]); $i++) {
            $query .= "($state_id,$district_id,'" . trim(mysql_real_escape_string($matches[2][$i])) . "','" . trim(mysql_real_escape_string($matches[1][$i])) . "','" . trim(mysql_real_escape_string($matches[3][$i])) . "'),";
            if (($i % 300) == 0) {
                $query = "Replace into pin_city(state_id,district_id,city,url,pincode) values" . $query;
                $query = substr($query, 0, strlen($query) - 1);
                if (mysql_query($query)) {
                    echo "Record Inserted<br>";
                    $query = "";
                }
            }
        }

        if (!empty($query)) {
            echo "<h1>Out</h1>";
            $query = "Replace into pin_city(state_id,district_id,city,url,pincode) values" . $query;
            $query = substr($query, 0, strlen($query) - 1);
            if (mysql_query($query)) {
                echo "Record Inserted<br>";
                $query = "";
            }
        }
    } else {
        $district = $district . "\n";
        file_put_contents("log/pin.log", $district,FILE_APPEND);
    }
}
?>