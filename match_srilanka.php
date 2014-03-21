<?php

//Gold price
if (preg_match("~(gold|silver) (rate|price)~", $spell_checked) || preg_match("~(rate|price)s? (of )?(gold|silver)~", $spell_checked) || $spell_checked == "goldprice") {
    include 'slgold.php';
}

echo"<br>SRI LANKA JOBS<br>";
include 'job_srilanka.php';
echo "<br><h2>TIME after SRI LANKA JOBS :" . (microtime(TRUE) - $time_start) . "</h2><br>";

echo"<br>TRUECALLER DIALOG<br>";
include 'truecaller_dialog.php';

if ($spell_checked == 'news' || $spell_checked == 'latest news') {
    echo"<br>SRI LANKA NEWS<br>";
    include 'slnews.php';
}

include 'priceSrilanka.php';
include 'train_srilanka.php';

include 'sl_platelets.php';
?>
