<?php

if ($loc_req) {

    if (empty($place_api)) {
        
        include 'get_place.php';
    }

    if ($srch_item == '') {
        echo "<br>search key<br>";
        $arplace = array();
        $place_api = str_replace(",", " ", $place_api);
        $place_api = preg_replace("~\bRd\b~", "Road", $place_api);
        $place_api = trim(preg_replace("~[\s]+~", " ", $place_api));
        $arplace = explode(" ", $place_api);
        var_dump($arplace);
        echo "<br>" . $match_key = remwords($spell_checked);
        foreach ($arplace as $p_val) {
            if (stripos($match_key, $p_val) !== false) {
                echo $match_key = preg_replace("~\b$p_val\b~i", " ", $match_key);
            }
        }
        echo $match_keyword = $match_key = trim(preg_replace("~[\s]+~", " ", $match_key));
    }

    if (($areaId) > 0 && !empty($match_key)) {
        $query = "SELECT place_data.id,msg FROM place_data where key_match = '" . $match_key . "' and area=" . $areaId . " limit 0,1";
        echo "<br>$query<br>";
        $result = mysql_query($query) or print(mysql_error() . "  in $query");
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $total_return = $row["msg"];
            $place_id = $row['id'];
        } else {
            if (isset($lat)) {
                $total_return = '';
                $third_api = false;
                $api_hit = false;
                $json_data2 = '';
//                $url = "https://maps.googleapis.com/maps/api/place/search/json?location=" . $lat . "," . $lng . "&radius=10000&keyword=" . urlencode($match_keyword) . "&sensor=false&key=AIzaSyAs9Y2DmlCPHktZeFNVfY_yzR704wtnhto";
//                echo $url;
//                $json_data = html_entity_decode(file_get_contents($url));
//                echo "http://IP/gyan/googlePlace/placeApi?lat=$lat&lng=$lng&keyword" . urlencode($match_keyword) . "&key=AIzaSyAs9Y2DmlCPHktZeFNVfY_yzR704wtnhto";
                echo $query_cnt = "Select * from place_apicount where `api1_cnt` <1000 OR `api2_cnt` <1000 OR `api3_cnt` <1000 limit 0,1";
                $result = mysql_query($query_cnt);
                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_array($result);
                    echo "<br>" . $api1_cnt = $row["api1_cnt"];
                    echo "<br>" . $api2_cnt = $row["api2_cnt"];
                    echo "<br>" . $api3_cnt = $row["api3_cnt"];
                    $api_id = $row["id"];
                } else {
                    $apiDate = date("Y:m:d");
                    $query_cnt = "insert into place_apicount (dated,api1_cnt,api2_cnt,api3_cnt) values ('" . $apiDate . "',0,0,0)";
                    $api1_cnt = 0;
                    $api2_cnt = 0;
                    $api3_cnt = 0;
                    if (mysql_query($query_cnt)) {
                        echo "record inserted<br>";
                        $api_id = mysql_insert_id();
                    }
                }

                if ($api1_cnt < 1000) {
                    
                    
                    $json_data2 = file_get_contents("API");
                }

                if (!empty($json_data2)) {
                    $json_dec = json_decode($json_data2, true);
                    var_dump($json_dec);
                    if ($json_dec['status'] == 'OVER_QUERY_LIMIT') {
                        $api_hit = true;
                        if ($api2_cnt < 1000) {
                            
                            $json_data2 = file_get_contents("API");
                        }
                    }
                    $query_cnt = "update place_apicount set api1_cnt=api1_cnt+1 where id=$api_id";
                    if (mysql_query($query_cnt)) {
                        echo "record updated<br>";
                    }
                } else {
                    $api_hit = true;
                    if ($api2_cnt < 1000) {
                        
                        $json_data2 = file_get_contents("API");
                    }
                }

                if (!empty($json_data2) && $api_hit) {
                    $json_dec = json_decode($json_data2, true);
                    var_dump($json_dec);
                    if ($json_dec['status'] == 'OVER_QUERY_LIMIT') {
                        if ($api3_cnt < 1000) {
                            
                            $json_data2 = file_get_contents("API");
                            $third_api = true;
                        }
                    }
                    $query_cnt = "update place_apicount set api2_cnt=api2_cnt+1 where id=$api_id";
                    if (mysql_query($query_cnt)) {
                        echo "record updated<br>";
                    }
                } else {
                    if ($api3_cnt < 1000 && $api_hit) {
                        
                        $json_data2 = file_get_contents("API");
                        $third_api = true;
                    }
                }

                if (!empty($json_data2)) {
                    $json_dec = json_decode($json_data2, true);
                    var_dump($json_dec);
                    if ($third_api) {
                        $query_cnt = "update place_apicount set api3_cnt=api3_cnt+1 where id=$api_id";
                        if (mysql_query($query_cnt)) {
                            echo "record updated<br>";
                        }
                    }
                    if ($json_dec['status'] == 'OK') {

                        echo '<br>';
                        $json_dec['results'] = array_values($json_dec['results']);
                        echo '<br>';
                        $count = 0;

                        $total_return.=ucfirst($match_keyword) . " in " . $place_api . "\n";
                        foreach ($json_dec['results'] as $key => $locs) {
                            if ($count < 10) {
                                $total_return.= ($count + 1) . "." . $locs['name'] . " " . $locs['vicinity'] . "\n";
                                $count += 1;
                            }
                        }

                        $q = "insert into place_data(key_match,area,msg) values('" . mysql_real_escape_string($match_key) . "'," . $areaId . ",'" . mysql_real_escape_string($total_return) . "')";
                        echo '<br>';
                        echo $q;
                        if (mysql_query($q)) {
                            echo "<br>Record inserted to place_data<br>";
                        }
                        $place_id = mysql_insert_id();
                    }
                }
            }
        }
    }
}
?>