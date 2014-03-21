
<?php

$display_errors = isset($_GET['debug']) ? "on" : "off";
ini_set("display_errors", $display_errors);
error_reporting(E_WARNING);
set_error_handler("handle_error");

define("DATA_PATH", "/data");

$errortype = array(
    E_ERROR => 'Error',
    E_WARNING => 'Warning',
    E_PARSE => 'Parsing Error',
    E_NOTICE => 'Notice',
    E_CORE_ERROR => 'Core Error',
    E_CORE_WARNING => 'Core Warning',
    E_COMPILE_ERROR => 'Compile Error',
    E_COMPILE_WARNING => 'Compile Warning',
    E_USER_ERROR => 'User Error',
    E_USER_WARNING => 'User Warning',
    E_USER_NOTICE => 'User Notice',
    E_STRICT => 'Runtime Notice',
    E_RECOVERABLE_ERROR => 'Catchable Fatal Error'
);

function handle_error($errno, $errstr, $errfile, $errline, $errcontext) {
    global $errortype;

    if (in_array($errno, array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR))) {
        $dt = date("Y-m-d H:i:s");
        $error_msg = "$dt $errortype[$errno]: $errstr in $errfile at $errline";
        if (filesize("log/errors.log") > 5000000) {
            $new_name = "log/errors.log." . time();
            $ren = rename("log/errors.log", $new_name);
        }
        file_put_contents(dirname(__FILE__) . "/log/errors.log", $error_msg . "\n", FILE_APPEND);
    }
    echo "<p><font color='red'>$errstr in $errfile at $errline</font></p>";
}

function terminate($error) {
    die("Script terminated due to error:<br>$error");
}

//----------------------------Execution Block------------------------------

ob_start();

$time_start = microtime(true);
$to_logserver = array();

include 'classes.php';
include 'functions.php';
$ttime = microtime(true);
include 'tagging.php';
$ttime = microtime(true) - $ttime;
echo "<br>tagging: $ttime<br>";

if (!isset($_GET['message']) || !isset($_GET['mobile'])) {
    trigger_error("Empty parameters", E_USER_WARNING);
}

//URL input parameters..............................
$query_in = $_GET['message']; //original query
$debug = isset($_GET['debug']) ? true : false;
$numbers = $number = $mobile = $_GET["mobile"];
$circle = $_GET["circle"];
$channels = $_GET["channels"];
$app_status = ' and status = 1';
$outPutType = isset($_GET['output']) ? $_GET['output'] : 'normal';
$userid = isset($_GET['userid']) ? $_GET['userid'] : '';
$max_length = isset($_GET['max_length']) ? $_GET['max_length'] : 480;
$country = isset($_GET['country']) ? $_GET['country'] : "india";
$opShortCode = isset($_GET['shortcode']) ? $_GET['shortcode'] : "";

$show_add_below = true;
echo $numbers;

$show_photoprice = false;
$product_name = 'SMSGyan';

if ($product_name) {
    $product_name_tag = $product_name;
} else {
    $product_name_tag = 'SMSGyan';
}

$org_free = $free;

$current_folder = basename(dirname(__FILE__));

echo "<br>Is Free: $free";
var_dump($free);
echo "QUERY IN: ";
var_dump($query_in);
echo '<br>';

$req = strtolower(trim($query_in));

if (preg_match("~[\w\d]|@~s", $req)) {
    $req = str_ireplace("<space>", " ", $req);
    $req = preg_replace("~(.+)[^+\w?'\"\)]$~U", "$1", $req);
    $req = preg_replace("~^['\"](.+)['\"]?$~U", "$1", $req); //removes enclosing quotes
    $req = preg_replace("~[<>]~", " ", $req); //removes enclosing <>
    $req = preg_replace("~([^?]+\?)\?+~", "$1", $req); // removes repeated question marks
    $req = preg_replace("~[\n\t]~", " ", $req); //replaces \n and \t with a space  
} else {
    $req = 'help';
}
$message = $req;
echo "Q: ";
var_dump($req);
echo "<br>";

include 'circlewise_place.php';

include 'setVariables.php';

