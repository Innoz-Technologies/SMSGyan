<?php

//set_time_limit(0);

$data = apc_fetch('data', $success);

if (!$success) {
    echo $url = "http://timesofindia.indiatimes.com/";
    $content = file_get_contents($url);

    echo "<h2>OUTSIDE NEWS</h2>";

    if (preg_match('~<a pg="Head#1" href="(.+)">(.+)</a>~Usi', $content, $match)) {
        echo "<h2>INSIDE NEWS</h2>";
//    var_dump($match);
        echo $news_url = "http://timesofindia.indiatimes.com" . trim($match[1]);
        $title = trim($match[2]);

        $fullcontent = file_get_contents($news_url);

        if (preg_match('~<div class="Normal">(.+)<!-- google_ad_section_end -->~Usi', $fullcontent, $matched)) {

            echo "<h2>INSIDE NEWS DATA</h2>";

            $data = trim($matched[1]);
            $data = preg_replace("~[\s]+~", " ", $data);
            $data = str_replace("<br><br>", "\n", $data);
            $data = strip_tags($data);
            if (!empty($data)) {
                $data = $title . "\n" . $data;
            }
            echo $data;
            apc_store('data', $data, 300);
        } elseif (preg_match('~<div class="Normal"><tmp>(.+)</tmp></div>~Usi', $fullcontent, $matched)) {
            echo "<h2>INSIDE NEWS DATA ELSE</h2>";

            $data = trim($matched[1]);
            $data = preg_replace("~[\s]+~", " ", $data);
            $data = str_replace("<br><br>", "\n", $data);
            $data = strip_tags($data);
            if (!empty($data)) {
                $data = $title . "\n" . $data;
            }
            echo $data;
            apc_store('data', $data, 300);
        }elseif (preg_match('~<div class="Normal">(.+)<span id="storyendpath">~Usi', $fullcontent, $matched)) {
            echo "<h2>INSIDE NEWS DATA ELSE</h2>";

            $data = trim($matched[1]);
            $data = preg_replace("~[\s]+~", " ", $data);
            $data = str_replace("<br><br>", "\n", $data);
            $data = strip_tags($data);
            if (!empty($data)) {
                $data = $title . "\n" . $data;
            }
            echo $data;
            apc_store('data', $data, 300);
        }
    }
}
if (!empty($data)) {

    $total_return = $data;
    $source_machine = $machine_id;
    $current_file = "/news/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'news';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
