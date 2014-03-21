<?php

if ($spell_checked == "gk") {

    $total_return = "Welcome to GK Menu";

    $options_list[] = "world";
    $list[] = array("content" => "__gk__world__");

    $options_list[] = "India";
    $list[] = array("content" => "__gk__india__");

    $options_list[] = "Latest Sports News";
    $list[] = array("content" => "__gk__sports__");

    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'GK';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__gk__world__~", $req)) {

    $url = "http://www.bbc.com/news/";
    $content = file_get_contents($url);

    if (preg_match_all('~<a class="story" rel=".+" href="(.+)">(.+)</a>~Usi', $content, $matched)) {
        for ($i = 0; $i < 5; $i++) {

            $options_list[$i] = trim(strip_tags($matched[2][$i]));
            $list[$i] = array("content" => "__wnewsurl__" . $matched[1][$i] . "__");
        }
        $total_return = "Top news";
    }
    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'GK';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__gk__india__~", $req)) {

    $total_return = "Explore India";

    $options_list[] = "demographics";
    $list[] = array("content" => "Demographics of India");

    $options_list[] = "Tourism";
    $list[] = array("content" => "Tourism in India");

    $options_list[] = "Cabinet";
    $list[] = array("content" => "cabinet of india");


    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'GK';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__gk__sports__~", $req)) {

    echo "<h2>Inside SPORTS NEWS</h2>";
    $data_return = getsportsnews();
    echo $data_return;
    $total_return = $data_return;

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'GK';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__wnewsurl__(.+)__~", $req, $match)) {

    $url = trim($match[1]);
    echo $url = "http://www.bbc.co.uk" . $url;

    $content = file_get_contents($url);

    if (preg_match('~<p class="introduction" id=".+">(.+)<div class=".+">~Usi', $content, $match)) {

        echo "<h2>Inside BBC</h2>";
        $fullarticle = $match[1];
        $fullarticle = str_replace('</p>', "\n", $fullarticle);
        $fullarticle = strip_tags($fullarticle);
        $fullarticle = html_entity_decode($fullarticle);
        echo $fullarticle;
        $total_return = $fullarticle;
    } elseif (preg_match('~<div class="emp-decription" id="meta-information">(.+)</div>~Usi', $content, $match)) {

        $fullarticle = $match[1];
        $fullarticle = str_replace('</p>', "\n", $fullarticle);
        $fullarticle = strip_tags($fullarticle);
        $fullarticle = html_entity_decode($fullarticle);
        echo $fullarticle;
        $total_return = $fullarticle;
    } elseif (preg_match('~<p class="introduction">(.+)</div>~Usi', $content, $match)) {

        $fullarticle = $match[1];
        $fullarticle = str_replace('</p>', "\n", $fullarticle);
        $fullarticle = strip_tags($fullarticle);
        $fullarticle = html_entity_decode($fullarticle);
        echo $fullarticle;
        $total_return = $fullarticle;
    }

    if ($total_return) {
        $total_return = str_replace("&#039;", "'", $total_return);
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'GK';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function getsportsnews() {

    $sportsnews = apc_fetch('sportnews', $success);

    if (!$success) {

        echo $url = "http://zeenews.india.com/sports/index.html";
        $content = file_get_contents($url);

        if (preg_match('~<div id="news2" class="hideout" style="overflow:hidden">.+<li><a href="(.+)">(.+)</a></li>~Usi', $content, $match)) {
            $title = trim($match[2]);
            $url_next = trim($match[1]);
            $url_next = "http://zeenews.india.com" . $url_next;

            echo $title . "\n";

            $content_next = file_get_contents($url_next);
            if (preg_match("~<!--Para1Text-->(.+)<!--Para1TextEnd-->~Usi", $content_next, $matched)) {
                $data = $matched[1];
                $data = str_replace("<br/><br/>", "\n", $data);
                $data = strip_tags($data);
                $data = html_entity_decode($data);
                echo $data;
            }

            $sportsnews = $title . "\n" . $data;

            apc_store('sportnews', $sportsnews, 900);
        }
    }
    return $sportsnews;
}

?>
