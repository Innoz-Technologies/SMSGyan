<?php

include 'configdb.php';
//if (preg_match("~\b(gift ideas?|giftidea)\b~", $spell_checked)) {
    $query = "select distinct whom,occasion from giftidea";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        $whom[] = $row["whom"];
        $occasion[] = $row["occasion"];
    }
    var_dump($whom);
    var_dump($occasion);
//}
?>
