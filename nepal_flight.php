<?php

echo "<h4>user id $userid req $req</h4>";
if ($userid == "50e12ea21fcad" && preg_match("~\b(flight)\b~", $req, $match)) {
    echo "<h4>Inside pregmatch</h4>";
    $placeFrom = '';
    $placeTo = '';
    $place = '';
    echo "<br>FLIGHT MATCHED<br>";
    if ($spell_checked == "flight") {
        $flight_return = "SMS FLIGHT <space> from [origin place] OR FLIGHT <space> to [destination place] to $shortcode";
    } elseif (!preg_match("~\b(who|how|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review)\b~", $req)) {

        echo 'flight 1 ' . $flight_req = preg_replace("~\b((trains?|trauns?|tran|trn|local|busstop|bus|number|time|timing)s?|stations?|which|when|give me|tell me|please|pleese|what|go|show|me|long|travel|do|have|been|the|of|in|no|pnr|journey|need|know|help|all|and|or|before|after|then|list|first|last|i want to|want|for|go|is|was|i|express|exp|passenger|passanger|pasienger|mail|ticket|charge|fron|murder|metro|next|hour|flight)\b~", "", $req);

        echo '<br>flight 2 ' . $flight_req = trim(preg_replace("~[\s]+~", " ", $flight_req));    //removing more spaces

        $flight_req = preg_replace("~[^\w\s]~", " ", $flight_req);        //replacing special chars with space

        $ismatched = false;
        /* if (preg_match("~\bto\b ([\w\s]+) fro?m ([\w\s]+)~", $flight_req, $match)) {
          echo '<br>Reg 1:';
          print_r($match);
          $placeFrom = $match[2];
          $placeTo = $match[1];
          $ismatched = true;
          } else if (preg_match("~.*(\b(fro?m)\b) ?([\w\s]+) to ([\w\s]+)~", $flight_req, $match)) {
          echo '<br>Reg 2:';
          print_r($match);
          $placeFrom = $match[3];
          $placeTo = $match[4];
          $ismatched = true;
          } else if (preg_match("~([\w\s]+) to ([\w\s]+)~", $flight_req, $match)) {
          echo '<br>Reg 3:';
          print_r($match);
          $placeFrom = $match[1];
          $placeTo = $match[2];
          $ismatched = true;
          } else if (preg_match("~([\w\s]+) (fro?m) ([\w\s]+)~", $flight_req, $match)) {
          echo '<br>Reg 4:';
          print_r($match);
          $placeFrom = $match[3];
          $placeTo = $match[1];
          $ismatched = true;
          } else */ if (preg_match("~from ([\w\s]+)~", $flight_req, $match)) {
            echo '<br>Reg 5:';
            print_r($match);
            $placeFrom = $match[1];
            $placeTo = 'N';
            $place = $placeFrom;
            $ismatched = true;
        } else if (preg_match("~to ([\w\s]+)~", $flight_req, $match)) {
            echo '<br>Reg 6:';
            print_r($match);
            $placeFrom = 'N';
            $placeTo = $match[1];
            $ismatched = true;
        } /* else if (preg_match("~([\w]+) ([\w]+)~", $flight_req, $match)) {
          echo '<br>Reg 7:';
          print_r($match);
          $placeFrom = $match[1];
          $placeTo = $match[2];
          $ismatched = true;
          } */
    }

    //code handling flight details

    if ($ismatched) {
        $flicode = '';
        $airName = '';

        echo "<h4>Checking airlines name present</h4>";
        //checking whether airline name 
        $query = "SELECT distinct airline,air_srch FROM nepal_flight_airlines";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

        $matched_airline = '';
        $arAirlines = array();
        while ($row = mysql_fetch_assoc($result)) {
            $arAirlines[] = $row['airline'];
            if ($placeTo && preg_match('~(' . $row['airline'] . '|' . $row['air_srch'] . ')~Usi', $placeTo, $match)) {
                $matched_airline = $row['airline'];
                $placeTo = preg_replace('~' . $match[1] . '~', '', $placeTo);
            } elseif ($placeFrom && preg_match('~(' . $row['airline'] . '|' . $row['air_srch'] . ')~Usi', $placeFrom, $match)) {
                $matched_airline = $row['airline'];
                $placeFrom = preg_replace('~' . $match[1] . '~', '', $placeFrom);
            }
        }

        //echo "<h4>Source: $placeFrom - Dest: $placeTo</h4>";
        if ($placeFrom != 'N') {
            $placeFrom = match_flight($placeFrom, 'nepal_flight_dest', 'dest_name', 'dest_srch');
            $place = $placeFrom;
        } else {
            $placeTo = match_flight($placeTo, 'nepal_flight_dest', 'dest_name', 'dest_srch');
            $place = $placeTo;
        }

        if ($placeFrom != 'N') {
            $place = $placeFrom;
            $method = 'domArrival';
            $text = "From $place To Tribhuwan Airport, Kathmandu";
        } else {
            $place = $placeTo;
            $method = 'domDepart';
            $text = 'From Tribhuwan Airport, Kathmandu To ' . $place;
        }

        echo "<h4>PLACE: $place METHOD: $method</h4>";

        if (!$matched_airline) {
            $flight_return = "$text - Reply with Airline Name\n";

            $options_list[] = 'All';
            $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__-1__-1__");  //format __npl__flight__<from>__<to>__<airline>__<code>__
            /* foreach ($arAirlines as $value) {
              $options_list[] = $value;
              $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $value . "__none__");  //format __npl__flight__<from>__<to>__<airline>__<code>__
              } */
            $request_type = 'getFlightNameFromPlace';
            include 'nepal_flight_check.php';

            $arFlightNames = json_decode($content, TRUE);
            //var_dump($arFlightNames);
            foreach ($arFlightNames as $value) {
                $options_list[] = $value['info']['airline_name'];
                $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $value['info']['airline_name'] . "__none__");  //format __npl__flight__<from>__<to>__<airline>__<code>__
            }
        } else {
            $airName = $matched_airline = match_flight($matched_airline, 'nepal_flight_airlines', 'airline', 'air_srch');
            //$arFlightCodes = get_nepal_flight_codes($matched_airline);
            $flight_return = "$text - $matched_airline - Reply with Flight Code\n";

            $options_list[] = 'All';
            $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $matched_airline . "__-1__");
            /* foreach ($arFlightCodes as $value) {
              $options_list[] = $value;
              $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $matched_airline . "__" . $value . "__");  //format __npl__flight__<from>__<to>__<airline>__<code>__
              } */

            $request_type = 'getFlightCodes';
            include 'nepal_flight_check.php';

            $arFlightCodes = json_decode($content, TRUE);
            //var_dump($arFlightCodes);
            foreach ($arFlightCodes as $value) {
                $options_list[] = $value['info']['flight_number'];
                $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $matched_airline . "__" . $value['info']['flight_number'] . "__");  //format __npl__flight__<from>__<to>__<airline>__<code>__
            }
        }
    }

    echo "flight data $flight_return<br>";
    if ($flight_return != '') {
        $total_return = $flight_return;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'flight';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} else if (preg_match('~__npl__flight__(.+)__(.+)__(.+)__(.+)__$~', $req, $matchp)) {
    echo "<h2>INSIDE REQ check</h2>";
    $placeFrom = $matchp[1];
    $placeTo = $matchp[2];
    $airName = $matchp[3];
    $flicode = $matchp[4];

    if ($placeFrom != 'N') {
        $place = $placeFrom;
        $method = 'domArrival';
        $text = "From $place To Tribhuwan Airport, Kathmandu";
    } else {
        $place = $placeTo;
        $method = 'domDepart';
        $text = 'From Tribhuwan Airport, Kathmandu To ' . $place;
    }

    echo "<h3>RQ: place: $place - AIR: $airName - CODE:$flicode</h3>";
    echo "<h3>Method : $method TEXT: $text</h3>";

    $flight_return = '';
    if ($flicode == 'none') {
        //$arFlightCodes = get_nepal_flight_codes($airName);
        //var_dump($arFlightCodes);
        $flight_return = "$text - Reply with Flight Code\n";

        $options_list[] = 'All';
        $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $airName . "__-1__");
        /* foreach ($arFlightCodes as $value) {
          $options_list[] = $value;
          $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $airName . "__" . $value . "__");  //format __npl__flight__<from>__<to>__<airline>__<code>__
          } */

        $request_type = 'getFlightCodes';
        include 'nepal_flight_check.php';

        $arFlightCodes = json_decode($content, TRUE);
        //var_dump($arFlightCodes);

        foreach ($arFlightCodes as $value) {
            $options_list[] = $value['info']['flight_number'];
            $list[] = array("content" => "__npl__flight__" . $placeFrom . "__" . $placeTo . "__" . $airName . "__" . $value['info']['flight_number'] . "__");  //format __npl__flight__<from>__<to>__<airline>__<code>__
        }
    } else {
//        //ready to fetch data from the website
//        $sp_code = $flicode;    //flight code
//        $sp_name = $airName;    //flight name Airline
//        $domDepart = $method; //action domestic departure
//        $sp_place = $place; //destination
//
//        echo $url_flight = 'http://www.nepalsutra.com/getDescription.php';
//
//        echo $fields_string = "req=$domDepart&sp_code=$sp_code&sp_name=$sp_name&sp_place=$sp_place&to=getFlightDetails";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url_flight);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        $content = curl_exec($ch);
        
        $request_type = 'getFlightDetails';
        include 'nepal_flight_check.php';
        
        $arHead[] = 'Airline';
        $arHead[] = 'Destination';
        $arHead[] = 'Flight No.';
        $arHead[] = 'Schedule';
        $arHead[] = 'Actual';
        $arHead[] = 'Status';

        if ($content) {
            //echo $content;

            if (preg_match('~<table width=".+" border="1" cellspacing="0" cellpadding="0">(.+)</table>~', $content, $mTable)) {
                $flightOut = '';
                if (preg_match_all('~<tr( class=".+")?>(.+)</tr>~Usi', $mTable[0], $mRow)) {
                    foreach ($mRow[0] as $rKey => $rData) {
                        if (preg_match_all('~<td( align="left")?>(.+)</td>~', $rData, $mTD)) {
                            $arData[] = explode('</td>', $mTD[0][0]);
                        }
                    }
                }

                array_walk_recursive($arData, 'strip_func');
                foreach ($arData as $value) {
                    $tdata = rtrim(implode(" - ", $value), ' - ');
                    $tdata = str_replace('-  -', '-', $tdata);
                    echo "TDATA: $tdata<br>";
                    $flightOut .= $tdata;
                    ;
                    $flightOut .= "\n";
                }
            }

            echo $flightOut;
            $flight_return = "$text\n$flightOut";
        } else {
            echo "<h3>CONTENT FAILED</h3>";
        }
    }

    if ($flight_return != '') {
        $total_return = $flight_return;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'flight';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function strip_func(&$item1, $key) {
    global $arHead;
    if (trim($item1) != '') {
        if ($key == 1) {
            $item1 = '';
        } else {
            $item1 = $arHead[$key] . ' : ' . trim(strip_tags($item1));
        }
    }
}

/*
 *  FUNCTON SEARCH STRING
 */

function srchstring_flight($mystring) {
    $words = explode(" ", $mystring);
    $ret = $words[0];
    for ($i = 1; $i < count($words); $i++) {
        if (strlen($words[$i - 1]) == 1 && strlen($words[$i]) == 1) {
            $ret .= $words[$i];
        } else {
            $ret .= " " . $words[$i];
        }
    }
    return $ret;
}

/*
 * 
 */

function match_flight($string, $table, $field, $search, $criteria='') {

    $return = '';
    echo "<h4>INSIDE check - $string - $table - $field</h4>";

    if ($string && $table && $field) {
        $string = trim(preg_replace("~\b(air|airlines?|)\b~i", "", $string));
        $string = preg_replace('~\(.*?\)~', '', $string);
        $string = preg_replace('~[\s]+~', '', $string);
        $string = trim(preg_replace('~[,;:\']~', '', $string));

        $query = "SELECT *,MATCH($field,$search) AGAINST('$string') AS point FROM $table WHERE MATCH($field,$search) AGAINST('$string') $criteria ORDER BY point DESC LIMIT 1";
        echo "<br>QUERY: $query<br/>";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $return = $row[$field];
        } else {
            $sub = substr($string, 0, 3);
            $query = "SELECT $search,$field from $table where $field like '%$sub%' $criteria";
            echo "<h4>Query MATCH: $query</h4>";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result) > 0) {
                $i = 0;
                $m2 = metaphone($string);
                echo "STRING: $string field $field search $search<br>";
                while ($row = mysql_fetch_array($result)) {
                    $bus_flight[$i] = trim($row[$field]);
                    $bus_flight_s[$i] = trim($row[$search]);

                    $m1 = metaphone($bus_flight_s[$i]);
                    $sim[$i] = similar_text($m1, $m2, $perc);
                    $percent[$i] = $perc;
                    echo '<h4>similarity: ' . $bus_flight_s[$i] . ' : ' . $sim[$i] . ', ' . $perc . '%</h4>';
                    $i++;
                }


                $highest = 70;
                $hkey = -1;
                foreach ($percent as$key => $pr) {
                    if ($pr > $highest) {
                        $highest = $pr;
                        $hkey = $key;
                        /* echo "<br>Matched at: " . $key;
                          echo "<br>Match using SIM :" . $bus_stop[$key] . '<br>'; */
                    }
                }

                if ($hkey >= 0) {
                    $return = $bus_flight[$hkey];
                    //$return['i'] = $bus_ids[$hkey];

                    $res[0] = $highest;
                    echo "<h4>MATCH RET: $return PRIORITY: $highest</h4>";
                    /* echo "<br>Matched Name :" . $bus_stop[$hkey];
                      echo "<br>Matched srch :" . $bus_srch[$hkey]; */
                }
            }
        }
        echo "<h4>PLACE " . $return . "</h4>";
        return $return;
    }
    return false;
}

function get_nepal_flight_codes($airline) {
    $flightcodes = array();
    $query = "SELECT flightcode FROM nepal_flight_airlines WHERE airline='$airline'";
    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    while ($row = mysql_fetch_assoc($result)) {
        $flightcodes[] = $row['flightcode'];
    }
    return $flightcodes;
}

?>
