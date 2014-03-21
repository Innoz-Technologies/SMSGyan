<?php

echo "Times Of India";
$contents = httpGet($surl);
if (!empty($contents)) {
    if (preg_match('~<h1>(.+)</h1>~Usi', $contents, $match3)) {
        echo 'heading';
        $head = strtoupper($match3[1]);
        $head = html_entity_decode($head);
        echo $head . "\n";
    }if (empty($data)) {
        if (preg_match('~<div class=\"Normal\">(.+)</div>~Usi', $contents, $match2)) {
            $data = $match2[1];
            $data = strip_tags($data);
            $data = html_entity_decode($data);
            $empty = $data;
            if ($data) {
                $set = 'toi';
                $title_h = $head;
            }
            $data = $head . "\n" . trim(preg_replace("~[\s]+~", " ", $data));
            $data = clean($data);
            echo $data;
        }
        if (empty($data)) {
            if (preg_match('~<div id="mod-a-body-first-para" style="" class="mod-timesofindiaarticletext mod-articletext">(.+)</div>~Usi', $contents, $match2)) {
                $data = $match2[1];
                $data = strip_tags($data);
                $data = html_entity_decode($data);
                $empty = $data;
                if ($data) {
                    $set = 'toi';
                    $title_h = $head;
                }
                if ($spell_checked == "new india") {
                    $options_list[] = "sports news";
                    $list[] = array("content" => "news sports");
                }
                $data = $head . "\n" . trim(preg_replace("~[\s]+~", " ", $data));
                $data = clean($data);
                echo $data;
            }
        }
    } 
//    else {
//        if ($set != 'toi' && $title_h != $head && (!empty($empty))) {
//            $options_list[] = "Also Read $head";
//            $list[] = array("content" => "News $head");
//            $news_also_read = true;
//        }
//    }
}
?>