//---------To LOG--------------
$to_logserver['date'] = $time_start;
$to_logserver['circle'] = $circle_short;
$to_logserver['msisdn'] = $number;
$to_logserver['query'] = $query_in;
$to_logserver['isreply'] = 0;
$to_logserver['isresult'] = 1;
$to_logserver['issub'] = $org_free;
$to_logserver['query_id'] = 0;

$query_alphabets = preg_replace("~[^\w\s\d]~", " ", $req);
echo '<br>QUERY ALPHABETS: ' . $query_alphabets . '<br>';

$query_words = explode(" ", strtolower($query_alphabets));
$query_words = array_values($query_words);
echo '<br>CLEANING QUERY WORDS<br>';

foreach ($query_words as $i => $qw) {
    if (strlen(trim($qw)) == 0) {
        unset($query_words[$i]);
    } else {
        $query_words[$i] = preg_replace("~[^\w\d]~", "", $qw);
    }
}
$query_words = array_values($query_words);
if ($query_words[0] == 'sms') {
    foreach ($query_words as $i => $qw) {
        if (isset($query_words[$i + 1])) {
            $query_words[$i] = $query_words[$i + 1];
        }
    }
    unset($query_words[$i]);

    $req = str_replace("sms ", "", $req);
    $query_alphabets = implode(' ', $query_words);
}
print_r($query_words);
echo "\n<br>query words: ";
var_dump($query_words);
echo "<br>\n";

$to_log = array("Q" => $query_in, "N" => $numbers, "D" => time());

//$isGyanFree = $free;

if (trim($req) == '') {
    $req = 'help';
}

$op_kript = 'd';

$ttime = microtime(true);
include 'lib/data-files.php';
require_once '/var/www/gyan/class.CompareString.php';
$ttime = microtime(true) - $ttime;
echo "<br>first includes : $ttime";

/* GLOBAL VARIABLE DECLARATIONS */

//Query
$word = '';
$search_word = '';
$spell_checked = '';
$spell_checked_word = '';
$google_results = '';

//initial multi-fetch
$url = array();
$recom_opns_list = array();

//ask
$ask_closest = false;
$isMoreOption = false;

//movie
$is_released = 'default';

//livescores
$live_return = '';

//suggestions - to use in allmanip.php
$weather_area = '';
$price_sug = '';
$return_zodiac_suggestion = '';

$flag_enabled = false;
$newyear_enabled = false;
$election_enabled = false;

//Result deciders
$subfunction = 0;
$trueknowledge_leven = false;
$wiki_leven = 0;
$wiki_answer_leven = 0;
$ask_leven = 500;
$disamb = false;
$direct = false;
$dict_must = false;
$stock_must = false;
$movie_must = false;
$horo_must = false;
$photo_must = false;
$expand_must = false;
$recipe_must = false;
$video_must = false;
$showtim_must = false;
$cri_res = false;
$cri_bill = 0;
$spcl_bill = 0;
//Database
$global_id = '';
$current_file = '';

//Servers
$machine_id = 1;

$m = '';
$source_machine = $machine_id;

//Reply
$google_search_results = array();
$addon = '';
$add_on_top = '';
$ask_or_wiki = 'wiki';
$total_return = '';
$toLog = array();
$isCampaing = false;
//Reply if no results
$no_result_string = "Sorry, We could not find an answer for your question. Please check the spelling and try again.\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
$isfs = false;  //For Frienship Day
$iskrish = false;
$check_safe_search = false;
$safe_search = true;
$is_adult = false;
$truelogin = array("user" => array("1" => "api_shyam", "2" => "api_mithun016", "3" => "api_sucheth", "4" => "api_vijith"), "pass" => array("1" => "wpjce1hhm0ehc7j7", "2" => "tc2oeq3b4sl3dfnh", "3" => "qpu04p6xueuhka9h", "4" => "1h9beccwkii4p92r"));
$app_name = '';
$nextfree = 0;

include 'lib/appconfigdb.php';

//DECLARATIONS END
//mains
$numeric_in = $req;
$req = preg_replace("~^sms (dw|fs|fc|gc|rb|id|freedom|cri|movie|lyrics|train|weather|route|love|flames|recipe|stock|dict|photo|picture|news|trace|price|expand|horoscope|loc)~", "$1", $req);
$req = preg_replace("~^(fs)\b~", "friendship", $req);

