<?php

if (preg_match("~\b(epl|football live|football score|live football|english premier league)\b~", $spell_checked)) {
    $score_checked = false;

    if ((preg_match("~(live|goal|scores?|livescores?)~", $spell_checked, $match)) || $spell_checked == 'epl') {
        $score_checked = true;
        include 'premierleague.php';
        if ($epl_result != '') {
            echo "<br>Inside EPL SCORE";
            $total_return = $epl_result;
            $current_file = "/temp/$numbers";
            $source_machine = $machine_id;
            file_put_contents(DATA_PATH . $current_file, $total_return);
            include 'allmanip.php';
            $to_logserver['source'] = 'epl';
            putOutput($total_return);
            exit();
        }
    }
    //Point table
    if (preg_match("~points?|table|standings?~", $spell_checked)) {
//        $query = "select distinct shortname,played,won,drawn,lost,goal_for,goal_against,points from epl_team order by points desc,(goal_for-goal_against) desc,played,goal_for desc";
//        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//        $total_return = "EPL STANDINGS\n";
//        //$total_return .= "Team(Point-Played-Won-Drawn-Lost-Goal for-Goal against)\n";
//        $total_return .= "Team(P W D L GF GA GD P)\n";
//        while ($row = mysql_fetch_array($result)) {
//            $total_return .= $row['shortname'] . "(" . $row['played'] . " " . $row['won'] . " " . $row['drawn'] . " " . $row['lost'] . " " . $row['goal_for'] . " " . $row['goal_against'] . " " . ($row['goal_for'] - $row['goal_against']) . " " . $row['points'] . ")\n";
//        }
//        $options_list[] = "UPCOMING FIXTURES";
//        $list[] = array("content" => "epl fixture", "count" => 1);
//        $options_list[] = "RECENT SCORES";
//        $list[] = array("content" => "epl score", "count" => 2);

        $url = "http://news.bbc.co.uk/sport2/hi/football/eng_prem/table/";
        $content = file_get_contents($url);

        if (preg_match("~<td class=\"c15\"><span class=\"rhst\">PTS</span></td>(.+)</table>~Usi", $content, $match)) {
            $point = $match[1];
            $point = trim(preg_replace("~[\s]+~", " ", $point));
            $point = trim(str_replace("</tr><tr><td colspan=\"15\"><hr/></td></tr>", "</tr>", $point));
            $point = trim(str_replace("</tr>", "***", $point));
            $point = trim(str_replace("</td>", "+++", $point));
            $point = strip_tags($point);
            $point = trim(preg_replace("~[\s]+~", " ", $point));
            $point = trim(str_replace("***", "\n", $point));
            $point = trim(str_replace("+++", " ", $point));
            $point = trim(str_replace("\n\n", "\n", $point));
            $point = trim(str_replace("\n ", "\n", $point));

            echo $point;
        }

        if (!empty($point)) {
            $total_return = "Team,Played,Home-W,D,L,GF,GA,Away-W,D,L,GF,GA,GD,P\n" . $point;
            $options_list[] = "UPCOMING FIXTURES";
            $list[] = array("content" => "epl fixture", "count" => 1);
            $options_list[] = "RECENT SCORES";
            $list[] = array("content" => "epl score", "count" => 2);
        }

        $current_file = "/temp/$numbers";
        $source_machine = $machine_id;
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'epl';
        putOutput($total_return);
        exit();
    }

    if (preg_match("~score|results?~", $spell_checked)) {
        $isscr = true;
    } else {
        $isscr = false;
    }
    if (preg_match("~fixtures?|schdules?|time(ings?)?~", $spell_checked)) {
        $isfix = true;
    } else {
        $isfix = false;
    }
    $limitcond = '';

    echo "<br>EPL DETAILS<br>";
    $isscore = true;
    $epl_req = $spell_checked;
    $splited = matchdate($epl_req);
    if (isset($splited[2])) {
        $epl_req = $splited[0];
        $getdate = $splited[2];
        echo "<br> Matched part $splited[1]";
    }

    $epl_req = preg_replace("~\b((epl|football|score|live|matches|match|points?|goals?|counts?|against|english|premier|League|fixture|Championship|england|local|time|timing)s?|which|when|give|tell|me|please|pleese|what|go|show|me|long|do|have|been|the|of|in|no|journey|need|know|help|all|or|before|after|then|list|first|last|i want to|want|for|go|is|was|i|express|mail|ticket|charge|fron|metro|next|hour)\b~", "", $epl_req);
    $epl_req = preg_replace("~[^\w\s]|\d~", " ", $epl_req);
    $epl_req = trim(preg_replace("~[\s]+~", " ", $epl_req));
    $isqueryset = false;
    $epl_result = '';
    if (str_word_count($epl_req) <= 2 || $spell_checked == 'epl') {
        echo "<br>less than two words";
        echo $query = "select team from epl_team where srch = '" . mysql_real_escape_string($epl_req) . "' or team = '" . mysql_real_escape_string($epl_req) . "'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            echo "<br>Found";
            $row = mysql_fetch_array($result);
            $team = $row['team'];
            $ep_query = "select * from epl_fixture where (home_team = '" . mysql_real_escape_string($team) . "' or away_team = '" . mysql_real_escape_string($team) . "') and ";
            $isqueryset = true;
        }
    }

    if (!$isqueryset) {
        if (preg_match("~(.+)\b(vs|and)\b(.+)~", $epl_req, $match)) {
            $team_home = trim($match[1]);
            $team_away = trim($match[3]);
            echo $query = "select team from epl_team where srch = '" . mysql_real_escape_string($team_home) . "' or team = '" . mysql_real_escape_string($team_home) . "'";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);
                $team_home = $row['team'];
                echo $query = "select team from epl_team where (srch = '" . mysql_real_escape_string($team_away) . "' or team = '" . mysql_real_escape_string($team_away) . "') and team <> '" . mysql_real_escape_string($team_home) . "'";
                $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                if (mysql_num_rows($result)) {
                    $row = mysql_fetch_array($result);
                    $team_away = $row['team'];
                    $ep_query = "select * from epl_fixture where ((home_team = '" . mysql_real_escape_string($team_home) . "' and away_team = '" . mysql_real_escape_string($team_away) . "') or (home_team = '" . mysql_real_escape_string($team_away) . "' and away_team = '" . mysql_real_escape_string($team_home) . "')) and ";
                    $isqueryset = true;
                }
            }
        }
    }

    if (!$isqueryset) {
        $names = explode(" ", $epl_req);
        $team_home = '';
        $team_away = '';
        foreach ($names as $nm) {
            echo $query = "select team from epl_team where (srch = '" . mysql_real_escape_string($nm) . "' or team = '" . mysql_real_escape_string($nm) . "') and team <> '" . mysql_real_escape_string($team_home) . "'";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);
                if ($team_home == '') {
                    $team_home = $row['team'];
                } else {
                    $team_away = $row['team'];
                    break;
                }
            }
        }
        if ($team_home != '' && $team_away != '') {
            $ep_query = "select * from epl_fixture where ((home_team = '" . mysql_real_escape_string($team_home) . "' and away_team = '" . mysql_real_escape_string($team_away) . "') or (home_team = '" . mysql_real_escape_string($team_away) . "' and away_team = '" . mysql_real_escape_string($team_home) . "')) and  ";
            $isqueryset = true;
        } else if ($team_home != '') {
            $ep_query = "select * from epl_fixture where (home_team = '" . mysql_real_escape_string($team_home) . "' or away_team = '" . mysql_real_escape_string($team_home) . "') and ";
            $isqueryset = true;
        }
    }

    if (!$isqueryset) {
//        if ($isfix) {
//            if (isset($getdate)) {
//                $to_date = strtotime("sunday", $getdate);
//            } else {
//                $to_date = strtotime("sunday");
//            }
//            $from_date = (strtotime("today") > strtotime("last monday", $to_date)) ? strtotime("today") : strtotime("last monday", $to_date);
//            $ep_query = "select * from epl_fixture where match_date >= '" . date('Y/m/d', $from_date) . "' and match_date <= '" . date('Y/m/d', $to_date) . "'";
//        } else {
        echo $ep_query = "select * from epl_fixture where ";
        $limitcond = " limit 10";
//        }
        $isqueryset = true;
    }

    if ($isqueryset) {
        $nexttitle = '';
        if ($isfix && $isscr == false) {
            $ep_query .= 'match_date >= CURDATE()' . $limitcond;
            $epl_result = "EPL FIXTURE\n";
        } else if ($isscr && $isfix == false) {
            $ep_query .= "home_goal <> '' and match_date>='2012-08-18' order by match_date desc $limitcond";
            $epl_result = "EPL SCORE\n";
        } else {
            $ep_query = "(" . $ep_query . "home_goal <> ''and match_date>='2012-08-18' order by match_date desc limit 2) UNION (" . $ep_query . " match_date >= CURDATE() limit 15)";
            $epl_result = "EPL 2012\n";
            $nexttitle = 'recent scores';
        }
        echo $ep_query;

        $result = mysql_query($ep_query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $i = 1;
            while ($row = mysql_fetch_array($result)) {
                if ($row['home_goal'] == '') {
                    if ($nexttitle == 'fixtures') {
                        $epl_result .= "Upcoming Fixtures\n";
                        $nexttitle = 'nothing';
                    }
                    $epl_result .= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . " " . $row['match_time'] . " at " . $row['venue'] . ".\n";
                } else {
                    if ($nexttitle == 'recent scores') {
                        $epl_result .= "Recent scores\n";
                        $nexttitle = 'fixtures';
                    }
                    $epl_result .= "$i. " . $row['home_team'] . "[" . $row['home_goal'] . " - " . $row['away_goal'] . "]" . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "\n" . $row['details'] . "\n";
                }
                $i++;
            }
            $total_return = $epl_result;
            $current_file = "/temp/$numbers";
            $source_machine = $machine_id;
            file_put_contents(DATA_PATH . $current_file, $total_return);
            include 'allmanip.php';
            $to_logserver['source'] = 'epl';
            putOutput($total_return);
            exit();
        }
    }
}
?>