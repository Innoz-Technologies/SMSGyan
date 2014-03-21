<?php

$qid_set = FALSE;
if (!isset($query_id)) {
    $qid_set = TRUE;
    $query_id = md5($numbers . time() . $query_in); //Unique identifier for each incoming query
}

echo "<br>Block/Unblock Keyword</br>";

if ($spell_checked == "your query" || $spell_checked == "ur query" || $spell_checked == "u r query" || $spell_checked == "query") {
    $spell_checked = $req = "help";
}

if (in_array("which", $query_words) && in_array("came", $query_words) && in_array("chicken", $query_words) && in_array("egg", $query_words)) {
    $req = "Which came first, the chicken or the egg";
}

if (strpos($spell_checked, "tourist places in kerala") !== false) {
    $req = "tourist places in kerala";
}
$toparray = array("top", "topten", "top10", "top 10", "top ten criminals", "top ten criminals of the world", "top ten criminals of world", "top 10 criminals", "top 10 criminals of the world", "top 10 criminals of world");
if (in_array($spell_checked, $toparray) || strpos($spell_checked, "ten criminals") !== false || strpos($spell_checked, "10 criminals") !== false) {
    $req = "top ten";
}

if (preg_match("~anna hazare~", $spell_checked)) {
    $req = 'anna hazare';
}

if (preg_match("~^friendship ((gr(ee|i)tings? ?(cards?)?)|((gr(ee|i)tings? )?cards?))~", $spell_checked)) {
    $req = 'photo friendship greeting cards';
    $spell_checked = 'photo friendship greeting cards';
    $isfs = true;
    echo 'Friendship Day';
}

if (strpos($spell_checked, "love tip") !== false) {
    $req = 'love tips';
    $spell_checked = 'love tips';
}

if (strpos($spell_checked, "beauty tip") !== false) {
    if (strpos($spell_checked, "men") !== false || strpos($spell_checked, "man") !== false || strpos($spell_checked, "boy") !== false) {
        $req = 'beauty tips for men';
        $spell_checked = 'beauty tips for men';
    } else {
        $req = 'beauty tips';
        $spell_checked = 'beauty tips';
    }
}

if (strpos($spell_checked, "sex tip") !== false) {
    if (strpos($spell_checked, "women") !== false || strpos($spell_checked, "lady") !== false || strpos($spell_checked, "ladies") !== false) {
        $req = 'sex tips for women';
        $spell_checked = 'sex tips for women';
    } elseif (strpos($spell_checked, "first") !== false || strpos($spell_checked, "night") !== false || strpos($spell_checked, "ladies") !== false) {
        $req = 'sex tips for first night';
        $spell_checked = 'sex tips for first night';
    } else {
        $req = 'sex tips';
        $spell_checked = 'sex tips';
    }
}

if (preg_match("~\b(bite?\b.*\bapple|apple\b.*\bbite?)\b~", $spell_checked)) {
    $spell_checked = "apple bite";
}

//$hotdog = preg_match("~why is (the|a|d|da)? hot dog called (a hot ?dog|so)~", $spell_checked);
//$hotdogs = preg_match("~why are hot dogs called (hot ?dogs|so)~", $spell_checked);
if ((strpos($spell_checked, "weight") !== false || strpos($spell_checked, "fat ") !== false) && (strpos($spell_checked, "lose") !== false || strpos($spell_checked, "reduce") !== false)) {
    echo "<br>NASSCOM AWARD";
    $spell_checked = "how to lose weight";
    $req = "how to lose weight";
    $query_alphabets = "how to lose weight";
}

if (preg_match("~\bin?no[zs]\b~", $spell_checked)) {
    if (preg_match("~\b(ceo|coo|cto|cio|cheif executive officer|chief (operation|organising) officer|cheif (information|innovation) officer|chief (technology|technical) officer)\b~", $spell_checked, $match)) {
        switch ($match[1]) {
            case 'ceo':
            case 'cheif executive officer':
                $spell_checked = 'ceo innoz';
                break;
            case 'coo':
            case 'chief operation officer':
            case 'chief organising officer':
                $spell_checked = 'coo innoz';
                break;
            case 'cio':
            case 'chief information officer':
            case 'chief innovation officer':
                $spell_checked = 'cio innoz';
                break;
            case 'coo':
            case 'chief technology officer':
            case 'chief technical officer':
                $spell_checked = 'cto innoz';
                break;
        }
    }
}
if (strpos($spell_checked, "founder") !== false && (strpos($spell_checked, "innoz") !== false || strpos($spell_checked, "innos") !== false || strpos($spell_checked, "inoz") !== false)) {
    echo "<br>NASSCOM AWARD";
    $spell_checked = "founder innoz";
}

