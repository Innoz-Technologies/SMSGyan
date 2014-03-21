<?php

var_dump($player);
$treturn = '';
if($match_type) {
    if($match_type == "wimbledon_completed") {
        $query = "Select * from tennis_completed";
        $result = mysql_query($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_array($result)) {
                $treturn .= $row['details'];
            }
        }
    } else if($match_type == "wimbledon_upcoming") {
        $query = "Select * from tennis";
        $result = mysql_query($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_array($result)) {
                $ttime = strtotime($row['Playtime'] . " + 5 hours 30 minutes");
                $ttime = date("H:i", $ttime);
                $treturn .= $row['Matches'] . "\n" . $row['Court'] . "\n" . "Start Time : " . $ttime;
            }
        }
    }
}else if ($player != '') {
    $query = "Select * from tennis where Matches like '%" . mysql_real_escape_string($player) . "%'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $response = mysql_fetch_array($result);
        $ttime = strtotime($response['Playtime'] . " + 5 hours 30 minutes");
        $ttime = date("H:i", $ttime);
        $treturn = $response['Matches'] . "\n" . $response['Court'] . "\n" . "Start Time : " . $ttime;
    }
} else {
    $query = "Select * from tennis";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_array($result)) {
            $ttime = strtotime($row['Playtime'] . " + 5 hours 30 minutes");
            $ttime = date("H:i", $ttime);
            $treturn .= $row['Matches'] . "\n" . $row['Court'] . "\n" . "Start Time : " . $ttime;
        }
    }
}

$current_file = "/tennis/$numbers";
file_put_contents(DATA_PATH . $current_file, $treturn);

$source_machine = "$machine_id";
$total_return = $treturn;
//$add_below = "\n--\nForward Lyrics to your lover! Sms LYRICS songname to 55444. For eg. LYRICS te amo.";

var_dump($total_return);
var_dump($options_list);
var_dump($list);
include 'allmanip.php';
var_dump($total_return);
var_dump($options_list);
var_dump($list);

$outs = serialize($list);
foreach ($list as $l) {
    $l['count'] = mb_convert_encoding($l['content'], "UTF-8");
}
file_put_contents(DATA_PATH . "/lists/$numbers", $outs);
$q = 'delete from lists where number="' . $numbers . '"';
mysql_query($q) or trigger_error(mysql_error() . " in $q", E_USER_ERROR);

$q = 'replace into lists (machine_id,number,query_id) VALUES ("' . $machine_id . '","' . $numbers . '","' . $query_id . '")';
mysql_query($q) or trigger_error(mysql_error() . " in $q", E_USER_ERROR);
?>