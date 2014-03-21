<?php

if ($free) {
    $len_max = 250;
} else {
    $len_max = 200;
}

mysql_close();
include 'lib/configdb2.php';

if (preg_match("~\b((savitha|savita).+(babi|bhabi|bhabbi|bhabhi))\b~", $spell_checked)) {

    $query = "select * from story_epd";
    $result = mysql_query($query);
    $len = 0;

    while ($row = mysql_fetch_array($result)) {
        $len = $len + strlen($row["titles"]) + 3;
        if ($len < $len_max) {
            $options_list[] = $row["titles"];
            $list[] = array("content" => "_storyepd__" . $row['id'] . "_");
            $lid = $row["id"];
        } else {
            $options_list[] = "More Options";
            $list[] = array("content" => "_storyepdmore__" . $lid . "_");
            break;
        }
    }
    if (count($options_list) > 0) {
        $total_return = "Stories Of Savitha Bhabi";
    }
}
if (preg_match("~_storyepd__(.+)_~", $req, $match1)) {
    $epd = $match1[1];
    echo $query = "select story from story_epd where id=$epd";
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $story_epd = $row['story'];
        $total_return = $story_epd;
    }
}
if (preg_match("~_storyepdmore__(.+)_~", $req, $match2)) {
    $id1 = $match2[1];
    $query = "select * from story_epd where id>$id1";
    $result = mysql_query($query);
    $len = 0;
    while ($row = mysql_fetch_array($result)) {
        $len = $len + strlen($row["titles"]) + 3;
        if ($len < $len_max) {
            $options_list[] = $row["titles"];
            $list[] = array("content" => "_storyepd__" . $row['id'] . "_");
            $lid = $row["id"];
        } else {
            $options_list[] = "More Options";
            $list[] = array("content" => "_storyepdmore__" . $lid . "_");
            break;
        }
    }
    if (count($options_list) > 0) {
        $total_return = "Stories Of Savitha Bhabi";
    }
}

mysql_close();
include 'lib/appconfigdb.php';

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'storyepsd';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
