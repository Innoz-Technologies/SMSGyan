<?php

$match_word = remwords($spell_checked);


if (preg_match("~__ipl__news_(.+)__~", $req, $match)) {
    $ipl_word = $match[1];
    $req = "__ipl__" . $ipl_word . "_";

    $options_list[] = "Fixtures Of $ipl_word";
    $list[] = array("content" => "__ipl__" . $ipl_word . "_fixture_");
}
if (preg_match("~__ipl__(.+)_~", $req, $match)) {
    echo "its here";
    $ipl_word = $match[1];
    echo $ipl_word . "\n";
    echo $spell_checked . "\n";
    if (strpos($ipl_word, "fixture") !== false) {
        if ($ipl_word == "fixture") {
            $query = "select * from ipl where match_date >= CURDATE()";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "mi_fixture" || $ipl_word == "mumbai indians_fixture") {
            $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Mumbai Indians' OR away_team='Mumbai Indians')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "csk_fixture" || $ipl_word == "chennai super kings_fixture" || $ipl_word == "csk_fixture") {
            $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Chennai Super Kings' OR away_team='Chennai Super Kings')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "rr_fixture" || $ipl_word == "rajasthan royals_fixture" || $ipl_word == "rr_fixture") {
            $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Rajasthan Royals' OR away_team='Rajasthan Royals')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "rcb_fixture" || $ipl_word == "royal challengers bangalore_fixture" || $ipl_word == "rcb_fixture") {
            $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Royal Challengers Bangalore' OR away_team='Royal Challengers Bangalore')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "sh_fixture" || $ipl_word == "sunrisers hyderabad_fixture" || $ipl_word == "sh_fixture") {
            echo $query = "select * from ipl where match_date >= CURDATE()AND (home_team='sunrisers hyderabad' OR away_team='sunrisers hyderabad')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "dd_fixture" || $ipl_word == "delhi daredevils_fixture" || $ipl_word == "dd_fixture") {
            $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Delhi Daredevils' OR away_team='Delhi Daredevils')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "kp_fixture" || $ipl_word == "kings x1 punjab_fixture" || $ipl_word == "kxip_fixture") {
            $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Kings XI Punjab' OR away_team='Kings XI Punjab')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "pw_fixture" || $ipl_word == "pune warriors india_fixture" || $ipl_word == "pwi_fixture") {
            echo $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Pune Warriors' OR away_team='Pune Warriors')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        } elseif ($ipl_word == "kkr_fixture" || $ipl_word == "kolkata knight riders_fixture" || $ipl_word == "kkr_fixture") {
            $query = "select * from ipl where match_date >= CURDATE()AND (home_team='Kolkata Knight Riders' OR away_team='Kolkata Knight Riders')";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }
        }
        $total_return = $ipl_result;
    } elseif ($ipl_word == "mumbai indians") {
        echo "Entering here";
        $query = "select * from ipl_team where shortname='mi'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "chennai super kings") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='csk'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "rajasthan royals") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='rr'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "royal challengers bangalore") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='rcb'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "sunrisers hyderabad") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='sh'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "delhi daredevils") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='dd'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "kings x1 punjab") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='kxip'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "pune warriors india") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='pwi'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "kolkata knight riders") {
        echo "Entering here";
        $query = "select members from ipl_team where shortname='kkr'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
        }
    } elseif ($ipl_word == "team") {
        $total_return = "Teams";
        $options_list[] = "Mumbai Indians";
        $list[] = array("content" => "__ipl__news_mumbai indians__");
        $options_list[] = "Chennai Super Kings";
        $list[] = array("content" => "__ipl__news_chennai super kings__");
        $options_list[] = "Rajastan Royals";
        $list[] = array("content" => "__ipl__news_rajasthan royals__");
        $options_list[] = "Royal Challengers Bangalore";
        $list[] = array("content" => "__ipl__news_royal challengers bangalore__");
        $options_list[] = "sunrisers hyderabad";
        $list[] = array("content" => "__ipl__news_sunrisers hyderabad__");
        $options_list[] = "Delhi Daredevils";
        $list[] = array("content" => "__ipl__news_delhi daredevils__");
        $options_list[] = "Kings X1 Punjab";
        $list[] = array("content" => "__ipl__news_kings x1 punjab__");
        $options_list[] = "Pune Warriors India";
        $list[] = array("content" => "__ipl__news_pune warriors india__");
        $options_list[] = "Kolkata Knight Riders";
        $list[] = array("content" => "__ipl__news_kolkata knight riders__");
    }
}
if (preg_match("~^\b(ipl mi|ipl mumbai indians|ipl mumbai|ipl chennai|ipl punjab|ipl deccan|ipl kolkata|ipl bangalore|ipl pune|ipl delhi|ipl rajastan|ipl csk|ipl chennai super kings|ipl rcb|ipl royal challengers bangalore|ipl rr|ipl rajasthan royals|ipl sh|ipl sunrisers hyderabad|ipl dd|ipl delhi daredevils|ipl kxip|ipl kings xi punjab|ipl kkr|ipl kolkata knight riders|kkr|ipl pwi|ipl pune warriors india| ipl mi|mumbai indians|csk|chennai super kings|rcb|royal challengers bangalore|rajasthan royals|rr|sunrisers hyderabad|sh|delhi daredevils|dd|kolkata knight riders|pune warriors india|pwi|kings xi punjab|kxip|ipl fixtures?)\b$~", $match_word)) {
    echo $match_word;
    if (preg_match("~\b(fixtures|fixture)\b~", $match_word)) {
        echo "its entering here";
        $match_word = str_replace('fixtures', '', $match_word);
        $match_word = str_replace('fixture', '', $match_word);
        $match_word = str_replace('ipl', '', $match_word);
        $match_word = trim($match_word);
        echo $query = "select * from ipl where match_date >= CURDATE()AND ((home_team like'%$match_word%' OR away_team like '%$match_word%') OR(shrt_home_team like '%$match_word%' OR shrt_away_team like'%$match_word%'))";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $i = 1;
            while ($row = mysql_fetch_array($result)) {
                $ipl_result.= "$i. " . $row['home_team'] . " Vs " . $row['away_team'] . " on " . date('F j', strtotime($row['match_date'])) . "," . $row['match_time'] . " " . " at " . $row['venue'] . "\n";
                $i++;
            }
        }
        $total_return = $ipl_result;
    } else {
        echo "its from here";
        echo $match_word;
        $match_word = str_replace('ipl', '', $match_word);
        $match_word = trim($match_word);
        echo $query = "select members from ipl_team where shortname like '%$match_word%'OR team like '%$match_word%'";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $team_members = $row['members'];
            $total_return = $team_members;
            $match_word = str_replace("mi", "mumbai indians", $match_word);
            $match_word = str_replace("csk", "chennai super kings", $match_word);
            $match_word = str_replace("rcb", "royal challengers bangalore", $match_word);
            $match_word = str_replace("sh", "sunrisers hyderabad", $match_word);
            $match_word = str_replace("dd", "delhi daredevils", $match_word);
            $match_word = str_replace("kxip", "kings xi punjab", $match_word);
            $match_word = str_replace("rr", "rajastan royals", $match_word);
            $match_word = str_replace("kkr", "kolkata knight riders", $match_word);
            $match_word = str_replace("pwi", "pune wariors india", $match_word);
            echo $total_return;
            $options_list[] = "Fixtures Of $match_word";
            $list[] = array("content" => "__ipl__" . $match_word . "_fixture_");
        }
    }
}