if (strpos($spell_checked, "why") !== false || strpos($spell_checked, "can you tell") !== false || strpos($spell_checked, "do you know") !== false || strpos($spell_checked, "reason") !== false) {
    echo "<br>INSIDE WHY";
    if ((strpos($spell_checked, "hotdog") !== false || strpos($spell_checked, "hot dog") !== false) && (strpos($spell_checked, "known") !== false || strpos($spell_checked, "called") !== false)) {
        echo "<br>INSIDE HOTDOG";
        $spell_checked = "Why is it called a hot dog if its not made out of dog";
    } elseif ((strpos($spell_checked, "bluetooth") !== false || strpos($spell_checked, "blue tooth") !== false) && (strpos($spell_checked, "known") !== false || strpos($spell_checked, "called") !== false)) {
        echo "<br>INSIDE BLUETOOTH";
        $spell_checked = "Why is it called Bluetooth technology";
    } elseif ((strpos($spell_checked, "angry bird") !== false || strpos($spell_checked, "angrybird") !== false)) {
        echo "<br>INSIDE ANGRYBIRDS";
        $spell_checked = "Why are the angry birds so angry";
    } elseif (strpos($spell_checked, "apple") !== false && (strpos($spell_checked, "product") !== false || strpos($spell_checked, "device") !== false) && (strpos($spell_checked, "start") !== false || strpos($spell_checked, "begin") !== false)) {
        echo "<br>INSIDE APPLE";
        $spell_checked = "Why do Apple products start with an i";
    } elseif (strpos($spell_checked, "twitter") !== false && strpos($spell_checked, "limit") !== false && (strpos($spell_checked, "140") !== false || strpos($spell_checked, "character") !== false)) {
        echo "<br>INSIDE TWITTER";
        $spell_checked = "Why does Twitter have a 140 character limit";
    } elseif (strpos($spell_checked, "santa") !== false && strpos($spell_checked, "red") !== false) {
        echo "<br>INSIDE Santa red";
        $spell_checked = "why santa wears red";
    }
}


// cricket fixture
if ($spell_checked == "cricket fixture" || $spell_checked == "cricket fixtures" || $spell_checked == "cricket schedule") {
    $spell_checked = "cri fixture";
    $req = "cri fixture";
    $query_alphabets = "cri fixture";
}

if (preg_match("~^__promo__(.+)__free$~", $query_in, $match)) {
    echo "<br>USSD PROMOTION<br>";
    $req = $match[1];
    $spell_checked = $match[1];
    $free = true;
}
if (preg_match("~^\b(oscar|oscar awards?|academy awards?|oscar award 2013)\b~", $spell_checked)) {
    $spell_checked = 'oscar awards';
    $req = 'oscar awards';
}

if ((strpos($spell_checked, "income tax") !== false && (strpos($spell_checked, "help") !== false || strpos($spell_checked, "returns") !== false || strpos($spell_checked, "returns help") !== false ))) {
    $spell_checked = 'income tax returns';
    $req = 'income tax returns';
}
if ($spell_checked == "national awards winner" || $spell_checked == "national awards" || $spell_checked == "national award winners 2012" || $spell_checked == "national award 2012" || $spell_checked == "national award" || $spell_checked == "national film awards" || $spell_checked == "national film award" || $spell_checked == "national awards 2012") {
    $spell_checked = "National Award winners";
}

if (strpos($spell_checked, "how") !== false && strpos($spell_checked, "impress") !== false && strpos($spell_checked, "boy") !== false && strpos($spell_checked, "girl") == false) {
    $spell_checked = "how to impress a boy";
    $req = "how to impress a boy";
}

if (strpos($spell_checked, "how") !== false && strpos($spell_checked, "pass") !== false && strpos($spell_checked, "exam") !== false) {
    $spell_checked = str_replace('exam', 'final exam', $spell_checked);
    $req = str_replace('exam', 'final exam', $req);
}

