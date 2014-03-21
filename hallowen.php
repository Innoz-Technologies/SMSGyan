<?php

if ($spell_checked == "halloween" || $spell_checked == "hallowen" || $spell_checked == "haloween" || $spell_checked == "halowen") {
    $total_return = "Halloween";

    $options_list[] = "about halloween";
    $list[] = array("content" => "about halloween");
    $options_list[] = "photo";
    $list[] = array("content" => "photo halloween");
//    $list[] = array("content" => "sandy storm battered us");

    if ($total_return) {
        $to_logserver['source'] = 'halloween';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
