<?php

echo '<br>SEARCH BING NEWS<br>';
$url_list = array("deccanherald", "timesofindia.indiatimes", "reuters", "ibnlive", "ndtv", "bbc", "cricbuzz", "mid-day", "thehindu", "entertainment.oneindia", "dnaindia", "hindustan");
$contents = bingNewsSearch($word);
$pl = xml_parser_create();
$xmlObj = xml_parse_into_struct($pl, $contents, $vals, $index);
xml_parser_free($pl);
$ar_in = 0;
$search_url = array();
$chkurl = true;
$isNotSet = true;
$search_titles = '';
$bing_news2 = '';
$bing_title = '';
$priority = $set_priority = 100;

//    print_r($vals);
if ($isFromNews) {
    foreach ($vals as $key => $item) {
        if ($item['tag'] == "NEWS:TITLE") {
            $news_title_key[] = $key;
            if (isset($item['value'])) {
                $bing_news .= strtoupper($item['value']) . "\n";
                $bing_news2 .= strtoupper($item['value']) . '<br>';
                $search_title[] = $item['value'];
            }
        }
        if ($item['tag'] == "NEWS:SNIPPET") {
            $news_snippet_key[] = $key;
            if (isset($item['value'])) {
                $bing_news .= $item['value'] . "\n";
                $bing_news2 .= $item['value'] . '<br>';
            }
        }
        if ($item['tag'] == "NEWS:URL") {
            $news_url_key[] = $key;
            preg_match("~http://(.+)/~Usi", $item['value'], $match);
            $url_bing = $match[1];
            $url_bing = preg_replace("~www\.|\.com|\.co|\.in|af\.|au\.|\.uk|uk\.|\.net|.\cms|\.ece|\.org|\.au|in\.~", "", $url_bing);
            $matched_urls[] = trim($url_bing);
            if (isset($item['value'])) {
                $search_url[] = $item['value'];
                $bing_news2 .= $item['value'] . '<br>';
            }
        }
        $ar_in++;
    }
    print_r($search_url);
    echo "<br><br>NEWS from BING : " . $bing_news2;
    include 'news_search_1.php';
    $total_return = $data;
    if (empty($total_return)) {
        $total_return = $bing_news;
    }
    file_put_contents(DATA_PATH . "/news/$numbers", $total_return);
} else {
    echo "<h3>checking date</h3>";
    foreach ($vals as$key => $item) {
        if ($item['tag'] == "NEWS:TITLE") {
            if (isset($item['value'])) {
                $searched_title = $item['value'];
                if (!empty($bing_title)) {
                    $bing_title = $searched_title;
                }
            }
        }

        if ($item['tag'] == "NEWS:URL") {
            if (isset($item['value'])) {
                preg_match("~http://(.+)/~Usi", $item['value'], $match);
                $url_bing = $match[1];
                $url_bing = trim(preg_replace("~www\.|\.com|\.co|\.in|af\.|au\.|\.uk|uk\.|\.net|.\cms|\.ece|\.org|\.au|in\.~", "", $url_bing));
                $matched_urls[] = trim($url_bing);

                if (strpos($url_bing, "deccanherald") !== FALSE) {
                    $priority = 6;
                } elseif (strpos($url_bing, "timesofindiadiatimes") !== FALSE) {
                    $priority = 1;
                } elseif (strpos($url_bing, "hindustan") !== FALSE) {
                    $priority = 5;
                } elseif (strpos($url_bing, "reuters") !== FALSE) {
                    $priority = 2;
                } elseif (strpos($url_bing, "ibnlive") !== FALSE) {
                    $priority = 4;
                } elseif (strpos($url_bing, "ndtv") !== FALSE) {
                    $priority = 3;
                } elseif (strpos($url_bing, "bbc") !== FALSE) {
                    $priority = 8;
                } elseif (strpos($url_bing, "cricbuzz") !== FALSE) {
                    $priority = 12;
                } elseif (strpos($url_bing, "mid-day") !== FALSE) {
                    $priority = 9;
                } elseif (strpos($url_bing, "thehindu") !== FALSE) {
                    $priority = 7;
                } elseif (strpos($url_bing, "entertainment") !== FALSE) {
                    $priority = 10;
                } elseif (strpos($url_bing, "dnaindia") !== FALSE) {
                    $priority = 11;
                }

//                if ($chkurl) {
                if ($set_priority > $priority) {
//                    if (in_array($url_bing, $url_list) && $set_priority > $priority) {
//                        $chkurl = false;
                    echo "<br>tiltle is" . $search_titles = trim($searched_title);
                    $set_priority = $priority;
                    echo "<br>$url_bing";
                }
//                }
            }
        }

        if ($isNotSet) {
            if ($item['tag'] == "NEWS:DATE") {
                if (isset($item['value'])) {

                    date_default_timezone_set('Asia/Calcutta');
                    $date1 = date('Y-m-d', strtotime($item['value']));
                    $date2 = date('Y-m-d');
                    $date_diff = strtotime($date2) - strtotime($date1);
                    $date_diff = (int) ($date_diff / (60 * 60 * 24));
                    if ($date_diff < 4) {
                        $isNotSet = false;
                    }
                }
            }
        }
    }
    if (empty($search_titles)) {
        $search_titles = trim($bing_title);
    }

    if ($isNotSet == false && !empty($search_titles)) {
        if (strlen($search_titles) > 30) {
            $search_titles = substr($search_titles, 0, 40) . "...";
        }
        $options_list[] = "Also Read: $search_titles";
        $list[] = array("content" => "News $spell_checked");
        var_dump($options_list);
    }
}


function bingNewsSearch($query) {
    $search = urlencode($query);
    echo $url = "http://api.bing.net/xml.aspx?AppId=386E2BBA48760D31251DF7D7A601E77C360D8D72&Verstion=2.2&Market=en-IN&Query=$search&Sources=News&web.count=1&xmltype=elementbased&Adult=Off";
    $response = httpGet($url);
    return $response;
}

?>