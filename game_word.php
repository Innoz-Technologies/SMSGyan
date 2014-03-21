<?php

$word_id = 0;
$first_word = '';
$point = 0;
$level = 1;
$word_id = 0;
$gameid = 0;
$isPlay = false;
$msisdn = $number;
$flag_enabled = false;
unset($list);
$opnSet = '';
$isShow = true;
$category = '';

if (stripos($spell_checked, "game start") !== false || stripos($spell_checked, "play game") !== false) {
    if (preg_match("~__game start_(.+)_(.+)_(.+)_(.+)_~", $req, $match)) {
        $opnSet = 'start';
        $level = $match[1];
        $point = $match[2];
        $word_id = $match[3];
        $category = $match[4];
        if ($level > 1) {
            $isPlay = true;
        }
    }

    if (empty($category)) {
        $opnSet = 'cat';
    }
} elseif (preg_match("~__game_opn_(.+)__~", $req, $match)) {
    $opnSet = $match[1];
} else {
    if ($req == 'gyan') {
        $opnSet = "show";
        $isShow = false;
    } else {
        $opnSet = "ans";
    }
}
echo $spell_checked;
echo $opnSet;

if ($opnSet == 'cat') {
    echo $total_return = "Welcome to SMS GYAN Games!\n";

    $options_list[] = "Movie Game";
    $list[] = array("content" => "__game start_1_0_0_mov_");
    $options_list[] = "Sports Game";
    $list[] = array("content" => "__game start_1_0_0_spt_");
    $options_list[] = "Dictionary Game";
    $list[] = array("content" => "__game start_1_0_0_dic_");
    $options_list[] = "Play cricket";
    $list[] = array("content" => "play cricket");
    $options_list[] = "play tictactoe";
    $list[] = array("content" => "play tictactoe");

    var_dump($options_list);
    var_dump($list);
} elseif ($opnSet == 'start') {
    if ($isPlay) {
        while ($gameid == 0) {
//            $word_id +=1;
            echo $query = "SELECT * FROM game_words where id>$word_id and category='$category' LIMIT 0 , 1";
            $result = mysql_query($query);
            if (mysql_num_rows($result) > 0) {
                $gameid = 1;
            } else {
                $word_id = 0;
            }
        }
    } else {
        echo $query = "update `game_data` set `status` =0  WHERE (MINUTE(TIMEDIFF(now( ),hit_time)) >=15 and HOUR( TIMEDIFF( now( ) , hit_time ) and DATEDIFF(now( ),hit_time)>0) >=0) or DATEDIFF(now( ),hit_time)>0 ";

        if (mysql_query($query)) {
            echo 'Record updated in game_data';
        }

        $q_game = "SELECT DISTINCT (`msisdn`) FROM `game_data` WHERE MINUTE(TIMEDIFF(now( ),hit_time)) <15 and DATEDIFF(now( ),hit_time)=0 and HOUR( TIMEDIFF( now( ) , hit_time ) ) =0";
        $result_game = mysql_query($q_game);

        while ($r_game = mysql_fetch_array($result_game)) {
            echo $query = "update `game_data` set `status` =2  WHERE `msisdn`='" . $r_game["msisdn"] . "' and status=0";

            if (mysql_query($query)) {
                echo 'Record updated in game_data';
            }
        }

        echo $query = "INSERT INTO `game_sum`(`startTime`, `endTime`, `operator`, `circle`, `msisdn`, `point`, `total_hit`, `level`) (SELECT min( hit_time ) AS START , max( hit_time ) AS END,'airtel' AS Operator ,max( circle ) as circle  , max( msisdn ) as msisdn  ,  max( points ) as points ,count(clue_count)+1 as tothit  , max(LEVEL ) as LEVEL FROM game_data WHERE STATUS =0 GROUP BY DATE_FORMAT( hit_time, '%d-%m-%Y' ) , `msisdn` )";
        if (mysql_query($query)) {
            echo 'Record inserted';
        }

        echo $query = "delete from game_data where status=0";
        if (mysql_query($query)) {
            echo 'Record deleted';
        }
        echo $query = "SELECT * FROM game_words where category='$category' ORDER BY rand() LIMIT 0 , 1";
        $result = mysql_query($query);
    }

    if (mysql_num_rows($result) > 0) {
        $url = "http://IP/cache/write.php?name=ga" . $msisdn . "&data=t&ttl=900";
        $content = file_get_contents($url);
        if ($content == "OK") {
            echo "<br>cache updated";
        }

        $row = mysql_fetch_array($result);
        $first_word = $clue_word = trim(strtolower($row["word"]));
        echo $clue_word = getCluueWord($first_word, $clue_word);
        $default = $row["default"];
        $word_id = $row["id"];
        $clue_count = 0;
        echo $query = "insert into game_data(msisdn,circle,word_id,first_word,clue_word,clue_count,points,level,status,hit_time) values('$msisdn','$circle',$word_id,'" . mysql_real_escape_string($first_word) . "','" . mysql_real_escape_string($clue_word) . "',0,$point,$level,1,'" . date('Y-m-d H:i:s') . "')";
        if (mysql_query($query)) {
            echo 'Record inserted into game_data';
        }
    }
    echo "<br>";
    if ($category != 'dic') {
        $shword = "Your game name is : ";
    } else {
        $shword = "Your game word is : ";
    }
    if (!empty($clue_word)) {
        $total_return = "Welcome to level $level\nFind the missing letters in the following word and win  Prizes!\n$shword $clue_word \n";
    }
    if ($category != 'dic') {
        $total_return .="Your clue is : " . ucfirst($default);
    }
    echo $total_return;

    $options_list[] = "Give me a clue";
    $list[] = array("content" => "__game_opn_clue__");
    $options_list[] = "Show answer";
    $list[] = array("content" => "__game_opn_show__");
    $options_list[] = "Quit game";
    $list[] = array("content" => "__game_opn_stop__");

    var_dump($options_list);
    var_dump($list);
} elseif ($opnSet == 'stop') {
    $free = TRUE;
    echo $total_return = "The game has been successfully terminated.\nTo start the game sms PLAY GAME to $shortcode";
    echo $query = "update game_data set status=0 where msisdn='$msisdn'";
    if (mysql_query($query)) {
        echo 'Record updated in game_data';
    }

    echo $q = "INSERT INTO `game_sum`(`startTime`, `endTime`, `operator`, `circle`, `msisdn`, `point`, `total_hit`, `level`) (SELECT min( hit_time ) AS START , max( hit_time ) AS END,'airtel' AS operator ,max( circle ) as circle  , max( msisdn ) as msisdn  ,  max( points ) as points ,count(clue_count)+1 as tothit  , max(LEVEL ) as LEVEL FROM game_data WHERE msisdn='$msisdn')";
    if (mysql_query($q)) {
        echo "Record inserted";
    }

    echo $query = "delete from game_data where msisdn='$msisdn'";

    if (mysql_query($query)) {
        echo 'Record deleted in game_data';
    }

    $url = "http://IP/cache/write.php?name=ga" . $msisdn . "&data=f&ttl=1";
    $content = file_get_contents($url);
    if ($content == "OK") {
        echo "<br>cache updated";
    }
} else {
    $url = "http://IP/cache/read.php?name=ga" . $msisdn;
    $content = file_get_contents($url);

    if ($content == "t") {

        echo $q = "Select msisdn from game_data where msisdn=" . $msisdn . " and MINUTE(TIMEDIFF(now( ),hit_time)) <15 and DATEDIFF(now( ),hit_time)=0 and HOUR( TIMEDIFF( now( ) , hit_time ) ) =0 and status>=1 order by hit_time desc limit 0,1";
        $res = mysql_query($q);

        if (mysql_num_rows($res) > 0) {
            if ($category == 'dic') {
                echo $query = "Select *,game_data.id as gid from game_data where msisdn=" . $msisdn . " order by hit_time desc limit 0,1";
            } else {
                echo $query = "Select *,if( clue_count =0, clue1, if( clue_count =1, clue2, clue3 ) ) AS clue,game_data.id as gid from game_data,game_words where game_data.word_id = game_words.id and msisdn=" . $msisdn . " order by hit_time desc limit 0,1";
            }

            $result = mysql_query($query);

            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);

                $gameid = $row["gid"];
                $clue_count = $row["clue_count"];
                $clue_word = $row["clue_word"];
                $first_word = trim(strtolower($row["first_word"]));
                $word_id = $row["word_id"];
                $level = $row["level"];
                $point = $row["points"];
                $status_g = $row["status"];
                $gdict = $row["default"];
                if ($category != 'dic') {
                    $clue = $row["clue"];
                    $category = $row["category"];
                }

                if ($category != 'dic') {
                    $shword = "Your game name is : ";
                } else {
                    $shword = "Your game word is : ";
                }

                if ($opnSet == 'clue') {
                    $clue_count += 1;
                    if ($category == 'dic') {
                        echo $total_return = "Find the missing letters in the following word and win  Prizes!\nYour game word is : " . $clue_word = fillCluueWord($first_word, $clue_word);
                    } else {
                        echo $total_return = "Find the missing letters in the following word and win  Prizes!\n$shword $clue_word \nYour clue is : " . ucfirst($clue);
                    }
                    $point -=1;
                    if ($clue_count < 3) {
                        $options_list[] = "Give me a clue";
                        $list[] = array("content" => "__game_opn_clue__");
                    }

                    $options_list[] = "Show answer";
                    $list[] = array("content" => "__game_opn_show__");
                    $options_list[] = "Quit game";
                    $list[] = array("content" => "__game_opn_stop__");

                    var_dump($options_list);
                    var_dump($list);

                    echo $query = "update game_data set clue_word='$clue_word',clue_count=$clue_count,Points=$point,hit_time='" . date('Y-m-d H:i:s') . "' where id=$gameid";
                    if (mysql_query($query)) {
                        echo 'Record updated in game_data';
                    }

                    $url = "http://IP/cache/write.php?name=ga" . $msisdn . "&data=t&ttl=900";
                    $content = file_get_contents($url);
                    if ($content == "OK") {
                        echo "<br>cache updated";
                    }
                } else if ($opnSet == 'show') {
                    if ($isShow) {
                        $point -=1;
                    }

                    $remPoint = 100 - $point;
                    $total_return = "$shword" . $first_word . "\nYour point is : $point \nYou need " . $remPoint . " more points to win the prize";
                    if ($category == 'dic') {
                        $total_return .="\nThe meaning is : " . ucfirst($gdict);
                    }
                    echo $total_return;

                    $options_list[] = "Play Again";
                    $list[] = array("content" => "__game start_" . $level . "_" . $point . "_" . $word_id . "_" . $category . "_");
                    $options_list[] = "Quit game";
                    $list[] = array("content" => "__game_opn_stop__");

                    var_dump($options_list);
                    var_dump($list);

                    echo $query = "update game_data set Points=$point,hit_time='" . date('Y-m-d H:i:s') . "' where id=$gameid";
                    if (mysql_query($query)) {
                        echo 'Record updated in game_data';
                    }

                    $url = "http://IP/cache/write.php?name=ga" . $msisdn . "&data=t&ttl=900";
                    $content = file_get_contents($url);
                    if ($content == "OK") {
                        echo "<br>cache updated";
                    }
                } elseif ($opnSet == 'ans') {
                    if ($status_g == 1) {
                        if ($req == $first_word) {

                            $point +=4;

                            if ($point >= 100) {
                                echo $query = "update game_data set level=$level,Points=$point,hit_time='" . date('Y-m-d H:i:s') . "' where id=$gameid";

                                if (mysql_query($query)) {
                                    echo 'Record updated in game_data';
                                }

                                echo $query = "update game_data set status=0 where msisdn='$msisdn'";

                                if (mysql_query($query)) {
                                    echo 'Record updated in game_data';
                                }

                                echo $q = "INSERT INTO `game_sum`(`startTime`, `endTime`, `operator`, `circle`, `msisdn`, `point`, `total_hit`, `level`) (SELECT min( hit_time ) AS START , max( hit_time ) AS END,'airtel' AS operator ,max( circle ) as circle  , max( msisdn ) as msisdn  ,  max( points ) as points ,count(clue_count)+1 as tothit  , max(LEVEL ) as LEVEL FROM game_data WHERE msisdn='$msisdn')";
                                if (mysql_query($q)) {
                                    echo "Record inserted";
                                }

                                echo $query = "delete from game_data where msisdn='$msisdn'";

                                if (mysql_query($query)) {
                                    echo 'Record deleted in game_data';
                                }

                                mysql_close();
                                include 'lib/mainconfigdb.php';
                                echo $query = "REPLACE INTO photo_search (number,circle,channel,expiry,medium,status,pricepoint,subscribed,pre_sent) VALUES ('$msisdn','$circle',9,DATE_ADD(NOW(),INTERVAL 30 DAY),'5','1','0','2',0)";
                                mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                                if ($operator == "airtel")
                                    $total_return = "Congrats. You won a free 30day subscription to Mobile Greeting Cards. Dial *321*552# (tollfree) to send customized Greeting Card to your loved ones. Happy Gaming :)";
                                else
                                    $total_return = "Congratulations.!! You Won.";

                                if ($category == 'dic') {
                                    $total_return .="\nThe meaning is : " . ucfirst($gdict);
                                }
                                echo $total_return;
                            } else {
                                $remPoint = 100 - $point;
                                if ($operator == "airtel")
                                    $total_return = "The level $level is successfully completed\nYour point is : $point \nYou need " . $remPoint . " more points to win the prize.";
                                else
                                    $total_return = "The level $level is successfully completed\nYour point is : $point \nYou need " . $remPoint . " more points to win.";

                                echo $query = "update game_data set level=$level,Points=$point,status=2,hit_time='" . date('Y-m-d H:i:s') . "' where id=$gameid";

                                if (mysql_query($query)) {
                                    echo 'Record updated in game_data';
                                }

                                $url = "http://IP/cache/write.php?name=ga" . $msisdn . "&data=t&ttl=900";
                                $content = file_get_contents($url);
                                if ($content == "OK") {
                                    echo "<br>cache updated";
                                }

                                $level += 1;
                                $options_list[] = "Play Again";
                                $list[] = array("content" => "__game start_" . $level . "_" . $point . "_" . $word_id . "_" . $category . "_");
                                $options_list[] = "Quit game";
                                $list[] = array("content" => "__game_opn_stop__");

                                var_dump($options_list);
                                var_dump($list);
                                if ($category == 'dic') {
                                    $total_return .="\nThe meaning is : " . ucfirst($gdict);
                                }
                                echo $total_return;
                            }
                        } else {
                            echo $total_return = "Sorry wrong Answer! Try again\n$shword $clue_word";
                            if ($clue_count < 3) {
                                $options_list[] = "Give me a clue";
                                $list[] = array("content" => "__game_opn_clue__");
                            }

                            $options_list[] = "Show answer";
                            $list[] = array("content" => "__game_opn_show__");
                            $options_list[] = "Quit game";
                            $list[] = array("content" => "__game_opn_stop__");

                            var_dump($options_list);
                            var_dump($list);
                        }
                    } else {
                        echo 'else cond';
                        if ($point >= 100) {
                            if ($operator == "airtel")
                                echo $total_return = "Congrats. You won a free 30day subscription to Mobile Greeting Cards. Dial *321*552# (tollfree) to send customized Greeting Card to your loved ones. Happy Gaming :)";
                            else
                                echo $total_return = "Congratulations.!! You Won. Happy Gaming :)";
                        } else {
                            $remPoint = 100 - $point;
                            if ($operator == "airtel")
                                $total_return = "Your are in game mode and level $level is successfully completed\nYour point is : $point \nYou need " . $remPoint . " more points to win the prize.";
                            else
                                $total_return = "Your are in game mode and level $level is successfully completed\nYour point is : $point \nYou need " . $remPoint . " more points to win.";

                            $level +=1;
                            $options_list[] = "Play Again";
                            $list[] = array("content" => "__game start_" . $level . "_" . $point . "_" . $word_id . "_" . $category . "_");
                            $options_list[] = "Quit game";
                            $list[] = array("content" => "__game_opn_stop__");

                            if ($category == 'dic') {
                                $total_return .="\nThe meaning is : " . ucfirst($gdict);
                            }
                            echo $total_return;
                        }
                    }
                }
            }
        }
    } elseif ($content == "c") {
        if (!(strpos($req, "@") !== FALSE && strpos($req, "@") == 0) && $spell_checked != 'chat') {
            if (strlen($req) > 15) {
                $q_chat = substr($query_in, 0, 15) . "...";
            } else {
                $q_chat = $query_in;
            }
            $add_below = "\n--\nTo send chat messages, add @ in the beginning of your message\neg: @ $q_chat";
        }
    }
}

