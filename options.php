<?php

echo "<h1>Options.php</h1>";
echo "<h4>Source is " . $to_logserver['source'] . "</h4>";

$newlist = array();
if (empty($option_top))
    $option_top = 'OPTIONS';

if (!$show_add_below)
    $add_below = '';

if (empty($recom_top))
    $recom_top = 'ALSO TRY';

if (empty($examplPrefix))
    $examplPrefix = "Reply with";

if (empty($moreOption))
    $moreOption = "MORE OPTIONS";

$lists = array();
$recom_list = array();

foreach ($list as $val) {
    if (!empty($val["type"]) && $val["type"] == "recom") {
        $recom_list[] = $val;
    } else {
        $lists[] = $val;
    }
}

$options_list_dis = $list_dis = array();

$arData = getLinksNew($total_return);

$total_return = $arData['result'];
$options_list_dis = $arData['options'];
$list_dis = $arData['list'];

if (count($options_list_dis) > 0) {
    $options_list = array_merge($options_list_dis, $options_list);
    $list = array_merge($list_dis, $list);
    $lists = array_merge($list_dis, $lists);
}

$exampl = "($examplPrefix option, e.g: 1)";
if ($show_charge_per_query && !$free && (stripos($options_list[0], "nlimited search at ") != 1 ))
    $exampl = "($examplPrefix option, e.g: 1 @" . $charge_currency . $charge_per_query . "/query)";

if (count($options_list)) {
    if (strlen($options_list[0]) < 15) {
        $exampl = "(Eg: $examplPrefix 1 for " . $options_list[0] . ")";
        if ($show_charge_per_query && !$free)
            $exampl = "(Eg: $examplPrefix 1 for " . $options_list[0] . " @" . $charge_currency . $charge_per_query . "/query)";
    }
} else if (count($recom_opns_list)) {
    if (strlen($recom_opns_list[0]) < 15) {
        $exampl = "(Eg: $examplPrefix 1 for " . $recom_opns_list[0] . ")";
        if ($show_charge_per_query && !$free)
            $exampl = "(Eg: $examplPrefix 1 for " . $recom_opns_list[0] . " @" . $charge_currency . $charge_per_query . "/query)";
    }
}

$option_top_len = strlen("\n" . $option_top . $exampl . "\n");
$recom_top_len = strlen($recom_top);
$add_below_len = 0;
$count = 1;

if (empty($add_below)) {
    $add_below = "";
} else {
    $add_below_len = strlen($add_below);
}

$option_length = 0;
$addon = "";
$addon_recom = "";

$tot_ret_length = strlen(trim($total_return));

foreach ($options_list as $value) {
    if (!$free && (stripos($value, "nlimited search at ") == 1) && $to_logserver['source'] == 'quiz') {
        $addon .= "\n--\n" . $count . ": " . $value;
    } else {
        $addon .= "\n" . $count . ": " . $value;
    }

    if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
        $addon .= " @" . $charge_currency . $charge_photo . "/query";
    }
    $count++;
}

echo "<h4>$addon</h4>";
if (!empty($options_list))
    $option_length = $option_top_len + strlen($addon);
else {
    $lscount = 1;

    foreach ($lists as $ls) {
        $ls['count'] = $lscount;
        $newlist[] = $ls;
        $lscount++;
    }
    $list = $newlist;
    if ($totalCount == 0)
        $totalCount = $total_count = count($list) + 1;
}

$recom_length = 0;

if (!empty($recom_opns_list)) {
    foreach ($recom_opns_list as $id => $value) {
        $addon_recom .= "\n" . $count . ": " . $value;
        if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
            $addon_recom .= " @" . $charge_currency . $charge_photo . "/query";
        }
        $count++;
    }
    if (!empty($recom_opns_list))
        $recom_length = $recom_top_len + strlen($addon_recom);
}

$out = "";

