<?php

if (preg_match("~^(namaz|loc change)\b~", $spell_checked, $match)) {
    echo "<br>CHANGE NAMAZ LOCATION<br>";
    $loc_req = str_replace($match[1], '', $spell_checked);
    $loc_req = preg_replace("~(<|>|\(|\))~", ' ', $loc_req);
    print_r($match);
    if (!preg_match("~\b(who|where)\b~", $loc_req, $match)) {
        $splited = matchdate($loc_req);
        if (isset($splited[2])) {
            $loc_req = $splited[0];
            $getdate = $splited[2];
            $istoday = false;
        } else {
            $getdate = strtotime('today');
            $istoday = TRUE;
        }
        $loc_req = preg_replace("~\b((namaz|loc|change|set|place|move|get|time|timing)s?|which|when|give|tell me|please|pleese|go|show|me|do|have|been|the|of|in|need|all|and|or|list|to|want|for|is|was|i|from)\b~", '', $loc_req);
        echo $loc_req = trim(preg_replace("~[\s]+~", " ", $loc_req));

        include 'namazloc.php';
        if ($total_return != '') {
            if ($istoday) {
                $options_list[] = "Tomorrow";
                $list[] = array("content" => "namaz tomorrow");
            }
            $to_logserver['source'] = 'namaz';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        } else {
            $list = array();
            $options_list = array();
        }
    }
}

//Namaz Location change Reply
if (preg_match("~^(namaz__match__loc )(.+) lat_ (.+) lng_ (.+)~", $spell_checked, $match)) {
    echo "<br>CHANGE NAMAZ LOCATION(REPLY)<br>";
    print_r($match);

    $free = true;
    $loc_req = $match[2];
    $lat = $match[3];
    $lng = $match[4];
    include 'namazloc.php';
    if ($total_return != '') {
        $to_logserver['source'] = 'namaz';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    } else {
        $list = array();
        $options_list = array();
    }
}
?>