<?php

echo "<h2>LIVECRICKET_NEW</h2>";
if ($operator != "idea") {
    $flag_enabled = False;
    $set_prom = false;
    $add_below = '';

    $free = $org_free;
    if ($operator == "airtel" && !$free && $circle_short !== 'DL') {

        include 'criBill.php';
    }


    $results = apc_fetch('scorecard', $success);

    if (!$success) {
        echo "INSIDE SUCCESS";
        $query = "select * from livecricket order by cri_order";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

        $hit_api = FALSE;
        $count = 0;
        $isset = false;
        $results = array();
        while ($row = mysql_fetch_array($result)) {
            echo "INSIDE WHILE";
            echo "<br>" . $timestamp = $row['hit_time'];
            echo "<br>" . $now = time();
            $time_diff = 0;
            echo "<br>" . $time_diff = abs($now - strtotime($timestamp));

            if ($time_diff > 10) {
                $hit_api = TRUE;
            } else {
                $hit_api = FALSE;
            }
            $hit = TRUE;

            if ($row["status"] && $hit_api) {
                $score = '';
                echo "<br>From Api<br>";

//            if (!$isset) {
//                include 'live.php';
//            }
                echo $cri_url = "API" . trim($row["url"]) . "";
                $log_count = count($to_logserver['urls']);
                $to_logserver['urls'][$log_count]['api_cri']['url'] = $cri_url;
                $ttime = microtime(true);
                $content = httpGet($cri_url);
                $content = str_replace('</upcoming_mat<points_table', '</upcoming_match_schedule>', $content);
                $ttime = microtime(true) - $ttime;
                $to_logserver['urls'][$log_count]['api_cri']['fetch_time'] = $ttime;
                $to_logserver['urls'][$log_count]['api_cri']['status'] = 1;
                $xmlObj = simplexml_load_string($content);
                $arrXml = objectsIntoArray($xmlObj);

                echo "<br><h2>dump</h2></br>";
//            if (!empty($live) && !$isset) {
//                $arrXml["livescore"] = $live;
//                $isset = TRUE;
//            }
                var_dump($arrXml);

                echo "<br> after eco";
                $arrXml['stat'] = $row['status'];
                $arrXml['name'] = $row['name'];
                $arrXml['machine'] = $machine_id;

                echo "<br> test <br>";


                $scoreflag = TRUE;
                if ($arrXml['livescore']) {

                    echo "toss" . $arrXml["status"]["toss"]["@attributes"]["team"];

                    if ($arrXml['status']['toss']['@attributes']['team'] != 'none') {
                        echo "<h2> toss info </h2>" . $toss = $arrXml['status']['toss']['@attributes']['team'] . " won the toss and elected to " . $arrXml['status']['toss']['@attributes']['decision'];
                    }

                    echo "<br> after toss";
                    $arrXml['livescore'] = str_replace('*', '.', $arrXml['livescore']);
                    $arrXml['livescore'] = str_replace('|', '/', $arrXml['livescore']);

                    //for toss
                    if (strpos($arrXml['livescore'], '0/0(0)') !== false) {
                        $arrXml['livescore'] = $toss . $arrXml['livescore'];
                    }
                    echo "<br> after lst";

                    file_put_contents(DATA_PATH . "/temp/livescore" . $count, $arrXml['livescore']);
                    $query = "update livecricket set scorecard='" . mysql_real_escape_string(serialize($arrXml)) . "' ,hit_time='" . date("Y-m-d H:i:s") . "' where id=" . $row["id"];
                    if (mysql_query($query)) {
                        echo "<br>Record Updated<br>";
                    }
                    if ($arrXml['scorecard']) {
                        file_put_contents(DATA_PATH . "/temp/scorecard" . $count, $arrXml['scorecard']);
                    }
                    if ($arrXml['commentary']) {
                        file_put_contents(DATA_PATH . "/temp/commentary" . $count, $arrXml['commentary']);
                    }
                    if ($arrXml['fall_of_wickets']) {
                        file_put_contents(DATA_PATH . "/temp/wickets" . $count, $arrXml['fall_of_wickets']);
                    }
                    if ($arrXml['upcoming_match_schedule']) {
                        file_put_contents(DATA_PATH . "/temp/schedule" . $count, $arrXml['upcoming_match_schedule']);
                    }
                    if ($arrXml['points_table']) {
//                    $arrXml['points_table'] = '';
                        file_put_contents(DATA_PATH . "/temp/points" . $count, $arrXml['points_table']);
                    }
                } else {
                    echo "<h1> else conditio </h1>";
                    $scoreflag = FALSE;
                    $to_logserver['urls'][$log_count]['api_cri']['status'] = 0;
                }
            } else {
                echo "<br>From database<br>";

                $arrXml = unserialize($row['scorecard']);
                $arrXml['stat'] = $row["status"];
            }
            $results[$count] = $arrXml;
            $count++;
        }
//    if ($operator == "idea" || $circle_short == "MB" || $circle_short == "MH") {
//        echo apc_store('scorecard', $results[2], 20);
//    } else {
        echo apc_store('scorecard', $results, 20);

//        apc_store(date('Hi'), $results, 1200);
//    }
    }

    if ($req == 'livescore2') {
        $total_return = $results[2]['livescore'];
        $source_machine = $results[2]['machine'];
        $current_file = "/temp/livescore2";
        if ($results[2]['status'] && $results[2]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary2");
        }
        if ($results[2]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard2");
        }
        if ($results[2]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall2");
        }
        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[2]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points2");
        }
        if ($results[2]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture2");
        }
        $to_logserver['source'] = 'cri';
    } else if ($req == 'livescore1') {
        $total_return = $results[1]['livescore'];
        $source_machine = $results[1]['machine'];
        $current_file = "/temp/livescore1";
        if ($results[1]['status'] && $results[1]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary1");
        }
        if ($results[1]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard1");
        }
        if ($results[1]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall1");
        }
        //special for idea and airtel(mb & mh)
//    if ($operator == "idea" && ($circle_short == "MB")) {
//        
//    } else {
        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
//    }

        if ($results[1]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points1");
        }
        if ($results[1]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture1");
        }
        $to_logserver['source'] = 'cri';
    } else if ($req == 'scorecard2') {
        $total_return = $results[2]['scorecard'];
        $source_machine = $results[2]['machine'];
        $current_file = "/temp/scorecard2";
        if ($results[2]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore2");
        }
        if ($results[2]['status'] && $results[2]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary2");
        }
        if ($results[2]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall2");
        }
        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[2]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points2");
        }
        if ($results[2]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture2");
        }
        $to_logserver['source'] = 'cri_scr';
    } else if ($req == 'scorecard1') {
        $total_return = $results[1]['scorecard'];
        $source_machine = $results[1]['machine'];
        $current_file = "/temp/scorecard1";
        if ($results[1]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore1");
        }
        if ($results[1]['status'] && $results[1]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary1");
        }
        if ($results[1]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall1");
        }

        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }


        if ($results[1]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points1");
        }
        if ($results[1]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture1");
        }
        $to_logserver['source'] = 'cri_scr';
    } else if ($req == 'commentary2') {
        $total_return = $results[2]['commentary'];
        $source_machine = $results[2]['machine'];
        $current_file = "/temp/commentary2";
        if ($results[2]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore2");
        }
        if ($results[2]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard2");
        }
        if ($results[2]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall2");
        }
        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[2]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points2");
        }
        if ($results[2]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture2");
        }
        $to_logserver['source'] = 'cri_cmr';
    } else if ($req == 'commentary1') {
        $total_return = $results[1]['commentary'];
        $source_machine = $results[1]['machine'];
        $current_file = "/temp/commentary1";
        if ($results[1]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore1");
        }
        if ($results[1]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard1");
        }
        if ($results[1]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall1");
        }


        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }

        if ($results[1]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points1");
        }
        if ($results[1]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture1");
        }
        $to_logserver['source'] = 'cri_cmr';
    } else if ($req == 'wicket fall2') {
        $total_return = $results[2]['fall_of_wickets'];
        $source_machine = $results[2]['machine'];
        $current_file = "/temp/wickets2";
        if ($results[2]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore2");
        }
        if ($results[2]['status'] && $results[2]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary2");
        }
        if ($results[2]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard2");
        }
        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[2]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points2");
        }
        if ($results[2]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture2");
        }
        $to_logserver['source'] = 'cri_wkt';
    } else if ($req == 'wicket fall1') {
        $total_return = $results[1]['fall_of_wickets'];
        $source_machine = $results[1]['machine'];
        $current_file = "/temp/wickets1";
        if ($results[1]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore1");
        }
        if ($results[1]['status'] && $results[1]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary1");
        }
        if ($results[1]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard1");
        }
        if ($operator == "idea" && ($circle_short == "MB")) {
            
        } else {
            if ($results[0]['name']) {
                $options_list[] = $results[0]['name'];
                $list[] = array("content" => 'cri');
            }
        }

        if ($results[1]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points1");
        }
        if ($results[1]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture1");
        }
        $to_logserver['source'] = 'cri_wkt';
    } else if ($req == 'cri points2') {
        $total_return = $results[2]['points_table'];
        $source_machine = $results[2]['machine'];
        $current_file = "/temp/points2";

        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[1]['status'] && $results[1]['name']) {
            $options_list[] = $results[1]['name'];
            $list[] = array("content" => 'livescore1');
        }
        if ($results[2]['status'] && $results[2]['name']) {
            $options_list[] = $results[2]['name'];
            $list[] = array("content" => 'livescore2');
        }

        if ($results[2]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture2");
        }
        $to_logserver['source'] = 'cri_pnt';
    } else if ($req == 'cri points1') {
        $total_return = $results[1]['points_table'];
        $source_machine = $results[1]['machine'];
        $current_file = "/temp/points1";

        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[1]['status'] && $results[1]['name']) {
            $options_list[] = $results[1]['name'];
            $list[] = array("content" => 'livescore1');
        }
        if ($results[2]['status'] && $results[2]['name']) {
            $options_list[] = $results[2]['name'];
            $list[] = array("content" => 'livescore2');
        }

        if ($results[1]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture1");
        }
        $to_logserver['source'] = 'cri_pnt';
    } else if ($req == 'cri fixture2') {
        $total_return = $results[2]['upcoming_match_schedule'];
        $source_machine = $results[2]['machine'];
        $current_file = "/temp/schedule2";

        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[1]['status'] && $results[1]['name']) {
            $options_list[] = $results[1]['name'];
            $list[] = array("content" => 'livescore1');
        }
        if ($results[2]['status'] && $results[2]['name']) {
            $options_list[] = $results[2]['name'];
            $list[] = array("content" => 'livescore2');
        }

        if ($results[2]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points2");
        }
        $to_logserver['source'] = 'cri_fxr';
    } else if ($req == 'cri fixture1') {
        $total_return = $results[1]['upcoming_match_schedule'];
        $source_machine = $results[1]['machine'];
        $current_file = "/temp/schedule1";


        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }

        if ($results[1]['status'] && $results[1]['name']) {
            $options_list[] = $results[1]['name'];
            $list[] = array("content" => 'livescore1');
        }
        if ($results[2]['status'] && $results[2]['name']) {
            $options_list[] = $results[2]['name'];
            $list[] = array("content" => 'livescore2');
        }

        if ($results[1]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points1");
        }
        $to_logserver['source'] = 'cri_fxr';
    } else if (strpos($spell_checked, 'scorecard') !== false) {

        $total_return = $results[0]['scorecard'];
        $source_machine = $results[0]['machine'];
        $current_file = "/temp/scorecard0";

        if ($results[0]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore");
        }
        if ($results[0]['status'] && $results[0]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary");
        }
        if ($results[0]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall");
        }
        if ($results[0]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points");
        }
        if ($results[0]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture");
        }
        $to_logserver['source'] = 'cri_scr';
    } else if (strpos($spell_checked, 'wicket fall') !== false) {
        $total_return = $results[0]['fall_of_wickets'];
        $source_machine = $results[0]['machine'];
        $current_file = "/temp/wickets0";
        if ($results[0]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore");
        }
        if ($results[0]['status'] && $results[0]['commentary']) {
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary");
        }
        if ($results[0]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard");
        }

        if ($results[0]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points");
        }
        if ($results[0]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture");
        }
        $to_logserver['source'] = 'cri_wkt';
    } else if (strpos($spell_checked, 'commentary') !== false) {
        $total_return = $results[0]['commentary'];
        $source_machine = $results[0]['machine'];
        $current_file = "/temp/commentary0";
        if ($results[0]['livescore']) {
            $options_list[] = "Summary";
            $list[] = array("content" => "livescore");
        }
        if ($results[0]['scorecard']) {
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard");
        }
        if ($results[0]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall");
        }
        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[0]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points");
        }
        if ($results[0]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture");
        }
        $to_logserver['source'] = 'cri_cmr';
    } else if (strpos($spell_checked, 'point') !== false || strpos($spell_checked, 'table') !== false) {
        $total_return = $results[0]['points_table'];
        $source_machine = $results[0]['machine'];
        $current_file = "/temp/points0";

        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[1]['status'] && $results[1]['name']) {
            $options_list[] = $results[1]['name'];
            $list[] = array("content" => 'livescore1');
        }
        if ($results[2]['status'] && $results[2]['name']) {
            $options_list[] = $results[2]['name'];
            $list[] = array("content" => 'livescore2');
        }

        if ($results[0]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture");
        }
        $to_logserver['source'] = 'cri_pnt';
    } else if (strpos($spell_checked, 'fixture') !== false || strpos($spell_checked, 'schedule') !== false) {
        $total_return = $results[0]['upcoming_match_schedule'];
        $source_machine = $results[0]['machine'];
        $current_file = "/temp/schedule0";

        if ($results[0]['name']) {
            $options_list[] = $results[0]['name'];
            $list[] = array("content" => 'cri');
        }
        if ($results[1]['status'] && $results[1]['name']) {
            $options_list[] = $results[1]['name'];
            $list[] = array("content" => 'livescore1');
        }
        if ($results[2]['status'] && $results[2]['name']) {
            $options_list[] = $results[2]['name'];
            $list[] = array("content" => 'livescore2');
        }

        if ($results[0]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points");
        }
        $to_logserver['source'] = 'cri_fxr';
    } else {
        $def_indx = 0;
        if ($results[0]['livescore']) {

            $def_indx = 0;
            $def_str = '';
        } else {

            $def_indx = 1;
            $def_str = '1';
        }

        echo "<h2>result0</h2>" . $results[0]['livescore'];

        echo "<h2>result</h2>" . $results[$def_indx]['livescore'];


        $total_return = $results[$def_indx]['livescore'];
        $source_machine = $results[$def_indx]['machine'];

        $current_file = "/temp/livescore$def_indx";
        if ($results[$def_indx]['status'] && $results[$def_indx]['commentary']) {
            echo "<h2>commentary</h2>";
            var_dump($results[$def_indx]['commentary']);
            $options_list[] = "Commentary";
            $list[] = array("content" => "commentary$def_str");
        }
        if ($results[$def_indx]['scorecard']) {
            echo "<h2>scorecard</h2>";
            var_dump($results[$def_indx]['scorecard']);
            $options_list[] = "Scorecard";
            $list[] = array("content" => "scorecard$def_str");
        }
        if ($results[$def_indx]['fall_of_wickets']) {
            $options_list[] = "Wickets";
            $list[] = array("content" => "wicket fall$def_str");
        }
        if (!$def_indx) {
            if ($results[1]['name']) {
                $options_list[] = $results[1]['name'];
                $list[] = array("content" => 'livescore1');
            }
        }

        if (!empty($results[2]['name']) && $results[2]['status']) {
            $options_list[] = $results[2]['name'];
            $list[] = array("content" => 'livescore2');
        }
        if ($results[$def_indx]['points_table']) {
            $options_list[] = "Points";
            $list[] = array("content" => "cri points$def_str");
        }
        if ($results[$def_indx]['upcoming_match_schedule']) {
            $options_list[] = "Fixture";
            $list[] = array("content" => "cri fixture$def_str");
        }
        $to_logserver['source'] = 'cri';
        if ($operator == "loop") {
            $add_below1 = "\nFor Schedule reply with SCH\nFor Best of Sachin reply with SAC\nFor Best of Malinga reply with MAL";
        } else {
            if ($number == '8826382201' || $number == '9741931588') {
                $add_below1 = "\n--\nPowered by Coco-Cola. Khushiyon Ki Chabi";
            } else {
                $add_below1 = "\n--\nPowered by cricketarchive.com";
            }
        }
    }
    if ($set_prom && $operator == "airtel") {
        $no = rand(0, 3);
        echo "<h2>RANDOM NO :$no </h2>";
        if ($no == 0 || $no == 1)
            $add_below = $add_below1 . "\n--\nDial *321*565# for Unlimited Search at $charge_currency $price_point/$validity days";
        else
            $add_below = $add_below1 . adscript();
    } else {
        echo "<h2>ELSE NOT IN RANDOM</h2>";
        $add_below = $add_below1 . adscript();
    }
