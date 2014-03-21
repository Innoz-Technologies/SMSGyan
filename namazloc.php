<?php

//Common function to set Output String
function set_result($myMatch, $myMsg) {
    global $total_return;
    global $add_below;
    global $loc_req;
    if ($loc_req) {
        $total_return = "Your location is currently set to $myMatch.\n";
    } else {
        $total_return = '';
    }
    $total_return .= $myMsg;
    $add_below = "\n\nTo change location, SMS NAMAZ <Your location> to 55444";
}

function getMsg($lat, $lng, $myPlace, $mydate) {
    include_once 'prayer.php';
    $time_zone = 5.5;
    $calcmethod = 1;
    $prayTime = new PrayTime($calcmethod);
    $times = $prayTime->getPrayerTimes($mydate, $lat, $lng, $time_zone);
    $msg[0] = "Namaz Timings for $myPlace on " . date('l jS \of F Y', $mydate) . "\n";
    $msg[0] .= "Fajr => " . date('h:i A', strtotime($times[0])) . "\n";
    //$msg[0] .= "Sunrise => " . date('h:i A',strtotime($times[1])) . "\n";
    $msg[0] .= "Dhuhr => " . date('h:i A', strtotime($times[2])) . "\n";
    $msg[0] .= "Asr => " . date('h:i A', strtotime($times[3])) . "\n";
    //$msg[0] .= "Sunset => " . date('h:i A',strtotime($times[4])) . "\n";
    $msg[0] .= "Maghrib => " . date('h:i A', strtotime($times[5])) . "\n";
    $msg[0] .= "Isha => " . date('h:i A', strtotime($times[6])) . "\n";

    $msg[1] = "Today's Iftar at " . date('h:i A', strtotime($times[5])) . ".($myPlace)\n";

    return $msg;
}

