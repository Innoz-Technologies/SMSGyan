<?php

if (preg_match("~\b^(news)\b(.+)?~si", $spell_checked, $match)) {
    echo "<h4>INSIDE THAILAND NEWS SEARCH</h4>";

    var_dump($match);

    if (isset($match[2]) && trim($match[2]) != "") {
        $thai_news = searchAllThailandNews(trim($match[2]));
    } else {
        $thai_news = getAllThailandNews();
    }

    if (!empty($thai_news)) {
        $options_list = $thai_news['options_list'];
        $list = $thai_news['list'];

        if (isset($match[2]) && trim($match[2]) != "") {
            $total_return = "Matches for '" . trim($match[2]) . "'";
        } else {
            $total_return = "News";
        }
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'thai_news';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    } else {
        $total_return = "No news found!";
        $to_logserver['source'] = 'thai_news';
        $to_logserver['isresult'] = 0;
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} else if (preg_match("~__thai__news__(.+)~si", $req, $match)) {
    echo "<h4>INSIDE THAILAND NEWS SEARCH</h4>";
    echo $url = $match[1];

    $thai_news = getThailandNews($url);

    if (!empty($thai_news)) {
        $total_return = $thai_news;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'thai_news';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    } else {
        $total_return = "No news found!";
        $to_logserver['source'] = 'thai_news';
        $to_logserver['isresult'] = 0;
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function getAllThailandNews() {

//	$ch = curl_init();
//	curl_setopt($ch, CURLOPT_URL, "http://www.bangkokpost.com/rss/data/news.xml");
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//	$content = curl_exec ($ch);	
//	curl_close ($ch);


    $content = httpGet('http://www.bangkokpost.com/rss/data/news.xml');
    var_dump($content);
    $return = array();

    if (preg_match_all("~<item>(.+)</item>~Usi", $content, $matches)) {
        //var_dump($matches);
        for ($i = 0; $i < count($matches[1]); $i++) {
            if (preg_match("~<title>(.+)</title>~Usi", $matches[1][$i], $match)) {
                $title = trim(html_entity_decode($match[1], ENT_QUOTES));
                $title = str_replace("&#039", "'", $title);
                //echo "<br>";
            }

            if (preg_match("~<link>(.+)</link>~Usi", $matches[1][$i], $match)) {
                $link = trim(html_entity_decode($match[1], ENT_QUOTES));
            }

            $options_list[$i] = $title;
            $list[$i] = array("content" => "__thai__news__" . $link);
        }

        $return['options_list'] = $options_list;
        $return['list'] = $list;
    }

    return $return;
}

function getThailandNews($url) {
//	$ch = curl_init();
//	curl_setopt($ch, CURLOPT_URL, $url);
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//	$content = curl_exec ($ch);	
//	curl_close ($ch);
    echo $url;
    $content = httpGet($url);
    $result = "";

    if (preg_match('~<div id="headergroup">(.+)<!-- audio -->~Usi', $content, $match)) {
        $result = preg_replace('~<div class="articlePhotoLeft">(.+)</div>~Usi', "", $match[1]);
        $result = preg_replace('~<ul>(.+)</ul>~Usi', "", $result);

        $result = trim(str_replace("</h2>", "***", $result));
        $result = trim(str_replace("</p>", "***", $result));
        $result = strip_tags($result);
        $result = trim(preg_replace("~[\s]+~", " ", $result));
        $result = trim(str_replace("***", "\n", $result));
        $result = trim(str_replace("\n ", "\n", $result));
        $result = html_entity_decode($result, ENT_QUOTES);
        $result = str_replace("&#039", "'", $result);
    }

    return $result;
}

function searchAllThailandNews($search) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.bangkokpost.com/search/news-and-article/" . $search);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($ch);
    curl_close($ch);

    $return = array();

    if (preg_match('~<ol id="thailandSearchList">(.+)</ol>~Usi', $content, $match)) {
        if (preg_match_all("~<li>(.+)</li>~Usi", $match[1], $matches)) {
            //var_dump($matches);
            for ($i = 0; $i < count($matches[1]); $i++) {
                if (preg_match("~<h3>(.+)</h3>~Usi", $matches[1][$i], $match1)) {
                    $title = trim(html_entity_decode(strip_tags($match1[1]), ENT_QUOTES));
                    $title = str_replace("&#039", "'", $title);
                    //echo "<br>";
                }

                if (preg_match('~<h3><a href="(.+)" target="_blank">~Usi', $matches[1][$i], $match1)) {
                    $link = trim(html_entity_decode($match1[1], ENT_QUOTES));
                }

                $options_list[$i] = $title;
                $list[$i] = array("content" => "__thai__news__http://www.bangkokpost.com" . $link);
            }
        }

        $return['options_list'] = $options_list;
        $return['list'] = $list;
    }

    return $return;
}

?>