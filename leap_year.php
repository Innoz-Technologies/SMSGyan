<?php

//if (strpos($spell_checked, "mystery 29th feb") !== false || strpos($spell_checked, "leap year") !== false || strpos($spell_checked, "leap year mystery") !== false || strpos($spell_checked, "feb 29th mystery") !== false || strpos($spell_checked, "leap year Superstitions") !== false || strpos($spell_checked, "feb 29 Superstitions") !== false) {
if (preg_match("~feb 29(th)? (mystery|Superstitions?)|(mystery|Superstitions?) feb 29(th)?|(mystery|Superstitions?) 29(th)? feb|leap year ?(mystery|Superstitions?)?~", $spell_checked)) {
    $options_list[] = "Facts from history";
    $list[] = array("content" => "facts from history");
    $options_list[] = "Superstitions";
    $list[] = array("content" => "superstitions");

    $total_return = "Leap Year";
    if ($total_return) {
        $to_logserver['source'] = 'spl';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
