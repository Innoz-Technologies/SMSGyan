<?php

if (preg_match("~__lovmsg__(.+)__~si", $req, $match)) {
    $id = $match[1];
    $query = "select * from sms_messages where keywords='love' and id!='$id' order by rand() limit 1";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $msg = $row["content"];
        $total_return = $msg;
        $id = $row["id"];
    }
    if (!empty($total_return)) {
        $options_list[] = "Read next message";
        $list[] = array("content" => "__lovmsg__" . $id . "__");
        $current_file = "sms_messages/content/id/$id";
        $source_machine = "db";
        include 'allmanip.php';
        $to_logserver['source'] = 'lovemsg';
        putOutput($total_return);
        exit();
    }
}
if ($req == "love" || $req == "luv" || $req == "lov" || $req == "l0ve" || (($spell_checked == "i love you" || $spell_checked == "i love u" || $spell_checked == "i luv u") && $operator == "vodafone")) {
    $query = "select * from sms_messages where keywords='love' order by rand() limit 1";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $msg = $row["content"];
        $total_return = $msg;
        $id = $row["id"];
    }
    if (!empty($total_return)) {
        $options_list[] = "Read next message";
        $list[] = array("content" => "__lovmsg__" . $id . "__");
        $current_file = "sms_messages/content/id/$id";
        $source_machine = "db";
        include 'allmanip.php';
        $to_logserver['source'] = 'lovemsg';
        putOutput($total_return);
        exit();
    }
}
?>