if ($total_return) {
    $to_logserver['source'] = 'game';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function getCluueWord($firstWord, $clueWord) {

    $fcount = strlen($firstWord);
    echo '<br>';
    echo $remcount = (int) $fcount / 3;
    $cwcount = 0;
    $numbers = range(2, $fcount - 2);
    shuffle($numbers);
    var_dump($numbers);

    foreach ($numbers as $val) {
        echo "<br>" . $val;
        $replace = false;
        if (substr($clueWord, $val, 1) != "_" && substr($clueWord, $val, 1) != " ") {
            echo "<br>val : " . substr($clueWord, $val, 1);
            if ($val > 0 && $val < $fcount - 1) {
                $prev = $val - 1;
                $next = $val + 1;

                while (substr($clueWord, $prev, 1) == " ") {
                    $prev -=1;
                }

                while (substr($clueWord, $next, 1) == " ") {
                    $next +=1;
                }

                $prev1 = $prev - 1;
                $next1 = $next + 1;

                while (substr($clueWord, $prev1, 1) == " ") {
                    $prev1 -=1;
                }

                while (substr($clueWord, $next1, 1) == " ") {
                    $next1 +=1;
                }

                echo "<br>val-1 : " . substr($clueWord, $prev, 1);
                if (substr($clueWord, $prev, 1) != "_" && substr($clueWord, $next, 1) != "_") {
                    $replace = true;
                } elseif (substr($clueWord, $prev, 1) == "_" && substr($clueWord, $next, 1) != "_") {
                    if ($val > 1) {
                        echo "<br>val-2 : " . substr($clueWord, $prev1, 1);
                        if (substr($clueWord, $prev1, 1) != "_") {
                            $replace = true;
                        }
                    }
                } elseif (substr($clueWord, $prev, 1) != "_" && substr($clueWord, $next, 1) == "_") {
                    if ($val < $fcount - 2) {
                        echo "<br>val+2 : " . substr($clueWord, $next1, 1);
                        if (substr($clueWord, $next1, 1) != "_") {
                            $replace1 = true;
                        }
                    }
                } else {
                    $replace = false;
                }
            }


            if ($replace) {
                echo '<br>';
                echo $remword1 = substr($clueWord, 0, $val - $fcount);
                echo '<br>';
                echo $remword2 = substr($clueWord, $val + 1);
                echo '<br>';
                echo $clueWord = $remword1 . "_" . $remword2;
                echo '<br>';
                $cwcount +=1;
            }
        }
        if ($cwcount >= $remcount) {
            break;
        }
    }
    return $clueWord;
}

function fillCluueWord($firstWord, $clueWord) {

    $fcount = strlen($firstWord);
    echo '<br>';
    echo $remcount = (int) $fcount / 3;
    $replace = false;
    $cwcount = 0;
    $numbers = range(2, $fcount - 1);
    shuffle($numbers);
    var_dump($numbers);
    echo $firstWord;
    echo '<br>';
    echo $clueWord;

    foreach ($numbers as $val) {

        if (substr($clueWord, $val, 1) == "_") {
            echo '<br>';
            echo $remword1 = substr($clueWord, 0, $val - $fcount);
            echo '<br>';
            echo $remword2 = substr($clueWord, $val + 1);
            echo '<br>';
            echo $mword = substr($firstWord, $val, 1);
            echo '<br>';
            echo $clueWord = $remword1 . $mword . $remword2;
            break;
        }
    }
    return $clueWord;
}

?>