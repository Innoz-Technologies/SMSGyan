<?php

include ("lovecalc.inc.php"); // Class
$my_love = new lovecalc($first_name, $second_name); // New instance
$val = $my_love->lovestat;

if ($islove) {
    $to_logserver['source'] = 'love';
    $love_result = "Your love percentage is " . $val . '.' . "\n"; // Show
    if ($val > 90) {
        $love_result .= "Perfect Match.";
    } else if ($val > 79 && $val <= 89) {
        $love_result .= "Excellent Match.";
    } else if ($val > 69 && $val <= 79) {
        $love_result .= "Very good Match.";
    } else if ($val > 59 && $val <= 69) {
        $love_result .= "Good Match.";
    } else if ($val > 49 && $val <= 59) {
        $love_result .= "Average Match.";
    } else if ($val > 24 && $val <= 49) {
        $love_result .= "Not a bad Match.";
    } else if ($val <= 24) {
        $love_result .= "Poor match.";
    }
} else {
    $to_logserver['source'] = 'fc';
    $val += ( (($val % 5) + 1) * (($val % 3) + 1) * ((($val % 2) * -2) + 1));
    if ($val > 99)
        $val = 100 - ($val - 99);
    else if ($val < 10)
        $val = 10 - ($val - 10);
    $love_result = "Your friendship percentage is " . $val . '.' . "\n"; // Show
    if ($val > 90) {
        $love_result .= "Best Friends forever.";
    } else if ($val > 75 && $val <= 90) {
        $love_result .= "Friends forever.";
    } else if ($val > 64 && $val <= 75) {
        $love_result .= "Best Friends.";
    } else if ($val > 49 && $val <= 64) {
        $love_result .= "Good Friends.";
    } else {
        $love_result .= "Just Friends.";
    }
}
echo "Love calculated";
//echo $query = "REPLACE INTO share_data (msisdn,circle,data,modified_date) VALUES ('$numbers','$circle','" . mysql_real_escape_string($love_result) . "',now())";
//mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

if ($operator == 'loop') {
    $add_below = "\n--\nFor more such unlimited Searches on sms subscribe to this service at just Rs 1/day dial *888*1#";
//} else {
//////    $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
////    $query = "select * from ad_scripts order by rand() limit 0,1";
////    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
////    if (mysql_num_rows($result)) {
////        $row = mysql_fetch_array($result);
////        $add_below = "\n--\n" . $row["script"];
////    }
} elseif (($circle_short == 'RJ' || $circle == 'RAJASTHAN' ) && $operator == 'idea') {
    $add_below = "\n--\nFor unlimited Search sms GYAN to $shortcode";
} else {
    echo "its here";
    echo $add_below = adscript();
}
$total_return = $love_result;
include 'allmanip.php';
if ($fromHi == true) {
    $total_return = str_replace("OPTIONS", "ALSO TRY", $total_return);
    $total_return = str_replace("Reply with", "Try with", $total_return);
}
putOutput($total_return);
exit();
?>