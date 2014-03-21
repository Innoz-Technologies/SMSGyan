<?php

if (preg_match("~(gold|silver) (rate|price)~", $spell_checked) || preg_match("~(rate|price)s? (of )?(gold|silver)~", $spell_checked) || $spell_checked == "goldprice") {
    $subfunction = 'gold';

    include 'gold.php';
}

include "match_chat.php";

//CAPITAL CM HM
include 'about_india.php';

//Google books
include 'match_book.php';


//BABAJOB
include 'match_job.php';

//INCOME TAX
include 'match_tax.php';

//BUS Route
include 'match_bus.php';

include 'match_train.php';

//Channel Guide
include 'match_tv.php';

include 'match_trace.php';

if ($spell_checked == 'news' || $spell_checked == 'latest news') {
    include 'timesNews.php';
}

include 'match_avi.php';

if (!$isOneAPI) {
    //price of mobile
    include 'match_mobprice.php';
    echo "<br>COMM SEARCH<br>";
    include 'comm_price.php';
}
?>