if (preg_match("~^\b(ipl|ipl live|ipl 2013|dlf ipl|ipl points|ipl points? table)\b$~", $spell_checked) && empty($total_return)) {
    echo "<br>From Ipl<br>";
    if (preg_match("~teams?~", $spell_checked)) {
        $total_return = "Teams";
        $options_list[] = "Mumbai Indians";
        $list[] = array("content" => "__ipl__news_mumbai indians__");
        $options_list[] = "Chennai Super Kings";
        $list[] = array("content" => "__ipl__news_chennai super kings__");
        $options_list[] = "Rajastan Royals";
        $list[] = array("content" => "__ipl__news_rajasthan royals__");
        $options_list[] = "Royal Challengers Bangalore";
        $list[] = array("content" => "__ipl__news_royal challengers bangalore__");
        $options_list[] = "sunrisers hyderabad";
        $list[] = array("content" => "__ipl__news_sunrisers hyderabad__");
        $options_list[] = "Delhi Daredevils";
        $list[] = array("content" => "__ipl__news_delhi daredevils__");
        $options_list[] = "Kings X1 Punjab";
        $list[] = array("content" => "__ipl__news_kings x1 punjab__");
        $options_list[] = "Pune Warriors India";
        $list[] = array("content" => "__ipl__news_pune warriors india__");
        $options_list[] = "Kolkata Knight Riders";
        $list[] = array("content" => "__ipl__news_kolkata knight riders__");
    } elseif (preg_match("~points?|table|standings?~", $spell_checked)) {

        $ipl_points = apc_fetch('points', $success);
//
        if (!$success) {
            $url = "http://www.sify.com/sports/cricket/ipl/pointstable/";
            $content = file_get_contents($url);

            if (preg_match('~<div class="fod-teams-header-wrapper"><h2>Points table</h2></div>(.+)</table>~Usi', $content, $match)) {
                $ipl_points = $match[1];

                $ipl_points = trim(preg_replace("~[\s]+~", " ", $ipl_points));
//    $ipl_points = preg_replace('~<td align="center" width="10" class="arial12black-b">&nbsp;</td>~Usi', "", $ipl_points);
//    $ipl_points = preg_replace('~<td bgcolor=\'#f3f3f3\' align="center" class="border-R arial12black-n">&nbsp;</td>~Usi', "", $ipl_points);
                $ipl_points = str_replace("</tr>", "***", $ipl_points);
                $ipl_points = strip_tags($ipl_points);
                $ipl_points = preg_replace("~[\s]+~", " ", $ipl_points);
                $ipl_points = str_replace("***", "\n", $ipl_points);
                $ipl_points = str_replace(" &nbsp; ", " ", $ipl_points);
                $ipl_points = str_replace("\n ", "\n", $ipl_points);
                $ipl_points = str_replace("\n\n\n", "\n", $ipl_points);
                $ipl_points = str_replace(" Team Played Won Loss NR Points Net R/R ", "Team Played Won Loss NR Points NetR/R", $ipl_points);

                echo $ipl_points;
                apc_store('points', $ipl_points, 900);
            }
        }
//        echo $query = "select distinct shortname,played,won,lost,points,net_rr from ipl_team order by points desc,net_rr desc";
//        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        $total_return = "IPL STANDINGS\n$ipl_points";
        //$total_return .= "Team(Point-Played-Won-Drawn-Lost-Goal for-Goal against)\n";
//        $total_return .= $ipl_points;
//        while ($row = mysql_fetch_array($result)) {
//            $total_return .= $row['shortname'] . "(" . $row['played'] . " " . $row['won'] . " " . $row['lost'] . "  " . $row['points'] . "  " . $row['net_rr'] . ")\n";
//        }
        $options_list[] = "About Ipl";
        $list[] = array("content" => "indian premier league");
        $options_list[] = "Fixture";
        $list[] = array("content" => "__ipl__fixture_");
        $options_list[] = "Teams";
        $list[] = array("content" => "__ipl__team_");
    } else {
        $flag_enabled = false;
        $total_return = "Ipl 2013";
        $options_list[] = "About Ipl";
        $list[] = array("content" => "indian premier league");
        $options_list[] = "Fixture";
        $list[] = array("content" => "__ipl__fixture_");
        $options_list[] = "Teams";
        $list[] = array("content" => "__ipl__team_");
        $options_list[] = "Points Table";
        $list[] = array("content" => "ipl points");
    }
}

if ($total_return) {
    $current_file = "/temp/$numbers";
    $source_machine = $machine_id;
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'ipl';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
