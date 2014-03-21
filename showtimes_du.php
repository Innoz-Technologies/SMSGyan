<?php

include 'dushowtime.php';
//This is for checking Cinema timings in the UAE
//class for array compare
if (empty($localmovie_return)) {
    include_once 'class.CompareNew.php';    //array based string comparison

    $time_start = microtime(true);
    $myDataArray = array();

    $langArray = array('ENGLISH', 'MALAYALAM', 'TAMIL', 'HINDI', 'TELUGU', 'ARABIC');
    $placeArray = array('DUBAI', 'SHARJAH', 'AJMAN', 'ABU DHABI', 'AL AIN', 'FUJAIRAH', 'RAS AL KHAIMAH', 'UMM AL QU WIN');

    $show_req = preg_replace("~\b((movie|show|time|timing|showtime|showtiming)s?)\b~", '', $spell_checked);
    $show_req = trim(preg_replace("~[\s]+~", " ", $show_req));
    if (preg_match("~(.*) (in|at|near) (.+)~", $show_req, $matches)) {
        $movie_array = searchMovie($matches[1], $matches[3]);
    } else {
        if (in_array(strtoupper($show_req), $placeArray)) {
            $movie_array = searchMovie('', $show_req);
        } else {
            $movie_array = searchMovie($show_req, '');
        }
    }

    if (!empty($movie_array)) {
        if (is_array($movie_array['movie'])) {
            $localmovie_return = "Place: " . $movie_array['place'][0] . "\n";
            foreach ($movie_array['movie'] as $key => $value) {
                $localmovie_return.="Movie: " . $value . " [" . $movie_array['lang'][$key] . "]\n";
                $localmovie_return.=$movie_array['info'][$key] . "\n";
            }
        } else {
            $localmovie_return = "Movie: " . $movie_array['movie'] . "[" . $movie_array['lang'] . "]\n";
            foreach ($movie_array['place'] as $key => $value) {
                $localmovie_return.="Place: " . $value . "\n";
                $localmovie_return.=$movie_array['info'][$key] . "\n";
            }
        }
    } else {
        $localmovie_return = "Sorry, no Showtimes found for your query";
    }

    $ttime2 = microtime(true);
}

function searchMovie($movieName = null, $cityName = null) {

    $apc_du_showtime = "du_showtime"; //key stored in cache
    $du_ttl = 60 * 60 * 5;

    $arrMatches = array();
    $arrReturned = array();
    //check for stored data
    $arrMatches = apc_fetch($apc_du_showtime, $success);
    if ($success === false) {
        echo "<h3>FROM WEBSITE</h3>";


        $url = "http://www.khaleejtimes.com/uae-cinema-listings.asp";
        $fields_string = "lang=Select&inputtext=";
        $arrHeader = array("Content-Length:" . strlen($fields_string),
            "Cookie:ASPSESSIONIDAQBSABBR=ABFLHCGBAENDHJNCDBLPKLPG; __utma=120147026.622345690.1350292410.1350292410.1350292410.1; __utmb=120147026; __utmc=120147026; __utmz=120147026.1350292410.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none); _em_vt=8323586978e5c1cc478ed83e91b14fe84ecd503720-27137050507bd3ba; _em_v=023a71a43d534faf4b4732383a0b507bd3ba6a4d00-85585666507bd3ba; _em_sv=-1; _em_hl=1",
            "Host:www.khaleejtimes.com",
            "Referer:http://www.khaleejtimes.com/uae-cinema-listings.asp");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        curl_close($ch);

        $content_url = $result;

        if (preg_match_all('~<td><table width="100%" border="0" cellspacing="0" cellpadding="0">(.+)</table></td>~Usi', $content_url, $match)) {

            foreach ($match[1] as $value) {

                $arrMatches = matchPreg_new($value);
            }
            apc_store($apc_du_showtime, $arrMatches, $du_ttl);
        }
    }

    if (!empty($arrMatches)) {

        if ($movieName != null || $movieName != "") {
            $movieName = strtolower(trim(preg_replace("~[\s]+~", " ", $movieName)));

            $mykey = false;
            foreach ($arrMatches['movie'] as $key => $value) {

                $movieName = strtolower(trim(preg_replace("~[\s]+~", " ", $movieName)));
                $value = strtolower(trim(preg_replace("~[\s]+~", " ", $value)));
                if ($movieName == $value) {
                    $mykey = $key;
                    break;
                }
            }

            if ($mykey === false) {

                $movie = new CompareStringArray($movieName, $arrMatches['movie']);

                $movie->compare();

                $mykey = $movie->meta_perc_key;
                $movieName = $movie->matched_value;
            }

            if ($mykey !== false) {
                $myplaces = $arrMatches['place'][$mykey];
                $myinfo = $arrMatches['info'][$mykey];
                $mylang = $arrMatches['lang'][$mykey];

                $arrReturned['movie'] = $movieName;
                $arrReturned['lang'] = $mylang;

                foreach ($myplaces as $key => $value) {
                    if ($cityName != null || $cityName != "") {
                        $value = strtolower(trim(preg_replace("~[\s]+~", " ", $value)));
                        $cityName = strtolower(trim(preg_replace("~[\s]+~", " ", $cityName)));
                        if ($cityName == $value) {

                            $arrReturned['place'][] = $value;
                            $arrReturned['info'][] = $myinfo[$key];
                        }
                    } else {

                        $arrReturned['place'][] = $value;
                        $arrReturned['info'][] = $myinfo[$key];
                    }
                }
            } else {
                echo "Sorry your search is not available";
            }
        } elseif ($cityName != null || $cityName != "") {

            $place_keys = array();
            $place_inner_keys = array();

            foreach ($arrMatches['place'] as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $value2 = strtolower(trim(preg_replace("~[\s]+~", " ", $value2)));
                    $cityName = strtolower(trim(preg_replace("~[\s]+~", " ", $cityName)));

                    if ($cityName == $value2) {
                        $place_keys[$key] = $key2;
                    }
                }
            }

            foreach ($place_keys as $key => $value) {

                $arrReturned['movie'][] = $arrMatches['movie'][$key];
                $arrReturned['lang'][] = $arrMatches['lang'][$key];
                $arrReturned['place'][] = $arrMatches['place'][$key][$value];
                $arrReturned['info'][] = $arrMatches['info'][$key][$value];
            }
        }
    }
    return $arrReturned;
}

