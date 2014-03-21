<?php

$total_return = '';
$code = '';
$time = (int) date('G');
echo "<br>Tv now check started link: $link<br>";

$query = "select * from tvnow_channel where name like '%" . $tv_req . "%' order by length(name) limit 1";
$result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
echo "<br>TVQUERY: $query";

if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_array($result);
    $link = $row['link'];
    $dname = $row['dname'];
} else {
    $query = "SELECT * from tvnow_channel where SUBSTRING(SOUNDEX(name),1,4) = SUBSTRING(SOUNDEX('" . $tv_req . "'),1,4)";
    $result = mysql_query($query);
    echo "<br>Soundx Query, Count" . mysql_num_rows($result);
    if (mysql_num_rows($result) == 0) {
        $sub = substr($tv_req, 0, 1);
        $query = "SELECT * from tvnow_channel where name like '" . $sub . "%'";
        $result = mysql_query($query);
        echo "<br>Like Query, Count" . mysql_num_rows($result);
        if (mysql_num_rows($result) == 0) {
            $query = "SELECT * from tvnow_channel";
            $result = mysql_query($query);
            echo "<br>Query, Count" . mysql_num_rows($result);
        }
    }
    $i = 0;
    $m2 = metaphone($tv_req);
    while ($row = mysql_fetch_array($result)) {
        $tvname[$i] = trim($row['name']);
        $tvdname[$i] = trim($row['dname']);
        $tvlink[$i] = trim($row['link']);
        $m1 = metaphone($tvname[$i]);
        //$lev_arry[$i] = levenshtein($m1, $m2);
        $sim[$i] = similar_text($m1, $m2, $perc);
        $percent[$i] = $perc;
        echo 'similarity: ' . $tvdname[$i] . ' : ' . $sim[$i] . ', ' . $perc . '% <br>';
        $i++;
//            $isfound = true;
    }

    if ($tvmust) {
        $highest = 75;
    } else {
        $highest = 85;
    }
    $hkey = -1;
    foreach ($percent as$key => $pr) {
        if ($pr >= $highest) {
            $highest = $pr;
            $hkey = $key;
            echo "<br>Matched at: " . $key;
            echo "<br>Match using SIM :" . $trname[$key] . ' Train count:' . $trCount[$key] . '<br>';
        }
    }
    if ($hkey >= 0) {
        $link = $tvlink[$hkey];
        $dname = $tvdname[$hkey];
        echo "<br>Matched Name :" . $tvname[$hkey];
        echo "<br>Matched link :" . $tvlink[$hkey];
    }
}    

$url = "http://tvnow.in/channellisting.asp?ch=" . $link . "";
$result = $dname;
$curTime = true;
if (isset($getdate)) {
    if ($getdate < strtotime("today -1 month")) {
        $getdate = strtotime(date("Y-m-d", $getdate) . " +1 year");
    }
    echo $getdate;
    echo "Date set:";
    if ($getdate <= strtotime("today + 6 days")) {
        $url .= "&cTime=" . urldecode(date('m/d/Y', $getdate));
        $result .= "(" . date('jS M', $getdate) . ")";
        $curTime = false;
    }
} else {
    $add_below = "\n--\nYou can also get program schedule for next 6 days, Eg: TV $dname ON " . date('jS F', strtotime("today + 3 days"));
}

