<?php


if (preg_match("~\b(sex|spicy) (story|stories)\b~", $spell_checked) && str_word_count($spell_checked) <= 6) {

    $set_lang = '';
    unset($lang_sex);
    unset($type_sex);
    unset($title_sex);
    echo "<h1>inside the sex story</h1>";

    $query_sex = remwords($spell_checked);
    $query_sex = preg_replace("~\b(sex|story|sexy|stories)\b~", "", $query_sex); // removing sex,story,sexy,stories from query
    $query_sex_word = explode(" ", $query_sex); // split query into words
// to get distinct language,title,type from table

    $lang_sex = apc_fetch('lang_sex', $success);
    echo "<h2>language dump</h2>" . var_dump($lang_sex);

    $type_sex = apc_fetch('type_sex', $type_ok);

    $title_sex = apc_fetch('title_sex', $title_ok);

    if (!$success) {
        unset($lang_sex);
        $query = "SELECT DISTINCT (`langauage`)FROM adult_content";
        $result = mysql_query($query);

        if (mysql_num_rows($result) > 1) {
            while ($row = mysql_fetch_array($result)) {
                $lang_sex[] = strtolower($row["langauage"]);
            }
        }
        apc_store('lang_sex', $lang_sex, 60480); // stored in cache
    }



    if (!$type_ok) {

        $query = "SELECT DISTINCT (`type`) FROM adult_content";
        $result = mysql_query($query);

        if (mysql_num_rows($result) > 1) {
            while ($row = mysql_fetch_array($result)) {
                $type_sex[] = $row["type"];
            }
        }
        apc_store('type_sex', $type_sex, 60480); // stored in cache
    }

    if (!$title_ok) {

        $query = "SELECT DISTINCT (`title`) FROM adult_content";
        $result = mysql_query($query);

        if (mysql_num_rows($result) > 1) {
            while ($row = mysql_fetch_array($result)) {
                $title_sex[] = $row["title"];
            }
        }
        apc_store('title_sex', $title_sex, 60480); // stored in cache
    }

    // check for language in query
    foreach ($lang_sex as $key => $lang_val) {
        foreach ($query_sex_word as $key => $sex_lang) {
            if (preg_match("~$lang_val~", $sex_lang)) {
                $set_lang = $lang_val;
            }
        }
    }

    echo "<h2>language :</h2>" . $set_lang;

    foreach ($type_sex as $key => $type_val) {
        foreach ($query_sex_word as $key => $sex_type) {
            if (preg_match("~$type_val~", $sex_type)) {
                $set_type = $type_val;
            }
        }
    }

    echo "<h2>type :</h2>" . $set_type;

    if (empty($circle_lang))
        $circle_lang = 'hindi';

    switch ($circle_lang) {

        case 'urdu':
        case 'marathi':
        case 'punjabi':
        case 'oriya':
        case 'gujarati':
        case 'assamese':
        case 'arabi':
            $circle_lang = 'hindi';
            break;
        default :
            break;
    }

    if (empty($set_lang))
        $set_lang = $circle_lang; //default circle language

    if (empty($set_type))
        $set_type = "straight";



    echo $query = "select * from adult_content where langauage='$set_lang' and type='$set_type' order by rand() limit 1";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $title = $row["title"];
        $id = $row["id"];
        $content = $row["content"];
        $lang = $row["langauage"];
        $type = $row["type"];
        $total_return = $title . "\n" . $content;
    }

    if (!empty($total_return)) {

        $options_list[] = "Read another";
        $list[] = array("content" => "__sex__next__" . $lang . "__" . $type . "__" . $id . "__");

        $options_list[] = "change language";
        $list[] = array("content" => "__sex__language__" . $lang . "__" . $type . "__" . $id . "__");

        $options_list[] = "change type";
        $list[] = array("content" => "__sex__type__" . $lang . "__" . $type . "__" . $id . "__");

        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        if ($operator == "idea" && $circle_short == "KA")
            $to_logserver['source'] = 'coolstory';
        else
            $to_logserver['source'] = 'sex_story';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__sex__next__(.+)__(.+)__(.+)__~", $req, $match)) {
    $lang = $match[1];
    $type = $match[2];
    $id = $match[3];

    echo $query = "select * from adult_content where langauage='$lang' and type='$type' and id!=$id order by rand() limit 1";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $title = $row["title"];
        $id = $row["id"];
        $content = $row["content"];
        $lang = $row["langauage"];
        $type = $row["type"];
        $total_return = $title . "\n" . $content;
    }

    if (!empty($total_return)) {

        $options_list[] = "Read another";
        $list[] = array("content" => "__sex__next__" . $lang . "__" . $type . "__" . $id . "__");

        $options_list[] = "change language";
        $list[] = array("content" => "__sex__language__" . $lang . "__" . $type . "__" . $id . "__");

        $options_list[] = "change type";
        $list[] = array("content" => "__sex__type__" . $lang . "__" . $type . "__" . $id . "__");

        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);

        $to_logserver['source'] = 'sex_story';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__sex__language__(.+)__(.+)__(.+)__~", $req, $match)) {

    echo "<h2>Inside Story Langauge Change </h2>";
    $lang = $match[1];
    $type = $match[2];
    $id = $match[3];

    echo $query = "SELECT distinct langauage FROM adult_content where type = '$type'";
    $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        $total_return = "Choose one language for the message\n";
    }

    while ($row = mysql_fetch_array($result)) {
        $lang_change[] = strtolower($row['langauage']);
    }

    var_dump($lang_change);

    if ($total_return) {
        foreach ($lang_change as $value) {
            $options_list[] = "$value";
            $list[] = array("content" => "__sex__next__" . $value . "__" . $type . "__" . $id . "__");
        }


        $to_logserver['source'] = 'sex_story';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__sex__type__(.+)__(.+)__(.+)__~", $req, $match)) {

    $lang = $match[1];
    $type = $match[2];
    $id = $match[3];

    echo "<h2>Inside Story Type Change </h2>";
    $lang = $match[1];
    $type = $match[2];
    $id = $match[3];

    echo $query = "SELECT distinct type FROM adult_content where langauage = '$lang'";
    $result = mysql_query($query) or trigger_error("ERROR in QUERY " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        $total_return = "Choose a type\n";
    }

    while ($row = mysql_fetch_array($result)) {
        $lang_change[] = strtolower($row['type']);
    }

    var_dump($lang_change);

    if ($total_return) {
        foreach ($lang_change as $value) {
            $options_list[] = "$value";
            $list[] = array("content" => "__sex__next__" . $lang . "__" . $value . "__" . $id . "__");
        }


        $to_logserver['source'] = 'sex_story';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
