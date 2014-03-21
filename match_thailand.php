<?php

//Gold price
if (preg_match("~(gold|silver) (rate|price)~", $spell_checked) || preg_match("~(rate|price)s? (of )?(gold|silver)~", $spell_checked) || $spell_checked == "goldprice") {
    include 'goldpriceThai.php';
}

echo"<br>THAI JOBS<br>";
//include 'job_thailand.php';
include 'th_jobs.php';
echo "<br><h2>TIME after THAI JOBS :" . (microtime(TRUE) - $time_start) . "</h2><br>";

//Train list
if ($appQueryFrom == "thai")
    include 'train_thailand.php';

include 'thailandNews.php';
echo "<h2>Before Thai FORTUNE</h2>";
include 'fortuneteller.php';
include 'thailandRestaurants.php';
include 'thailand_fplayer.php';
include 'travel_thailand.php';
include 'thai_lottery.php';
include 'thai_blog.php';
include 'muay_thai.php';
?>
