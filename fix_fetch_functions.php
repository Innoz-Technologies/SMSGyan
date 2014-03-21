<?php

function get_bing_result($sword, $is_adult = 0) {
    if ($is_adult) {
        //Parser
    } else {
        $scrap_ips = array("IPs");
        $rnd = rand(0, count($scrap_ips) - 1);
        echo $url = "http://$scrap_ips[$rnd]/scraper/bing.php?adult=$is_adult&q=" . urlencode($sword);
    }
    
    echo $data = file_get_contents($url);
    if ($data == 'NULL') {
        return 'NULL';
    } else {
        $out = json_decode(trim($data), TRUE);
        return $out;
    }
}

function fetch_wikihow($url) {
    echo "<h2>FROM WIKIHOW</h2>";
    global $current_file;
    global $machine_id;
    global $source_machine;
    global $spell_checked;
    global $source_id, $oldSource_id;
    global $fetchFromOutside, $oldSource, $lastResult, $newResult;

    $title = substr($url, 23);
    $query = "select * from data_how where title = '" . mysql_real_escape_string($title) . "'";
    $result = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);

    if (mysql_num_rows($result) && !$fetchFromOutside) {
        $row = mysql_fetch_array($result);
        $source_id = $row['id'];
        $source_machine = $row['machine'];
        $current_file = "/hownew/$source_id";
        $how_return = get_file_contents($current_file, $source_machine);
    } else {
        require_once 'class.WikiHow.php';
        $mywiki = new WikiHow($url);
        $how_return = $mywiki->start_search();
        if ($how_return) {
            if (mysql_num_rows($result)) {
                $source_machine = $row['machine'];
                $source_id = $row['id'];
                $current_file = "/hownew/" . $row['id'];

                $str = substr($result, 0, 500);
                $newResult = str2hex($str);

                if ($newResult != $lastResult || $oldSource != "how")
                    writeToFile($source_machine, DATA_PATH . $current_file, $how_return);
            } else {
                $query = "insert into data_how(title,machine) values('" . mysql_real_escape_string($title) . "',$machine_id)";
                mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                $source_id = mysql_insert_id();
                file_put_contents(DATA_PATH . "/hownew/$source_id", $how_return);
                $source_machine = $machine_id;
                $current_file = "/hownew/$source_id";
            }
        }
    }

    echo "HOW RETURN : " . $how_return;
    return $how_return;
}

function fetch_wikians($url) {
    global $current_file;
    global $source_machine;
    global $spell_checked;
    global $source_id, $fetchFromOutside, $newResult, $lastResult;

    $title = substr($url, 26);
    $query = "select * from data_wans where title = '" . mysql_real_escape_string($title) . "'";
    $result = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
    if (mysql_num_rows($result) && !$fetchFromOutside) {
        $row = mysql_fetch_array($result);
        $source_id = $row['id'];

        $wikians_return = $row['ans'];
    } else {
        require_once 'class.wikianswer.php';
        $out = new wikianswer($url);
        $wikians_return = $out->getAnswer();
        if ($wikians_return) {
            if (mysql_num_rows($result)) {
                $source_id = $row['id'];
                $str = substr($wikians_return, 0, 500);
                $newResult = str2hex($str);
                if ($newResult != $lastResult) {
                    $query = "update data_wans set ans='" . mysql_real_escape_string($wikians_return) . "' where id=" . $source_id;
                    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                }
            } else {
                $query = "insert into data_wans(title,ans) values('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($wikians_return) . "')";
                mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                $source_id = mysql_insert_id();
            }
        }
    }

    $current_file = "data_wans/ans/id/$source_id";
    $source_machine = "db";
    return $wikians_return;
}

function fetch_ans($url) {
    global $current_file;
    global $source_machine;
    global $spell_checked;
    global $source_id, $fetchFromOutside, $newResult, $lastResult;

    $title = substr($url, 29);
    $query = "select * from data_ans where title = '" . mysql_real_escape_string($title) . "'";
    $result = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
    if (mysql_num_rows($result) && !$fetchFromOutside) {
        $row = mysql_fetch_array($result);
        $source_id = $row['id'];

        $ans_return = $row['ans'];
    } else {
        require_once 'class.answers.php';
        $out = new answers($url);
        $ans_return = $out->getdata();
        if ($ans_return) {
            if (mysql_num_rows($result)) {
                $source_id = $row['id'];
                $str = substr($ans_return, 0, 500);
                $newResult = str2hex($str);
                if ($newResult != $lastResult) {
                    $query = "update data_ans set ans='" . mysql_real_escape_string($ans_return) . "' where id=" . $source_id;
                    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                }
            } else {
                $query = "insert into data_ans(title,ans) values('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($ans_return) . "')";
                mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                $source_id = mysql_insert_id();
            }
        }
    }

    $current_file = "data_ans/ans/id/$source_id";
    $source_machine = "db";
    return $ans_return;
}