if ((strpos($spell_checked, "boyfriend") !== false || strpos($spell_checked, "boy friend") !== false || strpos($spell_checked, " bf ") !== false) && (strpos($spell_checked, "pick") !== false || strpos($spell_checked, "attend") !== false) && (strpos($spell_checked, "phone") !== false || strpos($spell_checked, "mobile") !== false || strpos($spell_checked, "call") !== false)) {
    $spell_checked = "My boyfriend is not picking up his phone. What should I do";
    $req = "My boyfriend is not picking up his phone. What should I do";
    $query_alphabets = "My boyfriend is not picking up his phone. What should I do";
}
if (strpos($spell_checked, "interview") !== false && (strpos($spell_checked, "shirt") !== false || strpos($spell_checked, "pant") !== false || strpos($spell_checked, "dress") !== false || strpos($spell_checked, "cloth") !== false || strpos($spell_checked, "wear") !== false)) {
    $spell_checked = "Can I wear a light-blue shirt and cream pants to my job interview tomorrow";
    $req = "Can I wear a light-blue shirt and cream pants to my job interview tomorrow";
    $query_alphabets = "Can I wear a light-blue shirt and cream pants to my job interview tomorrow";
}

$spell_checked = trim($spell_checked);


$spell_checked_tmp = preg_replace("~(best|good|nice|locate|find) ?shopping ?(mall|place)?~", "locate shopping $2", $spell_checked);
if ($spell_checked_tmp == $spell_checked) {
    $spell_checked = preg_replace("~shopping ?(mall|place)~", "locate shopping $1", $spell_checked);
    echo "<br>Spell chkd for Best Shop2: $spell_checked";
} else {
    $spell_checked = $spell_checked_tmp;
    echo "<br>Spell chkd for Best Shop: $spell_checked";
}

if (preg_match("~movie (the)? ?(amazing spider-? ?man|spider-? ?man ?4)~Usi", $spell_checked)) {
    $req = $spell_checked = "Movie The Amazing Spider-Man";
}

if ($spell_checked == "job interview tips" || $spell_checked == "tips for job interview" || $spell_checked == "job interview") {
    $spell_checked = "interview tips";
    $req = "interview tips";
    $query_alphabets = "interview tips";
}
if ($spell_checked == "how impress boss" || $spell_checked == "how to excel at work" || $spell_checked == "how to do well at work" || $spell_checked == "how work well") {
    $spell_checked = "how to impress your boss";
    $req = "how to impress your boss";
    $query_alphabets = "how to impress your boss";
}
if ($spell_checked == "college interview tips" || $spell_checked == "admission interview tips" || $spell_checked == "admission process" || $spell_checked == "tips for admission") {
    $spell_checked = "admission interview";
    $req = "admission interview";
    $query_alphabets = "admission interview";
}
if ($spell_checked == "tips for a date" || $spell_checked == "date tips" || $spell_checked == "dating tips" || $spell_checked == "how impress" || $spell_checked == "how impress girl") {
    $spell_checked = "how to impress a girl";
    $req = "how to impress a girl";
    $query_alphabets = "how to impress a girl";
}
if (strpos($spell_checked, "upsc tips") !== false || strpos($spell_checked, "cse tips") !== false || strpos($spell_checked, "tips for upsc") !== false || strpos($spell_checked, "tips upsc") !== false || strpos($spell_checked, "upsc exam tips") !== false) {
    $spell_checked = "upsc tips";
    $req = "upsc tips";
    $query_alphabets = "upsc tips";
}
if (strpos($spell_checked, "aieee tips") !== false || strpos($spell_checked, "tips for aieee") !== false || strpos($spell_checked, "tips aieee") !== false || strpos($spell_checked, "aieee exam tips") !== false) {
    $spell_checked = "aieee tips";
    $req = "aieee tips";
    $query_alphabets = "aieee tips";
}
if (strpos($spell_checked, "medical exam tips") !== false || strpos($spell_checked, "tips for medical exam") !== false || strpos($spell_checked, "tips medical exam") !== false || strpos($spell_checked, "tips medical") !== false || strpos($spell_checked, "exam tips for medical") !== false) {
    $spell_checked = "medical tips";
    $req = "medical tips";
    $query_alphabets = "medical tips";
}
if (strpos($spell_checked, "cat exam tips") !== false || strpos($spell_checked, "cat tips") !== false || strpos($spell_checked, "tips cat exam") !== false || strpos($spell_checked, "tips for cat exam") !== false || strpos($spell_checked, "exam tips for cat") !== false || strpos($spell_checked, "tips cat") !== false) {
    $spell_checked = "cat exam tips";
    $req = "cat exam tips";
    $query_alphabets = "cat exam tips";
}