if ($tot_ret_length > 0) {
    if ($tot_ret_length < $max_length * 0.6) {
        echo "<br>First Case<br>";

        $totretTotLen = $max_length * 0.6;
        $tot_ret_set = set_tot_ret();
        $out .= $tot_ret_set;

        $opnsTotLen = $rem_length = $max_length - ($totretTotLen + $add_below_len);
        echo "<h2>Changing tot_ret_len $totretTotLen, $opnsTotLen</h2>";

        $option_set = set_option();
        $out .= $option_set;

        if (!empty($add_below))
            $out .= $add_below;

        appendPrevOptions();
    } else if (($option_length + $recom_length) < $max_length * 0.6) {
        echo "<br>Second Case<br>";

        $totretTotLen = $max_length - ($option_length + $recom_length + $add_below_len);
        $tot_ret_set = set_tot_ret();
        $out .= $tot_ret_set;
        echo $out;

        $rem_length = $opnsTotLen = $max_length - ($totretTotLen + $add_below_len);
        echo "<h2>Changing tot_ret_len $totretTotLen, $opnsTotLen</h2>";

        $option_set = set_option();
        $out .= $option_set;

        if (!empty($add_below))
            $out .= $add_below;

        appendPrevOptions();
    } else {
        echo "<br>Third Case<br>";

        $totretTotLen = $max_length * 0.5;
        $tot_ret_set = set_tot_ret();
        $out .= $tot_ret_set;

        $rem_length = $opnsTotLen = $max_length - ($totretTotLen + $add_below_len);
        echo "<h2>Changing tot_ret_len $totretTotLen, $opnsTotLen</h2>";

        $option_set = set_option();
        $out .= $option_set;

        if (!empty($add_below))
            $out .= $add_below;

        appendPrevOptions();
    }

    echo "<br>Final output is <br>";
    $total_return = $out;
    unset($listAll);

    $listAll["list"] = $t_list;
    $listAll["options_list"] = $t_options_list;
    $listAll["recom_opns_list"] = $t_recom_opns_list;
    $listAll["lists"] = $t_lists;
    $listAll["recom_list"] = $t_recom_list;
    $listAll["position"] = $cut_pos;
    $listAll["query"] = $word;
    $listAll["target"] = $current_file;
    $listAll["machine_id"] = $source_machine;

    var_dump($listAll);
} else {
    $total_return = $no_result_string;
}