$str_count = str_word_count($req);
if (($str_count > 2 ) && ($str_count < 8))
    $req = preg_replace("~^(fc)~", "calc friendship", $req);

$req = preg_replace("~(friendship )+~", "friendship ", $req);

echo "<br><h2>TIME before spell :" . (microtime(TRUE) - $time_start) . "</h2><br>";
$spell_checked_org = $spell_checked = checkSpelling($req);
$spell_checked = preg_replace("~\?~", '', $spell_checked);
echo "<br><h2>TIME after spell :" . (microtime(TRUE) - $time_start) . "</h2><br>";
echo "<br> Spell Checked:::::$spell_checked<br>";
$arCacheData = array();

echo "<h1>Fetching Data</h1>";
$cache_content = getCacheData("ls" . $number);
if ($cache_content != 'not_found') {
    $arCacheData = json_decode($cache_content, true);
    $arCacheData = timeOutCheck($arCacheData);
}

var_dump($arCacheData);
if (preg_match("~(1?.?\s?read more$|1?.?\s?next ?page$)~i", $spell_checked)) {
    echo "<br>Matched for read more";
    $req = "more";
    $numeric_in = 1;

    if (!empty($arCacheData["ca"])) {
        $row = $arCacheData["ca"];
    }
    if (!empty($row)) {
        echo "<br>FROM CACHE ";
        var_dump($row);
        $m = $row['m'];
        $source_machine = $row['m'];
        $query_id = $row['q'];
        $direct = true;
    }
} else if (preg_match("~^(\d{1,2})[^\d][+*/\^-]+~i", $req, $match)) {
    $numeric_in = $match[1];
} else if (preg_match("~^# ?(\d{0,2})$~", $req, $match)) {
    $numeric_in = $match[1];
}
echo "Numeric In: ";
var_dump($numeric_in);

$query_alphabets = preg_replace("~[^\w\s\d]~", " ", $req);
echo '<br>QUERY ALPHABETS: ' . $query_alphabets . '<br>';

$query_words = explode(" ", strtolower($query_alphabets));
$query_words = array_values($query_words);
echo '<br>CLEANING QUERY WORDS<br>';

foreach ($query_words as $i => $qw) {
    if (strlen(trim($qw)) == 0) {
        unset($query_words[$i]);
    } else {
        $query_words[$i] = preg_replace("~[^\w\d]~", "", $qw);
    }
}
$query_words = array_values($query_words);
if ($query_words[0] == 'sms') {
    foreach ($query_words as $i => $qw) {
        if (isset($query_words[$i + 1])) {
            $query_words[$i] = $query_words[$i + 1];
        }
    }
    unset($query_words[$i]);
    $req = str_replace("sms ", "", $req);
    $query_alphabets = implode(' ', $query_words);
}
print_r($query_words);
echo "\n<br>query words: ";
var_dump($query_words);
echo "<br>\n";
echo "<br><h2>TIME before spcl :" . (microtime(TRUE) - $time_start) . "</h2><br>";
//specially handled queries and output

include 'spl_case.php';

echo $spell_checked;
$query_down = false;

$query_in_keyword = $query_in;

//checking for xmlAPP

echo "<h2>Before XML APP check</h2>";
$flagxml = TRUE;
var_dump($arCacheData["ca"]);
$row = $arCacheData["ca"];

$islbs = false;


if (isset($row['a'])) {

    if (isset($row['l']) && $row['l'] == 1) {
        $islbs = true;
    }

    echo $xmlApp = $row['a'];
    if (preg_match("~xml__(.+)~", $xmlApp)) {
        echo $query_in_keyword;
        if (is_numeric($numeric_in) == true)
            $flagxml = FALSE;
        if (preg_match("~#(.+) (\d{1,2})~", $query_in_keyword, $match)) {
            var_dump($match);
            echo "<h2>Inside preg Match</h2>";
            echo $xmlappkey = "xml__#" . $match[1];
            if ($row['a'] == $xmlappkey) {
                echo $numeric_in = $match[2];
                $flagxml = FALSE;
            }
        }

        echo "<h2>Outside preg Match</h2>";
    } else {
        
    }
}
echo "<h2>After XML APP check</h2>";

