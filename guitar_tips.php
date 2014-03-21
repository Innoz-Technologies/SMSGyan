<?php

if (((strpos($spell_checked, "learn") !== false || strpos($spell_checked, "tip") !== false) && strpos($spell_checked, "guitar") !== false) || $spell_checked == "lgu") {
    mysql_close();
    include 'lib/configdb2.php';

    $query = "select * from guitar_tips where id=1";
    $res = mysql_query($query);

    if (mysql_num_rows($res)) {
        $row = mysql_fetch_array($res);
        $head = $row["head"];
        $tip = $row["tip"];
        $id = $row["id"];

        $total_return = $head . "\n" . $tip;
    }

    mysql_close();
    include 'lib/appconfigdb.php';

    if (!empty($total_return)) {
        $options_list[] = "Read next tip";
        $list[] = array("content" => "__nexttip__" . $id . "__");
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'gtip';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__nexttip__(.+)__~", $req, $match)) {
    $id = $match[1];
    $id = $id + 1;

    if ($id == "12") {
        $id = 1;
    }

    mysql_close();
    include 'lib/configdb2.php';

    $query = "select * from guitar_tips where id=$id";
    $res = mysql_query($query);

    if (mysql_num_rows($res)) {
        $row = mysql_fetch_array($res);
        $head = $row["head"];
        $tip = $row["tip"];
        $id = $row["id"];

        $total_return = $head . "\n" . $tip;
    }

    mysql_close();
    include 'lib/appconfigdb.php';

    if (!empty($total_return)) {
        $options_list[] = "Read next tip";
        $list[] = array("content" => "__nexttip__" . $id . "__");
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'gtip';
        putOutput($total_return);
        exit();
    }
}
?>