function set_tot_ret() {
    global $total_return, $totretTotLen, $tot_ret_length, $add_below_len, $to_logserver;
    global $max_length, $option_top_len, $option_length, $recom_length, $show_charge_per_query;
    global $options_list, $list, $lists, $cut_pos, $option_top, $exampl, $charge_currency, $examplPrefix;
    global $options, $soptions, $charge_per_query, $free, $show_photoprice, $charge_photo;

    $sents = $addon = "";
    if (empty($cut_pos))
        $cut_pos = 0;
    $not_added = true;
    $options_list_dis = $list_dis = array();
    $options = $soptions = array();
    $abrupt = false;
    if ($tot_ret_length > $totretTotLen) {
        $remStr = substr($total_return, $cut_pos);

        if (strlen($remStr) > $totretTotLen) {
            echo "<h2>length is greeater than max length</h2>";

            $options_list_dis[] = "NEXT PAGE";
            $list_dis[] = array("content" => "more");

            $exampl = "(Eg: $examplPrefix 1 for NEXT PAGE)";
            if ($show_charge_per_query && !$free)
                $exampl = "(Eg: $examplPrefix 1 for NEXT PAGE @" . $charge_currency . $charge_per_query . "/query)";

            $option_top_len = strlen("\n" . $option_top . $exampl . "\n");

            $options_list = array_merge($options_list_dis, $options_list);
            $list = array_merge($list_dis, $list);
            $lists = array_merge($list_dis, $lists);
            $count = 1;

            foreach ($options_list as $value) {
                if (!$free && (stripos($value, "nlimited search at ") == 1) && $to_logserver['source'] == 'quiz') {
                    $addon .= "\n--\n" . $count . ": " . $value;
                } else {
                    $addon .= "\n" . $count . ": " . $value;
                }

                if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
                    $addon .= " @" . $charge_currency . $charge_photo . "/query";
                }
                $count++;
            }

            if (!empty($options_list))
                $option_length = $option_top_len + strlen($addon);

            echo "<h2>Changing tot_ret_len $totretTotLen, $option_length, $recom_length, $add_below_len</h2>";

            if ($tot_ret_length < $max_length * 0.6) {
                $totretTotLen = $max_length * 0.6;
            } else if (($option_length + $recom_length) < $max_length * 0.6) {
                $totretTotLen = $max_length - ($option_length + $recom_length + $add_below_len);
            } else {
                $totretTotLen = $max_length * 0.5;
            }

            echo "<h2>Changing tot_ret_len $totretTotLen, $option_length, $recom_length, $add_below_len</h2>";
        }

        $string_length = $totretTotLen;

        do {
            $part = substr($total_return, $cut_pos, $string_length);
            if (strlen($remStr) > $totretTotLen) {
                $newline_at = strrpos($part, "\n"); //Position of the last \n

                $dot_at = strrpos($part, ". ");
                if ($dot_at) {
                    $dot_at++; //Position of the last dot
                }
                if ($dot_at < 100) {
                    echo "\n<br>dot_at = $dot_at. setting false 2<br>\n";
                    $dot_at = false;
                }

                if ($newline_at < 100) {
                    echo "\n<br>nl_at = $newline_at. setting false<br>\n";
                    $newline_at = false;
                }

                if ($dot_at || $newline_at) {
                    echo "\n<br>atleast one: <br>\n";
                    var_dump($dot_at);
                    var_dump($newline_at);
                    $abrupt = false;

                    if (!$newline_at) {
                        $end_at = $dot_at;
//                echo "<br>#6#: $end_at<br>";
                    } else {
                        $newline_2 = strrpos(substr($part, 0, $newline_at), "\n");
                        if ($newline_2 !== false) {
                            $head = substr($part, $newline_2, $newline_at - $newline_2); //part between the last two newlines

                            if (preg_match("~\b[A-Z]+\b\n~", $head, $matches)) { // matches 'HEADING'
                                echo "matches: ";
                                print_r($matches);
                                $newline_at = $newline_2 + 1; //strrpos( substr($part, 0, $newline_at ), "\n" );
                            }
                        }
                        $nl_b4_dot = strrpos(substr($part, 0, $dot_at), "\n") + 1;
                        $dot_part = substr($part, $nl_b4_dot, $dot_at - $nl_b4_dot);

                        if ($dot_at && preg_match("~\d+\.~", $dot_part, $subpat)) {
                            $end_at = $newline_at;
                            echo "<br>#1#: $end_at<br>";
                        } else {
                            // cut right after a \n or .
                            if (!$dot_at) {
                                $end_at = $newline_at;
                                echo "<br>#2#: $end_at<br>";
                            } else {
                                echo "<br>$dot_at and $newline_at";
                                $end_at = ( (strrpos($part, ". ") > strrpos($part, "\n")) || $newline_at === false ) ? $dot_at : $newline_at;
                                echo "<br>#3#: $end_at<br>";
                            }
                        }
                    }
                } else if (strlen(trim($sents)) == 0) {
                    $part = substr($total_return, $cut_pos, $string_length - 5);
                    $end_at = strrpos($part, " ");
                    echo "\n<br><b>no dot_at or nl_at</b><br>\n";
                    echo "<br>\n$part\n<br>";
                    echo "<br>#4#: $end_at<br>";
                    $abrupt = true;
                } else {
                    break;
                }
                echo "\n<br>end_at: " . var_dump($end_at) . "<br>\n";
                $cut = strlen($part) - $end_at;
                $part = substr($part, 0, $end_at);
                echo "part: <h4>$part</h4>";

                $cut_pos += strlen($part); //$length_needed - $cut;

                echo "\n<br>cut_pos: $cut_pos<br>\n";
                $sents = $part;
            } else {
                $cut = strlen($part);
                $cut_pos += strlen($part);
                $sents = $part;
                break;
            }

            $string_length = $string_length - (strlen($sents));
        } while (strlen($sents) + $cut < $totretTotLen);

        if ($abrupt)
            $sents .= "...";
    } else {
        $sents = $total_return;
    }

    $totretTotLen = strlen($sents);
    return $sents;
}

