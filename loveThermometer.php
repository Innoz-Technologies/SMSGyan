<?php

if ($req == "lovetest") {
    unset($arCacheData["lt"]);
    $total_return = "Love Thermometer Calculation!!!";
    $total_return.= "Reply with your name";


    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        putOutput($total_return);
        exit();
    }
}

if ((!isset($arCacheData["lt"]["nm"])) && isset($arCacheData["lt"]["no"])) {

    if (!preg_match("~\b(tv|train|define|trace|how|when|what|which|why|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|price|expand|pnr|dict|recipe|horoscope|photos?|party|city|greetings?|ind)\b~i", $req)) {
        if (str_word_count($req) <= 4 && strlen($req) >= 3 && !is_numeric($req)) {

            $nameLt = $req;
            $hit_time = date("Y-m-d H:i:s");
            $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
            $arCacheData["lt"]["expiry"] = $expiry_time;
            $arCacheData["lt"]["no"] = $number;
            $arCacheData["lt"]["nm"] = $nameLt;
        } else {
            unset($arCacheData["lt"]);
        }
    } else {
        unset($arCacheData["lt"]);
    }

    $total_return = "Reply with your age!!!";

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        putOutput($total_return);
        exit();
    }
}

if ((!isset($arCacheData["lt"]["ag"])) && isset($arCacheData["lt"]["nm"])) {
    if (!preg_match("~\b(tv|train|define|trace|how|when|what|which|why|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|price|expand|pnr|dict|recipe|horoscope|photos?|party|city|greetings?|ind)\b~i", $req)) {
        if (preg_match("~^[\d]{2}~", $req)) {
            $ageLt = $req;
            $hit_time = date("Y-m-d H:i:s");
            $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
            $arCacheData["lt"]["expiry"] = $expiry_time;
            $arCacheData["lt"]["no"] = $number;
            $arCacheData["lt"]["ag"] = $ageLt;
        }
    } else {
        unset($arCacheData["lt"]);
    }

    $total_return = "Please select your gender!!!";

    $options_list[] = "Male";
    $list[] = array("content" => "__your__gender__male__");
    $options_list[] = "Female";
    $list[] = array("content" => "__your__gender__female__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~__your__gender__(.+)__~", $req, $match)) {

    $gender = $match[1];
    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["gn"] = $gender;

    $total_return = "Select your zodiac sign";

    $options_list[] = "Aries";
    $list[] = array("content" => "__horoscope__aries__");
    $options_list[] = "Taurus";
    $list[] = array("content" => "__horoscope__taurus__");
    $options_list[] = "Gemini";
    $list[] = array("content" => "__horoscope__gemini__");
    $options_list[] = "Cancer";
    $list[] = array("content" => "__horoscope__cancer__");
    $options_list[] = "Leo";
    $list[] = array("content" => "__horoscope__leo__");
    $options_list[] = "Virgo";
    $list[] = array("content" => "__horoscope__virgo__");
    $options_list[] = "Libra";
    $list[] = array("content" => "__horoscope__libra__");
    $options_list[] = "Scorpio";
    $list[] = array("content" => "__horoscope__scorpio__");
    $options_list[] = "Sagittarius";
    $list[] = array("content" => "__horoscope__sagittarius__");
    $options_list[] = "Capricorn";
    $list[] = array("content" => "__horoscope__capricorn__");
    $options_list[] = "Aquarius";
    $list[] = array("content" => "__horoscope__aquarius__");
    $options_list[] = "Pisces";
    $list[] = array("content" => "__horoscope__pisces__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~__horoscope__(.+)__~", $req, $match)) {

    $zodiac = $match[1];
    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["zs"] = $zodiac;

    $total_return = "Reply with your partner's name";

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        putOutput($total_return);
        exit();
    }
}

if (isset($arCacheData["lt"]["zs"]) && (!isset($arCacheData["lt"]["pnm"]))) {

    if (!preg_match("~\b(tv|train|define|trace|how|when|what|which|why|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|price|expand|pnr|dict|recipe|horoscope|photos?|party|city|greetings?|ind)\b~i", $req)) {
        if (str_word_count($req) <= 4 && strlen($req) >= 3) {

            $pnameLt = $req;
            $hit_time = date("Y-m-d H:i:s");
            $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
            $arCacheData["lt"]["expiry"] = $expiry_time;
            $arCacheData["lt"]["pnm"] = $pnameLt;
        }

        $total_return = "Reply with your partner's age";
    }

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        putOutput($total_return);
        exit();
    }
}

