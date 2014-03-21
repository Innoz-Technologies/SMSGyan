<?php

if (preg_match("~__factsdesc__(.+)__~", $req, $match)) {

    var_dump($match);
    $url = trim($match[1]);

    $query = "select * from randomfacts where url='$url'";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        echo $facts = $row['description'];
        $id = $row['id'];
        $total_return = html_entity_decode($facts);
        $options_list[] = "Read Next Fact";
        $list[] = array("content" => "__factsnext__" . $id . "__");
    }
//    $content = file_get_contents($url);
//    if (preg_match("~<div class=\"singlepostcontent\">(.+)</script>~Usi", $content, $descrptn)) {
//        $facts = $descrptn[1];
//        $facts = trim(preg_replace("~[\s]+~", " ", $facts));
//        $facts = strip_tags($facts);
//        $facts = html_entity_decode($facts);
//        $facts = trim(preg_replace("~[\s]+~", " ", $facts));
//        $facts = trim(str_replace("[Source: Dailymail]", "", $facts));
//        echo $facts;
//        echo $query = "update randomfacts set description='$facts' where url='$url'";
//        if (mysql_query($query)) {
//            echo "<br>Record Inserted";
//        }
//        $total_return = $facts;
//        $options_list[] = "Read Next Fact";
//        $list[] = array("content" => "facts");
//    }
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'whatthefact';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__factsnext__(.+)__~", $req, $match)) {

    var_dump($match);
    $id = trim($match[1]);

    $query = "select * from randomfacts where subhead!='' and id!='$id' order by rand() limit 1";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        echo $url = $row['url'];
        $id = $row['id'];
        $fact_head = html_entity_decode($row['head']);
        $subhead = html_entity_decode($row['subhead']);
//        $fact_data = $row['description'];
    }
    if (!empty($fact_head)) {
        $total_return = strtoupper($fact_head) . "\n" . $subhead;
        $options_list[] = "Read more about this fact";
        $list[] = array("content" => "__factsdesc__" . $url . "__");
        $options_list[] = "Read Next Fact";
        $list[] = array("content" => "__factsnext__" . $id . "__");
    }
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'whatthefact';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~\b^(fact|facts)\b~", $spell_checked)) {
    echo "<h1>WHATTHEFACT</h1>";
    $query = "select * from randomfacts where subhead!='' order by rand() limit 1";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        echo $url = $row['url'];
        $id = $row['id'];
        $fact_head = html_entity_decode($row['head']);
        $subhead = html_entity_decode($row['subhead']);
//        $fact_data = $row['description'];
    }

//    $content = file_get_contents($url);
//
//    if (preg_match("~<div class=\"posttitle\"><h1>(.+)</h1>~Usi", $content, $title)) {
//        $head = html_entity_decode($title[1]);
//        $query = "update randomfacts set head='$head' where url='$url'";
//        if (mysql_query($query)) {
//            echo "<br>Record Inserted";
//        }
//    }
//    if (preg_match("~<b>(.+)</b></div>~Usi", $content, $subtitle)) {
//        $subhead = html_entity_decode($subtitle[1]);
//    }
//    }
//
//    if (preg_match_all("~<div class='imghere'><a href='(.+)'>~Usi", $content, $match)) {
//        foreach ($match[1] as $url_next) {
//            echo $query = "insert ignore into randomfacts(url) values ('$url_next')";
//            if (mysql_query($query)) {
//                echo "<br>Record Inserted";
//            }
//        }
//    }

    if (!empty($fact_head)) {
        $total_return = strtoupper($fact_head) . "\n" . $subhead;
        $options_list[] = "Read more about this fact";
        $list[] = array("content" => "__factsdesc__" . $url . "__");
        $options_list[] = "Read Next Fact";
        $list[] = array("content" => "__factsnext__" . $id . "__");
    }
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'whatthefact';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>