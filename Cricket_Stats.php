<?php

if ($spell_checked == "cricket statistics" || $spell_checked == "cricket stats" || $spell_checked == "cricket rankings" || $spell_checked == "cricket rank" || $spell_checked == "cricket table" || $spell_checked == "icc rankings" || $spell_checked == "cricket status" || $spell_checked == "cricket ranking") {
    $flag_enabled = false;
    $total_return = "CRICKET RANKINGS!!!";
    $options_list[] = "Odi Rankings";
    $list[] = array("content" => "_odi_rank");
    $options_list[] = "T20 Rankings";
    $list[] = array("content" => "_t20_rank");
    $options_list[] = "Test Rankings";
    $list[] = array("content" => "_test_rank");
}
if ($spell_checked == "_odi_rank") {
    $flag_enabled = false;
    $total_return = "ODI RANKINGS!!!";
    $options_list[] = "Top 10 Bowlers";
    $list[] = array("content" => "_odi_bowl");
    $options_list[] = "Top 10 Batsmen";
    $list[] = array("content" => "_odi_bat");
    $options_list[] = "Team Rankings";
    $list[] = array("content" => "odi rankings");
}
if ($spell_checked == "_t20_rank") {
    $flag_enabled = false;
    $total_return = "T20 RANKINGS!!!";
    $options_list[] = "Top 10 Bowlers";
    $list[] = array("content" => "_T20_bowl");
    $options_list[] = "Top 10 Batsmen";
    $list[] = array("content" => "_T20_bat");
    $options_list[] = "Team Rankings";
    $list[] = array("content" => "2020 rankings");
}
if ($spell_checked == "_test_rank") {
    $flag_enabled = false;
    $total_return = "TEST RANKINGS!!!";
    $options_list[] = "Top 10 Bowlers";
    $list[] = array("content" => "_test_bowl");
    $options_list[] = "Top 10 Batsmen";
    $list[] = array("content" => "_test_bat");
    $options_list[] = "Team Rankings";
    $list[] = array("content" => "test rankings");
}
if ($total_return) {
    include 'allmanip.php';
    $to_logserver['source'] = 'cricketstats';
    putOutput($total_return);
    exit();
}
?>
