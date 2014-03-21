<?php

//Gold Price
if (preg_match("~(gold|silver) (rate|price)~", $spell_checked) || preg_match("~(rate|price)s? (of )?(gold|silver)~", $spell_checked) || $spell_checked == "goldprice") {
    include 'goldprice_pakistan.php';
}

include 'job_pakistan.php';

echo"<br>NEWS PAKISTAN<br>";
include 'news_pakistan.php';

include 'pricePakistan.php';

include 'pak_platelets.php';
?>
