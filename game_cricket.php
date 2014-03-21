<?php

//include 'configdb.php';
//$req = $spell_checked = $_GET["q"];
//$msisdn = "7353970716";
//$circle_short = "KA";
//$total_return = "";
$options_list = array();
$list = array();
$criWin = 0;

if (stripos($spell_checked, "start cricket") !== false || stripos($spell_checked, "play cricket") !== false) {
    mysql_close();
    include 'lib/configdb2.php';

    $total_return = "Your team is India. Please select your opposite team";
    $query_team = "Select * from game_cri_team where id>1";
    $result_team = mysql_query($query_team);
    $options_list[] = "change your team";
    $list[] = array("content" => "__cricket_change_2__3__");

    while ($row = mysql_fetch_array($result_team)) {
        $team = $row["fullName"];
        $teamID = $row["id"];
        $options_list[] = ucfirst($team);
        $list[] = array("content" => "__cricket_team_0__" . $teamID . "__");
    }

    mysql_close();
    include 'lib/appconfigdb.php';
} elseif (preg_match("~__cricket_(.+)_(.+)__(.+)__~", $req, $match)) {
    $type = $match[1];
    $first = $match[2];
    $second = $match[3];

    mysql_close();
    include 'lib/configdb2.php';

    if ($type == "team") {
        $oppTeamID = $second;
        $bat_id = $first;
        $target = rand(40, 50);
        $need = $target + 1;
        $oppWicket = rand(0, 9);

        if ($oppTeamID > 0) {
            $q_t = "SELECT * FROM `game_cri_team` where id =$oppTeamID";
            $r_t = mysql_query($q_t);

            if (mysql_num_rows($r_t)) {
                $row_t = mysql_fetch_array($r_t);
                $oppTeam = $row_t["team"];
                $oppFullName = $row_t["fullName"];
            }
        }

        if ($bat_id > 0) {
            echo $q_team = "UPDATE `game_cri_bat` SET `oppTeamID`=$oppTeamID,`oppTeam`='$oppTeam',`targetScore`=$target,`oppWicket`=$oppWicket where id=$bat_id";
            if (mysql_query($q_team)) {
                echo "Record updated";
            }
        } else {
            $team = "IND";
            $teamID = 1;
            echo $q_team = "INSERT INTO `game_cri_bat`(`msisdn`, `circle`, `teamID`, `oppTeamID`, `team`, `oppTeam`, `targetScore`,`oppWicket`) VALUES ('$msisdn','$circle_short',$teamID,$oppTeamID,'$team','$oppTeam',$target,$oppWicket)";
            if (mysql_query($q_team)) {
                $bat_id = mysql_insert_id();
            }
        }

        if ($bat_id > 0) {
            echo $q_t = "SELECT * FROM `game_cri_team`,`game_cri_bat` where `game_cri_bat`.teamID=`game_cri_team`.id and `game_cri_bat`.id =$bat_id";
            $r_t = mysql_query($q_t);

            if (mysql_num_rows($r_t)) {
                $row_t = mysql_fetch_array($r_t);
                $team = $row_t["team"];
                $tFullName = $row_t["fullName"];

                $total_return = "$oppFullName $target/$oppWicket \n$tFullName need $need runs from 30 balls with 10 wickets in hand";
                $options_list[] = "start Batting";
                $list[] = array("content" => "__cricket_bat_start__" . $bat_id . "__");
            }
        }
    } elseif ($type == "bat") {
        $bat_id = $second;
        $begin = $first;

        if ($begin == "start") {
            $query_bat = "select * from game_cri_bat where id=$bat_id limit 1";
            $result_bat = mysql_query($query_bat);

            if (mysql_num_rows($result_bat)) {
                $r_bat = mysql_fetch_array($result_bat);
                $teamID = $r_bat["teamID"];
                $targetScore = $r_bat["targetScore"];
                $targetOver = $r_bat["targetOver"];
                $oppTeam = $r_bat["oppTeam"];
                $oppWicket = $r_bat["oppWicket"];

                $total_return .="$oppTeam $targetScore/$oppWicket\n";
                $oppOver = (int) ($targetOver / 6);
                $total_return .="Overs $oppOver.0\n--\n";

                echo $query_ply = "Select *,game_cri_player.id as pid from game_cri_player,game_cri_team where game_cri_team.id=game_cri_player.teamID and teamID=$teamID order by game_cri_player.id limit 2";
                $result_ply = mysql_query($query_ply);

                if (mysql_num_rows($result_ply)) {
                    $r_ply = mysql_fetch_array($result_ply);
                    $playerName1 = $r_ply["playerName"];
                    $playerID1 = $r_ply["pid"];
                    $r_ply = mysql_fetch_array($result_ply);
                    $playerName2 = $r_ply["playerName"];
                    $playerID2 = $r_ply["pid"];

                    $total_return .= $r_ply["team"] . " 0/0\n";

                    $total_return .="Overs  0\n";
                    $total_return .= $playerName1 . " : 0\n";
                    $total_return .= $playerName2 . " : 0\n";

                    $q = "UPDATE `game_cri_bat` SET `playerID1`=$playerID1,`playerID2`=$playerID2,`playerName1`='$playerName1',`playerName2`='$playerName2',`currentBat`=$playerID1 where id=$bat_id";
                    if (mysql_query($q)) {
                        $options_list[] = "Face the first ball";
                        $list[] = array("content" => "__cricket_bat_next__" . $bat_id . "__");
                        $options_list[] = "Quit";
                        $list[] = array("content" => "__cricket_quit_next__" . $bat_id . "__");
                    }
                }
            }
        } else {
            $query_bat = "Select * from game_cri_bat where game_cri_bat.id=$bat_id";
            $result_bat = mysql_query($query_bat);

            if (mysql_num_rows($result_bat)) {
                $r_bat = mysql_fetch_array($result_bat);
                $score1 = $r_bat["score1"];
                $score2 = $r_bat["score2"];
                $totalBall = $r_bat["totalBall"];
                $totalRun = $r_bat["totalRun"];
                $team = $r_bat["team"];
                $teamID = $r_bat["teamID"];
                $oppTeam = $r_bat["oppTeam"];
                $oppTeamID = $r_bat["oppTeamID"];
                $wicket = $r_bat["wicket"];
                $playerName1 = $r_bat["playerName1"];
                $playerName2 = $r_bat["playerName2"];
                $playerID1 = $r_bat["playerID1"];
                $playerID2 = $r_bat["playerID2"];
                $currentBat = $r_bat["currentBat"];
                $targetScore = $r_bat["targetScore"];
                $targetOver = $r_bat["targetOver"];
                $oppWicket = $r_bat["oppWicket"];
                $score = 0;

                if ($currentBat == $playerID1) {
                    $curBatsName = $playerName1;
                } else {
                    $curBatsName = $playerName2;
                }
                $total_return .="$oppTeam $targetScore/$oppWicket\n";
                $oppOver = (int) ($targetOver / 6);
                $total_return .="Overs $oppOver.0\n--\n";

                $balling = get_criBall();
                if ($balling == "good") {
                    $totalBall = $totalBall + 1;
                    if ($totalBall == $targetOver) {
                        $criWin = 2;
                    }
                    $score = 0;
                } elseif ($balling == "bowled" || $balling == "catch" || $balling == "runout" || $balling == "stump") {
                    $totalBall = $totalBall + 1;
                    $wicket = $wicket + 1;

                    if ($wicket == 10) {
                        $criWin = 4;
                    }

                    $q_fetch = "SELECT * FROM `game_cri_player` WHERE `id`>$playerID1 and `id`>$playerID2 order by id limit 1";
                    $result_fetch = mysql_query($q_fetch);
                    if (mysql_num_rows($result_fetch)) {
                        $row = mysql_fetch_array($result_fetch);
                        $newPlayer = $row["playerName"];
                        $newPlayerID = $row["id"];

                        if ($currentBat == $playerID1) {
                            $q_upd = "UPDATE `game_cri_bat` SET `playerID1`=$newPlayerID,`playerName1`='$newPlayer' WHERE game_cri_bat.id=$bat_id";
                        } else {
                            $q_upd = "UPDATE `game_cri_bat` SET `playerID2`=$newPlayerID,`playerName2`='$newPlayer' WHERE game_cri_bat.id=$bat_id";
                        }

                        if (mysql_query($q_upd)) {
                            if ($currentBat == $playerID1) {
                                $playerName1 = $newPlayer;
                                $playerID1 = $newPlayerID;
                                $score1 = 0;
                            } else {
                                $playerName2 = $newPlayer;
                                $playerID2 = $newPlayerID;
                                $score2 = 0;
                            }
                        }
                    }

                    if ($balling == "catch" || $balling == "runout") {
                        if ($currentBat == $playerID1) {
                            $currentBat = $playerID2;
                        } else {
                            $currentBat = $playerID1;
                        }
                    }
                    $total_return .= "Out!!!!\n";
                    if ($balling == "bowled") {
                        $total_return .= $curBatsName . " is bowled\n";
                    } elseif ($balling == "catch") {
                        $total_return .= $curBatsName . " is caught out\n";
                    } elseif ($balling == "runout") {
                        $total_return .= $curBatsName . " is stumped out\n";
                    } elseif ($balling == "stump") {
                        $total_return .= $curBatsName . " is run out\n";
                    }
                } else {
                    $score = 1;
                    $total_return .= ucfirst($balling) . " Ball\n";
                }

                if ($criWin < 4) {
                    $over = (int) ($totalBall / 6);
                    $balls = (int) ($totalBall % 6);
                    $scored = 0;
                    $throwRun = 0;

                    if ($balling == "good" || $balling == "no") {
                        $scored = get_criScore();
                        if ($scored < 4) {
                            if ($totalRun + $scored > $targetScore) {
                                $scored = $targetScore - $totalRun + 1;
                                $score = $score + $scored;
                                $criWin = 1;
                                if ($scored > 0) {
                                    if ($scored == 1) {
                                        $total_return .= "$scored run\n";
                                    } else {
                                        $total_return .= "$scored runs\n";
                                    }
                                }
                            } else {
                                if ($scored > 0) {
                                    if ($scored == 1) {
                                        $total_return .= "$scored run\n";
                                    } else {
                                        $total_return .= "$scored runs\n";
                                    }
                                }
                                $score = $score + $scored;
                            }
                        } else {
                            $total_return .= "$scored!!!\n";
                            $score = $score + $scored;
                            if ($totalRun + $score > $targetScore)
                                $criWin = 1;
                        }

                        if ($scored < 4) {
                            $throwRun = get_throwRun();
                            if ($throwRun > 0) {
                                if ($throwRun < 4) {
                                    if ($totalRun + $score + $throwRun > $targetScore) {
                                        $throwRun = $targetScore - $totalRun + 1;
                                        $score = $score + $throwRun;
                                        $criWin = 1;
                                        if ($throwRun > 0) {
                                            if ($scored == 1) {
                                                $total_return .= "Overthrow $throwRun run\n";
                                            } else {
                                                $total_return .= "Overthrow $throwRun runs\n";
                                            }
                                        }
                                    } else {
                                        $score = $score + $throwRun;
                                        if ($throwRun > 0) {
                                            if ($scored == 1) {
                                                $total_return .= "Overthrow $throwRun run\n";
                                            } else {
                                                $total_return .= "Overthrow $throwRun runs\n";
                                            }
                                        }
                                    }
                                } else {
                                    $total_return .= "Overthrow $throwRun!!!\n";
                                    $score = $score + $throwRun;
                                    if ($totalRun + $score > $targetScore)
                                        $criWin = 1;
                                }
                            }
                        }
                    }
                }

                $totalRun = $totalRun + $score;

                if ((($scored + $throwRun) % 2) == 0) {
                    $nextBat = $currentBat;
                } else {
                    if ($currentBat == $playerID1) {
                        $nextBat = $playerID2;
                    } else {
                        $nextBat = $playerID1;
                    }
                }

                if ($balls == 0) {
                    if ($nextBat == $playerID1) {
                        $nextBat = $playerID2;
                    } else {
                        $nextBat = $playerID1;
                    }
                }
                if ($balling == "good" || $balling == "no") {
                    if ($balling == "no") {
                        $pscore = $score - 1;
                    } else {
                        $pscore = $score;
                    }

                    if ($pscore > 0) {
                        if ($pscore == 1) {
                            $total_return .= $curBatsName . " Scored $pscore Run.\n";
                        } else {
                            $total_return .= $curBatsName . " Scored $pscore Runs.\n";
                        }
                    } else {
                        $total_return .= "Its a dot ball.\n";
                    }
                    if ($currentBat == $playerID1) {
                        $score1 = $score1 + $pscore;
                    } else {
                        $score2 = $score2 + $pscore;
                    }
                }

                $total_return .= $team . " " . $totalRun . "/" . $wicket . "\n";
                $total_return .="Overs  $over.$balls \n";
                if ($nextBat == $playerID1) {
                    $total_return .= $playerName1 . " => " . $score1 . "\n";
                    $total_return .= $playerName2 . " : " . $score2 . "\n";
                } else {
                    $total_return .= $playerName1 . " : " . $score1 . "\n";
                    $total_return .= $playerName2 . " => " . $score2 . "\n";
                }


                if ($criWin == 4) {
                    if ($totalRun > $targetScore) {
                        $criWin = 1;
                    } elseif ($totalRun == $targetScore) {
                        $criWin = 3;
                    } else {
                        $criWin = 2;
                    }
                }

                $q = "UPDATE `game_cri_bat` SET `score1` = $score1, `score2` = $score2, `totalRun` = $totalRun, `totalBall` = $totalBall, `wicket` = $wicket, `currentBat` = $nextBat where id = $bat_id";
                if (mysql_query($q)) {
                    if ($criWin == 1) {
                        $winWicket = 10 - $wicket;
                        $total_return = "$team won by $winWicket wicket. Congratulation :)\n" . $total_return;
                    } elseif ($criWin == 2) {
                        $losRun = $targetScore - $totalRun;
                        $total_return = "$team lost by  $losRun runs. :(\n" . $total_return;
                    } elseif ($criWin == 2) {
                        $total_return = "The Match Draw.:|\n" . $total_return;
                    } else {
                        $options_list[] = "Face the next ball";
                        $list[] = array("content" => "__cricket_bat_next__" . $bat_id . "__");
                        $options_list[] = "Quit";
                        $list[] = array("content" => "__cricket_quit_next__" . $bat_id . "__");
                    }
                }
            }
        }
    } elseif ($type == "bowl") {
        $total_return = "Your won the toss please select the options";
        $options_list[] = "Batting";
        $list[] = array("content" => "__cricket_toss_" . $team . "__" . $teamID . "__");
        $options_list[] = "Bowling";
        $list[] = array("content" => "__cricket_toss_" . $team . "__" . $teamID . "__");
    } elseif ($type == "quit") {
        $total_return = "The game terminated successfully...";
    } elseif ($type == "change") {

        $total_return = "Please select your team";
        $query_team = "Select * from game_cri_team";
        $result_team = mysql_query($query_team);

        while ($row = mysql_fetch_array($result_team)) {
            $team = $row["team"];
            $teamID = $row["id"];
            $options_list[] = ucfirst($team);
            $list[] = array("content" => "__cricket_oppteam_" . $team . "__" . $teamID . "__");
        }
    } elseif ($type == "oppteam") {
        $team = $first;
        $teamID = $second;

        echo $q_team = "INSERT INTO `game_cri_bat`(`msisdn`, `circle`, `teamID`, `team`) VALUES ('$msisdn','$circle_short',$teamID,'$team')";
        if (mysql_query($q_team)) {
            $bat_id = mysql_insert_id();

            $total_return = "Please select your opposite team";
            $query_team = "Select * from game_cri_team where id !=$teamID";
            $result_team = mysql_query($query_team);

            while ($row = mysql_fetch_array($result_team)) {
                $team = $row["fullName"];
                $teamID = $row["id"];
                $options_list[] = ucfirst($team);
                $list[] = array("content" => "__cricket_team_" . $bat_id . "__" . $teamID . "__");
            }
        }
    }

    mysql_close();
    include 'lib/appconfigdb.php';
}

