<?php

$no_result_msg = "Sorry. No message found for your query. Try again later\n";

if (preg_match("~__msg__content__(.+)__(.+)__(.+)__~", $req, $match)) {

    $msg_type = $match[1];
    $msg_lang = $match[2];
    $msg_id = $match[3];

    $query = "SELECT * FROM message_content WHERE lcase(language)='$msg_lang' AND lcase(type)='$msg_type' and id> $msg_id limit 1";
    $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());

    if (mysql_num_rows($result) <= 0) {
        $msg_id = 0;  //reseting the id value
        $query = "SELECT * FROM message_content WHERE lcase(language)='$msg_lang' AND lcase(type)='$msg_type' and id> $msg_id limit 1";
    }

    $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());

    //to add to options list
    $optType = "";
    $optLang = "";
    $optID = "";

    while ($row = mysql_fetch_array($result)) {
        $total_return = $row['type'] . "\n";
        $total_return .= $row['message'] . "\n";

        $optID = strtolower($row['id']);
        $optType = strtolower($row['type']);
        $optLang = strtolower($row['language']);
    }

    if ($total_return) {
        $options_list[] = "Read Next";
        $list[] = array("content" => '__msg__content__' . $optType . '__' . $optLang . '__' . $optID . '__');
    } else {
        $total_return = $no_result_msg;
        $to_logserver['isresult'] = 0;
        //$free=true;
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'message';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__change__language__(.+)__(.+)__(.+)__~", $req, $match)) {

    $msg_type = $match[1];
    $msg_lang = $match[2];
    $msg_id = $match[3];

    /*
     * SELECTING LANGAUGE FOR CHOOSING SUITABLE LANGUAGE
     */


    //to add to options list
    $optType = "";
    $optID = "";

    $query = "SELECT distinct language FROM message_content where type = '$msg_type' AND lower(language) != '$msg_lang' AND language != '' LIMIT 5";
    $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        $total_return = "Choose one language for the message\n";
    }

    while ($row1 = mysql_fetch_array($result)) {
        $lang_change[] = strtolower($row1['language']);
    }

    if ($total_return) {
        $lang_change[] = $msg_lang;
        foreach ($lang_change as $value) {
            $options_list[] = "$value";
            $list[] = array("content" => '__msg__content__' . $msg_type . '__' . $value . '__' . $msg_id . '__');
        }
    } else {
        $total_return = $no_result_msg;
        $to_logserver['isresult'] = 0;
        //$free=true;
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'message';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} else if (preg_match("~\bm[e|a]ss?age?s?|shayari|sayari|shayeri\b~", $spell_checked, $machedkey)) {  // && str_word_count($spell_checked) <= 5
    echo "<br>MESSAGE CAPTURED $spell_checked key matched <br>";

    $tmp_spell_checked = $spell_checked;

    $match_found = trim($machedkey[0]);


    //var_dump($machedkey);

    $message = "";

    if (strpos($tmp_spell_checked, 'message') !== false || strpos($tmp_spell_checked, 'messages') !== false) {
        $is_msg = true;
        echo "<br>message caught<br>";
        $def_language = 'english';
    } else {
        $is_msg = false;
        echo "<br>shayari caught<br>";
        $def_language = 'hindi';
    }
    $message = str_replace('messages', '', $tmp_spell_checked);
    $message = str_replace('message', '', $message);

    echo "<h3>replced msg [$message]</h3>";
    $lang_used = "";  //language 
    $msg_type = "";   //type of message

    $arrLang = array('malayalam' => array('malayalam', 'malayalm'), 'hindi' => array('hindi', 'hndi', 'gujarati', 'gujarathi', 'assamese', 'asamese', 'asames', 'urdu', 'punjabi', 'panjabi', 'marathi', 'marati', 'oriya', 'orya', 'bengali', 'begali'), 'tamil' => array('tamil', 'tmil'), 'telugu' => array('telugu', 'telungu', 'telengu', 'telegu'), 'english' => array('english', 'eng', 'engleesh', 'inglish'), 'urdu' => array('urdu', 'urudu'), 'punjabi' => array('punjabi', 'panjabi', 'punjbi'));

    if (!$is_msg) {
        unset($arrLang['hindi'][7]);
        unset($arrLang['hindi'][8]);
        unset($arrLang['hindi'][9]);
    }

    echo "Message $message<br>";
    echo "<br>CHECKING LANGUAGE<br>";
    foreach ($arrLang as $key => $value) {
        foreach ($value as $lng) {
            echo "CURRENT LANG: $key => $lng<br>";
            if (preg_match("~$lng~", $message)) {
                //echo "LANGUAGE: $key<br>";
                $lang_used = $key;
                $message = str_replace($lng, "", $message); //removing language from query                
                break;
            }
        }
        if ($lang_used != "") {
            break;
        }
    }

    if ($lang_used == "") {
        $lang_used = $circle_lang;
        switch ($circle_lang) {
            case 'assamese':
            case 'gujarati':
            case 'urdu':
            case 'bengali':
            case 'marathi':
            case 'oriya':
            case 'punjabi':
                $lang_used = 'hindi';
                break;
        }
    }
    echo "Language: $lang_used <br>";


    $key_matched = "";    //matched key ie message type
    $subtype = "";    //message sub type

    $cache_msg_keys = "message_cache";    //Name of the cache variable
    $cachekey = array();  //used to store messsage key values frim the DB.

    if (trim($message) == "") { // if only blank message receives
        $time = strtotime('now');

        $morn_time = mktime('12', '00', '00');
        $aft_time = mktime('16', '00', '00');
        $eve_time = mktime('19', '00', '00');
        $nite_time = mktime('23', '59', '59');

        if (date('H:i:s', $time) <= date('H:i:s', $morn_time)) {
            echo "<h1>GOOD MORNING</h1>";
            $key_matched = "good morning";
        } elseif (date('H:i:s', $time) <= date('H:i:s', $aft_time)) {
            echo "<h1>GOOD AFTER NOON</h1>";
            $key_matched = "good afternoon";
        } elseif (date('H:i:s', $time) <= date('H:i:s', $eve_time)) {
            echo "<h1>GOOD EVENING</h1>";
            $key_matched = "good evening";
        } elseif (date('H:i:s', $time) <= date('H:i:s', $nite_time)) {
            echo "<h1>GOOD NITE</h1>";
            $key_matched = "good night";
        }
    } else {

        $cachekey = apc_fetch($cache_msg_keys);

        if ($cachekey !== false) {
            check_messsage_content($cachekey);
        }

        echo " KEY MATCHED $key_matched FIRST CHECK<br>";

        if ($cachekey === false || $key_matched == "") {

            apc_delete($cache_msg_keys);  //DELETES THE CACHE IF EXIST
            //message cache not found... Fetching from the Database
            echo "<h2>CACHE BUILDING</h2>";
            $query = "SELECT * FROM message_keys";

            $result = mysql_query($query) or trigger("ERROR in query " . mysql_error());

            while ($row = mysql_fetch_array($result)) {
                $key = strtolower($row['types']);
                $values = explode(',', $row['keywords']);

                //echo "TYPE: " . $key . " KEYWORDS: " . print_r($values) . "<br>";
                $cachekey[$key] = $values;
            }
            apc_store($cache_msg_keys, $cachekey);
            //$cachekey = apc_fetch($cache_msg_keys);

            check_messsage_content($cachekey);
//            echo "CACHE $cachekey KEY MATCHED $key_matched SECOND CHECK<br>";
        }
    }
    $key_matched = strtolower($key_matched);

    echo "<h3>MATCHED KEY: $key_matched LANGUAGE: $lang_used</h3>";
    //REPEATING THE SAME CODE ****** MADE OR COPY CODE AS ABOVE CODE CHANGES
    // key matched and language known

    /*
     * 
     */
    echo "<h3>CHECKING MESSGE</h3>";
    $tmp_spell_checked = str_replace($lang_used, '', $tmp_spell_checked);
    $tmp_spell_checked = preg_replace('~[\s]+~', ' ', $tmp_spell_checked);
    $arMessage = explode(' ', $tmp_spell_checked);

    $msg_indx = array_search($match_found, $arMessage);

    $pre_msg = isset($arMessage[$msg_indx - 1]) ? $arMessage[$msg_indx - 1] : '';
    $post_msg = isset($arMessage[$msg_indx + 1]) ? $arMessage[$msg_indx + 1] : '';

    echo "<h3>MESSAGE INDEX: $msg_indx - PRE: $pre_msg - POST: $post_msg MATCHED: $key_matched - [$tmp_spell_checked]</h3>";

    $must_MSG = false;

    $preg_to = '';
    if (!empty($pre_msg))
        $preg_to = $pre_msg;

    if (!empty($post_msg)) {
        if(!empty($preg_to))
            $preg_to .= '|';
        $preg_to .= "$post_msg";
    }

    if (preg_match("~$preg_to~Usi", $key_matched, $matchmsg)) {
        var_dump($matchmsg);
        if (!empty($matchmsg[0])) {
            $must_MSG = true;
        }
    }
    if ($must_MSG) {
        echo "<h4>MUST SET</h4>";
    }
    /*
     * 
     */
    echo "<br>" . $query = "SELECT * FROM message_content WHERE lcase(language)='$lang_used' AND lcase(type)='$key_matched' order by rand() limit 1";
    $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());

    echo "key not matched MESAGE $message<br>";
    if (mysql_num_rows($result) <= 0 && trim($message) != "") {
        echo "<br>" . $query = "SELECT * FROM message_content WHERE lcase(language)='$lang_used' AND lcase(subtype) like '%$message%' order by rand() limit 1";
        $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());
    }

    //checking for content
    //
    echo "ROW COUNT : " . mysql_num_rows($result) . "<br>";
    if (mysql_num_rows($result) <= 0 && $lang_used != $def_language) {
        $lang_used = $def_language;
        echo "<br>" . $query = "SELECT * FROM message_content WHERE lcase(language)='$lang_used' AND lcase(type)='$key_matched' order by rand() limit 1";
        $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());
    }

    //to add to options list
    $optType = "";
    $optLang = "";
    $optID = "";
    if (mysql_num_rows($result) > 0) {
        echo "<h3>DATA FETCHED</h3>";
    }
    while ($row = mysql_fetch_array($result)) {
        $total_return = $row['type'] . "\n";
        $total_return .= $row['message'] . "\n";

        $optID = strtolower($row['id']);
        $optType = strtolower($row['type']);
        $optLang = strtolower($row['language']);
    }

    //new option.. if only one language found, no option will shown, If two, option will be change to that language
    echo "<br>" . $query = "SELECT distinct language FROM message_content where type = '$optType' AND lower(language) != '$optLang' AND language != '' LIMIT 5";
    $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());

    $arrOptionList = array();
    echo "<br>Num ROWS: " . $num_rows = mysql_num_rows($result);
    if ($num_rows == 1) {
        $row2 = mysql_fetch_array($result);
        $arrOptionList['list'][] = $optType . ' ' . strtolower($row2['language']) . ' message';
        $arrOptionList['title'][] = $row2['language'] . ' ' . $optType . ' Messages';
    } else if ($num_rows > 1) {
        $arrOptionList['list'][] = '__change__language__' . $optType . '__' . $optLang . '__' . $optID . '__';
        $arrOptionList['title'][] = 'Change Language';
    }

    echo "TOTal RETurn: $total_return<br>";
    if ($total_return) {
        $options_list[] = "Read Next";
        $list[] = array("content" => '__msg__content__' . $optType . '__' . $optLang . '__' . $optID . '__');

        /* $options_list[] = "Change Language";
          $list[] = array("content" => '__change__language__' . $optType . '__' . $optLang . '__' . $optID . '__'); */
        foreach ($arrOptionList['title'] as $key => $value) {
            $options_list[] = "$value";
            $list[] = array("content" => $arrOptionList['list'][$key]);
        }
    } else {
        if ($must_MSG) {
            $total_return = $no_result_msg;
            $to_logserver['isresult'] = 0;
        }
        //$free=true;
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'message';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function check_messsage_content($cachekey) {
    global $message, $key_matched;

    //echo "CHACHE CONTENT<br>";
    //var_dump($cachekey);
    //checking keys
    $words_splited = explode(" ", $message);
    //var_dump($words_splited);

    $prev_word = "";
    foreach ($words_splited as $word) {
        $prev_word.=" $word";
        echo "<br>MSG " . $prev_word = trim($prev_word);


        foreach ($cachekey as $key => $value) {
            //echo "KEY : $key<br>";
            if (metaphone($prev_word) == metaphone($key)) {
                $key_matched = $key;
                $message = str_replace($prev_word, '', $message);
                break;
            } else {
                foreach ($value as $v) {
                    //echo "VALUE : $v<br>";
                    if (metaphone($prev_word) == metaphone($v)) {
                        $key_matched = $key;
                        $message = str_replace($prev_word, '', $message);
                        break;
                    }
                }
            }
        }
    }
}

?>
