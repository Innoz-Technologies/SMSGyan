<?php

if ($spell_checked == "trans" || $spell_checked == "translate") {
    $total_return = "Please select an option";

    $options_list[] = "English to Hindi";
    $list[] = array("content" => "__trans__hindi__");

    $options_list[] = "English to Telugu";
    $list[] = array("content" => "__trans__telugu__");

    $options_list[] = "English to Tamil";
    $list[] = array("content" => "__trans__tamil__");

    $options_list[] = "English to Marathi";
    $list[] = array("content" => "__trans__marathi__");

    $options_list[] = "English to Bengali";
    $list[] = array("content" => "__trans__bengali__");
	
	$options_list[] = "Quit";
    $list[] = array("content" => "__trans__quit__");
} elseif (preg_match('~__trans__(.+)__~', $req, $match)) {

    echo "<h2>INSIDE TRANS OPTION</h2>";
    $lang = trim($match[1]);


    $word = ucfirst($lang);
    $total_return = "English to $word Translator : Please reply with your string";
    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +1 hour"));
    $arCacheData["trans"]["expiry"] = $expiry_time;
    $arCacheData["trans"]["lang"] = $lang;
    $showsuboption = FALSE;
    
} elseif (!empty($arCacheData["trans"]) && str_word_count($req) >= 1) {


    echo "<h2>INSIDE TRANS</h2>";


    var_dump($arCacheData["trans"]);

    $lang = $arCacheData["trans"]["lang"];

    switch ($lang) {
        case 'hindi':
            $query_in_keyword = "#translator" . " " . $req . " hindi";

            break;

        case 'telugu':
            $query_in_keyword = "#translator" . " " . $req . " telugu";

            break;

        case 'tamil':
            $query_in_keyword = "#translator" . " " . $req . " tamil";

            break;

        case 'marathi':
            $query_in_keyword = "#translator" . " " . $req . " marathi";

            break;

        case 'gujarati':
            $query_in_keyword = "#translator" . " " . $req . " gujarati";

            break;

        case 'bengali':
            $query_in_keyword = "#translator" . " " . $req . " bengali";

            break;

        default:
            break;
    }

    echo "<h2>$query_in</h2>";


//    unset($arCacheData["trans"]);
}

if ($total_return) {
    $to_logserver['source'] = 'trans';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
