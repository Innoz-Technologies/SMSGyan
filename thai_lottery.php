<?php

if ($spell_checked == "lottery result" || $spell_checked == "lottery results") {

    echo $url = "http://www.thailottoresults.com/";
    $content = file_get_contents($url);

    if (preg_match('~<a href=\'http://www.thailottoresults.com/.+\'>(.+)</a>~Usi', $content, $match))
        $title = trim(strip_tags($match[1]));
    if (preg_match('~<div class=\'post-body entry-content\'.+>(.+)</strong><br />~Usi', $content, $match)) {

        $data = trim($match[1]);
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace('</span><br />', "+++", $data);
        $data = strip_tags($data);
        $data = str_replace('+++', "\n", $data);
        $total_return = "$title\n$data";
    } else {
        $total_return = "No results found";
    }
}
if (!empty($total_return)) {
    $to_logserver['source'] = 'lottery_thai';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
