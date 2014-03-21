<?php

if ($spell_checked == "travel") {
    $total_return = "Invalid format Send Travel [space] [place name].Eg: travel phuket";
} elseif (preg_match('~^(travels?|places?) (.+)~', $req, $match)) {

    $search = trim($match[2]);
    $search_place = trim(str_replace(' ', '-', $search));
    echo $url = "http://www.tourismthailand.org/Where-to-Go/$search_place";

    echo "<h2>trave Thailand</h2>";
    $content = httpGet($url);

//    echo $content;

    if (preg_match_all('~<div class="name"><a class="color" href="(.+)">(.+)</a></div>~Usi', $content, $match)) {
        var_dump($match);

        $total_return = "Places to visit near $search";
        for ($i = 0; $i < count($match[1]); $i++) {
            $options_list[] = trim($match[2][$i]);
            $list[] = array("content" => "__travel__thailand__next__" . $match[1][$i] . "__");
        }
    } else {
        $total_return = "No place found matching your query";
    }
} elseif (preg_match('~__travel__thailand__next__(.+)__~', $req, $match)) {
    $url_next = trim($match[1]);

    $content = file_get_contents($url_next);
    if (preg_match('~<p class="address">(.+)</p>~Usi', $content, $match)) {
        $address = "Address: " . ($match[1]);
    }
    if (preg_match('~<p style="text-align:justify;"><p><p.+>(.+)</p></p></p>~Usi', $content, $match)) {
        $attraction = "Attraction Details: " . (strip_tags($match[1]));
    }

    if (!empty($address) || !empty($attraction))
        $total_return = $address . "\n" . $attraction
        ;
    else
        $total_return = "No details found";
}

if (!empty($total_return)) {
    $to_logserver['source'] = 'travel_thai';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
