<?php

$no_result_msg = "Sorry. No Tips found for your query. Try again later\n";
$conDb2 = getAppDB2Con();
if (preg_match("~__tips__content__(.+)__(.+)__(.+)__~", $req, $match)) {

    $tips_type = $match[1];
    $tips_lang = $match[2];
    $tips_id = $match[3];

    $query = "SELECT * FROM tips_content WHERE lcase(language)='$tips_lang' AND lcase(type)='$tips_type' and id> $tips_id limit 1";
    $result = mysqli_query($conDb2, $query) or trigger_error("ERROR in QUERY " . mysql_error());

    if (mysqli_num_rows($result) <= 0) {
        $tips_id = 0;  //reseting the id value
        $query = "SELECT * FROM tips_content WHERE lcase(language)='$tips_lang' AND lcase(type)='$tips_type' and id> $tips_id limit 1";
    }

    $result = mysqli_query($conDb2, $query) or trigger_error("ERROR in QUERY " . mysql_error());

    //to add to options list
    $optType = "";
    $optLang = "";
    $optID = "";

    while ($row = mysqli_fetch_array($result)) {
        $total_return = $row['type'] . "\n";
        $total_return .= $row['content'] . "\n";

        $optID = strtolower($row['id']);
        $optType = strtolower($row['type']);
        $optLang = strtolower($row['language']);
    }

    if ($total_return) {
        $options_list[] = "Read Next";
        $list[] = array("content" => '__tips__content__' . $optType . '__' . $optLang . '__' . $optID . '__');
    } else {
        $total_return = $no_result_msg;
        $to_logserver['isresult'] = 0;
        //$free=true;
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'tips';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__change__language__tips__(.+)__(.+)__(.+)__~", $req, $match)) {

    $tips_type = $match[1];
    $tips_lang = $match[2];
    $tips_id = $match[3];

    /*
     * SELECTING LANGAUGE FOR CHOOSING SUITABLE LANGUAGE
     */


    //to add to options list
    $optType = "";
    $optID = "";

    $query = "SELECT distinct language FROM tips_content where type = '$tips_type' AND lower(language) != '$tips_lang' AND language != '' LIMIT 5";
    $result = mysqli_query($conDb2, $query) or trigger_error("ERROR in QUERY " . mysql_error());

    if (mysqli_num_rows($result) > 0) {
        $total_return = "Choose one language for the message\n";
    }

    while ($row1 = mysqli_fetch_array($result)) {
        $lang_change[] = strtolower($row1['language']);
    }

    if ($total_return) {
        $lang_change[] = $tips_lang;
        foreach ($lang_change as $value) {
            $options_list[] = "$value";
            $list[] = array("content" => '__tips__content__' . $tips_type . '__' . $value . '__' . $tips_id . '__');
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
        $to_logserver['source'] = 'tips';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} else if (preg_match("~\btips? (.+)\b|(.+) tips?\b$~", $spell_checked, $machedkey)) {  // && str_word_count($spell_checked) <= 5
    echo "<br>TIPS CAPTURED $spell_checked key matched <br>";

    $tmp_spell_checked = $spell_checked;

    $match_found = '';
    if (isset($machedkey[2]))
        $match_found = $machedkey[2];
    elseif (isset($machedkey[1]))
        $match_found = $machedkey[1];

    $tips = "";

    $tips = str_replace('tips', '', $tmp_spell_checked);
    $tips = str_replace('tip', '', $tips);

    echo "<h3>replced tips [$tips]</h3>";
    $lang_used = "";  //language 
    $tips_type = "";   //type of tips

    $arrLang = array('malayalam' => array('malayalam', 'malayalm'), 'hindi' => array('hindi', 'hndi', 'gujarati', 'gujarathi', 'assamese', 'asamese', 'asames', 'urdu', 'punjabi', 'panjabi', 'marathi', 'marati', 'oriya', 'orya', 'bengali', 'begali'), 'tamil' => array('tamil', 'tmil'), 'telugu' => array('telugu', 'telungu', 'telengu', 'telegu'), 'english' => array('english', 'eng', 'engleesh', 'inglish'), 'urdu' => array('urdu', 'urudu'), 'punjabi' => array('punjabi', 'panjabi', 'punjbi'));

    echo "Tips $tips<br>";
    $lang_used = 'english';  //COMMENT THIS LINE & UNCOMMENT BELOW LINES TO USE LANGUAGE OPTION

    /* echo "<br>CHECKING LANGUAGE<br>";
      foreach ($arrLang as $key => $value) {
      foreach ($value as $lng) {
      echo "CURRENT LANG: $key => $lng<br>";
      if (preg_match("~$lng~", $tips)) {
      //echo "LANGUAGE: $key<br>";
      $lang_used = $key;
      $tips = str_replace($lng, "", $tips); //removing language from query
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
      } */

    echo "Language: $lang_used <br>";


    $key_matched = "";    //matched key ie message type
    $subtype = "";    //message sub type

    $cache_msg_keys = "tips_cache";    //Name of the cache variable
    $cachekey = array();  //used to store messsage key values frim the DB.

    if (trim($tips) == "") { // if only blank message receives
    } else {

        $cachekey = apc_fetch($cache_msg_keys);

        if ($cachekey !== false) {
            check_tips_content($cachekey);
        }

        echo " KEY MATCHED $key_matched FIRST CHECK<br>";

        if ($cachekey === false || $key_matched == "") {

            apc_delete($cache_msg_keys);  //DELETES THE CACHE IF EXIST
            //message cache not found... Fetching from the Database
            echo "<h2>CACHE BUILDING</h2>";
            $query = "SELECT * FROM tips_keys";

            $result = mysqli_query($conDb2, $query) or trigger("ERROR in query " . mysql_error());

            while ($row = mysqli_fetch_array($result)) {
                $key = strtolower($row['types']);
                $values = explode(',', $row['keywords']);

                //echo "TYPE: " . $key . " KEYWORDS: " . print_r($values) . "<br>";
                $cachekey[$key] = $values;
            }
            apc_store($cache_msg_keys, $cachekey);
            //$cachekey = apc_fetch($cache_msg_keys);

            check_tips_content($cachekey);
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
    echo "<h3>CHECKING TIPS</h3>";
    $tmp_spell_checked = str_replace($lang_used, '', $tmp_spell_checked);
    $tmp_spell_checked = preg_replace('~[\s]+~', ' ', $tmp_spell_checked);
    $arMessage = explode(' ', $tmp_spell_checked);

    $tips_indx = array_search($match_found, $arMessage);

    $pre_msg = isset($arMessage[$tips_indx - 1]) ? $arMessage[$tips_indx - 1] : '';
    $post_msg = isset($arMessage[$tips_indx + 1]) ? $arMessage[$tips_indx + 1] : '';

    echo "<h3>MESSAGE INDEX: $tips_indx - PRE: $pre_msg - POST: $post_msg MATCHED: $key_matched - [$tmp_spell_checked]</h3>";

    $must_MSG = false;

    $preg_to = '';
    if (!empty($pre_msg))
        $preg_to = $pre_msg;

    if (!empty($post_msg)) {
        if (!empty($preg_to))
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
    echo "<br>" . $query = "SELECT * FROM tips_content WHERE lcase(language)='$lang_used' AND lcase(type)='$key_matched' order by rand() limit 1";
    $result = mysqli_query($conDb2, $query) or trigger_error("ERROR in QUERY " . mysql_error());

    echo "key not matched TIPS $tips<br>";
    if (mysqli_num_rows($result) <= 0 && trim($tips) != "") {
        echo "<br>" . $query = "SELECT * FROM tips_content WHERE lcase(language)='$lang_used' AND lcase(subtype) like '%$tips%' order by rand() limit 1";
        $result = mysqli_query($conDb2, $query) or trigger_error("ERROR in QUERY " . mysql_error());
    }

    //checking for content
    //
    echo "ROW COUNT : " . mysqli_num_rows($result) . "<br>";
    if (mysqli_num_rows($result) <= 0 && $lang_used != $def_language) {
        $lang_used = $def_language;
        echo "<br>" . $query = "SELECT * FROM tips_content WHERE lcase(language)='$lang_used' AND lcase(type)='$key_matched' order by rand() limit 1";
        $result = mysqli_query($conDb2, $query) or trigger_error("ERROR in QUERY " . mysql_error());
    }

    //to add to options list
    $optType = "";
    $optLang = "";
    $optID = "";
    if (mysqli_num_rows($result) > 0) {
        echo "<h3>DATA FETCHED</h3>";
    }
    while ($row = mysqli_fetch_array($result)) {
        $total_return = $row['type'] . "\n";
        $total_return .= $row['content'] . "\n";

        $optID = strtolower($row['id']);
        $optType = strtolower($row['type']);
        $optLang = strtolower($row['language']);
    }

    //new option.. if only one language found, no option will shown, If two, option will be change to that language
    echo "<br>" . $query = "SELECT distinct language FROM tips_content where type = '$optType' AND lower(language) != '$optLang' AND language != '' LIMIT 5";
    $result = mysqli_query($conDb2, $query) or trigger_error("ERROR in QUERY " . mysql_error());

    $arrOptionList = array();
    echo "<br>Num ROWS: " . $num_rows = mysqli_num_rows($result);
    if ($num_rows == 1) {
        $row2 = mysqli_fetch_array($result);
        $arrOptionList['list'][] = $optType . ' ' . strtolower($row2['language']) . ' tips';
        $arrOptionList['title'][] = $row2['language'] . ' ' . $optType . ' tips';
    } else if ($num_rows > 1) {
        $arrOptionList['list'][] = '__change__language__tips__' . $optType . '__' . $optLang . '__' . $optID . '__';
        $arrOptionList['title'][] = 'Change Language';
    }

    echo "TOTal RETurn: $total_return<br>";
    if ($total_return) {
        $options_list[] = "Read Next";
        $list[] = array("content" => '__tips__content__' . $optType . '__' . $optLang . '__' . $optID . '__');

        /* $options_list[] = "Change Language";
          $list[] = array("content" => '__change__language__' . $optType . '__' . $optLang . '__' . $optID . '__'); */
        if (!empty($arrOptionList)) {
            foreach ($arrOptionList['title'] as $key => $value) {
                $options_list[] = "$value";
                $list[] = array("content" => $arrOptionList['list'][$key]);
            }
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
        $to_logserver['source'] = 'tips';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function check_tips_content($cachekey) {
    global $tips, $key_matched;

    //echo "CHACHE CONTENT<br>";
    //var_dump($cachekey);
    //checking keys
    $words_splited = explode(" ", $tips);
    //var_dump($words_splited);

    $prev_word = "";
    foreach ($words_splited as $word) {
        $prev_word.=" $word";
        echo "<br>TIPS " . $prev_word = trim($prev_word);


        foreach ($cachekey as $key => $value) {
            //echo "KEY : $key<br>";
            if (metaphone($prev_word) == metaphone($key)) {
                $key_matched = $key;
                $tips = str_replace($prev_word, '', $tips);
                break;
            } else {
                foreach ($value as $v) {
                    //echo "VALUE : $v<br>";
                    if (metaphone($prev_word) == metaphone($v)) {
                        $key_matched = $key;
                        $tips = str_replace($prev_word, '', $tips);
                        break;
                    }
                }
            }
        }
    }
}

?>