if ($link != '') {
    if ($curTime) {
        $flag_tv = 0;
        echo $query = "SELECT * FROM tvchannel_store where channel_id='$link' && date='" . (date("Y-m-d")) . "' ";
        $result = mysql_query("SELECT * FROM tvchannel_store where channel_id='$link' && date='" . (date("Y-m-d")) . "' ");
        if ($result) {

            $row = mysql_fetch_array($result);
            $code = json_decode($row['details']);
        }
        $flag_tv = 1;
//   $s=$code->time;
//   echo $s;
        var_dump($code);
        $pgmcount = count($code);
        $pgm_list = '';
        $start = 0;
        $result = $dname;
        for ($i = 0; $i < $pgmcount; $i++) {
            $pgmdate = strtotime($code[$i]->time);
            echo "<br>Now:" . date('H');
            echo "<br>pgm:" . date('H', $pgmdate);

            if (date('H') < 3 && date('H', $pgmdate) >= 4) {
                $pgmdate -= 86400; //6+0*60*24
                echo "<br><h2>date sub</h2>";
            } elseif (date('H', $pgmdate) < 4) {
                $pgmdate += 86400; //6+0*60*24
            }
            echo "<br>pgmdate:" . $pgmdate;
            echo "<br>time:" . time();
            if ($pgmdate >= time()) {
                echo "<br><h2>time:</h2>";
                break;
            }
        }

        if ($i > 0)
            $start = $i - 1;


        for ($i = $start; $i < $pgmcount; $i++) {
//                echo "jsla";
            $pgm_list .= "\n" . $code[$i]->time . " " . $code[$i]->title;
            if (isset($code[$i]->cat)) {
                $pgm_list .= "(" . $code[$i]->cat . ")";
            } else {
                $pgm_list .= " ";
            }
            if (isset($code[$i]->rate)) {
                $pgm_list .= "Rating:" . $code[$i]->rate;
            }
        }
        $total_return.=$pgm_list;
    }

    if ($link != '' && $code == '') {

        $pgm_list = '';
        if ($link > 0) {
//            $url = "http://tvnow.in/channellisting.asp?ch=" . $link . "";
//            $result = $dname;
//        if (isset($getdate)) {
//            if ($getdate < strtotime("today -1 month")) {
//                $getdate = strtotime(date("Y-m-d", $getdate) . " +1 year");
//            }
//
//            echo "Date set:";
//            if ($getdate <= strtotime("today + 6 days")) {
//                $url .= "&cTime=" . urldecode(date('m/d/Y', $getdate));
//                $result .= "(" . date('jS M', $getdate) . ")";
//                $curTime = false;
//            }
//        } else {
//            $add_below = "\n--\nYou can also get program schedule for next 6 days, Eg: TV $dname ON " . date('jS F', strtotime("today + 3 days"));
//        }
            echo $url;
            $data = httpGet($url);
            if (preg_match_all("~<table border=\"0\" cellpadding=\"0\"  width=\"677\"(.+)<tr><td>&nbsp;</td></tr>~Usi", $data, $matches)) {
                //var_dump($matches);
                foreach ($matches[0] as $k => $pgm) {
                    if (preg_match("~<span class=\"tvchannel\">(.+)</span><br>~Usi", $pgm, $match)) {
                        $event[$k]['time'] = $match[1];
                    }

                    if (preg_match("~<span class=\"programmeheading\" >(.+)</span><br>~Usi", $pgm, $match)) {
                        $event[$k]['title'] = $match[1];
                    }
                    if (preg_match("~Category </span><span class=\"programmetext\">(.+)</span></a><br>~Usi", $pgm, $match)) {
                        $event[$k]['cat'] = $match[1];
                    }
//        if (preg_match("~\t\t<span class=\"programmetext\">(.+)</span></a><br>~Usi", $pgm, $match)) {
//            $event[$k]['desc'] = $match[1];
//        }
                    if (preg_match("~<span class=\"programmeheading\">(.+)</span>~Usi", $pgm, $match)) {
                        if ($match[1] != '') {
                            $event[$k]['rate'] = $match[1];
                        }
                    }
                }
//            print_r($event);
                echo "<br>";
                $str = json_encode($event);
//              echo $str;
                if (isset($event)) {
                    if ($curTime && $time >= 6) {
                        echo "event is der....";
                        $query = "insert into tvchannel_store(channel_id,date,details) values ('" . mysql_escape_string($link) . "','" . (date("Y/m/d")) . "','" . mysql_escape_string($str) . "')";
                        $result1 = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                    }
                }
                $pgmcount = count($event);
                $start = 0;
                if ($curTime) {
                    for ($i = 0; $i < $pgmcount; $i++) {
                        $pgmdate = strtotime($event[$i]['time']);
                        echo "<br>Now:" . date('H');
                        echo "<br>pgm:" . date('H', $pgmdate);

                        if (date('H') < 3 && date('H', $pgmdate) >= 4) {
                            $pgmdate -= 86400; //6+0*60*24
                            echo "<br><h2>date sub</h2>";
                        } elseif (date('H', $pgmdate) < 4) {
                            $pgmdate += 86400; //6+0*60*24
                        }
                        echo "<br>pgmdate:" . $pgmdate;
                        echo "<br>time:" . time();
                        if ($pgmdate >= time()) {
                            echo "<br><h2>time:</h2>";
                            break;
                        }
                    }
                    if ($i > 0)
                        $start = $i - 1;
                }

                for ($i = $start; $i < $pgmcount; $i++) {
                    $pgm_list .= "\n" . $event[$i]['time'] . " " . $event[$i]['title'];
                    if (isset($event[$i]['cat'])) {
                        $pgm_list .= "(" . $event[$i]['cat'] . ")";
                    } else {
                        $pgm_list .= " ";
                    }
                    if (isset($event[$i]['rate'])) {
                        $pgm_list .= "Rating:" . $event[$i]['rate'];
                    }
                }
            }
        }
    }
    if ($pgm_list == '') {
        $chnl = $result;
        include 'tv_guide.php';
        if ($total_return == '') {
            $total_return = $chnl . "\nAwaiting schedule from channel for this date.";
            $to_logserver['isresult'] = 0;
            $free = true;
        }
    } else {
        $total_return = $result . $pgm_list;
    }
} elseif ($tvmust) {
    $total_return = "Sorry, No tv schedule found for $tv_srch.";
    $to_logserver['isresult'] = 0;
    $add_below = '';
    $free = true;
}

//    eif ($tvmust) {
//    $total_return = "Sorry, No tv schedule found for $tv_srch.";
//    $free = true;
//}
?>