if (is_numeric($numeric_in) == true && $numeric_in < 50) {
    echo "<h1>Fetching from file</h1>";
    var_dump($arCacheData["ca"]);

    if (!empty($arCacheData["ca"])) {
        $row = $arCacheData["ca"];
    }

    if (!empty($row)) {
        echo "<br>FROM CACHE ";
        var_dump($row);

        if (isset($row['a']) && $flagxml && !($row['x'])) {
            $query_in_keyword = $row['a'] . ' ' . $numeric_in;
            $to_logserver['isreply'] = 1;
            $to_logserver['query'] = $query_in_keyword;

            if ($operator == "dialog") {
                echo "<h1>Dialog Free</h1>";
                $free = TRUE;
            } //for dialog ON 23-04-2013
        } else {

            $m = $row['m'];
            $source_machine = $row['m'];

            if ($row['f'] == 1) {
                $free = true;
                $nextfree = 1;
            }

            echo "<h2>Separating List From ListAll</h2>";
            $listAll = $arCacheData["ls"];

            echo "<br>All Data in List";
            $list = $listAll["list"];

            echo "<br>LIST:";
            print_r($list);
            echo "<br>";
            foreach ($list as $l) {
                if ($l['count'] == $numeric_in) {
                    echo "<br>Numeric IN: $numeric_in";
                    $query_id = $row['q'];
                    $req = $l['content'];
                    //--TO LOG----
                    $to_logserver['query'] = $req;
                    $to_logserver['isreply'] = 1;

                    $spell_checked = $req;             //checkspelling not called for optionList edited on 14/02/2013
                    $mrpquery = $req; //for vodafone MRP keyword 12/03/2013

                    $spell_checked_org = $spell_checked;
                    $search_word = $spell_checked;
                    echo "Spell checked :$spell_checked";

                    $query_alphabets = preg_replace("~[^\w\s\.]~", "", $req);
                    $query_alphabets = str_replace(".", " ", $query_alphabets);
                    echo '<br>QUERY ALPHABETS: ' . $query_alphabets . '<br>';

                    $query_words = explode(" ", $query_alphabets);
                    echo '<br>CLEANING QUERY WORDS<br>';
                    if ($query_words[0] == 'sms') {
                        foreach ($query_words as $i => $qw) {
                            if (isset($query_words[$i + 1])) {
                                $query_words[$i] = $query_words[$i + 1];
                            }
                        }
                        unset($query_words[$i]);
                    }
                    print_r($query_words);
                    foreach ($query_words as $i => $qw) {
                        if (strlen(trim($qw)) == 0 || is_numeric($qw)) {
                            unset($query_words[$i]);
                        } else {
                            $query_words[$i] = preg_replace("~[^\w]~", "", $qw);
                        }
                    }
                    $query_words = array_values($query_words);
                    echo "\n<br>query words: ";
                    var_dump($query_words);
                    $direct = false;
                    echo "<br>direct1: $direct";
                    if (isset($l['type'])) {
                        echo "<br>type:" . $l['type'];
                        switch ($l['type']) {
                            case 'disamb':
                            case 'Also read':
                                $direct = true;
                                echo "<br>direct2: $direct";
                                break;
                        }
                    }
                    echo "<br>direct3: $direct";
                }
            }
        }
    }
}

if ($query_down) {
    $req = $prevReq;
}

if (!isset($query_id)) {
    $query_id = md5($numbers . time() . $query_in); //Unique identifier for each incoming query
}

include 'app_mainNew.php';

$isNextPage = false;

if ($req == "more") {
    $to_logserver['source'] = 'more';
    include 'moreNew.php';
    if ($debug) {
        ob_end_flush();
    } else {
        ob_end_clean();
    }
    exit();
} else if ($req == "more options") {
    include 'moreoptions.php';
}
$source_machine = $machine_id;

$list = array();
$lists = array();
$options_list = array();

