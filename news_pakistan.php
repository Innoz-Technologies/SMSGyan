<?php

if (preg_match("~\b^(news|siasat)\b(.+)?~si", $spell_checked, $match)) {
    echo "<h4>INSIDE PAKISTAN NEWS SEARCH</h4>";

    var_dump($match);

    if (isset($match[2]) && trim($match[2]) != "") {
        $pak_news = searchpaknews(trim($match[2]));
    } else {
        $pak_news = getpaknews();
    }

    if (!empty($pak_news)) {
        $options_list = $pak_news['options_list'];
        $list = $pak_news['list'];

        if (isset($match[2]) && trim($match[2]) != "") {
            $total_return = $pak_news;
            unset($options_list);
            unset($list);
        } else {
            $total_return = "News";
        }
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'pak_news';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    } else {
        $total_return = "No news found!";
        $to_logserver['source'] = 'pak_news';
        $to_logserver['isresult'] = 0;
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} else if (preg_match("~__pak__news__(.+)~si", $req, $match)) {
    echo "<h4>INSIDE THAILAND NEWS SEARCH</h4>";

    echo $url = "http://dawn.com/news/" . $match[1];

    $pak_news = getdetailspak($url);

    if (!empty($pak_news)) {
        $total_return = $pak_news;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'pak_news';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    } else {
        $total_return = "No news found!";
        $to_logserver['source'] = 'pak_news';
        $to_logserver['isresult'] = 0;
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function getpaknews() {
    $return = array();

    $url = "http://dawn.com/latest-news";
    $content = file_get_contents($url);

    if (preg_match_all("~<h3 class='story-hed'><a href='/news/(.+)'>(.+)</a>~", $content, $match)) {
        //var_dump($match);
        for ($i = 0; $i < 10; $i++) {

            $options_list[$i] = trim($match[2][$i]);
            $list[$i] = array("content" => "__pak__news__" . trim($match[1][$i]));
        }
    }
    $return['options_list'] = $options_list;
    $return['list'] = $list;
    return $return;
}

function searchpaknews($search) {

    $url = "http://www.geo.tv/SearchNews.aspx?URL=" . urlencode($search);
    $content = file_get_contents($url);

    if (preg_match('~<a href="article-(.+)" id=".+" title=".+">~Usi', $content, $match)) {
        //var_dump($match);
        echo $url_next = "http://www.geo.tv/article-" . trim($match[1]);

        $newscontent = file_get_contents($url_next);

        if (preg_match('~<a id="ctl00_ContentPlaceHolder1_HLHeading" title="(.+)" style=".+">~', $newscontent, $match)) {
            $title = strtoupper(trim($match[1]));
            echo $title . "\n";
        }
        if (preg_match('~<div id="article_content" class="single_article_content">(.+)<span id="ctl00_ContentPlaceHolder1_lblNewsSource" class="meta_comments">~Usi', $newscontent, $match)) {
            $data = $match[1];
            $data = preg_replace('~[\s]+~', " ", $data);
            $data = strip_tags($data);
            $data = preg_replace('~[\s]+~', " ", $data);
            echo $data;
        }
    }
    return $title . "\n" . $data;
}

function getdetailspak($url) {
    //$url = "http://dawn.com/news/1031326/secret-govt-document-reveals-scores-of-civilians-killed-in-us-drone-strikes";
    $content = file_get_contents($url);

    if (preg_match('~<div class="row-fluid story-content">(.+)</div>~Usi', $content, $match)) {
        $data = $match[1];
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = strip_tags($data);
        echo $data;
    }
    return $data;
}

?>