if (isset($arCacheData["lt"]["pnm"]) && (!isset($arCacheData["lt"]["pag"]))) {
    if (!preg_match("~\b(tv|train|define|trace|how|when|what|which|why|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|price|expand|pnr|dict|recipe|horoscope|photos?|party|city|greetings?|ind)\b~i", $req)) {
        if (preg_match("~^[\d]{2}~", $req)) {
            $ageLt = $req;
            $hit_time = date("Y-m-d H:i:s");
            $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
            $arCacheData["lt"]["expiry"] = $expiry_time;
            $arCacheData["lt"]["no"] = $number;
            $arCacheData["lt"]["pag"] = $ageLt;
        }
    } else {
        unset($arCacheData["lt"]);
    }
    $total_return = "Select your partners gender";

    $options_list[] = "Male";
    $list[] = array("content" => "__partner__gender__male__");
    $options_list[] = "Female";
    $list[] = array("content" => "__partner__gender__female__");


    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~__partner__gender__(.+)__~", $req, $match)) {

    $Pgender = $match[1];
    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["pgn"] = $Pgender;

    $total_return = "Select your partners zodiac sign";

    $options_list[] = "Aries";
    $list[] = array("content" => "__partner__zodiac__aries__");
    $options_list[] = "Taurus";
    $list[] = array("content" => "__partner__zodiac__taurus__");
    $options_list[] = "Gemini";
    $list[] = array("content" => "__partner__zodiac__gemini__");
    $options_list[] = "Cancer";
    $list[] = array("content" => "__partner__zodiac__cancer__");
    $options_list[] = "Leo";
    $list[] = array("content" => "__partner__zodiac__leo__");
    $options_list[] = "Virgo";
    $list[] = array("content" => "__partner__zodiac__virgo__");
    $options_list[] = "Libra";
    $list[] = array("content" => "__partner__zodiac__libra__");
    $options_list[] = "Scorpio";
    $list[] = array("content" => "__partner__zodiac__scorpio__");
    $options_list[] = "Sagittarius";
    $list[] = array("content" => "__partner__zodiac__sagittarius__");
    $options_list[] = "Capricorn";
    $list[] = array("content" => "__partner__zodiac__capricorn__");
    $options_list[] = "Aquarius";
    $list[] = array("content" => "__partner__zodiac__aquarius__");
    $options_list[] = "Pisces";
    $list[] = array("content" => "__partner__zodiac__pisces__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__partner__zodiac__(.+)__~", $req, $match)) {

    $Pzodiac = $match[1];
    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["pzs"] = $Pzodiac;

    $total_return = "How do you personally feel about your relationship?";

    $options_list[] = "I'm not happy";
    $list[] = array("content" => "__relationship__not happy__1__");
    $options_list[] = "I'm happy";
    $list[] = array("content" => "__relationship__happy__2__");
    $options_list[] = "I don't know";
    $list[] = array("content" => "__relationship__don't know__0__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~__relationship__(.+)__(.+)__~", $req, $match)) {


    $arCacheData["lt"]["count"] = 0;
    $count = $match[2];

    $relation = $match[1];
    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["rel"] = $relation;
    $arCacheData["lt"]["count"] += $count;

    $nameLt = $arCacheData["lt"]["nm"];
    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = $nameLt . " do you think " . $pnameLt . " is beautiful?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q1__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q1__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q1__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~__q1__(.+)__(.+)__~", $req, $match)) {

    $q1 = $match[1];
    $count = $match[2];


    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q1"] = $q1;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Does $pnameLt know you?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q2__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q2__no__1__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q2__not sure__0__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q2__(.+)__(.+)__~", $req, $match)) {

    $q2 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q2"] = $q2;
    $arCacheData["lt"]["count"] += $count;

    $nameLt = $arCacheData["lt"]["nm"];

    $total_return = "$nameLt, do you know her parents?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q3__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q3__no__1__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q3__not sure__0__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q3__(.+)__(.+)__~", $req, $match)) {

    $q3 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q3"] = $q3;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Does $pnameLt know your parents?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q4__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q4__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q4__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q4__(.+)__~", $req, $match)) {

    $q4 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q4"] = $q4;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Is $pnameLt taller than you?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q5__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q5__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q5__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q5__(.+)__(.+)__~", $req, $match)) {
    $q5 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q5"] = $q5;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Do you know $pnameLt's friends?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q6__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q6__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q6__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q6__(.+)__(.+)__~", $req, $match)) {
    $q6 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q6"] = $q6;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Have you already been at $pnameLt place?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q7__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q7__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q7__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q7__(.+)__(.+)__~", $req, $match)) {
    $q7 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q7"] = $q7;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Have you ever had a date with $pnameLt?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q8__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q8__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q8__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q8__(.+)__(.+)__~", $req, $match)) {
    $q8 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q8"] = $q8;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Have you danced with $pnameLt already?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q9__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q9__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q9__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}if (preg_match("~__q9__(.+)__(.+)__~", $req, $match)) {
    $q9 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q9"] = $q9;
    $arCacheData["lt"]["count"] += $count;

    $pnameLt = $arCacheData["lt"]["pnm"];

    $total_return = "Have you kissed $pnameLt already?";

    $options_list[] = "yes";
    $list[] = array("content" => "__q10__yes__2__");
    $options_list[] = "no";
    $list[] = array("content" => "__q10__no__0__");
    $options_list[] = "Not sure";
    $list[] = array("content" => "__q10__not sure__1__");

    if ($total_return) {
        $to_logserver['source'] = 'loveT';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~__q10__(.+)__(.+)__~", $req, $match)) {

    $q10 = $match[1];
    $count = $match[2];

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["lt"]["expiry"] = $expiry_time;
    $arCacheData["lt"]["no"] = $number;
    $arCacheData["lt"]["q10"] = $q10;
    $arCacheData["lt"]["count"] += $count;

    $nameLt = $arCacheData["lt"]["nm"];
    $pnameLt = $arCacheData["lt"]["pnm"];

    $first_name = $nameLt; //name
    $second_name = $pnameLt; // partners name

    $Pzodiac = $arCacheData["lt"]["pzs"]; //zodiac sign of partner
    $zodiac = $arCacheData["lt"]["zs"]; // zodiac sign

    $ageLt = $arCacheData["lt"]["ag"]; // age
    $PageLt = $arCacheData["lt"]["pag"]; // partners age

    include ("lovecalc.inc.php"); // Class
    $my_love = new lovecalc($first_name, $second_name); // New instance
    $val = $my_love->lovestat;

    $islove = TRUE;

    if ($islove) {
        $love_result = "Your love percentage is " . $val . '.' . "\n"; // Show
        if ($val > 90) {
            $love_result .= "Perfect Match.";
        } else if ($val > 79 && $val <= 89) {
            $love_result .= "Excellent Match.";
        } else if ($val > 69 && $val <= 79) {
            $love_result .= "Very good Match.";
        } else if ($val > 59 && $val <= 69) {
            $love_result .= "Good Match.";
        } else if ($val > 49 && $val <= 59) {
            $love_result .= "Average Match.";
        } else if ($val > 24 && $val <= 49) {
            $love_result .= "Not a bad Match.";
        } else if ($val <= 24) {
            $love_result .= "Poor match.";
        }
    }

    $name11 = preg_split('//', $first_name, -1, PREG_SPLIT_NO_EMPTY);
    $name22 = preg_split('//', $second_name, -1, PREG_SPLIT_NO_EMPTY);
    $s = 0;
    $count1 = strlen($first_name);
    $count2 = strlen($second_name);
    for ($x = 0; $x < $count1; $x++) {
        $m = $name11[$x];
        for ($y = 0; $y < $count2; $y++) {
            if ($m == $name22[$y]) {
                unset($name11[$x]);
                unset($name22[$y]);
                $s = $s + 2;
                break;
            }
        }
    }
    $tp = $count1 + $count2;
    $t = $tp - $s;
    if ($t == 2 || $t == 4 || $t == 7 || $t == 9) {
        $flames_result = $first_name . " is ENEMY to " . $second_name . ".";
        $val = 1;
    } else if ($t == 3 || $t == 5 || $t == 14) {
        $flames_result = $first_name . " is FRIEND to " . $second_name . ".";
        $val = 2;
    } else if ($t == 6 || $t == 11 || $t == 15) {
        $flames_result = $first_name . " is going to MARRY " . $second_name . ".";
        $val = 3;
    } else if ($t == 10) {
        $flames_result = $first_name . " is in LOVE with " . $second_name . ".";
        $val = 4;
    } else if ($t == 8) {
        $flames_result = $first_name . " has more AFFECTION on " . $second_name . ".";
        $val = 5;
    } else {
        $flames_result = $first_name . " and " . $second_name . " are sweetheart.";
        $val = 6;
    }

    $q = mysql_query("SELECT contents FROM match_horoscope where sign1='$zodiac' and sign2='$Pzodiac'");
    $row = mysql_fetch_array($q);

    if ($row) {
        $zodiac_return = $row['contents'];
    }

    $Age = $ageLt + $PageLt;

    $count_Final = $arCacheData["lt"]["count"];

    echo $count_Final;

    if ($count_Final > 15) {
        $relatnStatus = "Perfect Couple";
    } else if ($count_Final > 10 && $count_Final <= 14) {
        $relatnStatus = "Ideal Couple";
    } else if ($count_Final > 5 && $count_Final <= 9) {
        $relatnStatus = "Happy Couple";
    } else if ($count_Final < 5) {
        $relatnStatus = "Good Couple";
    }



    $total_return = "Love result : " . $love_result . "\n";
    $total_return.="Flames result : " . $flames_result . "\n";
    $total_return.="Current relationship status : " . $relatnStatus . "\n";
    $total_return.="Sign Compatibility result : " . $zodiac_return;


    if ($total_return) {
        unset($arCacheData["lt"]);
        $to_logserver['source'] = 'loveT';
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
unset($arCacheData["lt"]);
?>
