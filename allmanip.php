<?php

$mandatory_photo_sugg = false;

if (!isset($list) || count($list) == 0) {
    $list = array();
}
if (!isset($options_list) || count($options_list) == 0) {
    $options_list = array();
}
$cnt = 1;

echo "\n<br>testing google search results<br>\n";
var_dump($ask_or_wiki);
var_dump($google_search_results);
echo "\n<br>---------<br>\n";
echo "ask_or_wiki: $ask_or_wiki<br>\n";
if (($ask_or_wiki != 'wiki' || ($subfunction == 5 && $movie_return)) && is_array($google_search_results)) {
    echo "\n<br>listing google search<br>\n";
    if (!count($list)) {
        $list = array();
    }
    $read_also = '';

    $query = "SELECT related FROM data WHERE global_id='$global_id'";
    $result = mysql_query($query) or trigger_error("Error in $query: " . mysql_error());
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_row($result);
        $read_also = strlen($row[0]) > 0 ? $row[0] : '';
    }
    if (!$read_also) {
        echo "\n<br>read also from google<br>\n";

        if ($mwiki_return['article_title']) {
            if ($mwiki_return['article_title'] != '') {
                $read_also = $mwiki_return['article_title'];
                $query = "UPDATE data SET related='$read_also' WHERE global_id = '$global_id'";
                mysql_query($query) or trigger_error("Error in $query: " . mysql_error());
            }
        }
    }

    if ($read_also && ($mwiki_return != '' || $subfunction == 5)) {
        $options_list[] = "Also read: '" . str_replace("_", " ", $read_also) . "'";
        $list[] = array("content" => $read_also, "type" => "Also read");
    } else {
        echo "No also read:<bR>read also: ";
        var_dump($read_also);
    }
    print_r($list);
    echo "\n<br>---------------<br>\n";
}

//echo $total_return;
echo "<br><h2>TIME before cmore :" . (microtime(TRUE) - $time_start) . "</h2><br>";
echo "<h3>";
echo "current file: " . $current_file . '</h3>';
if ($operator == 'api' || $operator == 'wap' || $outPutType == "xml") {
    include 'cmoreapi.php';
} else {
    echo "<br><bR>";

    echo "<br>Options.php<br>";
    include 'options.php';

    echo "<h5>cmored</h5>opt_list:";
    echo $total_return;
    print_r($list);
    echo "<br>";
}
echo "<br><h2>TIME before list :" . (microtime(TRUE) - $time_start) . "</h2><br>";
print_r($options_list);

foreach ($list as $l) {
    $l['count'] = mb_convert_encoding($l['content'], "UTF-8");
}

//if (count($listAll) > 0) {
//    $outs = serialize($listAll);
//    file_put_contents(DATA_PATH . "/lists/$numbers", $outs);
//}

echo "<br><h2>TIME all manip end :" . (microtime(TRUE) - $time_start) . "</h2><br>";
if ($numbers != 'gyantest' && ($isReturn || $app_name)) {
    $to_cache['m'] = $machine_id;
    $to_cache['q'] = $query_id;
    if ($app_name) {
        $to_cache['a'] = $app_name;
        //
        if ($xmlappFlag) {
            $to_cache['x'] = TRUE;
        } else {
            $to_cache['x'] = FALSE;
        }
        //modified on 12th jan
    }
    if ($nextfree) {
        $to_cache['f'] = $nextfree;
    }

    if (!empty($to_cache)) {
        $expiry_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +1 Day"));
        $to_cache["expiry"] = $expiry_date;
        $arCacheData["ca"] = $to_cache;
    }
}
?>