//if ($isblacklisted == 0 && $operator != 'wapapi' && $isemp != 1) {
//    echo "its here";
//    $add_below.="\n--\nTo get a Certified MBA Degree, SMS MBA to $shortcode";
//}

    echo "<br><h2>TIME before all :" . (microtime(TRUE) - $time_start) . "</h2><br>";
    if ($total_return) {
//    $ipl_stats = apc_fetch('iplstats', $success);
//    if (!$success) {
//        $query = "select question from canned_responses where source='iplstats'";
//        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//        $ipl_stats[] = mysql_num_rows($result);
//        while ($row = mysql_fetch_array($result)) {
//            $ipl_stats[] = $row['question'];
//        }
//        apc_store('iplstats', $ipl_stats);
//        echo "from DB";
//    }
//    $rnd = rand(1, $ipl_stats[0]);
//    $options_list[] = $ipl_stats[$rnd];
//    $list[] = array("content" => $ipl_stats[$rnd]);
//    if ($operator == 'airtel') {
//        $options_list[] = "Play cricket";
//        $list[] = array("content" => "Play cricket");
//
//      
//        }
//    }
        if ($operator == 'airtel') {
            $options_list[] = "Play cricket";
            $list[] = array("content" => "Play cricket");
        }
//t20 world cup special
//    $options_list[] = "cricket masti";
//    $list[] = array("content" => "cricket masti");
//    $options_list[] = "live radio";
//    $list[] = array("content" => "live radio fakeipl");

        include 'allmanip.php';
        echo "<br><h2>TIME after all :" . (microtime(TRUE) - $time_start) . "</h2><br>";
        putOutput($total_return);
        exit();
    }
}
?>