<?php


if ($spell_checked == 'tourism nepal' || $spell_checked == 'tour nepal' || $spell_checked == 'nepal tourism' || $spell_checked == 'nepal tour') {

    $arDest['http://welcomenepal.com/promotional/tourist-destination/around-kathmandu/'] = 'Kathmandu Valley';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/pokhara/'] = 'Pokhara';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/chitwan/'] = 'Chitwan';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/lumbini/'] = 'Lumbini';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/janakput/'] = 'Janakpur';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/everest-region-2/'] = 'Everest Region';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/annapurna-region/'] = 'Annapurna Region';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/langtang-region/'] = 'Langtang Region';
    $arDest['http://welcomenepal.com/promotional/tourist-destination/park-reserves/'] = 'National Parks';
    //$arDest['http://welcomenepal.com/promotional/tourist-destination/hill-stations/'] = 'Hill Stations';
    //$arDest['http://welcomenepal.com/promotional/tourist-destination/pilgrimage-sites/'] = 'Pilgrimage Sites';

    $total_return = "Reply with Place Name";
    foreach ($arDest as $key => $value) {
        $options_list[] = $value;
        $list[] = array("content" => "__nepal__tourism__$value" . "__" . "$key");
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'npl-tour';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match('~__nepal__tourism__(.+)__(.+)~', $req, $m)) {
    $url = trim($m[2]);
    $head = trim($m[1]);

    //echo "inside match $url [$head]<br>";
    $data = '';
    $content = httpGet($url);
    if ($content) {
        //echo "content found <br>";
        if (preg_match('~<div class="post">(.+)</div>~Usi', $content, $matched)) {
            echo "inside pregmatch<br>";
            $data = trim($matched[1]);
            $data = preg_replace('~[\s]+~', ' ', $data);
            $data = str_replace(array('</p>', '</h6>'), "\n", $data);
            $data = preg_replace('~<li class="active">.+</li>~', '', $data);
            $data = strip_tags($data);

            $some_special_chars = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ",'â€™');
            $replacement_chars = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N",'');

            $data = str_replace($some_special_chars, $replacement_chars, $data);
            //echo "DATA: $data<br>";
            $total_return = "$head\n" . trim($data);
        }
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'npl-tour';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