$safe_search_query = SafeSearch($query_alphabets);
echo "<br>Query alpha: $query_alphabets";
echo "<br>safe alpha: $query_alphabets";
echo "<br>Is adult: $is_adult";
if ($safe_search_query != $query_alphabets) {
    $is_adult = true;
}
echo "<br>Is adult: $is_adult";

include 'common_before.php';

switch ($user_country) {
    case 'india':
        include 'match_india.php';
        break;
    case 'dubai':
        include 'match_dubai.php';
        break;
    case 'srilanka':
        include 'match_srilanka.php';
        break;
    case 'nepal':
        include 'match_nepal.php';
        break;
    case 'pakistan':
        include 'match_pakistan.php';
        break;
    case 'thailand':
        include 'match_thailand.php';
        break;
    case 'nigeria':
        include 'match_nigeria.php';
        break;
    case 'ghana':
        include 'match_ghana.php';
        break;
    case 'kenya':
        include 'match_kenya.php';
        break;
    case 'philippians':
        include 'match_philippines.php';
        break;
}

include 'common_after.php';

if (preg_match("~news\b(.+)~", $spell_checked, $matches) || preg_match("~(.+)\bnews$~", $spell_checked, $matches)) {
    echo "<br>NEWS $query_alphabets<bR>";
    $word = trim($matches[1]);
    if ($word == "india") {
        
        $options_list[] = "sports news";
        $list[] = array("content" => "news sports india");
    }


    $isFromNews = true;
//    include 'bingnews.php';
    include 'newsurl.php';
    $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
    include 'allmanip.php';
    $to_logserver['source'] = 'news';
    putOutput($total_return);
    exit();
}

if (preg_match("~^videos?( of)?\b (.+)~", $spell_checked, $matches)) {
    echo "<br>VIDEO<br>";
    if (preg_match("~^[^\w]*video~", $spell_checked)) {
        $video_must = true;
    }
    $word = $matches[2];
    include 'video_list.php';
    if ($videosearch_return) {
        $total_return = $videosearch_return;
        include 'allmanip.php';
        $to_logserver['source'] = 'video';
        putOutput($total_return);
        exit();
    }
} else if (preg_match("~(.+) \bvideos?$\b~", $spell_checked, $matches)) { //changed on 21-05-2013 as per VK's
    echo "<br>VIDEO<br>";
    $word = $matches[1];
    include 'video_list.php';
    if ($videosearch_return) {
        $total_return = $videosearch_return;
        include 'allmanip.php';
        $to_logserver['source'] = 'video';
        putOutput($total_return);
        exit();
    }
}

