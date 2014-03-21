<?php

if (preg_match('~^(player|ipl player|ipl stats?) (.+)~', $req, $match) && str_word_count($req) <= 5) {

    var_dump($match);
    $name = trim($match[2]);

    mysql_close();
    include 'lib/configdb2.php';

    echo $q = "SELECT player,url,data,timestamp FROM ipl_stats WHERE `player` like ('%$name%') LIMIT 1";
    $result = mysql_query($q);

    if (mysql_num_rows($result) == 0) {
        echo $q = "select player,url,data,timestamp,MATCH(`player`) AGAINST ('$name') AS revl FROM ipl_stats WHERE MATCH (`player`) AGAINST ('$name') ORDER BY revl DESC LIMIT 1";
        $result = mysql_query($q);
    }

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);

        $name = $row['player'];
        $url = trim($row['url']);
        $data = $row['data'];
        $exTime = $row['timestamp'];
        echo $exTime = date("Y:m:d", strtotime($exTime));
        $cmpTime = date("Y:m:d");

        if (empty($data)) {

            echo "Inside empty data";
            $data = sifydata($url);
            echo $query = "update ipl_stats set data='" . mysql_real_escape_string($data) . "' where player='$name' and url='$url'";
            $result = mysql_query($query);
            if (!empty($data))
                $total_return = "Ipl Stats Of : $name\n$data";
            
        } elseif (($exTime == $cmpTime) && !empty($data)) {

            echo "Inside NOT empty data";
            $total_return = "Ipl Stats Of : $name\n$data";
        } else {
            $data = sifydata($url);
            $query = "update ipl_stats set data='$data' where player='$name' and url='$url'";
            $result = mysql_query($query);
            if (!empty($data))
                $total_return = "Ipl Stats Of : $name\n$data";
        }
    } else {
        mysql_close();
        include 'lib/appconfigdb.php';

        $total_return = "No players matched.Try again with another palyer name. Ex:Player Suresh Raina";
        $free = true;
        $to_logserver['source'] = 'player';
        $to_logserver['isresult'] = 0;
        putOutput($total_return);
        exit();
    }

    if ($total_return) {
        mysql_close();
        include 'lib/appconfigdb.php';

        $current_file = "/player/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);

        $source_machine = $machine_id;
        $to_logserver['source'] = 'player';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function sifydata($url) {
//        $url = "http://scores.sify.com/match/player_profiles/lakshmipathy_balaji.shtml";
    $content = file_get_contents($url);
    $data = '';

    if (preg_match('~<a class="arial12white-b">Bowling Statistics</a></td>.+<td align="center".+">IPL</td>(.+)</tr>~Usi', $content, $data)) {
//    var_dump($data);

        $bowl_stats = $data[1];
        $bowl_stats = preg_replace("~[\s]+~", "", $bowl_stats);
        $bowl_stats = str_replace("</td>", "~", $bowl_stats);
        $bowl_stats = strip_tags($bowl_stats);
        $bowl_stats = explode('~', $bowl_stats);

//    var_dump($bowl_stats);
        if (count($bowl_stats) == 13) {
            $bowl_data .="Matches : $bowl_stats[0]\n";
            $bowl_data.="Balls : $bowl_stats[1]\n";
            $bowl_data.="Runs : $bowl_stats[2]\n";
            $bowl_data.="Wkts : $bowl_stats[3]\n";
            $bowl_data.="BBI : $bowl_stats[4]\n";
            $bowl_data.="BBM : $bowl_stats[5]\n";
            $bowl_data.="Econ : $bowl_stats[6]\n";
            $bowl_data.="Avg : $bowl_stats[7]\n";
            $bowl_data.="SR : $bowl_stats[8]\n";
            $bowl_data.="4W : $bowl_stats[9]\n";
            $bowl_data.="5W : $bowl_stats[10]\n";
            $bowl_data.="10W : $bowl_stats[11]\n";
        }
    }


    if (preg_match('~<a class="arial12white-b">Batting Statistics</a></td>.+<td align="center".+">IPL</td>(.+)</tr>~Usi', $content, $data)) {
//    var_dump($data);

        $bat_stats = $data[1];
        $bat_stats = preg_replace("~[\s]+~", "", $bat_stats);
        $bat_stats = str_replace("</td>", "~", $bat_stats);
        $bat_stats = strip_tags($bat_stats);
        $bat_stats = explode('~', $bat_stats);
        if (count($bat_stats) == 13) {
            $bat_data.="Matches : $bat_stats[0]\n";
            $bat_data.="Inns : $bat_stats[1]\n";
            $bat_data.="NO : $bat_stats[2]\n";
            $bat_data.="Runs : $bat_stats[3]\n";
            $bat_data.="HS : $bat_stats[4]\n";
            $bat_data.="BF : $bat_stats[5]\n";
            $bat_data.="Avg : $bat_stats[6]\n";
            $bat_data.="SR : $bat_stats[7]\n";
            $bat_data.="100's : $bat_stats[8]\n";
            $bat_data.="50's : $bat_stats[9]\n";
            $bat_data.="6's : $bat_stats[10]\n";
            $bat_data.="4's : $bat_stats[11]\n";
        }
    }
    if (!empty($bowl_data) && !empty($bat_data))
        $data = "Batting Stats: \n$bat_data\nBowiling Stats: \n$bowl_data";
    echo $data;
    return $data;
}

?>