function fetch_ehow($url) {
    global $current_file;
    global $source_machine;
    global $spell_checked;
    global $source_id, $fetchFromOutside, $newResult, $lastResult;

    $title = substr($url, 20);
    echo "got title: $title";
    if (!strpos($title, ':')) {
        $query = "select * from data_ehow where title = '" . mysql_real_escape_string($title) . "'";
        $result = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
        if (mysql_num_rows($result) && !$fetchFromOutside) {
            $row = mysql_fetch_array($result);
            $source_id = $row['id'];
            $ehow_return = $row['ans'];
        } else {
            require_once 'class.ehow.php';
            $out = new ehow($url);
            $ehow_return = $out->getdata();
            if ($ehow_return) {
                if (mysql_num_rows($result)) {
                    $source_id = $row['id'];
                    $str = substr($ehow_return, 0, 500);
                    $newResult = str2hex($str);
                    if ($newResult != $lastResult) {
                        $query = "update data_ehow set ans='" . mysql_real_escape_string($ehow_return) . "' where id=" . $source_id;
                        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                    }
                } else {
                    $query = "insert into data_ehow(title,ans) values('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($ehow_return) . "')";
                    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                    $source_id = mysql_insert_id();
                }
            }
        }

        $current_file = "data_ehow/ans/id/$source_id";
        $source_machine = "db";
    } else {
        $ehow_return = '';
    }
    return $ehow_return;
}

function fetch_iforum($url) {
    global $current_file;
    global $source_machine;
    global $spell_checked;
    global $source_id, $fetchFromOutside, $newResult, $lastResult;

    if (preg_match("~http://www.india-forums.com/tv-show/[\d]+/(.+)(/about|/cast|/)?~", $url)) {
        $title = substr($url, 36);
        $query = "select * from data_iforum where title = '" . mysql_real_escape_string($title) . "'";
        $result = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
        if (mysql_num_rows($result) && !$fetchFromOutside) {
            $row = mysql_fetch_array($result);
            $source_id = $row['id'];

            $iforum_return = $row['ans'];
        } else {
            require_once 'class.indiaforum.php';
            $out = new indiaforum($url);
            $iforum_return = $out->getOut();
            if ($iforum_return) {
                if (mysql_num_rows($result)) {
                    $source_id = $row['id'];
                    $str = substr($iforum_return, 0, 500);
                    $newResult = str2hex($str);
                    if ($newResult != $lastResult) {
                        $query = "update data_iforum set ans='" . mysql_real_escape_string($iforum_return) . "' where id=" . $source_id;
                        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                    }
                } else {
                    $query = "insert into data_iforum(title,ans) values('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($iforum_return) . "')";
                    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                    $source_id = mysql_insert_id();
                }
            }
        }

        $current_file = "data_iforum/ans/id/$source_id";
        $source_machine = "db";
        return $iforum_return;
    } else {
        return '';
    }
}

function fetch_imdb($url) {
   //API - Parser
}

function fetch_linkedin($url) {
    global $current_file;
    global $source_machine;
    global $spell_checked;
    global $source_id, $fetchFromOutside, $newResult, $lastResult;


    $title = substr($url, 26);
    $title = str_replace('/', "", $title);

    $query = "select * from data_linked where title = '" . mysql_real_escape_string($title) . "'";
    $result = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
    if (mysql_num_rows($result) && !$fetchFromOutside) {
        $row = mysql_fetch_array($result);
        $source_id = $row['id'];

        $linked_return = $row['ans'];
    } else {
        require_once 'class.linkedin.php';
        $out = new linkedin($url);
        $linked_return = $out->getabout();
        if ($linked_return) {
            if (mysql_num_rows($result)) {
                $source_id = $row['id'];
                $str = substr($linked_return, 0, 500);
                $newResult = str2hex($str);
                if ($newResult != $lastResult) {
                    $query = "update data_linked set ans='" . mysql_real_escape_string($linked_return) . "' where id=" . $source_id;
                    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                }
            } else {
                $query = "insert into data_linked(title,ans) values('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($linked_return) . "')";
                mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                $source_id = mysql_insert_id();
            }
        }
    }

    $current_file = "data_linked/ans/id/$source_id";
    $source_machine = "db";
    return $linked_return;
}

