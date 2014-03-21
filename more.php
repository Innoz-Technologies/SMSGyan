<?php

echo "\n<br><br>FREE: ";
var_dump($free);
echo "<br>\n";
$query = 'select target,position,machine_id from request where (mobile="' . $numbers . '" and position !=-1)';
$result = mysql_query($query) or trigger_error("Error in $query: " . mysql_error(), E_USER_ERROR);
$num_rows = mysql_num_rows($result);
if ($num_rows != 0) {
    $row = mysql_fetch_assoc($result);
    print_r($row);
    $current_file = $row["target"];
    $position = $row["position"];
    $m = $row['machine_id'];
    if (stripos($file, "www/gyan")) {
        $m = 2;
    }
    if ($m == "db") {
        //target = table/field/id_field/id
        $fields = explode("/", $current_file);
        echo "<br>request table<br>";
        print_r($fields);
        echo "<br>";
        if ($fields[0] == 'canned_responses' && in_array($fields[3], array(25, 26, 100))) {
            $free = true;
        }
        $query = "SELECT " . $fields[1] . " FROM " . $fields[0] . " WHERE `" . $fields[2] . "` = '" . mysql_real_escape_string($fields[3]) . "'";
        $result = mysql_query($query) or die(mysql_error() . " in $query");
        $row = mysql_fetch_row($result);
        echo "<br>row<br>";
        print_r($row);
        echo "<br>";
        $content = str_replace("\r", "\n", $row[0]);

        $content = trim($content);
    } else {
        $content = get_file_contents($current_file, $m);
        if (!$content) {
            sleep(1);
            $content = get_file_contents($current_file, $m);
        }
    }

    var_dump($content);

    $e = 0; //
    //for disamb pages
    if (substr($content, 0, 1) == '|') {
        echo "<br>DISAMBIGUATION PAGE<br>";
        $e = strpos($content, '|', 1) + 1;
    }

    //
    $first_char = substr($content, $position + $e - 1, 2);
    echo "\n<br>first char: ";
    var_dump($first_char);
    echo "<br>";
    if (strpos($first_char, ".") === false && strpos($first_char, "\n") === false) {
        $nlpos = strpos($content, "\n");
        $dotpos = strpos($content, ".");
        var_dump($nlpos);
        var_dump($dotpos);
        $x = $nlpos ? $nlpos : $dotpos;
        echo "<br>x: ";
        var_dump($x);
        echo "<br>";
        $content = trim(substr($content, $position + $x));
    } else {
        echo "<br>position:";
        var_dump($position);
        var_dump($e);
        echo "<br>";
        $content = substr($content, $position + $e);
    }
    /* if (strlen($content) > 1000) {
      $content = left($content, 1000);
      } */
    //echo "<br>$content<br>";

    $out_text = trim(getLinks($content));
    $addon = '';
    $add_on_top = '';

    if (strlen($out_text) > 480) {
        $addon = "\nOptions (Eg: Reply with 1 for Next Page):\n";
    }

    if ($has_options)
        $add_on_top = "Options (Eg: Reply with 1 for Next Page):\n";
    //$options = array();
    unset($options);
    $total_output_length = strlen($out_text) + strlen($add_on_top) + strlen($addon);

    if (strlen($out_text) + strlen($add_on_top) + strlen($addon) > 480) {
        //$has_options = false;
        if ($has_options) {
            $addon = "\n1. View more results";
            if (!$free) {
                $addon .= " @Rs.$charge_per_query/query";
            }
        } else {
            $addon = "\nOptions (Eg: Reply with 1 for Next Page):\n";
            $addon .= "1.NEXT PAGE";
            if (!$free) {
                $addon .= " @Rs.$charge_per_query/query";
            }
        }
        $cut_pos = 0; //$position;
        $not_added = true;
        $sents = "";
        $abrupt = false;

        //	Extract upto CHAR_LIMIT chars from total_return after LINKS changed
        do {
            $length_needed = 480 - ( strlen($sents) + strlen($addon) + strlen($add_on_top) );
            $part = substr($content, $cut_pos, $length_needed);
            echo "\n<br>first part<br>\n";
            var_dump($part);
            echo "\n<br>-------<br>\n";
            $cut = 0;

            /*
              if ($has_options)
              $dot_at = false;
              else {
              $dot_at = strrpos($part, ". ");
              if ($dot_at) $dot_at += 1;
              }
              $newline_at = strrpos($part, "\n");
             */

            //Position of the last \n
            $newline_at = strrpos($part, "\n");
            //Position of the last dot
            //if (!$direct) {
            $dot_at = strrpos($part, ". ");
            if ($dot_at) {
                $dot_at++;
            }
//            } else {
//                echo "\n<br>dot at false 1<br>\n";
//                $dot_at = false;
//            }
            if ($dot_at < 100) {
                echo "\n<br>dot false 2 $dot_at<br>\n";
                $dot_at = false;
            }
            if ($newline_at < 100) {
                echo "\n<br>new line at false: $newline_at<br>\n";
                $newline_at = false;
            }

            var_dump($dot_at);
            var_dump($newline_at);

            if ($dot_at || $newline_at) {
                echo "\n<br>dot_at: $dot_at<br>\nnew_line: $newline_at<br>\n";
                $abrupt = false;

                if (!$newline_at) {
                    $end_at = $dot_at;
                } else {
                    $newline_2 = strrpos(substr($part, 0, $newline_at), "\n");
                    if ($newline_2 !== false) {
                        $head = substr($part, $newline_2, $newline_at - $newline_2); //part between the last two newlines
                        echo "\n<br>head: $head<br>\n";
                        if (!preg_match("~\b[a-z]+\b~", $head, $matches)) { // matches 'HEADING'
                            echo "\n<br>head matched<br>\n";
                            $newline_at = $newline_2 + 1; //strrpos( substr($part, 0, $newline_at ), "\n" );
                        }
                    }
                    /* if ($dot_at && preg_match("~\b\d{,3}\.~", substr($part, $dot_at - 4, 5), $subpat)) {
                      $end_at = $newline_at;
                      } else {
                      // cut right after a \n or .
                      $end_at = ( (strrpos($part, ". ") > strrpos($part, "\n")) || $newline_at === false ) ? $dot_at : $newline_at;
                      } */
                    $nl_b4_dot = strrpos(substr($part, 0, $dot_at), "\n") + 1;
                    $dot_part = substr($part, $nl_b4_dot, $dot_at - $nl_b4_dot);

                    echo "\n<br>nl_b4_dot: $nl_b4_dot<br>\n";
                    echo "\n<br>dot_part: $dot_part<br>\n";

                    if ($dot_at && preg_match("~\d{,2}\.~", $dot_part, $subpat)) { //finds 1. , 10. etc
                        $end_at = $newline_at;
                        echo "\n<br>ol found new end_at: $end_at<br>\n";
                    } else {
                        // cut right after a \n or .
                        if (!$dot_at) {
                            $end_at = $newline_at;
                        } else {
                            $end_at = ( (strrpos($part, ". ") > strrpos($part, "\n")) || $newline_at === false ) ? $dot_at : $newline_at;
                            echo "\n<br>END AT: $end_at<br>\n";
                        }
                    }
                }
            } else if (strlen($sents) == 0) {
                //no dot or newline
                $end_at = strrpos($part, " ");
                $abrupt = true;
                echo "\n<br>abrupt, end_at: $end_at<br>\n";
            } else {
                echo "\n<br>stopping with:";
                var_dump($sents);
                echo "<br>\n";
                break;
            }

            $cut = strlen($part) - $end_at;
            $part = substr($part, 0, $end_at);
            $cut_pos += strlen($part); //$length_needed - $cut;

            echo "<br>cut: $cut<br>\npart: $part<br>\ncut_pos: $cut_pos<br>\n";
            echo "sents: $sents<br>\n";
            $sents = getLinks($sents . $part);
            echo "sents after getLinks:\n";
            var_dump($sents);
            echo "<br>----<br>\n";
            /* if ($has_options && $not_added) {
              $sents = "Type the option you wish to select & reply e.g. 1\n" . $sents;
              $not_added = false;
              } */
        } while (strlen($sents) + strlen($addon) + strlen($add_on_top) + $cut < 480);

        echo "\n<br>do..while end<br>\n";

        var_dump($sents);

        echo "<br>------------<br>\n";

//        var_dump($sents);
//        var_dump($addon);
//        var_dump($add_on_top);

        if (strlen($sents) > 4 && preg_match("~[\w\d]+~", $sents)) {
            if ($addon != '') {
                if ($direct) {
                    $options[] = array("content" => "more",
                        "count" => count($options) + 1, "type" => "disamb");
                } else {
                    $options[] = array("content" => "more",
                        "count" => count($options) + 1);
                }
                $key = '';
                foreach ($options as $opt) {
                    if ($opt['content'] == 'more') {
                        $key = $opt['count'];
                        break;
                    }
                }
                if ($has_options) {
                    $addon = "\n$key: View more results";
                    if (!$free) {
                        $addon .= " @Rs.$charge_per_query/query";
                    }
                } else {
                    $addon = "\nOptions (Eg: Reply with 1 for Next Page):\n$key: NEXT PAGE";
                    if (!$free) {
                        $addon .= " @Rs.$charge_per_query/query";
                    }
                }
            }
            if ($free == false && $showsuboption) {
                if ($addon == '') {
                    $addon = "\nOptions (Eg: Reply with 1 for Next Page):";
                }
                $key = count($options) + 1;
                if ($validity == 1) {
                    if ($to_logserver['source'] == 'quiz') {
                        $addon .= "\n--\n$key: Unlimited search at Rs $price_point/day";
                    }
                    $addon .= "\n$key: Unlimited search at Rs $price_point/day";
                } else {
                    if ($to_logserver['source'] == 'quiz') {
                        $addon .= "\n--\n$key: Unlimited search at Rs $price_point/day";
                    }
                    $addon .= "\n$key: Unlimited search at Rs $price_point/$validity days";
                }
                // "Subscribe at Rs $pricepoint/$pricepoint days"; //Subscribe option";
                $options[] = array("content" => "sub_gyan", "count" => count($options) + 1);
            }

            //$sents has text with maximum length attainable
            if ($abrupt)
                $sents .= "...";

            $length = strlen($sents) + strlen($addon);
            $position += $cut_pos;
            echo "\n<br>new pos: $position<bR>\n";
            $query = 'update request set position=' . $position . ' where mobile="' . $numbers . '"';
            mysql_query($query) or trigger_error("Error in $query: " . mysql_error(), E_USER_ERROR);

            if ($current_folder == 'test') {
                $listAll["list"] = $options;
                $outs = serialize($listAll);
            } else {
                $outs = serialize($options);
            }
            file_put_contents(DATA_PATH . "/lists/$numbers", $outs);
//            $lq = "REPLACE INTO lists (machine_id,number,query_id) VALUES ('$machine_id','$numbers','$query_id')";
//            mysql_query($lq) or trigger_error(mysql_error() . " in $lq", E_USER_ERROR);
            $to_cache['m'] = $machine_id;
            $to_cache['q'] = $query_id;
            $url = "http://IP/cache/write.php?name=ls$numbers&data=" . urlencode(json_encode($to_cache)) . "&ttl=86400";
            $cache_res = file_get_contents($url);
            echo "<br>Cache res : $cache_res";
            $total_return = $add_on_top . $sents . $addon;
            echo "\n<br>total_return len: " . strlen($total_return) . "<br>\n";
            echo "<br>This Is MORE :$total_return";
            if (!(strpos($total_return, 'NEXT PAGE') > 0 )) {
                echo "<br>Example replaced";
                $total_return = str_replace('Eg: Reply with 1 for Next Page', 'Reply with option, eg. 1', $total_return);
            }
            putOutput($total_return);
        } else {
            echo "\n<br>EMPTY OUTPUT 1<br>\n";
            $total_return = 'Sorry, no more data available';
            putOutput($total_return);
        }
    } else {
        if ($free == false && $showsuboption) {
            if ($addon == '') {
                $addon = "\nOptions (Eg: Reply with 1 for Next Page):";
            }
            $key = 1;
            if ($validity == 1) {
                $addon .= "\n$key: Unlimited search at Rs $price_point/day";
            } else {
                $addon .= "\n$key: Unlimited search at Rs $price_point/$validity days";
            }
            // "Subscribe at Rs $pricepoint/$pricepoint days"; //Subscribe option";
            $options[] = array("content" => "sub_gyan", "count" => 1);
        }
        echo "\n<br>no read more<br>\n";
        if (strlen($out_text) > 4 && preg_match("~[\w\d]+~", $out_text)) {
            $query = 'update request set position=-1 where mobile="' . $numbers . '"';
            mysql_query($query) or trigger_error("Error in $query: " . mysql_error(), E_USER_ERROR);
            $content = getLinks($content);

            $outs = serialize($options);
            file_put_contents(DATA_PATH . "/lists/$numbers", $outs);
//            $lq = "REPLACE INTO lists (machine_id,number,query_id) VALUES ('$machine_id','$numbers','$query_id')";
//            mysql_query($lq) or trigger_error(mysql_error() . " in $lq", E_USER_ERROR);
            $to_cache['m'] = $machine_id;
            $to_cache['q'] = $query_id;
            $url = "http://IP/cache/write.php?name=ls$numbers&data=" . urlencode(json_encode($to_cache)) . "&ttl=18000";
            $cache_res = file_get_contents($url);
            echo "<br>Cache res : $cache_res";
            $out_text = $out_text . $addon;
        } else {
            echo "\n<br>EMPTY OUTPUT 2<br>\n";
            $out_text = 'Sorry, no more data available';
        }
        if ($has_options) {
            $add_on_top = "Options (Eg: Reply with 1 for Next Page):\n";
        }
        echo "<br>This Is MORE :$out_text";
        if (!(strpos($out_text, 'NEXT PAGE') > 0 )) {
            echo "<br>Example replaced";
            $out_text = str_replace('Eg: Reply with 1 for Next Page', 'Reply with option, eg. 1', $out_text);
        }
        putOutput($out_text);
    }
} else {
    echo "\n<br>empty query result<br>\n";
    $total_return = $no_result_string;
    putOutput($total_return);
}
?>