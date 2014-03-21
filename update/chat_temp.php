<?php

set_time_limit(0);
include 'configdb.php';
$query = "Select * from billNumber";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {
    $arData["b"] = $row["isBill"];
    $arData["d"] = $row["billDate"];
    $url = "http://IPs/cache/write.php?name=bl" . $row["msisdn"] . "&data=" . urlencode(serialize($arData)) . "&ttl=86400";
    $content = file_get_contents($url);
    if ($content != "OK") {
        echo "<br>Cache not Updated" . $row["msisdn"];
    }
}

//while ($row = mysql_fetch_array($result)) {
//    $url = "http://IPs/cache/read.php?name=bl" . $row["msisdn"];
//    $content = file_get_contents($url);
//    if ($content != "not_found") {
//        $arData = unserialize($content);
//        if (!empty($arData)) {
//            if ($arData["b"] == 1) {
//                $q = "Update billNumbers set isBill=1,billDate='" . $arData["d"] . "' where msisdn=" . $row["msisdn"];
//                if (mysql_query($q)) {
//                    echo "<br>Record Updated";
//                }
//            }
//        }
//    }
//}
?>
