<?php

if ($req == "weather" && $circle_short == "AP") {
    echo "<h2>INSIDE WEATHER SPL CASE</h2>";
    echo $spell_checked = 'weather hyderabad';
    $add_below = "\n--\nTo know more SMS  weather <Cityname> to $shortcode";
}

//if ($spell_checked == "railway budget" || $spell_checked == "railway budget 2012" || $spell_checked == "rail budget" || $spell_checked == "railway budget highlights" || $spell_checked == "rail budget 2012" || $spell_checked == "railwaybudget" || $spell_checked == "railways budget" || $spell_checked == "railways budget 2012") {
//    $spell_checked = "rail_budget";
//    $options_list[] = "List of new trains";
//    $list[] = array("content" => "new_train");
//}
//if ($spell_checked == "list of new trains" || $spell_checked == "list of new trains in budget" || $spell_checked == "new trains" || $spell_checked == "new trains in railway budget" || $spell_checked == "new trains in budget 2012") {
//    $spell_checked = "new_train";
//    $options_list[] = "Highlights of railway budget 2012-13";
//    $list[] = array("content" => "rail_budget");
//}
echo "<br>before opera $req";
if ($req == "opera") {
    echo "inside opera";
    $total_return = "Download Opera Mini! Visit http://m.opera.com \n(browsing charges apply)";
    $to_logserver['source'] = 'canned';
    putOutput($total_return);
    exit();
}

if ($operator == "airtel") {
    if ($req == "search" || $req == "hi" || $req == "hello") {
        $req = "help";
    }
}

if ($req == "help") {
    echo $query = "SELECT msg,`msg_id`,`isFree` FROM `help_operator`,`help_msg` WHERE `help_msg`.id=`help_operator`.`msg_id` and ((`operator`='$operator' and `circle`='$circle_short') OR (operator='$userid') OR (operator='$user_country')) ORDER BY help_operator.id";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
//        $showsuboption = false;
        $row = mysql_fetch_array($result);
        $total_return = $row["msg"];
        $free = $row["isFree"];
        $current_file = "help_msg/msg/id/" . $row['msg_id'];
        $source_machine = "db";
        $to_logserver['source'] = 'helpmsg';
        $total_return = preg_replace("~((airtel|unlimited) ?gyan)~i", $product_name, $total_return);
        $total_return = preg_replace("~\b(55444)\b~i", $shortcode, $total_return);
        $total_return = preg_replace("~\b(9056)\b~i", $shortcode, $total_return);
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif ($req == "keyword" || $req == "keywords") {
    echo "keywords";
    echo $query = "SELECT msg,`msg_id`,`isFree`,keywordid FROM `help_operator`,`help_msg` WHERE `help_msg`.id=`help_operator`.`keywordid` and ((`operator`='$operator' and `circle`='$circle_short') OR (operator='$userid') OR (operator='$user_country')) ORDER BY help_operator.id";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
//        $showsuboption = false;
        $row = mysql_fetch_array($result);
        $total_return = $row["msg"];
        $free = $row["isFree"];
        $current_file = "help_msg/msg/id/" . $row['keywordid'];
        $source_machine = "db";
        $to_logserver['source'] = 'helpkeyworrd';
        $total_return = str_replace("easy search", $product_name, $total_return);
        $total_return = preg_replace("~\b(55444)\b~i", $shortcode, $total_return);
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}


echo $query = "SELECT * FROM canned_responses WHERE question='" . mysql_real_escape_string($spell_checked) . "'";
$result = mysql_query($query);
if (mysql_num_rows($result)) {
    echo "<h3>CANNED RESPONSE</h3>";
    $flag_enabled = false;

    if ($spell_checked == "upsc tips") {
        $options_list[] = "recommended books";
        $list[] = array("content" => "IAS Preliminary (CSAT) Exam Books");
    } elseif ($spell_checked == "aieee tips") {
        $options_list[] = "recommended books";
        $list[] = array("content" => "recommended books for aieee");
    } elseif ($spell_checked == "medical tips") {
        $options_list[] = "recommended books";
        $list[] = array("content" => "Books for Medical Entrance Exam");
    } elseif ($spell_checked == "cat exam tips") {
        $options_list[] = "recommended books";
        $list[] = array("content" => "books for cat exam");
    } elseif ($spell_checked == "what to do on a date with a boy") {
        $options_list[] = "what to do on a date with a girl";
        $list[] = array("content" => "what to do on a date with a girl");
    } elseif ($spell_checked == "what to do on a date with a girl") {
        $options_list[] = "what to do on a date with a boy";
        $list[] = array("content" => "what to do on a date with a boy");
    } elseif ($spell_checked == "how to dress for a date for girl") {
        $options_list[] = "how to dress for a date for boy";
        $list[] = array("content" => "how to dress for a date for boy");
    } elseif ($spell_checked == "how to dress for a date for boy") {
        $options_list[] = "how to dress for a date for girl";
        $list[] = array("content" => "how to dress for a date for girl");
    } elseif ($spell_checked == "indian independence history") {
        $options_list[] = "Freedom Fighters";
        $list[] = array("content" => "id fighters");
    } elseif ($spell_checked == "eid-ul-fitr traditions") {
        $options_list[] = "eid decorations";
        $list[] = array("content" => "eid decorations");
    } else if ($spell_checked == "eid decorations") {
        $options_list[] = "main menu";
        $list[] = array("content" => "eid");
    } elseif (strpos($spell_checked, 'movie') !== false && strpos($spell_checked, 'movie') == 0) {

        $spell_checked = str_replace("movie", "", $spell_checked);

        $can_title = $spell_checked;
        $hello_title = $can_title;

        //suggestion for helloTune
        include 'helloTune.php';
    }

    $row = mysql_fetch_array($result);
    $total_return = $row['answer'];
    if ($row['image_id']) {
        $word = $row['photo_word'];
        $subfunction = 7;
        $kcr = kript($numbers, $row['image_id'], $op_kript);
        $img_return = 'http://IP/' . $kcr;
        $newyear_enabled = FALSE;
    }
    $current_file = "canned_responses/answer/id/" . $row['id'];
    $source_machine = "db";
    $to_logserver['source'] = $row['source'];
    if ($row['source'] == 'iplstats') {
        $ipl_stats = apc_fetch('iplstats', $success);
        if (!$success) {
            $query = "select question from canned_responses where source='iplstats'";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            $ipl_stats[] = mysql_num_rows($result);
            while ($row = mysql_fetch_array($result)) {
                $ipl_stats[] = $row['question'];
            }
            apc_store('iplstats', $ipl_stats);
            echo "from DB";
        }
        $rnd = rand(1, $ipl_stats[0]);
        $options_list[] = $ipl_stats[$rnd];
        $list[] = array("content" => $ipl_stats[$rnd]);
    }

    echo "<br>Product Name: $product_name";
    echo "<br>Total return: $total_return";
    $total_return = preg_replace("~((airtel|unlimited) ?gyan)~i", $product_name, $total_return);
    echo "<br>Total return2 $shortcode : $total_return";
    $total_return = preg_replace("~\b(55444)\b~i", $shortcode, $total_return);
    $total_return = preg_replace("~\b(9056)\b~i", $shortcode, $total_return);
    echo "<br>Total return3 $shortcode : $total_return";
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>