if (strpos($spell_checked, "what to do") !== false && strpos($spell_checked, "date") !== false) {
    if (strpos($spell_checked, "men") !== false || strpos($spell_checked, "boy") !== false || strpos($spell_checked, "guy") !== false) {
        $spell_checked = "what to do on a date with a boy";
        $req = "what to do on a date with a boy";
        $query_alphabets = "what to do on a date with a boy";
    } else {
        $spell_checked = "what to do on a date with a girl";
        $req = "what to do on a date with a girl";
        $query_alphabets = "what to do on a date with a girl";
    }
}

if (strpos($spell_checked, "how to dress for a date") !== false) {
    if (strpos($spell_checked, "girl") !== false || strpos($spell_checked, "women") !== false || strpos($spell_checked, "gal") !== false) {
        $spell_checked = "how to dress for a date for girl";
        $req = "how to dress for a date for girl";
        $query_alphabets = "how to dress for a date for girl";
    } else {
        $spell_checked = "how to dress for a date for boy";
        $req = "how to dress for a date for boy";
        $query_alphabets = "how to dress for a date for boy";
    }
}

if (strpos($spell_checked, "how") !== false && strpos($spell_checked, "impress") !== false && strpos($spell_checked, "girl") !== false) {
    $spell_checked = "how to impress a girl";
    $req = "how to impress a girl";
    $query_alphabets = "how to impress a girl";
}

if (preg_match('~exam(inations?)? ?tips?~Usi', $spell_checked)) {
    echo "<h1>Exam spl</h1>";
    $spell_checked = $req = 'exam tips';
}
if ((strpos($spell_checked, "how") !== false || strpos($spell_checked, "tip") !== false) && strpos($spell_checked, "ielts") !== false && strpos($spell_checked, "exam") !== false) {
    $spell_checked = "ielts tips";
    $req = "ielts tips";
    $query_alphabets = "ielts tips";
}
if ((strpos($spell_checked, "how") !== false || strpos($spell_checked, "tip") !== false) && strpos($spell_checked, "toefl") !== false && strpos($spell_checked, "exam") !== false) {
    $spell_checked = "toefl tips";
    $req = "toefl tips";
    $query_alphabets = "toefl tips";
}
if ((strpos($spell_checked, "how") !== false || strpos($spell_checked, "tip") !== false) && strpos($spell_checked, "sat") !== false && strpos($spell_checked, "exam") !== false) {
    $spell_checked = "sat tips";
    $req = "sat tips";
    $query_alphabets = "sat tips";
}
if ((strpos($spell_checked, "how") !== false || strpos($spell_checked, "tip") !== false) && strpos($spell_checked, "gre") !== false && strpos($spell_checked, "exam") !== false) {
    $spell_checked = "gre tips";
    $req = "gre tips";
    $query_alphabets = "gre tips";
}

if ((strpos($spell_checked, "significance") !== false && strpos($spell_checked, "moles") !== false)) {
    $spell_checked = "significance of moles";
    $req = "significance of moles";
    $query_alphabets = "significance of moles";
}
date_default_timezone_set('Asia/Calcutta');
$time = (int) date('G');
if (($time >= 16 && $time < 23) && $spell_checked == "ipl") {
    $req = 'cri';
    $spell_checked = 'cri';
    $query_alphabets = 'cri';
} //score when ipl match is live edited on 03/04/2013

if ($spell_checked == "gita saar") {
    $req = 'gita saar message';
    $spell_checked = 'gita saar message';
    $query_alphabets = 'gita saar message';
}

if ($spell_checked == "gita teachings") {
    $req = 'gita saar message';
    $spell_checked = 'gita teachings message';
    $query_alphabets = 'gita teachings message';
}

echo "<h2>Outside Superstar</h2>";


if ($spell_checked == "dc") {
    $total_return = "The link to download DelightCircle mobile app is: http://delightcircle.com/m. Click on the link and get the free app to discover offers and places around you.";
    $to_logserver['source'] = 'dc';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if ($spell_checked == "helpline") {
    $total_return = "Let us pray for the safety and comfort of thousands of pilgrims stranded due to the Uttarakhand flash flood. Incase you want to reach out to some relief teams, here are the helpline nos.
Uttarkashi: 01374-226126, 226161
Chamoli: 01372-251437
Tehri: 01376-233433
Rudraprayag: 01732-1077
The ITBP helpline and control room numbers: 011-24362892, 9968383478
Army medical emergency helpline numbers: 18001805558, 18004190282, 8009833388
Uttarakhand Helpline numbers: 0135-2710334, 2710335, 2710233";

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'helpline';

    include 'allmanip.php';
    putoutput($total_return);
}
?>
