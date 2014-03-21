<?php

include 'configdb.php';
echo $query = "select bank,id from ifsc_bank";
echo $result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {
    $srch_word = $row["bank"];
    $id = $row["id"];
    $srch_word = trim(preg_replace("~\b(ltd|limited|co-operative|co-op|of|and|co op|the|co operative|cooperative|n|na|ag|plc|ufg|corp|psc|saog|\(mumbai\)|nv)\b~i", " ", $srch_word));
    $srch_word = trim(preg_replace("~\.|\-|,~", " ", $srch_word));
    $srch_word = trim(preg_replace("~[\s]+~", " ", $srch_word));
    $srch_word = srchstring($srch_word);

    $q = "update ifsc_bank set srch='" . mysql_real_escape_string($srch_word) . "' where id =" . $id;
    if (mysql_query($q)) {
        echo "<br>Record updated";
    }
}

function srchstring($mystring) {
    $words = explode(" ", $mystring);
    $ret = $words[0];
    for ($i = 1; $i < count($words); $i++) {
        if (strlen($words[$i - 1]) == 1 && strlen($words[$i]) == 1) {
            $ret .= $words[$i];
        } else {
            $ret .= " " . $words[$i];
        }
    }
    return $ret;
}

?>
