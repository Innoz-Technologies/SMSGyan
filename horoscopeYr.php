<?php

echo "<br> 2012 horo <br>";
if (preg_match("~(horoscope 2013|2013 horoscope) (.+)|((2013|horoscope) (.+) (2013|horoscope))|(2013) (.+)|(.+) 2013~", $spell_checked, $match)) {

    echo $hor_word = preg_replace("~horoscope|2013~", "", $spell_checked);

    $query = "SELECT * FROM horoscope_yrly WHERE SOUNDEX( horoscope ) = SOUNDEX( '" . $hor_word . "' )";
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $total_return = $row['data'];
        $hname = $row['horoscope'];
        $hid = $row['id'];
    }

    if ($total_return) {
        $source_machine = 'db';
        $current_file = "horoscope_yrly/data/id/" . $hid;
        $to_logserver['source'] = 'horoscope_year';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
