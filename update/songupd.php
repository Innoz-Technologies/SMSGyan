<?php

include 'configdb.php';

$query = "SELECT * FROM  `song_detail1` ORDER BY  `id`";
$result = mysql_query($query);

$movieID = 2181;
$prevUrl = "";
while ($row = mysql_fetch_array($result)) {
    $url = trim($row["url"]);
    if ($url != $prevUrl && !empty($prevUrl))
        $movieID += 1;

    $q = "UPDATE `song_detail1` SET `movieID`=$movieID WHERE `id`=" . $row["id"];
    if (!mysql_query($q)) {
        echo "<br>Record not Updated " . $row["id"];
    }
    $prevUrl = $url;
}
?>