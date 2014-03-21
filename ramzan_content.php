<?php

if (preg_match("~^\b(ramdan|ramdhan|ramadhan|ramadan|ramzan)\b$~", $req)) {
    $total_return = "RAMADAN SPECIAL !!!";

    $options_list[] = "RAMDHAN MESSAGE";
    $list[] = array("content" => "ramdhan message");

    $options_list[] = "greeting cards";
    $list[] = array("content" => "greeting card for ramadan");

    $options_list[] = "SIGNIFICANCE OF RAMDHAN";
    $list[] = array("content" => "significance of ramadan");

    $options_list[] = "QURAN QUOTES";
    $list[] = array("content" => "quran quotes");

    $options_list[] = "RAMDHAN TIPS";
    $list[] = array("content" => "ramdhan tips");


    $options_list[] = "NAMAZ TIMING";
    $list[] = array("content" => "namaz timing");

    if ($total_return) {
        $to_logserver['source'] = 'ramdhan';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
