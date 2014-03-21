<?php

if ($spell_checked == 'koran verse' || $spell_checked == 'quran verse' || $spell_checked == 'verse' || $spell_checked == 'quran' || $spell_checked == 'koran'||$spell_checked == 'verses') {

    mysql_close();
    include 'lib/configdb2.php';
    echo $query = "select * from devotional where religion='islam' and type='quran verses' order by rand() limit 1";
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $text = $row["text"];
        $id = $row["id"];
        $total_return = $text;
        $options_list[] = "Read another";
        $list[] = array("content" => "quran verse");
    }
    mysql_close();
    include 'lib/appconfigdb.php';
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'devotional';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if ($spell_checked == "dev" || $spell_checked == "devotional") {
    $total_return = "Select Your Religion";
    $options_list[] = "Hindu";
    $list[] = array("content" => "__religion__hindu__");
    $options_list[] = "Islam";
    $list[] = array("content" => "__religion__islam__");
    $options_list[] = "Christian";
    $list[] = array("content" => "__religion__christian__");
    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'devotional';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__religion__(.+)__~Usi", $req, $match)) {
    $religion = $match[1];
    if ($religion == "hindu") {
        $total_return = "Hindu Devotional Songs,Stories,Bhagavad Gita,Quotes!!!";
        $options_list[] = "Songs";
        $list[] = array("content" => "__dev__hindu__song__");
        $options_list[] = "Stories";
        $list[] = array("content" => "__dev__hindu__story__");
        $options_list[] = "Bhagavad Gita";
        $list[] = array("content" => "__dev__hindu__bhagavad gita__");
        $options_list[] = "Quotes";
        $list[] = array("content" => "__dev__hindu__quotes__");
    }
    if ($religion == "islam") {
        $total_return = "Islam Devotional Songs,Stories,Quaran Verses,Hadith!!!";
        $options_list[] = "Song";
        $list[] = array("content" => "__dev__islam__song__");
        $options_list[] = "Stories";
        $list[] = array("content" => "__dev__islam__story__");
        $options_list[] = "Quran  Verses";
        $list[] = array("content" => "__dev__islam__quran verses__");
        $options_list[] = "Hadith";
        $list[] = array("content" => "__dev__islam__hadith__");
    }
    if ($religion == "christian") {
        $total_return = "Christian Devotional Songs,Stories,Bible Verses!!!";
        $options_list[] = "Song";
        $list[] = array("content" => "__dev__christian__song__");
        $options_list[] = "Stories";
        $list[] = array("content" => "__dev__christian__story__");
        $options_list[] = "Bible Verses";
        $list[] = array("content" => "__dev__christian__bible verse__");
    }
    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'devotional';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__dev__(.+)__(.+)__~Usi", $req, $match)) {
    $religion = $match[1];
    $type = $match[2];

    mysql_close();
    include 'lib/configdb2.php';

    echo $query = "select * from devotional where religion='$religion' and type='$type' order by rand() limit 1";
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $text = $row["text"];
        $type = $row["type"];
        $id = $row["id"];
        $religion = $row["religion"];
    }
    $total_return = $text;
    $options_list[] = "Read Another";
    $list[] = array("content" => "__readanother__" . $religion . "__" . $type . "__" . $id . "__");
    mysql_close();
    include 'lib/appconfigdb.php';
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'devotional';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__readanother__(.+)__(.+)__(.+)__~Usi", $req, $match)) {
    $religion = $match[1];
    $type = $match[2];
    $id = $match[3];


    mysql_close();
    include 'lib/configdb2.php';

    echo $query = "select * from devotional where religion='$religion' and type='$type' and id>$id";
    $result = mysql_query($query);

    if (mysql_num_rows($result) == 0) {
        echo $query = "select * from devotional where religion='$religion' and type='$type'";
        $result = mysql_query($query);
    }
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $text = $row["text"];
        $type = $row["type"];
        $id = $row["id"];
        $religion = $row["religion"];
        $total_return = $text;
        $options_list[] = "Read Another";
        $list[] = array("content" => "__readanother__" . $religion . "__" . $type . "__" . $id . "__");
    }

    var_dump($options_list);
    var_dump($list);

    mysql_close();
    include 'lib/appconfigdb.php';
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'devotional';
        putOutput($total_return);
        exit();
    }
}
?>
