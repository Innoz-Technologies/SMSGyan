<?php

$contents = httpGet($surl);
if (!empty($contents)) {
    if (preg_match('~<h1 class="article-title">(.+)</h1>~Usi', $contents, $match3)) {
        $head = strip_tags($match3[1]);
        $head = strtoupper($head);
        $head = html_entity_decode($head);
        echo $head . "\n";
    }
    if (empty($data)) {
        if (preg_match("~<p>(.+)</div>~Usi", $contents, $match4)) {
            $data = $match4[1];
            $data = html_entity_decode($data);
            $data = strip_tags($data);
            $data = str_replace('For NDTV Updates, follow us on Twitter or join us on Facebook', '', $data);
            if ($data) {
                $set = 'dnaindia';
                $title_h = $head;
            }
            $data = $head . "\n" . trim(preg_replace("~[\s]+~", " ", $data));
            echo $data;
        }
    } 
//    else {
//        if ($set != 'dnaindia' && $title_h != $head) {
//            $options_list[] = "Also Read $head";
//            $list[] = array("content" => "News $head");
//            $news_also_read = true;
//        }
//    }
}
?>