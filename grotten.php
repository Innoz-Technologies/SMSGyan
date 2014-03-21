<?php

echo "<h3>Grotten.php</h3>";

$response = $rotten_in;

$gmovie_return = rtomatoes_details($response);
var_dump($gmovie_return);

function rtomatoes_details($cons) {
    global $rkey;
    global $remain_movie;
    global $word;
    global $spell_checked_word;
    $check_title = $spell_checked_word;
    global $snn;
//    $check_title = $mov_name;
    global $title_tm, $rating_tm, $synop_tm, $casting_tm, $year_tm;
    $rotten_return = '';
    $rating = array();
    $content_jsn = json_decode($cons);
    $content_jsn = objectsIntoArray($content_jsn);
    //print_r($content_jsn);
    if (isset($content_jsn['total']) && $content_jsn['total'] != 0 && $content_jsn['total'] != NULL) {
        $total_results = trim($content_jsn['total']);
    }

    foreach ($content_jsn['movies'] as $distinct) {
        //print_r($distinct);
        $snn[] = $distinct;
    }
    //print_r($snn);


    foreach ($snn as $key => $data) {
        if (isset($data['title']) && $data['title'] != NULL) {
            $title_tm[$key] = trim($data['title']);
        }

        if (isset($data['id']) && $data['id'] != NULL) {
            $id_tm[$key] = trim($data['id']);
        }

        foreach ($data['ratings'] as$kn => $rnt) {
            if (isset($rnt) && $rnt != NULL) {
                $rating_tm[$key][$kn] = trim($rnt) / 10;
            }
        }

        if (isset($data['year']) && $data['year'] != NULL) {
            $year_tm[$key] = trim($data['year']);
        }

        if (isset($data['synopsis']) && $data['synopsis'] != NULL) {
            $synop_tm[$key] = trim($data['synopsis']);
        }

        //$runtime[$key]= trim($data['runtime']);
        //print_r($release = trim($content_jsn['movies'][0]['synopsis']));
        $i = 0;
        foreach ($data['abridged_cast'] as $cst) {
            //var_dump($cst);
            if (isset($cst['name']) && $cst['name'] != NULL) {
                $casting_tm[$key][$i][0] = trim($cst['name']);
            }
            if (isset($cst['characters'][0]) && $cst['characters'][0] != NULL) {
                $casting_tm[$key][$i][1] = trim($cst['characters'][0]);
            }
            $i = $i + 1;
        }
    }

    $fkey = 100;
    $prevyear = 1111;
    $rkey = 0;

    if (isset($total_results)) {
        for ($i = 0; $i < $total_results; $i++) {
            if (!isset($title_tm[$i]))
                continue;
            $dist_title = $title_tm[$i];
            $lev_arry[$i] = levenshtein($dist_title, $check_title);
        }

        foreach ($lev_arry as $id => $val) {
            if ($val <= $fkey) {
                if ($val == $fkey) {
                    if ($prevyear < $year_tm[$id]) {
                        $rkey = $id;
                        $fkey = $val;
                        $prevyear = $year_tm[$id];
                    }
                } else {
                    $rkey = $id;
                    $fkey = $val;
                    $prevyear = $year_tm[$id];
                }
            }
        }
//        asort($lev_arry);
//
//        $temp = each($lev_arry);
//        echo "Key--" . $rkey = $temp["key"];
//        echo "Value--" . $rtitle = $temp["value"];

        $rotten_return = get_movie_details($rkey);
        //unset ($title_tm[$rkey]);

        if (isset($title_tm)) {
            //echo "INN";
            print_r($remain_movie = $title_tm);
        }
    }


    //$rotten_return = get_movie_details(0);
    if (!empty($rotten_return)) {
        $result = array("movie" => true, "type" => "rotten", "id" => $id_tm[$rkey], "title" => $title_tm[$rkey], "value" => $rotten_return);
    } else {
        $result = false;
    }
    return $result;
}

function get_movie_details($v) {
    global $title_tm, $rating_tm, $synop_tm, $casting_tm, $year_tm;
    if (isset($title_tm[$v]) && $title_tm[$v] != NULL) {
        $rotten_return = "Title: $title_tm[$v]";
        if (isset($year_tm[$v]) && $year_tm[$v] != NULL) {
            $rotten_return .= "  (" . $year_tm[$v] . ")\n";
        } else
            $rotten_return .= "\n";
    }
    //$rotten_return .= "Release date: $release_date \n";
    if (isset($rating_tm[$v]['critics_score']) && $rating_tm[$v]['critics_score'] != NULL && $rating_tm[$v]['critics_score'] != -1 && $rating_tm[$v]['critics_score'] != 0) {
        $rotten_return .= "Critic Rating:" . $rating_tm[$v]['critics_score'] . "\n";

        if (isset($rating_tm[$v]['audience_score']) && $rating_tm[$v]['audience_score'] != NULL && $rating_tm[$v]['audience_score'] != 0 && $rating_tm[$v]['audience_score'] != -1) {
            $rotten_return .= "Viewer Rating:" . $rating_tm[$v]['audience_score'] . "\n";
        }
        if (isset($synop_tm[$v]) && $synop_tm[$v] != NULL) {
            $rotten_return .= "Plot: $synop_tm[$v]\n";
        }
        if (isset($casting_tm[$v]) && $casting_tm[$v] != NULL) {
            $rotten_return .= "Cast:\n";
            foreach ($casting_tm[$v] as $ccst) {
                if (isset($ccst[0]) && $ccst[0] != NULL) {
                    $rotten_return .= "$ccst[0] ";
                }
                if (isset($ccst[1]) && $ccst[1] != NULL) {
                    $rotten_return .= "- $ccst[1]\n";
                }else
                    $rotten_return .= "\n";
            }
        }
    } else if (isset($rating_tm[$v]['audience_score']) && $rating_tm[$v]['audience_score'] != NULL && $rating_tm[$v]['audience_score'] != 0 && $rating_tm[$v]['audience_score'] != -1) {
        $rotten_return .= "Viewer Rating:" . $rating_tm[$v]['audience_score'] . "\n";

        if (isset($rating_tm[$v]['critics_score']) && $rating_tm[$v]['critics_score'] != NULL && $rating_tm[$v]['critics_score'] != -1 && $rating_tm[$v]['critics_score'] != 0) {
            $rotten_return .= "Critic Rating:" . $rating_tm[$v]['critics_score'] . "\n";
        }
        if (isset($synop_tm[$v]) && $synop_tm[$v] != NULL) {
            $rotten_return .= "Plot: $synop_tm[0]\n";
        }
        if (isset($casting_tm[$v]) && $casting_tm[$v] != NULL) {
            $rotten_return .= "Cast:\n";
            foreach ($casting_tm[$v] as $ccst) {
                if (isset($ccst[0]) && $ccst[0] != NULL) {
                    $rotten_return .= "$ccst[0] ";
                }
                if (isset($ccst[1]) && $ccst[1] != NULL) {
                    $rotten_return .= "- $ccst[1]\n";
                }else
                    $rotten_return .= "\n";
            }
        }
    } else
        $rotten_return = "";

    return $rotten_return;
}

?>
