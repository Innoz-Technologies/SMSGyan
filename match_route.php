<?php

if (preg_match("~__bestmaketrip__(.+)__(.+)__(.+)__~", $req, $matches)) {
    echo "<h3>Route API SPCL CASE</h3>";
    $input = $matches[1];
    $origin = $matches[2];
    $destination = $matches[3];
    $hitMake = false;
    $matched = TRUE;

    $file = $listAll["target"];
    $mch = $listAll['machine_id'];
    $content = get_file_contents($file, $mch);
    $arResult = json_decode($content, TRUE);

    if (empty($arResult)) {
        $hitMake = TRUE;
    }
    include 'routeapi.php';
} elseif (preg_match("~\b(routes?|distances?|directions?)\b~", $spell_checked, $match)) {
    echo "<br>ROUTE DETAILS<br>";
    echo $route_req = $spell_checked;
    $rout_must = false;
    $hitapi = true;
    if (($match[1] == 'to') || ($match[1] == ' 2 ')) {
        $route_req = preg_replace("~ 2 ~", " to ", $route_req);
        $hitapi = false;
    } else if (($match[1] == 'route') || ($match[1] == 'routes')) {
        $rout_must = true;
    }
    if (!preg_match("~\b(who|where|movie|song|weather|climate|cricket|cri|score|review|lyrics|bus|dict)\b~", $req)) {
        $route_req = preg_replace("~\b((routes?|distances?|directions?|time|timing)s?|stations?|root|which|when|give me|tell me|please|pleese|what|reach|go|how|show|me|long|travel|do|have|been|the|of|in|no|pnr|journey|need|know|help|all|and|or|before|after|then|list|first|last|i want to|want|for|go|is|was|i|express|passenger|passanger|mail|ticket|charge|murder)\b~", "", $route_req);

        $route_req = preg_replace("~[^\w\s]|\d~", " ", $route_req);
        $route_req = trim(preg_replace("~[\s]+~", " ", $route_req));

        echo "<br>$route_req<br>";
        $matched = false;
        if (preg_match("~\bto\b ([\w\s]+) fro?m ([\w\s]+)~", $route_req, $match)) {
            echo '<br>Reg 1:';
            print_r($match);
            $origin = $match[2];
            $destination = $match[1];
            $matched = true;
        } else if (preg_match("~.*(\b(fro?m)\b) ?([\w\s]+) to ([\w\s]+)~", $route_req, $match)) {
            echo '<br>Reg 2:';
            print_r($match);
            $origin = $match[3];
            $destination = $match[4];
            $matched = true;
        } else if (preg_match("~([\w\s]+) to ([\w\s]+)~", $route_req, $match)) {
            echo '<br>Reg 3:';
            print_r($match);
            $origin = $match[1];
            $destination = $match[2];
            $matched = true;
        } else if (preg_match("~([\w\s]+) (fro?m) ([\w\s]+)~", $route_req, $match)) {
            echo '<br>Reg 4:';
            print_r($match);
            $origin = $match[3];
            $destination = $match[1];
            $matched = true;
        } else if (str_word_count($route_req) == 2 && $rout_must) {
            echo '<br>preg 5';
            $match = explode(' ', $route_req);
            $origin = $match[0];
            $destination = $match[1];
            $matched = true;
        }

        if (!$blockINDSpec) {
            $input = "first";
            $hitMake = TRUE;
            include 'routeapi.php';
        }
        if (!$hitapi) {
            $query = "select city_name from citylist where city_name = '$origin' or city_name = '$destination'";
            $result = mysql_query($query) or trigger_error(mysql_errno());
            if (mysql_num_rows($result)) {
                $hitapi = true;
            }
        }
//        if(!$matched){
//            $route_req = preg_replace("~\b(fro?m)\b~", '', $route_req);
//            $route_req = trim(preg_replace("~[\s]+~", " ", $route_req));
//            if ((str_word_count($route_req) > 1) && (str_word_count($route_req) < 7)) {
//                echo '<br>Reg 7:';
//                print_r($match);
//                $origin = $route_req;
//                $matched = true;
//            }
//        }

        if ($matched) {
            include 'directions.php';
            if ($directions_return != '') {     // this variable set inside directions.php
                $total_return = $directions_return;
                $source_machine = 'db';
                //file_put_contents(DATA_PATH . $current_file, $directions_return);
                $add_below = "\n--\nTo get train timings SMS, TRAIN from <source> to <destination> on <date>. For eg: TRAIN FROM TRIVANDRUM TO NEW DELHI ON 2 JULY.";
                include 'allmanip.php';
                $to_logserver['source'] = 'route';
                putOutput($total_return);
                exit();
            } else if ($rout_must) {
                $total_return = "Sorry, no ROUTE result found from " . strtoupper($origin) . " to " . strtoupper($destination) . ".";
                $total_return .= "\n--\nTo get train timings SMS, TRAIN from <source> to <destination> on <date>. For eg: TRAIN FROM TRIVANDRUM TO NEW DELHI ON 2 JULY.";
                $charge_per_query = 0;
                $to_logserver['isresult'] = 0;
                $to_logserver['source'] = 'route';
                putOutput($total_return);
                exit();
            }
        }
    }
}

function getRestAPIData($url) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, "smsgyan@123:smsgyan@123");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    $result = curl_exec($ch);

    if (curl_error($ch)) {
        $result = '';
    }
    curl_close($ch);
    return $result;
}

function getRouteTime($minute) {
    if ($minute > 59) {
        $hr = floor($minute / 60);
        $minute = $minute - $hr * 60;
        return "$hr hr $minute min";
    } else {
        return "$minute min";
    }
}

?>