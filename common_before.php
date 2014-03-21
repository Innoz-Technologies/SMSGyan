<?php

if (substr($query_in, strlen($query_in) - 1, 1) == '?') {
    $question_in = substr($query_in, 0, strlen($query_in) - 1);
} else {
    $question_in = $query_in;
}

include 'game.php';

include 'slang.php';

if ((strpos($spell_checked, 'cri ') !== false || strpos($spell_checked, 'ckt ') !== false || strpos($spell_checked, 'cricket ') !== false) && (strpos($spell_checked, 'schedule') !== false || strpos($spell_checked, 'fixture') !== false || strpos($spell_checked, 'time') !== false || strpos($spell_checked, 'timing') !== false)) {
    include 'cri_sch.php';
}

$cri_res = TRUE;
$hor_res = TRUE;

echo "<h1>SPL CRI</h1>";

if ($cri_res) {
    $rr = trim(str_ireplace("'", "", $query_alphabets));
    if (preg_match("~\b^(livescore|commentary|wicket|ipl cri|live scor|ipl scor|score|scor|skore|cri|ckt|ipllive|live cri|ipl live|iplscor|what is the score|live ipl|cricket ipl|sms cri|cricket live|cricket scor|cricketlive|c r i|scr|scorecard|livescore1|livescore2|live score|cric|live cricket|sms cricket|cricket|scores|t20)\b~si", $rr) || ($spell_checked == "india" && $circle_short == "KA")) { // changed on 04/03/2013 as per mail, give cri results for keyword india
        echo "<br> CRI MATCH";
        echo "<br> CRI MATCH NEXT";

        include 'livecricket_new.php';
        if (!$live_return) {
            include 'livescores.php';
            if ($live_return != '') {
                $to_logserver['source'] = 'cri';
                putOutput($live_return);
                exit();
            }
        }
    }
}

include 'doctor.php';
include 'match_namaz.php';

$spelled_qry_alphabets = $spell_checked;
if ($spelled_qry_alphabets == 'keyword' || $spelled_qry_alphabets == 'keywords' || $spelled_qry_alphabets == 'key word' || $spelled_qry_alphabets == 'key words' || $spelled_qry_alphabets == 'sms keywords' || $spelled_qry_alphabets == 'sms keyword') {
    $spell_checked = 'keywords';
    $req = 'keywords';
    $flag_enabled = false;
    $free = true;
}

include 'taxiFare.php';

//TWEET Card
include 'match_tc.php';

include 'match_canned.php';

//EPL SCore
include 'match_epl.php';
include 'truecaller_new.php';

//Route
include 'match_route.php';

include 'content_story.php';

include 'match_knowledge.php';


echo"<br>MSG CONTENT<br>";
include 'message_content.php';

echo "<h2>Twitter API BEFORE</h2>";
//twitter api

echo "<h2>EMAIL API BEFORE</h2>";
//email app

echo '<br>Cricket Statistics<br>';
include 'Cricket_Stats.php';

echo '<br>Cricket Rankings<br>';
include 'cricket_rank.php';

echo '<br>IPL<br>';
include 'ipl.php';

include 'valentines.php';

if (preg_match("~__local__srch__(.+)_(.+)__~", $req, $match)) {
//bing local search
}
?>
