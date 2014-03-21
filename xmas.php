<?php

if ($spell_checked == "christmas" || $spell_checked == "xmas") {
    $total_return = "Christmas Special";

    $options_list[] = "christmas stories";
    $list[] = array("content" => "christmas story");

    $options_list[] = "wishing messages";
    $list[] = array("content" => "christmas messages");

    $options_list[] = "christmas quotes";
    $list[] = array("content" => "christmas quotes");

    $options_list[] = "christmas song";
    $list[] = array("content" => "christmas song");
    
    $options_list[] = "christmas cards";
    $list[] = array("content" => "greeting christmas");
}

if ($total_return) {
    $to_logserver['source'] = 'christmas';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
