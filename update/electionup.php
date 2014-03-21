<?php

set_time_limit(0);
ini_set("display_errors", "on");
error_reporting(E_ALL);
include 'configdb.php';
$query = "select * from election_plc";
$result = mysql_query($query);

//if (mysql_num_rows($result)) {
//    $row = mysql_fetch_array($result);
//    $data = $row["data"];
//    $data = str_replace(")\n", "), 0 votes\n", $data);
//    echo $data = str_replace(") ", "), 0 votes\n", $data);
//}

while ($row = mysql_fetch_array($result)) {
    $eid = $row["id"];
    $data = $row["data"];

    $data = str_replace("\r", "", $data);
    $data = str_replace(")\n", "), 0 Votes\n", $data);
    $data = trim(str_replace(") ", "), 0 Votes\n", $data));
    $q = "update election_plc set result='" . mysql_real_escape_string($data) . "' where id =$eid";

    if (mysql_query($q)) {
        echo "Record Updated<br>";
        $eid = 0;
        $data = "";
    }
}
?>