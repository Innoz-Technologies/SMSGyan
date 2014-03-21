<?php

include 'configdb2.php';

$query = "select locality,id from snapdeal_locality";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {
    $srch_word = $row["locality"];
    $locality_id = $row["id"];
    $srch_word = trim(preg_replace("~\b(nagar|road|Street|Layout|Bazar|Town|Lane|Colony|Palya|Circle|City|block|junction|cross|Quarters|&|Gali|Temple|high)\b~i", " ", $srch_word));
    $srch_word = trim(preg_replace("~\.|\-|,~", " ", $srch_word));
    $srch_word = trim(preg_replace("~[\s]+~", " ", $srch_word));
    $srch_word=srchstring($srch_word);

    $q = "update snapdeal_locality set srch='" . mysql_real_escape_string($srch_word) . "' where id =" . $locality_id;
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
