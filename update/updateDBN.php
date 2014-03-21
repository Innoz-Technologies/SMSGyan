<?php

include 'configdb.php';

$query = "select * from app_andriod";
$result = mysql_query($query) or die("Could not perform select query - " . mysql_error());

while ($row = mysql_fetch_array($result)) {

    $id = $row['id'];

    $url = "API";
    $content = file_get_contents($url);

    if ($content) {
        if (preg_match('~<brownieurl>(.+)<brownieurl>~', $content, $matchsd))
            $brurl = trim($matchsd[1]);
    }

    $q = "UPDATE `app_andriod` SET `brownie_icon_url`= '$brurl' WHERE `id`=" . $row["id"];
    mysql_query($q);
//    break;
}
?>
