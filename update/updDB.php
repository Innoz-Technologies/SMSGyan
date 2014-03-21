<?php

include 'configdb.php';

$query = "SELECT * FROM `Knowledge` WHERE `Session` LIKE 'sex' ";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {

    $title = $row["Subject"];
    $langauage = $row["Language"];
    $type = $row["category"];
    $content = $row["Content"];
//    $content = str_replace("'", "", $content);
//    $content = str_replace(",", "", $content);
//    $title = str_replace("'", "", $title);

    $q = "insert into adult_content(`title`,`langauage`,`type`,`content`) Values('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($langauage) . "','" . mysql_real_escape_string($type) . "','" . mysql_real_escape_string($content) . "')";
    if (mysql_query($q)) {
        echo "<br>Record Inserted";
    }
//    break;
}
?>