<?php

echo "INDIA TODAY NEWS";
$contents = httpGet($surl);
if (!empty($contents)) {
    if (preg_match('~<h1>(.+)</h1>~Usi', $contents, $match3)) {
        echo 'heading';
        $head = strtoupper($match3[1]);
        $head = html_entity_decode($head);
        echo $head . "\n";
    }if (empty($data)) {
        if (preg_match("~<div class=\"fullstorytext\">(.+)</div>~Usi", $contents, $match2)) {
            $data = $match2[1];
            $data = strip_tags($data);
            $data = html_entity_decode($data);
            $empty = $data;
            if ($data) {
                $set = 'indiatoday';
                $title_h = $head;
            }
            $data = $head . "\n" . trim(preg_replace("~[\s]+~", " ", $data));
            $data = clean($data);
            echo $data;
        }
    } 
//    else {
//        if ($set != 'indiatoday' && $title_h != $head && (!empty($empty))) {
//            $options_list[] = "Also Read $head";
//            $list[] = array("content" => "News $head");
//            $news_also_read = true;
//        }
//    }
}
?>