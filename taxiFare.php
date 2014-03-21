<?php

if ($current_folder == "test") {
    echo"<br>OLA CAB<br>";
    include 'olaCab.php';
}

echo "<br><h2>TIME after Ola Cab :" . (microtime(TRUE) - $time_start) . "</h2><br>";

$total_return = '';
$outStr = '';

if (preg_match("~\b(taxi|cabs?)\b~", $spell_checked)) {
    echo "<h3>Taxi Fare</h3>";
    $isPossible = true;
    $cityid = 0;
    $destination = $origin = '';

    if (preg_match("~^(taxi|cabs?)~", $spell_checked)) {
        $taxiFare_must = true;
    }

    echo $taxiStr = trim(preg_replace("~(taxi|cabs?)~", "", $spell_checked));

    if (preg_match("~\bto\b ([\w\s]+) fro?m ([\w\s]+)~", $taxiStr, $match)) {
        echo '<br>Reg 1:';
        $origin = $match[2];
        $destination = $match[1];
    } else if (preg_match("~.*(\b(fro?m)\b) ?([\w\s]+) to ([\w\s]+)~", $taxiStr, $match)) {
        echo '<br>Reg 2:';
        $origin = $match[3];
        $destination = $match[4];
    } else if (preg_match("~([\w\s]+) to ([\w\s]+)~", $taxiStr, $match)) {
        echo '<br>Reg 3:';
        $origin = $match[1];
        $destination = $match[2];
    } else if (preg_match("~([\w\s]+) (fro?m) ([\w\s]+)~", $taxiStr, $match)) {
        echo '<br>Reg 4:';
        $origin = $match[3];
        $destination = $match[1];
    }

    $origin = trim(remwords($origin));
    $destination = trim(remwords($destination));

    if (!empty($origin) && !empty($destination)) {
        echo $query = "select * from taxi_distime where SOUNDEX(origin)=SOUNDEX('" . $origin . "') and SOUNDEX(destination)=SOUNDEX('" . $destination . "') limit 0,1";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

        echo "<br>" . mysql_num_rows($result);

        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_array($result);
            echo "<br>" . $cityid = $row["cityid"];
            echo "<br>" . $distance = $row["distance"];
            echo "<br>" . $esttime = $row["duration"];
        } else {

            if ($operator == "du") {
                $url = "API";
            } else {
                $url = "API";
            }

            $esttime = 0;

            echo "<br>DIRECTIONS URL:<br>$url<br>";
            $json = file_get_contents($url);

            $directions = new GoogleDirections($json);
            if ($directions->get_distance()) {
                $start_loc_lat = $directions->start_location->lat;
                $start_loc_lng = $directions->start_location->lng;

                $end_loc_lat = $directions->end_location->lat;
                $end_loc_lng = $directions->end_location->lng;

                $clat = 999;
                $clng = 999;
                $result_lat = 0;
                $result_lng = 0;
                $cityid = 0;

                $query = "select * from taxi_state";
                $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

                while ($row = mysql_fetch_array($result)) {

                    $result_lat = abs(abs($start_loc_lat) - abs($row["lat"]));

                    $result_lng = abs(abs($start_loc_lng) - abs($row["lng"]));


                    if ($result_lat <= $clat && $result_lng <= $clng) {
                        $city = $row["state"];
                        $clat = $result_lat;
                        $clng = $result_lng;

                        $city_lat = $row["lat"];
                        $city_lng = $row["lng"];
                        $cityid = $row["sval"];
                    }
                }
                $isPossible = true;
                if ($cityid > 0) {
                    echo $distance = $directions->distance;
                    if ($origin == $destination || $city == $origin || $city == $destination) {
                        echo 'city, origin, destination are same';
                        $isPossible = false;
                    } elseif (($start_loc_lat == $city_lat) || ($start_loc_lng == $city_lng)) {
                        echo "origin and city are same";
                        $isPossible = false;
                    } elseif (($end_loc_lat == $city_lat) || ($end_loc_lng == $city_lng)) {
                        echo "destination and city are same";
                        $isPossible = false;
                    } elseif (abs(abs($start_loc_lat) - abs($city_lat)) > 1 || abs(abs($start_loc_lng) - abs($city_lng)) > 1) {
                        echo "origin is out of city";
                        $isPossible = false;
                    } elseif (abs(abs($end_loc_lat) - abs($city_lat)) > 1 || abs(abs($end_loc_lng) - abs($city_lng)) > 1) {
                        echo "destination is out of city";
                        $isPossible = false;
                    } elseif ($distance == 0) {
                        echo "Destance=0";
                        $isPossible = false;
                    }

                    if ($isPossible) {

                        $distance = preg_replace("~[^\d,\.]~", "", $directions->distance);
                        $duration = $directions->duration;

                        echo '<br>' . $city;
                        preg_match("~(.+) hours?~", $duration, $hr);
                        if (!empty($hr)) {
                            $esttime = $hr[1] * 3600;
                        }
                        $duration = preg_replace("~(.+) hours~", "", $duration);
                        echo '<br>';
                        preg_match("~(.+) mins?~", $duration, $min);
                        if (!empty($min)) {
                            echo $esttime += $min[1] * 60;
                        }


                        echo $query = "insert into taxi_distime(origin,destination,distance,duration,cityid) values('$origin','$destination',$distance,$esttime,$cityid)";

                        mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                        $direction_id = mysql_insert_id();
                    }
                }
            }
        }

        if ($cityid > 0 && $isPossible) {
            echo $url = "API";
            $content = file_get_contents($url);

            if (preg_match('~<th scope="col">(.+)</table>~Usi', $content, $match)) {
                $out = str_replace("</b>", " ", $match[1]);
                $out = str_replace("</span>", "***", $out);
                $out = str_replace("</th>", "***", $out);
                $out = strip_tags($out);
                $out = trim(preg_replace("~[\s]+~", " ", $out));
                $out = str_replace("***", "\n", $out);
                $out = str_replace("\n ", "\n", $out);
                $out = str_replace("&nbsp;", "", $out);
                echo $out;
            }
            $total_return = "The Fare from  $origin  to $destination \n$out";
        } else if ($taxiFare_must) {
            $total_return = "Sorry no taxi fare found for $spell_checked";
            $to_logserver['isresult'] = 0;
        }

        if ($total_return) {
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = 'taxi_fare';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}
?>