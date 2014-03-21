<?php

$pl = xml_parser_create();
$xmlObj = xml_parse_into_struct($pl, $news_in, $vals, $index);
xml_parser_free($pl);
$ar_in = 0;
$search_url = array();
$chkurl = true;
$isNotSet = true;
$search_titles = '';
$bing_news2 = '';
$bing_title = '';
$priority = $set_priority = 100;
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
            $url_bing = preg_replace("~www\.|\.com|\.co|\.in|af\.|au\.|\.uk|uk\.|\.net|.\cms|\.ece|\.org|\.au|in\.~", "", $url_bing);
            $matched_urls[] = trim($url_bing);

            if (strpos($url_bing, "deccanherald") !== FALSE) {
                $priority = 2;
            } elseif (strpos($url_bing, "timesofindia") !== FALSE) {
                $priority = 1;
            } elseif (strpos($url_bing, "reuters") !== FALSE) {
                $priority = 4;
            } elseif (strpos($url_bing, "ibnlive") !== FALSE) {
                $priority = 3;
            } elseif (strpos($url_bing, "ndtv") !== FALSE) {
                $priority = 5;
            } elseif (strpos($url_bing, "bbc") !== FALSE) {
                $priority = 7;
            } elseif (strpos($url_bing, "cricbuzz") !== FALSE) {
                $priority = 11;
            } elseif (strpos($url_bing, "mid-day") !== FALSE) {
                $priority = 8;
            } elseif (strpos($url_bing, "thehindu") !== FALSE) {
                $priority = 6;
            } elseif (strpos($url_bing, "entertainment") !== FALSE) {
                $priority = 9;
            } elseif (strpos($url_bing, "dnaindia") !== FALSE) {
                $priority = 10;
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

//var_dump($matched_urls);
//if (!empty($matched_urls)) {
//    $q = "insert into bing_api_urls(url) VALUES";
//    foreach ($matched_urls as $id => $uVal) {
//        if ($id == 0) {
//            $q .="('" . mysql_real_escape_string($uVal) . "')";
//        } else {
//            $q .=",('" . mysql_real_escape_string($uVal) . "')";
//        }
//    }
//    echo "<br>$q";
//    if (mysql_query($q)) {
//        echo "<br>Record inserted to bing_api_urls<br>";
//    }
//}
?>