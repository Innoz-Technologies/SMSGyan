<?php

include 'fix_fetch_functions.php';

$spell_checked = preg_replace("~[^\w\d\*\+\%\^\-]~", " ", $spell_checked);
$spell_checked = trim(preg_replace("~[\s]+~", " ", $spell_checked));

if ($direct) {
    echo "It is direct";
    $return = fetch_mediawiki($spell_checked_org, $direct);
    $total_return = $return['article'];
    $to_logserver['source'] = 'wiki';
    echo "Photo from wiki: " . $return['media'] . " $photos_pack " . $is_adult;
    if ($return['media'] && $photos_pack && !$is_adult) {
        $options_list[] = "photo of " . str_replace('_', ' ', $return['title']);
        $list[] = array("content" => "__mwiki__image__" . $return['media'], "type" => "photo");
    }
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (preg_match("~(locate|find)\b(.+)\b(near|in|at|on)(.+)~", $spell_checked, $match)) {
    $what = trim($match[1]);
    $where = trim($match[2]);
    $total_return = fetch_bing_local($what, $where);
    if ($total_return) {
        $to_logserver['source'] = 'local';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if ($debug) {
    $nlp_ip = 'IP';
} else {
    $nlp_ip = 'IP';
}

echo "CRI RECORDS";
include 'fix_cri.php';

$savetodata = true;
$get_wans = true;
if (strlen($spell_checked) > 40) { //very less chance to repeat
    $savetodata = false;
} else if (preg_match("~\b(time|current|letest|last|next|age|old|news|recent|new|today|minister|president|precedent|birthday|ceo)\b~", $spell_checked)) {
    $savetodata = false;
    $get_wans = false;
}
//$savetodata = false;

$suggestions = array();
$sugg_index = 0;

$spell_keywords = remwords($spell_checked_org);

if ($savetodata) {
    $updateTable = $fetchFromOutside = false;
    echo $query = "select * from data_new1 where query = '" . mysql_real_escape_string($spell_checked) . "'";
    $result = mysql_query($query) or trigger_error(mysql_error() . " in " . $query, E_USER_ERROR);

    $history = '';
    if (mysql_num_rows($result) == 0) {
        $fetchFromOutside = true;
    } else {
        $row = mysql_fetch_array($result);
        var_dump($row);
        $confidence = $row["confidence"];
        $lastResult = $history = $row["history"];
        $oldSource = $row["source"];
        if (strlen($history) >= 99) {
            $history = substr($history, -98, 98);
        }

        if (strlen($lastResult) >= 3)
            $lastResult = substr($lastResult, -2, 2);

        $id = $row['id'];
        $oldSource_id = $source_id = $row['source_id'];
        $fetchFromOutside = fetchFromOutSide($confidence);
        $updateTable = true;
    }


    if (!$fetchFromOutside) {
//        $row = mysql_fetch_array($result);
//        $id = $row['id'];
//        $source_id = $row['source_id'];
        switch ($row['source']) {
            case 'how':
                $q = "select machine from data_how where id = $source_id";
                $r = mysql_query($q) or trigger_error(mysql_error() . " in " . $q, E_USER_ERROR);
                $rw = mysql_fetch_array($r);
                $source_machine = $rw['machine'];
                $current_file = "/hownew/$source_id";
                $to_logserver['source'] = 'how';
                $total_return = get_file_contents($current_file, $source_machine);
                break;

            case 'wiki':
                $q = "select server_id from articles where id = $source_id";
                $r = mysql_query($q) or trigger_error(mysql_error() . " in " . $q, E_USER_ERROR);
                $rw = mysql_fetch_array($r);
                $source_machine = $rw['server_id'];
                $current_file = "/mwiki/$source_id";
                $to_logserver['source'] = 'wiki';
                $total_return = get_file_contents($current_file, $source_machine);
                break;
            case 'wiki_ext':
                $source_machine = $source_id;
                $current_file = "/mwikiext/$id";
                $to_logserver['source'] = 'wiki';
                $total_return = get_file_contents($current_file, $source_machine);
                break;
            case 'evi':
            case 'duck':
            case 'wolf':
                $case = $row['source'];
                $source_machine = $source_id;
                $current_file = "/$case/$id";
                $to_logserver['source'] = $case;
                $total_return = get_file_contents($current_file, $source_machine);
                break;
            case 'wans':
            case 'linked':
            case 'ans':
            case 'iforum':
            case 'imdb':
            case 'ehow':
            case 'local':
                $case = $row['source'];
                $q = "select ans from data_$case where id = $source_id";
                $r = mysql_query($q) or trigger_error(mysql_error() . " in " . $q, E_USER_ERROR);
                $rw = mysql_fetch_array($r);
                $total_return = $rw['ans'];
                $source_machine = 'db';
                $current_file = "data_$case/ans/id/$source_id";
                $to_logserver['source'] = $case;
                break;
        }
        if ($total_return) {
            $suggestions = json_decode($row['suggestion'], TRUE);

            if ($photos_pack && !$is_adult) {
                foreach ($suggestions as $value) {
                    $options_list[] = $value['option'];
                    $list[] = $value['list'];
                }
            } else {
                foreach ($suggestions as $value) {
                    if ($value['list']['type'] != 'photo') {
                        $options_list[] = $value['option'];
                        $list[] = $value['list'];
                    }
                }
            }
            if (str_word_count($spell_keywords) == 1) {
                if (is_word_intable($spell_keywords, 'data_dict')) {
                    $options_list[] = "Dict $spell_keywords";
                    $list[] = array("content" => "dict $spell_keywords");
                }
                if (is_word_intable($spell_keywords, 'data_acry')) {
                    $options_list[] = "Expand $spell_keywords";
                    $list[] = array("content" => "expand $spell_keywords");
                }
            }
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        } else {
            $query = "delete from data_new where id = $id";
            mysql_query($query) or trigger_error(mysql_error() . " in " . $query, E_USER_ERROR);
            echo "Deleted cached record";
        }
    }
}

$source = '';
$source_id = '';

$bing_results = 'NULL';
if ($google_results) {
    echo "Results from GOOGLE";
    $bing_results = $google_results;
}

if (preg_match("~^ho?w\b~", $spell_checked)) {
    if ($bing_results == 'NULL') {
        $bing_results = get_bing_result($spell_checked, $is_adult);
    }
    if ($bing_results != 'NULL') {
        $how_url = '';
        $wikia_url = '';
        foreach ($bing_results['r'] as $url) {
            if (strpos($url, 'http://www.wikihow.com') !== false) {
                $total_return = fetch_wikihow($url);
                if ($total_return) {
                    $to_logserver['source'] = 'how';
                    $source = 'how';
                    break;
                }
            } elseif (strpos($url, 'http://www.ehow.com') !== false) {
                echo "Fetching ehow data";
                $total_return = fetch_ehow($url);
                if ($total_return) {
                    $to_logserver['source'] = 'ehow';
                    $source = 'ehow';
                    break;
                }
            } 
        }
    }
}

if (!$total_return) {
    include 'fix_duckduck.php';
}

if (!$total_return) {
    //NLP core engine program Hit $isq_url
    $isq = trim(file_get_contents($isq_url));
    echo "<br>\nISQ : $isq";
    if ($isq == '1') {
        echo "<br>\nISQuestion";
        $return = get_wolf_ans($spell_checked_org);
        if ($return) {
            $wiki_sugg = get_wiki_title($spell_keywords);
            if ($wiki_sugg) {
                $suggestions[$sugg_index]['option'] = $options_list[] = "Article: $wiki_sugg";
                $suggestions[$sugg_index]['list'] = $list[] = array("content" => $wiki_sugg, "type" => "Also read");
                $sugg_index++;
            }
            if ($savetodata) {

                $source_id = $machine_id;
                if ($updateTable) {
                    if (!empty($oldSource_id) && $oldSource_id < 5) {
                        $source_id = $oldSource_id;
                    }
                }
                $source_machine = $source_id;

                insertToDataNew("wolf");
                $str = substr($return, 0, 500);
                $newResult = str2hex($str);

                $current_file = "/wolf/$id";

                if ($newResult != $lastResult || $oldSource != "wolf")
                    writeToFile($source_machine, DATA_PATH . $current_file, $return);

//                $query = "insert into data_new(query,source,source_id,suggestion) values('" . mysql_real_escape_string($spell_checked) . "','wolf',$machine_id,'" . mysql_real_escape_string(json_encode($suggestions)) . "')";
//                mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
//                $id = mysql_insert_id();
//                file_put_contents(DATA_PATH . "/wolf/$id", $return);
//                $current_file = "/wolf/$id";
            } else {
                file_put_contents(DATA_PATH . "/temp/$numbers", $return);
                $current_file = "/temp/$numbers";
            }
            $source_machine = $machine_id;
            $to_logserver['source'] = 'wolf';
            $total_return = $return;
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
//}
    if ($bing_results == 'NULL') {
        $bing_results = get_bing_result($spell_checked, $is_adult);
    }
    if ($bing_results['s']) {
        $spell_checked = trim($bing_results['s']);
    }
    if ($bing_results != 'NULL') {
        $total_return_tmp = '';
        $count = 0;
        foreach ($bing_results['r'] as $url) {
            if (strpos($url, 'http://www.wikihow.com') !== false) {
                $total_return = fetch_wikihow($url);
                if ($total_return) {
                    $to_logserver['source'] = 'how';
                    $source = 'how';
                    break;
                }
            } else if (strpos($url, 'http://wiki.answers.com/Q/') !== false && $get_wans) {
                $total_return = fetch_wikians($url);
                if ($total_return) {
                    $to_logserver['source'] = 'wans';
                    $source = 'wans';
                    break;
                }
            } elseif (strpos($url, 'http://www.ehow.com') !== false) {
                $total_return = fetch_ehow($url);
                if ($total_return) {
                    $to_logserver['source'] = 'ehow';
                    $source = 'ehow';
                    break;
                }
            } else if (strpos($url, 'http://en.wikipedia.org/wiki/') !== false) {
                if (preg_match('~http://en.wikipedia.org/wiki/(.+)~', $url, $matches)) {
                    $sr = $matches[1];
                    if (!(strpos($sr, ':') > 0 || strpos($sr, '"') > 0 || substr($sr, 0, 7) == 'List_of' || $sr == "Main_Page" || $sr == "Wikipedia")) {
                        $return = fetch_mediawiki($sr);
                        if ($return) {
                            if ($return['exact']) {
                                $total_return = $return['article'];
                                $to_logserver['source'] = 'wiki';
                                if ($source == 'wiki_ext') {
                                    $suggestions[$sugg_index]['option'] = "Full article: " . $return['title'];
                                    $suggestions[$sugg_index]['list'] = array("content" => $return['title'], "type" => "Also read");
                                    $sugg_index++;
                                }
                                break;
                            } else if (!$total_return_tmp) {
                                $total_return_tmp = $return['article'];
                                $source_machine_tmp = $source_machine;
                                $current_file_tmp = $current_file;
                                $source_id_tmp = $source_id;
                                $source_tmp = $source;
                            }
                            if ($return['media']) {
                                $suggestions[$sugg_index]['option'] = "photo of " . str_replace('_', ' ', $return['title']);
                                $suggestions[$sugg_index]['list'] = array("content" => "__mwiki__image__" . $return['media'], "type" => "photo");
                                $sugg_index++;
                            }
                        }
                    }
                }
            } else if (strpos($url, 'http://www.linkedin.com/in/') !== false||strpos($url, 'http://in.linkedin.com/in/') !== false) {
                $total_return = fetch_linkedin($url);
                if ($total_return) {
                    $to_logserver['source'] = 'linked';
                    $source = 'linked';
                    break;
                }
            } else if (strpos($url, 'http://www.answers.com/topic/') !== false && $get_wans) {
                $total_return = fetch_ans($url);
                if ($total_return) {
                    $to_logserver['source'] = 'ans';
                    $source = 'ans';
                    break;
                }
            } else if (strpos($url, 'http://www.india-forums.com/tv-show/') !== false) {
                if (strpos($url, '/video/') === false && strpos($url, '/news/') === false && strpos($url, '/gallery/') === false) {
                    if (strpos($url, '/cast/') === false && strpos($url, '/about/') === false) {
                        $url .= 'about/';
                    }
                    $total_return = fetch_iforum($url);
                    if ($total_return) {
                        $to_logserver['source'] = 'iforum';
                        $source = 'iforum';
                        break;
                    }
                }
            } else if (strpos($url, 'http://www.imdb.com/title/') !== false) {
                $total_return = fetch_imdb($url);
                if ($total_return) {
                    $to_logserver['source'] = 'imdb';
                    $source = 'imdb';
                    break;
                }
            }
            $count++;
        }
    }
}
if ($bing_results != 'NULL') {
    $bing_total = count($bing_results['r']);
    for ($index = $count + 1; $index < $bing_total; $index++) {
        if (strpos($bing_results['r'][$index], 'http://en.wikipedia.org/wiki/') !== false) {
            if (preg_match('~http://en.wikipedia.org/wiki/(.+)~', $bing_results['r'][$index], $matches)) {
                $sr = $matches[1];
                if (!(strpos($sr, ':') > 0 || strpos($sr, '"') > 0 || substr($sr, 0, 7) == 'List_of' || $sr == "Main_Page" || $sr == "Wikipedia")) {
                    $suggestions[$sugg_index]['option'] = "Also read: " . urldecode(str_replace("_", " ", $sr));
                    $suggestions[$sugg_index]['list'] = array("content" => urldecode($sr), "type" => "Also read");
                    $sugg_index++;
                    break;
                }
            }
        }
    }
    if (isset($bing_results['l'])) {
        if (preg_match("~what=(.+)\&where=(.+)\&~U", $bing_results['l']['l'], $match)) {
            echo $what = urldecode(trim($match[1]));
            echo $where = urldecode(trim($match[2]));
            if ($total_return) {
                $suggestions[$sugg_index]['option'] = "Locate $what in $where";
                $suggestions[$sugg_index]['list'] = array("content" => "Locate $what in $where");
                $sugg_index++;
            } else {
                $total_return = fetch_bing_local($what, $where);
                echo "bing response: $total_return";
                if ($total_return) {
                    $to_logserver['source'] = 'local';
                    $source = 'local';
                }
            }
        }
    }
//    echo "Video sug " . $bing_results['v'];
//    if ($bing_results['v']) {
//        if ($spell_keywords) {
//            echo "adding video sug";
//            $suggestions[$sugg_index]['option'] = "Video $spell_checked_org";
//            $suggestions[$sugg_index]['list'] = array("content" => "video $spell_keywords");
//            $sugg_index++;
//        }
//    }
}

if (!$total_return && $total_return_tmp) {
    $total_return = $total_return_tmp;
    $source_machine = $source_machine_tmp;
    $current_file = $current_file_tmp;
    $to_logserver['source'] = 'wiki';
    $source_id = $source_id_tmp;
    $source = $source_tmp;
}

print_r($suggestions);
if ($photos_pack && !$is_adult) {
    foreach ($suggestions as $value) {
        $options_list[] = $value['option'];
        $list[] = $value['list'];
    }
} else {
    foreach ($suggestions as $value) {
        if ($value['list']['type'] != 'photo') {
            $options_list[] = $value['option'];
            $list[] = $value['list'];
        }
    }
}
if (str_word_count($spell_keywords) == 1) {
    if (is_word_intable($spell_keywords, 'data_dict')) {
        $options_list[] = "Dict $spell_keywords";
        $list[] = array("content" => "dict $spell_keywords");
    }
    if (is_word_intable($spell_keywords, 'data_acry')) {
        $options_list[] = "Expand $spell_keywords";
        $list[] = array("content" => "expand $spell_keywords");
    }
}

if ($total_return && $savetodata) {
//    $source_machine = $source_id;

    $str = substr($total_return, 0, 500);
    $newResult = str2hex($str);

    insertToDataNew($source);

    if ($source == 'wiki_ext') {
//        $source_id = $machine_id;
//        if ($updateTable) {
//            if (!empty($oldSource_id) && $oldSource_id < 5) {
//                $source_id = $oldSource_id;
//            }
//        }

        $current_file = "/mwikiext/$id";

        if ($newResult != $lastResult || $oldSource != "wiki_ext")
            writeToFile($source_machine, DATA_PATH . $current_file, $total_return);
    }

//    $query = "insert into data_new1(query,source,source_id,suggestion) values('" . mysql_real_escape_string($spell_checked) . "','$source',$source_id,'" . mysql_real_escape_string(json_encode($suggestions)) . "')";
//    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
//    $id = mysql_insert_id();
//    if ($source == 'wiki_ext') {
//        file_put_contents(DATA_PATH . "/mwikiext/$id", $total_return);
//        $current_file = "/mwikiext/$id";
//        $source_machine = $machine_id;
//    }
}
include 'allmanip.php';
putOutput($total_return);
exit();
?>