function fetch_bing_local($what, $where) {
    global $current_file;
    global $source_machine;
    global $spell_checked;
    global $source_id, $fetchFromOutside, $newResult, $lastResult;

    $query = "select * from data_local where `what` = '" . mysql_real_escape_string($what) . "' and `where` = '" . mysql_real_escape_string($where) . "'";
    $result = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
    echo "after db check";
    if (mysql_num_rows($result) && !$fetchFromOutside) {
        $row = mysql_fetch_array($result);
        $source_id = $row['id'];
        $local_return = $row['ans'];
    } else {
        require_once 'class.local_bing.php';
        $out = new local_bing($what, $where);
        $local_return = $out->getdata();
        if ($local_return) {
            if (mysql_num_rows($result)) {
                $source_id = $row['id'];
                $str = substr($local_return, 0, 500);
                $newResult = str2hex($str);
                if ($newResult != $lastResult) {
                    $query = "update data_local set ans='" . mysql_real_escape_string($local_return) . "' where id=" . $source_id;
                    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                }
            } else {
                $query = "insert into data_local(`what`,`where`,ans) values('" . mysql_real_escape_string($what) . "','" . mysql_real_escape_string($where) . "','" . mysql_real_escape_string($local_return) . "')";
                mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
                $source_id = mysql_insert_id();
            }
        }
    }

    $current_file = "data_local/ans/id/$source_id";
    $source_machine = "db";
    return $local_return;
}

function get_wolf_ans($query) {
    //API paerser
}

function get_true_ans($query) {
    //API - Parser
}

function fetch_mediawiki($title, $direct = false) {
    //API - Parser
}

function get_wiki_title($search) {
     //API - Parser
}

function is_word_intable($word, $table) {
     //API - Parser
}

//To calculate confidence value of query
//Avinash (Rahul)2 21-03-2013
//fetchFromOutSide, getConfidence, insertToDataNew and str2hex

function fetchFromOutSide($confidence) {
    $randomFloat = rand(0, 100) / 100;
    if ($randomFloat > $confidence) {
        return true;
    } else {
        return false;
    }
}

function getConfidence($history) {
    $history = trim($history);
    $history_splits = str_split($history, 2);
    $count = count($history_splits);

    // this condition should not happen; provided history is saved in correct format
    preg_match("/([a-f0-9][a-f0-9])+/", $history, $match);
    if (strlen($match[0]) != strlen($history))
        return 0;

    $cache = $history_splits[$count - 1];
    $cache_count = 1;
    for ($i = $count - 2; $i >= 0; $i--) {
        if (strcmp($cache, $history_splits[$i]) == 0) {
            $cache_count++;
        }
    }
    return $cache_count / ($count + 1);
}

function str2hex($str) {
    $binary = "00000000";
    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        $temp_binary = substr("00000000" . decbin(ord($str{$i})), -8);
        for ($j = 0; $j < 8; $j++) {
            if (($binary{$j} == '1' && $temp_binary{$j} == '0') || ($binary{$j} == '0' && $temp_binary{$j} == '1'))
                $binary{$j} = '1';
            else
                $binary{$j} = '0';
        }
    }
    return substr("00" . base_convert($binary, 2, 16), -2);
}

function insertToDataNew($source) {
    echo "<h2>TO DATANEW</h2>";
    global $spell_checked, $suggestions, $source_id;
    global $id, $confidence, $history, $updateTable, $newResult;

    $history .= $newResult;
    $confidence = getConfidence($history);

    if ($updateTable) {
        echo "<br>" . $query = "update data_new1 set source='$source', source_id='$source_id', suggestion='" . mysql_real_escape_string(json_encode($suggestions)) . "',confidence=$confidence,history='$history' where id=" . $id;
        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
    } else {
        echo "<br>" . $query = "insert into data_new1(query,source,source_id,suggestion,confidence,history) values('" . mysql_real_escape_string($spell_checked) . "','$source',$source_id,'" . mysql_real_escape_string(json_encode($suggestions)) . "',$confidence,'$history')";
        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
        $id = mysql_insert_id();
    }
}

?>