function set_option() {
    global $recom_length, $option_length, $opnsTotLen, $totretTotLen, $to_logserver;
    global $options_list, $recom_opns_list, $list, $lists, $recom_list, $charge_currency;
    global $option_top, $recom_top, $exampl, $moreOption, $show_charge_per_query;
    global $show_photoprice, $charge_per_query, $direct, $free, $total_count, $charge_photo;

    $options_out = "";
    $count = 1;
    $lscount = $lcount = 1;
    $newlist = array();
    $newoptions_list = array();
    $newrlist = array();

    echo "<h2>Length $totretTotLen (tot), $option_length (opn) ,$recom_length (rec),  $opnsTotLen (opn_g)</h2>";

    if ($option_length > 0 || $recom_length > 0) {
        $addon = "";
//====================== Total Options list length less than avail length ===============================   

        if (($option_length + $recom_length) < $opnsTotLen) {

            echo "<br>First case option<br>";
            var_dump($recom_list);
            //Options list appending            
            if ($option_length > 0) {
                $addon .= "\n" . $option_top . $exampl . "\n";
                foreach ($options_list as $value) {
                    if (!$free && (stripos($value, "nlimited search at ") == 1) && $to_logserver['source'] == 'quiz') {
                        $addon .= "\n--\n" . $count . ": " . $value;
                    } else {
                        $addon .= "\n" . $count . ": " . $value;
                    }

                    if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
                        $addon .= " @" . $charge_currency . $charge_photo . "/query";
                    }
                    $count++;
                }
                $options_out .= $addon;

                $lscount = 1;

                //setting Numeric input handling field for list  
                foreach ($lists as $ls) {
                    $ls['count'] = $lscount;
                    $newlist[] = $ls;
                    $lscount++;
                }
                $list = $newlist;
            }

            $addon_recom = "";

            //Recommendation options appending           
            if ($recom_length > 0) {
                $addon_recom .= "\n" . $recom_top . $exampl . "\n";
                foreach ($recom_opns_list as $value) {
                    $addon_recom .= "\n" . $count . ": " . $value;
                    if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
                        $addon_recom .= " @" . $charge_currency . $charge_photo . "/query";
                    }
                    $count++;
                }
                $options_out .= $addon_recom;

                //setting Numeric input handling field for recommadation list  
                foreach ($recom_list as $rls) {
                    $rls['count'] = $lscount;
                    $newrlist[] = $rls;
                    $lscount++;
                }
                $list = array_merge($list, $newrlist);
            }
            $opnsTotLen = $option_length + $recom_length;
        } else {
//====================== Total Options list length greater than avail length ===============================            
            echo "<br>Second case option<br>";
            $addon = "";

            //calculating more option's length
            $more = "\n" . $count . ": " . $moreOption . "\n";

            echo $opnsTotLen;

            //calaculating total length for given for options
            $optns_len = $opnsTotLen - (strlen($more) + 5);
            echo "After " . $optns_len;
            $len = 0;

            //if total options is less than
            if (($option_length) < $optns_len) {
                $lscount = 1;
                if ($option_length > 0) {
                    echo "First case 2";
                    //options list appending
                    $addon .= "\n" . $option_top . $exampl . "\n";
                    foreach ($options_list as $value) {
                        if (!$free && (stripos($value, "nlimited search at ") == 1) && $to_logserver['source'] == 'quiz') {
                            $addon .= "\n--\n" . $count . ": " . $value;
                        } else {
                            $addon .= "\n" . $count . ": " . $value;
                        }

                        if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
                            $addon .= " @" . $charge_currency . $charge_photo . "/query";
                        }
                        $count++;
                    }
                    $options_out .= $addon;
                    $len = strlen($addon);

                    //setting Numeric input handling field for list
                    foreach ($lists as $ls) {
                        $ls['count'] = $lscount;
                        $newlist[] = $ls;
                        $lscount++;
                    }
                    $lists = $newlist;
                }

                if ($recom_length > 0) {
                    $addon_recom = "";
                    $opns_line = "\n" . $recom_top . $exampl . "\n" . $count . ": " . $recom_opns_list[0];

                    if (($len + strlen($opns_line)) < $optns_len) {
                        $opns_line = "\n" . $recom_top . $exampl . "\n";

                        foreach ($recom_opns_list as $value) {
                            $opns_line .= "\n" . $count . ": " . $value;
                            if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
                                $opns_line .= " @" . $charge_currency . $charge_photo . "/query";
                            }

                            $len += strlen($opns_line);
                            if ($len < $optns_len) {
                                $addon_recom .= $opns_line;
                                $opns_line = "";
                            } else {
                                $len = strlen($addon) + strlen($addon_recom);
                                break;
                            }
                            $count++;
                        }
                    }
                    $options_out .= $addon_recom;
                }


                echo "<br>$options_out<br>";
                echo "<br>length $len<br>";

                $opns_line = "";
                $more = "";

                $more = "\n" . $count . ": " . $moreOption;

                $arindex = $count - count($options_list) - 1;
                $options_out .= $more;

                foreach ($recom_opns_list as $id => $value) {
                    if ($id == $arindex) {
                        $newoptions_list[] = $moreOption;
                        $newoptions_list[] = $value;
                    } else {
                        $newoptions_list[] = $value;
                    }
                }

                $recom_opns_list = $newoptions_list;
                $newlist1 = array();

                foreach ($recom_list as $ls) {
                    if ($lscount == $count) {
                        $ls['count'] = $count;
                        $newlist[] = array("count" => $count, "content" => "more options");
                        $newlist1[] = array("count" => $count, "content" => "more options");
                        $count = $count + 1;
                        $lscount++;
                    }
                    $ls['count'] = $lscount;
                    $newlist[] = $ls;
                    $newlist1[] = $ls;
                    $lscount++;
                }

                $recom_list = $newlist1;
                $list = $newlist;
            } else {
                echo "second case 2";
                $opns_head = "\n" . $option_top . $exampl . "\n";
                $options_out .= $opns_head;

                $len += strlen($opns_head);

                $opns_line = "";
                if ($option_length > 0) {
                    foreach ($options_list as $value) {
                        if (!$free && (stripos($value, "nlimited search at ") == 1) && $to_logserver['source'] == 'quiz') {
                            $opns_line .= "\n--\n" . $count . ": " . $value;
                        } else {
                            $opns_line .= "\n" . $count . ": " . $value;
                        }

                        if ($show_photoprice && (stripos($value, "hoto of ") == 1 ) && $charge_photo != $charge_per_query) {
                            $opns_line .= " @" . $charge_currency . $charge_photo . "/query";
                        }

                        $len += strlen($opns_line);
                        if ($len < $optns_len) {
                            $addon .= $opns_line;
                            $opns_line = "";
                        } else {
                            $len = strlen($addon) + strlen($opns_head);
                            break;
                        }
                        $count++;
                    }
                    $options_out .= $addon;
                }

                $opns_line = "";
                $more = "";

                $more = "\n" . $count . ": " . $moreOption;

                $arindex = $count - 1;
                $options_out .= $more;

                foreach ($options_list as $id => $value) {
                    if ($id == $arindex) {
                        $newoptions_list[] = $moreOption;
                        $newoptions_list[] = $value;
                    } else {
                        $newoptions_list[] = $value;
                    }
                }

                $options_list = $newoptions_list;

                $lcount = 1;
                echo "before list settings";
                foreach ($list as $ls) {
                    if ($lcount == $count) {
                        $ls['count'] = $lcount;
                        $newlist[] = array("count" => $count, "content" => "more options");
                        $count = $count + 1;
                        $lcount++;
                    }
                    $ls['count'] = $lcount;
                    $newlist[] = $ls;

                    $lcount++;
                }

                $list = $newlist;
                $lists = $newlist;
            }
            $opnsTotLen = $opnsTotLen - $len - strlen($more);
        }
    }
    $total_count = $count;
    return $options_out;
}