if (strpos($weather_word, 'weather') !== false || strpos($weather_word, 'climate') !== false || strpos($weather_word, 'temperature') !== false || strpos($weather_word, 'mausam') !== false) {
    echo "<h2>Weather Word: $weather_word</h2>";
    $word = '';
    if (preg_match("~^[^\w]*(weather|climate|temperature|mausam)([^\w]*report)?([^\w]*(at|of|in))?[^\w]+(\w+)~", $weather_word, $match)) {
        echo "\n<br>WEATHER<br>\n";
        $word = $match[5];
    } else if (preg_match("~(.+)\b(weather|climate|temperature|mausam)\b[^\w]*$~", $weather_word, $match)) {
        $word = $match[1];
    } else if (preg_match("~(.+)\b(weather|climate|temperature|mausam)\b(.+)~", $weather_word, $match)) { // added on 21/11/2012
        $word = $match[3];
    }

    if ($word) {
        include 'weather_sugg.php';
        if ($weather_return == '' && $match[1] == 'weather') {
            $to_logserver['isresult'] = 0;
            $weather_return = " No weather information currently available for this place. For eg. Sms weather delhi to $shortcode for Delhi weather details.";
            echo "\n<br>WEATHER MUST<br>\n";
        } else if ($weather_return != '') {
            $to_logserver['source'] = 'weather';
            $total_return = $weather_return;
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}

if (strpos($spell_checked, 'stock') !== false) {
    echo "ON STOCK";
    if (preg_match("~^(stock)s?[^\w]+(price of )?(\w+[^?]*)~", $spell_checked, $match)) {
        $word = $match[3];
        $subfunction = 2;
        $stock_must = true;
        include 'stocks.php';
    } else if (preg_match("~(.+)\bstocks?[^\w]*$~", $spell_checked, $match)) {
        $word = trim($match[1]);
        $subfunction = 2;
        $stock_must = false;
        include 'stocks.php';
    }

    if ($stock_return) {
        $total_return = $stock_return;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'stock';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~\b^(dic|dict|define|meaning|dictionary)\b(\sof)?[^\w]+(\w+[^?]*)~", $query_alphabets, $match)) {

    //API
    if ($dict_return) {
        $subfunction = 3;
        $total_return = $dict_return;
        $current_file = "data_dict/ans/query/$word";
        $source_machine = "db";
        $to_logserver['source'] = 'dict';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~^(expand|expansion|full.form|fullform|fulform|full? ?name)(\sof)?[^\w]+([^?]+)~", $req, $match) || preg_match("~(expand|expansion|full.form|fullform|fulform|full? ?name)(\sof)?[^\w]+([^?]+)~", $spell_checked, $match)) {
    //API
    if ($acry_return) {
        $subfunction = 4;
        $total_return = $acry_return;
        $current_file = "data_acry/ans/query/$word";
        $source_machine = "db";
        $to_logserver['source'] = 'acry';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~(show.?tim|movie.?tim)~", $spell_checked, $matches)) {
//} else if (strpos(checkSpelling($query_alphabets), "showtime") !== false) {
    echo "<br>SHOWTIMES<br>";
    if (preg_match("~^[^\w]*show.?tim~", $spell_checked)) {
        $showtim_must = true;
    }
    print_r($matches);
//include 'localmovie.php';
    include 'showtimes.php';
    echo "SHOWTIME :";
    var_dump($localmovie_return);
    if ($localmovie_return) {
        $current_file = "/movie/$numbers ";
        $source_machine = $machine_id;
        file_put_contents(DATA_PATH . $current_file, $localmovie_return);
        $total_return = $localmovie_return;
        $direct = true;
        $to_logserver['source'] = 'showtimes';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if ((preg_match("~\b(lyric|lyrics)\b~si", $lyricsWord) || preg_match("~\b^(song|poem|songs|poems)\b~si", $lyricsWord) ) && strlen($spell_checked) > 6) {
    include 'lyricsCentral.php';
}

$word = '';
if (preg_match("~\b^(photo|picture|image|foto|pic|pictur|wallpaper)s?\b( of)?( for)?[^\w]+(\w+[^?]*)~", $spell_checked, $match) && $photos_pack && (!strpos($spell_checked, 'dirty picture') || strpos($spell_checked, 'photo') !== false)) {
    $flag_enabled = false;
    $check_safe_search = true;
    if (preg_match("~^[^\w]*photo~", $spell_checked)) {
        $photo_must = true;
    }
    $word = trim($match[4]);
    echo "<br>PHOTO<br>$word<br>";
    $direct = true;
} else if (preg_match("~(.+)[^\w]+\b(photo|image|picture|wallpaper)s?\b$~", $spell_checked, $match) && $photos_pack && (!strpos($spell_checked, 'dirty picture') || strpos($spell_checked, 'photo') !== false)) {
    $flag_enabled = false;
    $check_safe_search = true;
    $subfunction = 11;
    $word = trim($match[1]);
    echo "<br>PHOTO<br>$word<br>";
    $direct = true;
}
if ($word) {
    //API/ Parser
}

$movie_title = '';
if (preg_match("~^(movie|film|flim|review)s?( review)?[^\w]+(\w+[^?]*)~", $spell_checked, $match)) {
    echo "<br>MOVIE REVIEW<br>";
    if ($match[1] == 'movie') {
        $movie_must = true;
    }
    echo "<br>Movie title is : " . $movie_title = $word = trim($match[3]);
} else if (in_array($query_words[count($query_words) - 1], array("film", "movie"))) {
    echo "<br>MOVIE MATCH 2<br>";
    $words = $query_words;
    unset($words [count($words) - 1]);
    $movie_title = $word = implode(' ', $words);
}
if ($movie_title) {
    //API/Parser
} 

include 'city.php';

include 'tmpfix.php';
?>
