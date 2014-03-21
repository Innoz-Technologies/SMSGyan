<?php

$slnews = apc_fetch('dataSL', $success);

if (!$success) {
    echo $url = "http://www.dailynews.lk/";
    $content = file_get_contents($url);

    if (preg_match('~<p class="tpd">(.+)</td>~', $content, $matched)) {
        $date_news = trim($matched[1]);
        echo $date_news = date("Y/m/d", strtotime($date_news));


        if (preg_match('~<a style="text-decoration: none" class="one" href="(.+)">~', $content, $matches)) {
            $url = trim($matches[1]);

            echo $url = "http://www.dailynews.lk/$date_news/$url";

            $contents = file_get_contents($url);
        }

        if (preg_match('~<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber5" dir="ltr">(.+)</table>~Usi', $contents, $match)) {
            $slnews = $match[1];
            $slnews = preg_replace("~[\s]+~", " ", $slnews);
            $slnews = strip_tags($slnews);

            if (!empty($slnews))
                apc_store('dataSL', $slnews, 180);
        }
    }
}
if (!empty($slnews)) {

    $total_return = $slnews;
    $source_machine = $machine_id;
    $current_file = "/news/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'news';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>