<?php

echo "<h2>New more.php</h2>";

if (!empty($listAll["target"])) {
    $showSub = false;
    $current_file = $listAll["target"];
    $cut_pos = $position = $listAll["position"];
    $source_machine = $m = $listAll['machine_id'];
    if (stripos($file, "www/gyan")) {
        $m = 2;
    }

    if ($m == "db") {
        
        $fields = explode("/", $current_file);
        echo "<br>request table<br>";
        print_r($fields);
        echo "<br>";
        if ($fields[0] == 'canned_responses' && in_array($fields[3], array(25, 26, 100))) {
            $free = true;
        }
        $query = "SELECT " . $fields[1] . " FROM " . $fields[0] . " WHERE `" . $fields[2] . "` = '" . mysql_real_escape_string($fields[3]) . "'";
        $result = mysql_query($query) or die(mysql_error() . " in $query");
        $row = mysql_fetch_row($result);
        echo "<br>row<br>";
        print_r($row);
        echo "<br>";
        $content = str_replace("\r", "\n", $row[0]);

        $content = trim($content);
    } else {
        $content = get_file_contents($current_file, $m);
        if (!$content) {
            sleep(1);
            $content = get_file_contents($current_file, $m);
        }
    }

    if (isset($arCacheData["ca"]['f'])) {
        if ($arCacheData["ca"]['f'] == 1) {
            $free = true;
            $nextfree = 1;
        } else if ($arCacheData["ap"]['d'] == date("Y-m-d")) {
            $free = true;
            $nextfree = 2;
        } else {
            $free = FALSE;
            $nextfree = 2;
        }
    }
    $total_return = $content;
} else {
    echo "\n<br>empty query result<br>\n";
    $total_return = $no_result_string;
}

unset($lists);
unset($options_list);
unset($recom_opns_list);
unset($recom_list);
unset($list);

if ($total_return) {
    $to_logserver['source'] = 'more';
    include 'allmanip.php';
    putOutput($total_return);
}
?>