function postUrl($url, $fields_string, $arrHeader) {
    //$url = "http://www.khaleejtimes.com/uae-cinema-listings.asp";
    //$fields_string = "veh_user=&regfield=$to_trace&chsis=&Submit=Get";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function matchPreg_new($data) {
    global $myDataArray, $langArray, $placeArray;
    $lang = "";
    $th_name = "";
    $movie = "";
    $timings = "";
    $place = array();
    $th_data = array();

    if (preg_match('~<td height="20"><strong>(.+)</strong></td>~Usi', $data, $match1)) {

        $valuenew = trim(strip_tags($match1[1]));
        $valuenew = strtolower(trim(preg_replace("~[\s]+~", " ", $valuenew)));
        if (in_array(strtoupper($valuenew), $langArray)) {
            $lang = $valuenew;
        } else {
            
        }

        $data = preg_replace('~<td height="20"><strong>(.+)</strong></td>~Usi', "", $data);
    }

    if (preg_match('~<td><span class="kt_fnt_black9">(.+)</span></td>~Usi', $data, $match2)) {

        $value2 = $match2[1];

        if (preg_match('~<strong>(.+)</strong> ?</font>~Usi', $value2, $match2)) {

            $movie = str_replace('&amp;', '&', strip_tags($match2[1]));
        }
        $count_1 = 1;
        $tmp_info = "";
        while ($count_1 <= 10) {
            if (preg_match('~<strong>(.+)</strong> ?<p>~Usi', $value2, $match2)) {

                $value = $match2[1];
                $value = str_replace($movie, '', $value);
                $value = trim(strip_tags($value));
                if (trim($value) != "") {
                    $value = strtolower(trim(preg_replace("~[\s]+~", " ", $value)));
                    if (in_array(strtoupper($value), $placeArray)) {
                        $place[] = strtolower($value);
                    } else {
                        $tmp_info = strtolower($value);
                    }
                }

                $value2 = preg_replace('~<strong>(.+)</strong> ?<p>~Usi', "", $value2, 1);

                if (preg_match('~^(.+)<strong>~Usi', $value2, $match2)) {

                    $value = $match2[1];

                    $value = str_replace('&amp;', '&', trim(strip_tags($value)));
                    if (trim($value) != "")
                        $th_data[] = str_replace('&amp;', '&', strtolower($tmp_info . $value));

                    $value2 = preg_replace('~(.+)(<strong>)~Usi', "$2", $value2, 1);
                }else {
                    $value = trim(strip_tags($value2));
                    if (trim($value) != "")
                        $th_data[] = strtolower(str_replace('&amp;', '&', $value));

                    $value2 = preg_replace('~(.+)~Usi', "", $value2, 1);
                }
            }


            $count_1++;
        }
        //echo "count: $count_1<br>";
    }

    $myDataArray['movie'][] = trim(strtolower($movie));
    $myDataArray['lang'][] = strtolower($lang);
    $myDataArray['place'][] = $place;
    $myDataArray['info'][] = $th_data;

    return $myDataArray;
}

?>