$isExist = false;
if ($loc_req) {
    //already searched location should match here
    $query = "SELECT namaz_loc_match.id,matched,lat,lng FROM namaz_loc_srch,namaz_loc_match where namaz_loc_srch.area = namaz_loc_match.id and typed = '" . mysql_real_escape_string($loc_req) . "'";
    echo "<br>$query<br>";
    $result = mysql_query($query) or print(mysql_error() . "  in $query");
    if (mysql_num_rows($result)) {
        $isExist = true;
    } else {
        //If reply from option list and existing in db; will match here
        $query = "SELECT id,matched,lat,lng FROM namaz_loc_match where matched = '" . mysql_real_escape_string($loc_req) . "'";
        echo "<br>$query<br>";
        $result = mysql_query($query) or print(mysql_error() . "  in $query");
    }
    if (mysql_num_rows($result)) {
        echo '<h5>FOUND IN DB</h5>';
        $row = mysql_fetch_array($result);
        $q = "replace into namaz_list_new(msisdn,circle,area) values('$numbers','$circle_short'," . $row['id'] . ")";
        $places = explode(',', $row['matched']);
        $msgs = getMsg($row['lat'], $row['lng'], $places[0], $getdate);
        if (mysql_query($q)) {
            set_result($row['matched'], $msgs[0]);
        }
    } else {
        if (isset($lat)) {
            $places = explode(',', $loc_req);
            $msgs = getMsg($lat, $lng, $places[0], $getdate);
            //Insertion of new Location
            $q = "insert into namaz_loc_match(matched,circle,lat,lng,msg1,msg2) values('" . mysql_real_escape_string($loc_req) . "','$circle'," . $lat . "," . $lng . ",'" . mysql_real_escape_string($msgs[0]) . "','" . mysql_real_escape_string($msgs[1]) . "')";
            if (mysql_query($q)) {
                echo "<br>Record inserted to namaz_loc_match<br>";
                echo $areaId = mysql_insert_id();
            }
            $q = "replace into namaz_list_new(msisdn,circle,area) values('$numbers','$circle_short',$areaId)";
            if (mysql_query($q)) {
                set_result($loc_req, $msgs[0]); //Setting Result String
            }
            echo $total_return;
        } else {
            //calling google api to get 'lat' and 'lng'
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($loc_req) . "&sensor=true";
            $json_data = html_entity_decode(file_get_contents($url));
            $json_dec = json_decode($json_data, true);
            print_r($json_dec);
            if ($json_dec['status'] == 'OK') {        //If result found
                foreach ($json_dec['results'] as $key => $rst) {
                    //$addcount = count($rst['address_components']);
                    echo '<br>' . substr($rst['formatted_address'], strlen($rst['formatted_address']) - 5);
//                    if (substr($rst['formatted_address'], strlen($rst['formatted_address']) - 5) != 'India') {
//                        unset($json_dec['results'][$key]);
//                        echo '  :Removed';
//                    }
                }
                print_r($json_dec['results']);
                $json_dec['results'] = array_values($json_dec['results']);
                echo '<br>';
                print_r($json_dec['results']);
                if (count($json_dec['results']) == 1 || $to_logserver['isreply']) {      // If single match Found
                    $query = "SELECT id,matched,lat,lng FROM namaz_loc_match where matched = '" . mysql_real_escape_string($json_dec['results'][0]['formatted_address']) . "'";
                    echo "<br>$query<br>";
                    $result = mysql_query($query) or print(mysql_error() . "  in $query");
                    if (mysql_num_rows($result)) {  //If Matched Location is already in DB
                        echo '<br> First Case';
                        $row = mysql_fetch_array($result);
                        print_r($row);
                        $places = explode(',', $row['matched']);
                        $msgs = getMsg($row['lat'], $row['lng'], $places[0], $getdate);

                        $msg1 = $msgs[0];
                        $areaId = $row['id'];
                    } else {
                        echo '<br> second Case';
                        $msgs = getMsg($json_dec['results'][0]['geometry']['location']['lat'], $json_dec['results'][0]['geometry']['location']['lng'], $json_dec['results'][0]['address_components'][0]['long_name'], $getdate);
                        //Insertion of new Location
                        $q = "insert into namaz_loc_match(matched,circle,lat,lng,msg1,msg2) values('" . mysql_real_escape_string($json_dec['results'][0]['formatted_address']) . "','$circle'," . $json_dec['results'][0]['geometry']['location']['lat'] . "," . $json_dec['results'][0]['geometry']['location']['lng'] . ",'" . mysql_real_escape_string($msgs[0]) . "','" . mysql_real_escape_string($msgs[1]) . "')";
                        if (mysql_query($q)) {
                            echo "<br>Record inserted to namaz_loc_match<br>";
                            echo $areaId = mysql_insert_id();
                        }
                        $msg1 = $msgs[0];
                    }
                    //Inseting New search Text
                    echo $q = "insert into namaz_loc_srch(typed,area) values('" . mysql_real_escape_string($loc_req) . "',$areaId)";
                    if (mysql_query($q)) {
                        echo "<br>Record inserted to namaz_loc_srch";
                    }
                    $q = "replace into namaz_list_new(msisdn,circle,area) values('$numbers','$circle_short',$areaId)";
                    if (mysql_query($q)) {
                        set_result($json_dec['results'][0]['formatted_address'], $msg1); //Setting Result String
                    }
                    echo $total_return;
                } else if (count($json_dec['results']) > 1) {  //More than One Match
                    $istoday = false;
                    $total_return = "Your search text matches the following locations.\nPlease select one.";
                    $count = 1;
                    foreach ($json_dec['results'] as $key => $locs) {   //Location List to user to select location
                        if ($count < 10) {
                            $options_list[] = $locs['formatted_address'];
                            $list[] = array("content" => "namaz__match__loc " . $locs['formatted_address'] . " lat_ " . $locs['geometry']['location']['lat'] . " lng_ " . $locs['geometry']['location']['lng'], "count" => $count);
                            $count += 1;
                        }
                    }
                } else {
                    $total_return = "Sorry, No match found from India for '$loc_req'. Check your spelling and try again...";
                    $istoday = false;
                }
            } else {
                $total_return = "Sorry, No match found for '$loc_req'. Check your spelling and try again...";
                $istoday = false;
            }
        }
    }
//    print_r($options_list);
//    print_r($list);
} else {
    $q = "SELECT msisdn,area FROM namaz_list_new WHERE msisdn = '$numbers'";
    $r = mysql_query($q) or trigger_error("Error in $q: " . mysql_error(), E_USER_ERROR);
    if (mysql_num_rows($r)) {
        $row = mysql_fetch_array($r);
        $query = "SELECT id,matched,lat,lng FROM namaz_loc_match where id = " . $row['area'];
        echo "<br>$query<br>";
        $result = mysql_query($query) or print(mysql_error() . "  in $query");
        if (mysql_num_rows($result)) {
            echo '<h5>FOUND IN DB</h5>';
            $row = mysql_fetch_array($result);
            $places = explode(',', $row['matched']);
            $msgs = getMsg($row['lat'], $row['lng'], $places[0], $getdate);
            set_result($row['matched'], $msgs[0]);
        }
    } else {
        $total_return = "Location not found.\nTo get namaz timings sms NAMAZ <your location> to $shortcode";
    }
}
?>