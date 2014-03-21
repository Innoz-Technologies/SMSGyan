<?php

if ($spell_checked == "muay thai") {
    $total_return = "Muay Thai is a combat sport from the muay martial arts of Thailand that uses stand-up striking along with various clinching techniques.";

    $options_list[] = "Results";
    $list[] = array("content" => "__muay_thai__result__");

    $options_list[] = "Upcoming Events";
    $list[] = array("content" => "__muay_thai__events__");
} elseif (preg_match('~__muay_thai__result__~', $req)) {
    $url = "http://www.muaythaiauthority.com/p/results.html";
    $content = file_get_contents($url);

    if (preg_match_all('~<a href="http://www.muaythaiauthority.com/(.+)">(.+)</a>~Usi', $content, $match)) {
        //var_dump($match);

        $total_return = "Results";

        $link = array();
        $name = array();
        for ($i = 0; $i <= 10; $i++) {
            $link = trim(strip_tags($match[1][$i]));
            $name = trim(strip_tags($match[2][$i]));

            $options_list[] = $name;
            $list[] = array("content" => "__result__next__" . $link . "__");
        }
    }
} elseif (preg_match('~__muay_thai__events__~', $req)) {
    $url = "http://www.muaythaiauthority.com/p/upcoming-events.html";
    $content = file_get_contents($url);

    if (preg_match_all('~<a href="http://www.muaythaiauthority.com/(.+)">(.+)</a>~Usi', $content, $match)) {
        //var_dump($match);

        $total_return = "Results";

        $link = array();
        $name = array();
        for ($i = 0; $i < count($match[1]); $i++) {
            $link = trim(strip_tags($match[1][$i]));
            $name = trim(strip_tags(html_entity_decode($match[2][$i])));

            $options_list[] = $name;
            $list[] = array("content" => "__events__next__" . $link . "__");
        }
    }
} elseif (preg_match('~__result__next__(.+)__~', $req, $match)) {

    $url = "http://www.muaythaiauthority.com/" . trim($match[1]);
    $content = file_get_contents($url);

    if (preg_match('~<div style="text-align: justify;">(.+)<div style=\'clear:both;\'>~Usi', $content, $match)) {
        $data = $match[1];
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace('</b>', "***", $data);
        $data = strip_tags($data);
        $data = str_replace('***', "\n", $data);
        $total_return = $data;
    }
} elseif (preg_match('~__events__next__(.+)__~', $req, $match)) {

    $url = "http://www.muaythaiauthority.com/" . trim($match[1]);
    $content = file_get_contents($url);

    if (preg_match('~<div style="text-align: justify;">(.+)<div style=\'clear:both;\'>~Usi', $content, $match)) {
        $data = $match[1];
        $data = preg_replace('~[\s]+~', " ", $data);
//        $data = str_replace('</b>', "***", $data);
        $data = strip_tags($data);
        $data = str_replace('***', "\n", $data);
        $data = str_replace(', ', "\n", $data);
//        $data = ltrim(",", $data);
        $total_return = $data;
    }
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    include 'allmanip.php';
    $to_logserver['source'] = 'muaythai';
    putOutput($total_return);
    exit();
}
?>
