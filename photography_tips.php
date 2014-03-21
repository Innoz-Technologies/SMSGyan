<?php

if (preg_match("~^\b(mobile (photo|camera|photography) tips?|how to take good photos? from mobile|mpt)\b~", $spell_checked)) {
    mysql_close();
    include 'lib/configdb2.php';

    $query = "select * from photo_tips where id=1";
    $res = mysql_query($query);

    if (mysql_num_rows($res)) {
        $row = mysql_fetch_array($res);
        $head = $row["head"];
        $desc = $row["description"];
        $id = $row["id"];

        $total_return = strtoupper($head) . "\n" . $desc;
    }

    if (!empty($total_return)) {
        $options_list[] = "Read next tip";
        $list[] = array("content" => "__phototip__" . $id . "__");
        $options_list[] = "best scenes to photograph";
        $list[] = array("content" => "best scenes to photograph");
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'phototip';
        putOutput($total_return);
        exit();
    }

    mysql_close();
    include 'lib/appconfigdb.php';
} elseif (preg_match("~__phototip__(.+)__~", $req, $match)) {

    mysql_close();
    include 'lib/configdb2.php';

    $id = $match[1];
    $id = $id + 1;

    if ($id == 12) {
        $id = 1;
    }

    $query = "select * from photo_tips where id=$id";
    $res = mysql_query($query);

    if (mysql_num_rows($res)) {
        $row = mysql_fetch_array($res);
        $head = $row["head"];
        $desc = $row["description"];
        $id = $row["id"];

        $total_return = strtoupper($head) . "\n" . $desc;
    }

    mysql_close();
    include 'lib/appconfigdb.php';

    if (!empty($total_return)) {
        $options_list[] = "Read next tip";
        $list[] = array("content" => "__phototip__" . $id . "__");
        $options_list[] = "best scenes to photograph";
        $list[] = array("content" => "best scenes to photograph");
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'phototip';
        putOutput($total_return);
        exit();
    }
}
?>
