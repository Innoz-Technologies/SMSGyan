<?php

if (preg_match('~^\b(tennis)\b~', $spell_checked)) {

    $tennis_data = getAPISportskeda();

    foreach ($tennis_data as $tennisvalue) {
        $arTour[] = $tennisvalue["tournament"];
        if (($tennisvalue["status"] == 'To Finish') || ($tennisvalue["status"] == 'Started')) {
            foreach ($tennisvalue as $index1 => $val1) {
                if (is_array($val1)) {
                    if ($index1 == 'contestant2')
                        $match_score .=") Vs ";
                    foreach ($val1 as $index => $val) {

                        if ($index == 'name') {
                            if (!is_array($val))
                                $match_score .= $val;
                            else
                                $match_score .= "(Unknown";
                        }
                        if (!is_array($val)) {

                            if ($index == 'score')
                                $match_score .= "(Score: " . $val . " Set:";
                            else if (strpos($index, 'set') !== FALSE)
                                $match_score .=" " . $val;
                            else if (strpos($index, 'tb') !== FALSE)
                                $match_score .=",T" . $val;
                            else
                                continue;
                        }
                    }
                    if (strpos($index1, 'contestant2') !== FALSE)
                        $match_score .=")\n";
                }
            }
        }
    }
    $arTour = array_unique($arTour);

    if (count($arTour) > 1) {
        foreach ($arTour as $tourval) {
            $options_list[] = $tourval;
            $list[] = array("content" => "__tennis__tour__" . $tourval . "__");
        }
        if (empty($match_score))
            $total_return = "Please Select Any One Tournament";
        else
            $total_return = "Ongoing Matches : \n" . $match_score;
    }
} elseif (preg_match('~__tennis__tour__(.+)__~', $req, $match)) {

    $tennis_data = getAPISportskeda();

    echo "<h2>Inside Tennis Next Page</h2>";

    if (!empty($tennis_data)) {
        $tour_type = trim($match[1]);

        foreach ($tennis_data as $tennisvalue) {
            if ($tennisvalue["tournament"] == $tour_type) {

                if (($tennisvalue["status"] == 'Not started')) {
                    $nextmatch[] = $tennisvalue["Not started"];
                }

                if (($tennisvalue["status"] == 'Finished')) {
                    $finished[] = $tennisvalue["Finished"];
                }

                if (($tennisvalue["status"] == 'To Finish') || ($tennisvalue["status"] == 'Started')) {
                    foreach ($tennisvalue as $index1 => $val1) {
                        if (is_array($val1)) {
                            if ($index1 == 'contestant2')
                                $match_score .=") Vs ";
                            foreach ($val1 as $index => $val) {
                                if ($index == 'name') {
                                    if (!is_array($val))
                                        $match_score .= $val;
                                    else
                                        $match_score = "(Unknown";
                                }
                                if (!is_array($val)) {

                                    if ($index == 'score')
                                        $match_score .= "(Score: " . $val . " Set:";
                                    else if (strpos($index, 'set') !== FALSE)
                                        $match_score .=" " . $val;
                                    else if (strpos($index, 'tb') !== FALSE)
                                        $match_score .=",T" . $val;
                                    else
                                        continue;
                                }
                            }
                            if (strpos($index1, 'contestant2') !== FALSE)
                                $match_score .=")\n";
                        }
                    }
                }elseif (($tennisvalue["status"] == 'Not started')) {
                    foreach ($tennis_data as $tennisvalue) {
                        if ($tennisvalue["tournament"] == $tour_type) {
                            if ($tennisvalue["status"] == 'Not started') {
                                date_default_timezone_set('CET');
                                $cest_time = strtotime($tennisvalue['date'] . " " . $tennisvalue['time']['cest_time']);
                                date_default_timezone_set('Asia/Kolkata');
                                $ist = date('h:i A', $cest_time);
                                $match_fixture .= $tennisvalue['contestant1']['name'] . " vs " . $tennisvalue['contestant2']['name'] . " Today at IST : " . $ist . "\n";
                            }
                        }
                    }
                }
            }
        }
    }
    if (!empty($match_score)) {
        $total_return = $match_score;

        if (count($nextmatch) > 1) {
            $options_list[] = "Upcoming Matches";
            $list[] = array("content" => "__tennis__upcoming__matches__" . $tour_type . "__");
        }
        if (count($finished) > 1) {
            $options_list[] = "Completed Matches";
            $list[] = array("content" => "__tennis__completed__matches__" . $tour_type . "__");
        }
    } elseif (!empty($match_fixture)) {
        $total_return = "Upcoming Matches\n" . $match_fixture;
        if (count($finished) > 1) {
            $options_list[] = "Completed Matches";
            $list[] = array("content" => "__tennis__completed__matches__" . $tour_type . "__");
        }
    }
} elseif (preg_match('~__tennis__upcoming__matches__(.+)__~', $req, $match)) {


    echo "<h2>Inside Tennis Upcoming Matches</h2>";

    $tour_type = trim($match[1]);

    $tennis_data = getAPISportskeda();


    if (!empty($tennis_data)) {
        foreach ($tennis_data as $tennisvalue) {
            if ($tennisvalue["tournament"] == $tour_type) {
                if ($tennisvalue["status"] == 'Not started') {
                    date_default_timezone_set('CET');
                    $cest_time = strtotime($tennisvalue['date'] . " " . $tennisvalue['time']['cest_time']);
                    date_default_timezone_set('Asia/Kolkata');
                    $ist = date('h:i A', $cest_time);
                    $match_fixture .= $tennisvalue['contestant1']['name'] . " vs " . $tennisvalue['contestant2']['name'] . " Today at IST : " . $ist . "\n";
                }
            }
        }
        if (!empty($match_fixture)) {
            $total_return = $match_fixture;
        }
    }
} elseif (preg_match('~__tennis__completed__matches__(.+)__~', $req, $match)) {


    echo "<h2>Inside Tennis Next Page</h2>";

    $tour_type = trim($match[1]);

    $tennis_data = getAPISportskeda();

    if (!empty($tennis_data)) {
        foreach ($tennis_data as $tennisvalue) {
            foreach ($tennisvalue as $index1 => $val1) {
                if (is_array($val1)) {
                    if ($index1 == 'contestant2')
                        $match_score .=") Vs ";
                    foreach ($val1 as $index => $val) {
                        if (!is_array($val)) {
                            if ($index == 'name')
                                $match_score .= $val;
                            else if ($index == 'score')
                                $match_score .= "(Score: " . $val . " Set:";
                            else if (strpos($index, 'set') !== FALSE)
                                $match_score .=" " . $val;
                            else if (strpos($index, 'tb') !== FALSE)
                                $match_score .=",T" . $val;
                            else if (strpos($index, 'result') !== FALSE)
                                $match_score .=",Result-Winner:" . $win;
                            else
                                continue;
                        }
                    }
                    if (strpos($index1, 'contestant2') !== FALSE)
                        $match_score .=")\n";
                }
            }
        }

        if (!empty($match_score)) {
            $total_return = $match_score;
        }
    }
}
if ($total_return) {

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);

    $to_logserver['source'] = 'tennis';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function getAPISportskeda() {

    global $to_logserver;

    $tennis_data = apc_fetch('apidata', $success);

    if (!$tennis_data) {

        echo "<h2>Inside SPORTSKEEDA API </h2>";

        $date_api = date('Y-m-d');
        $ttime = microtime(true);
        $apiurl = "http://api.sportskeeda.com/live/sport/6/$date_api/$date_api";
        $content = file_get_contents($apiurl);

        $ttime = microtime(true) - $ttime;

        $log_count = count($to_logserver['urls']);
        $to_logserver['urls'][$log_count]['sportskeeda']['fetch_time'] = $ttime;
        $to_logserver['urls'][$log_count]['sportskeeda']['type'] = 'tennis';
        $to_logserver['urls'][$log_count]['sportskeeda']['url'] = $apiurl;

        if (!empty($content)) {
            $to_logserver['urls'][$log_count]['sportskeeda']['status'] = 1;
            $xml = objectsIntoArray(simplexml_load_string($content));
            $tennis_data = $xml['match'];
        } else {
            $to_logserver['urls'][$log_count]['sportskeeda']['status'] = 0;
        }

        apc_store('apidata', $tennis_data, 300);
    }

    return $tennis_data;
}

?>
