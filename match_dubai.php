<?php

//Gold price
if (preg_match("~(gold|silver) (rate|price)~", $spell_checked) || preg_match("~(rate|price)s? (of )?(gold|silver)~", $spell_checked) || $spell_checked == "goldprice") {
    include 'goldprice_AED.php';
}

echo"<br>UAE JOBS<br>";
include 'uae_jobs.php';
echo "<br><h2>TIME after UAE JOBS :" . (microtime(TRUE) - $time_start) . "</h2><br>";

echo"<br>UAE NEWS<br>";
include 'news_du.php';
include 'duOptions.php';
include 'vehicle.php';
include 'uae_restaurant.php';
include 'dubai_metro.php';

echo"<br>UAE DAY<br>";
include 'UAEday.php';

if ($spell_checked == 'news' || $spell_checked == 'latest news') {
    $req = 'news uae';
    $spell_checked = 'news uae';
}

include 'priceDubai.php';
?>
