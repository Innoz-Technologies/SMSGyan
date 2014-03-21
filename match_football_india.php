<?php

if ((strpos($spell_checked, 'football') !== false && (strpos($spell_checked, 'delhi') !== false || strpos($spell_checked, 'india') !== false || strpos($spell_checked, 'bayern') !== false)) || (strpos($spell_checked, 'india') !== false && strpos($spell_checked, 'bayern') !== false )) {
    $flag_enabled = false;
    $total_return = 'India VS Fc Bayern!';
    $options_list[] = "Match Day";
    $list[] = array("content" => "INDIA VS FC BAYERN");
    $options_list[] = "FC Bayern Munchen";
    $list[] = array("content" => "BAYERN MUNICH");
    $options_list[] = "Team FC Bayern Munchen";
    $list[] = array("content" => "BAYERN FOOTBALL TEAM");
    $options_list[] = "India";
    $list[] = array("content" => "INDIAN NATIONAL FOOTBALL TEAM");
    $options_list[] = "Team India";
    $list[] = array("content" => "INDIAN FOOTBALL TEAM");
    include 'allmanip.php';
    $to_logserver['source'] = 'menu_foot';
    putOutput($total_return);
    exit();
}
?>