function appendPrevOptions() {
    echo "<h1>Previous Options</h1>";
    global $options_list, $recom_opns_list, $list, $lists, $recom_list, $listAll, $isMoreOption;
    global $t_options_list, $t_recom_opns_list, $t_list, $t_lists, $t_recom_list, $numeric_in;

    $t_options_list = $t_recom_opns_list = $t_list = $t_lists = $t_recom_list = array();

    if (!empty($list)) {
        if (!empty($lists)) {
            $t_options_list = array_merge($options_list, $t_options_list);
            $t_lists = array_merge($lists, $t_lists);
        }

        $t_list = array_merge($list, $t_list);

        if (!empty($recom_list)) {
            $t_recom_list = array_merge($recom_list, $t_recom_list);
            $t_recom_opns_list = array_merge($recom_opns_list, $t_recom_opns_list);
        }

        if (!empty($listAll) && !$isMoreOption && is_numeric($numeric_in) == true) {
            echo "<br>Appending Previous options<br>";
            for ($i = count($options_list); $i < count($listAll["options_list"]); $i++) {
                $t_options_list[] = $listAll["options_list"][$i];
                $t_lists[] = $listAll["lists"][$i];
            }

            for ($i = count($recom_opns_list); $i < count($listAll["recom_opns_list"]); $i++) {
                $t_recom_opns_list[] = $listAll['recom_opns_list'][$i];
                $t_recom_list[] = $listAll['recom_list'][$i];
            }

            for ($i = count($list); $i < count($listAll["list"]); $i++) {
                $t_list[] = $listAll["list"][$i];
            }
        }
    }
}

?>