echo $total_return;
var_dump($options_list);
var_dump($list);
if ($total_return) {
//    echo $log_data = date("Y-m-d H:i:s") . ",$msisdn,$circle,$query_in\n";
//    if (filesize("log/gameCri.log") > 5000000) {
//        $new_name = "log/game.log." . time();
//        $ren = rename("log/game.log", $new_name);
//    }
//    file_put_contents("log/gameCri.log", $log_data, FILE_APPEND);
    $to_logserver['source'] = 'gamecri';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function get_criScore() {
    $randnum = rand(0, 100);
    $randnum = (int) ($randnum % 12);
    switch ($randnum) {
        case 1:
            $randnum = 1;
            break;
        case 2:
            $randnum = 2;
            break;
        case 3:
            $randnum = 3;
            break;
        case 4:
            $randnum = 4;
            break;
            break;
        case 6:
            $randnum = 6;
            break;
        default :
            $randnum = 0;
            break;
    }
    return $randnum;
}

function get_throwRun() {
    $randnum = rand(0, 1000);
    $randnum = (int) ($randnum % 50);
    switch ($randnum) {
        case 1:
            $randnum = 1;
            break;
        case 2:
            $randnum = 2;
            break;
        case 3:
            $randnum = 3;
            break;
        case 4:
            $randnum = 4;
            break;
        default :
            $randnum = 0;
            break;
    }
    return $randnum;
}

function get_criBall() {
    $randnum = rand(0, 1000);
    $randnum = (int) ($randnum % 100);
    switch ($randnum) {
        case 1:
            return "wide";
            break;
        case 2:
            return "no";
            break;
        case 3:
            return "bowled";
            break;
        case 4:
            return "catch";
            break;
        case 5:
            return "runout";
            break;
        case 6:
            return "stump";
            break;
        default :
            return "good";
            break;
    }
}

?>