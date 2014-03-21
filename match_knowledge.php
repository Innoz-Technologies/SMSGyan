<?php

if (preg_match("~(sex (story|stories|tips|tip)|^friendship (m[ea]ss?ages?|lyrics|songs?|poem|celb idea|idea_gift)|^pononam (messages?|lyrics?)|(^pickup lines?|^pick up line|^pickup|^pick up)|(^quran (qu?ote?s?|verses?))|^(indep|freedom) ?(day)? (m[ea]ss?ages?|qu?ote?s?|songs?|lyrics)|^rama?[dz]an (messages?|quotes?|recipes?)|^(lord )?((sh?ri)? ?krishnan?|(janm)?ashtami) (m[ea]ss?ages?|bh?ajan[ea]?|songs?|lyrics|story|stories|history)|hfz (m[ea]ss?ages?|qu?ote?s?)|ramadan (m[ea]ss?ages?|quotes?|recipes)|((lord |gowr[iy] )?(ganesha?|Vinayaka?|ganapath?i|gajanana|chaturthi) (chaturthi )?)(m[ea]ss?ages?|songs?|lyrics|bh?ajan[ea]?)|onam (m[ea]ss?ages?|songs?|lyrics|paa?tt?[ue]?)|tea?chers? (day )?(m[ea]ss?ages?|songs?|lyrics|qu?ote?s?)|(di[vw]ali|deepa[vw]ali) (m[ea]ss?ages?|songs?|lyrics|qu?ote?s?|recipes?)|^(new ?year) (songs?|lyrics)|(christmas|x[',.-]?mas) (songs?|lyrics|story|recipes?)|^republic ?(day)? (m[ea]ss?ages?|qu?ote?s?|songs?|lyrics|leader)|^valentine'?s? ?(day)? (m[ea]ss?ages?|greetings?|qu?ote?s?|songs?|lyrics)|^(rose|propose|chocolate|teddy|promise|hug|kiss) ?(day)? (m[ea]ss?ages?|greetings?)|^shiva?( ?rath?ri)? (m[ea]ss?ages?|bh?ajan[ea]?|songs?)|^holi (m[ea]ss?ages?|songs?|lyrics)|^sri krishna (songs?|message|story)|^ugadi (m[ea]ss?ages?)|^gudi padwa (m[ea]ss?ages?)|^ram navami (m[ea]ss?ages?|bh?ajan[ea]?|songs?)|^sajibu (m[ea]ss?ages?)|^fools day (prank ideas?|m[ea]ss?ages?)|^friend (gift)|^monsoon (lyrics?|songs?|movies?)|^id (messages?|lyrics?|fighters?)|^kishore (lyrics)|^eid (messages?|decorations?)|^onam (messages?|lyrics?)|^mj (lyrics?)|^beyonce (lyrics?)|^td (messages?|quotes?|poems?|famous)|(^feng shui? tips?|^feng shu)|(^vaa?sth?u tips?)|^vishwakarma (recipes?|lyrics?)|^jain (messages?|quotes?)|^gandhi (speech|facts?)|^navratri (lyrics|recipes|message)|^smoke (personality)|^durga (messages?|recipes?)|^bakrid (recipes?)|^dussehra (ramlyrics)|^bond (dialogues)|^karva (gift wife|gift husband)|^ayyappa (lyrics)|^shayari (urdu|funny) |^obama (speech)|^cd (quotes)|^bhau beej (messages)|^sai baba (story)|^disability (quotes)|^rajinikanth (dialogues)|^rajnikanth (jokes)|^rajinikanth (facts)|(^dec ?12|^december ?12|^12-12-12)|^new year (parties bangalore|parties chennai|parties mumbai|parties delhi|parties pune)|^sachin (quotes)|^tony greig (commentary)|^bihu (recipes|lyrics|crafts)|^pongal (recipes|lyrics)|^dravid (quotes)|^sankranti (recipes|wishes)|^byceps? (tips?)|^love (story|stories)|^hair care (tips?)|^easter (recipes|lyrics)|^holi (jokes?|shayari)|^may day (quotes?)|^jokes? (tintumon|adult|sex|funny)|^may day (quotes?)|^may day (quotes?)) ?(_not_(\d+))?(.+)?~", strtolower($spell_checked), $match)) {
    echo "<br>KNOWLEDGE SEARCH<br>";
    print_r($match);

    $mylang_handle = "";  // language checking option
    $flag_enabled = FALSE;
    if (!$match[94] == '') {       //handicaped
        $sesn = 'may day';
        $que = $match[94]; //$match[93];
        $to_logserver['source'] = 'md';
    } elseif (!$match[93] == '') {       //handicaped
        $sesn = 'holi';
        $que = $match[93]; //$match[93];
        $to_logserver['source'] = 'fun_keyword';
    } elseif (!$match[92] == '') {       //handicaped
        $sesn = 'easter';
        $que = $match[92];
        $to_logserver['source'] = 'easter';
    } elseif (!$match[91] == '') {       //handicaped
        $sesn = 'hair care';
        $que = 'tips'; //$match[90];
        $to_logserver['source'] = 'haircare';
    } elseif (!$match[90] == '') {       //handicaped
        $sesn = 'love';
        $que = 'story'; //$match[90];
        $to_logserver['source'] = 'lovestory';
    } elseif (!$match[88] == '') {       //handicaped
        $sesn = 'sankranti';
        $que = $match[88];
        $to_logserver['source'] = 'sankranti';
    } elseif (!$match[87] == '') {       //handicaped
        $sesn = 'dravid';
        $que = $match[87];
        $to_logserver['source'] = 'dravidBday';
    } elseif (!$match[86] == '') {       //handicaped
        $sesn = 'pongal';
        $que = $match[86];
        $to_logserver['source'] = 'pongal_spl';
    } elseif (!$match[85] == '') {       //handicaped
        $sesn = 'bihu';
        $que = $match[85];
        $to_logserver['source'] = 'bihu_spl';
    } elseif (!$match[84] == '') {       //handicaped
        $sesn = 'tony greig';
        $que = $match[84];
        $to_logserver['source'] = 'tonygreig_spl';
    } elseif (!$match[83] == '') {       //handicaped
        $sesn = 'sachin';
        $que = $match[83];
        $to_logserver['source'] = 'sachinspl';
    } elseif (!$match[82] == '') {       //handicaped
        $sesn = 'new year';
        $que = $match[82];
        $to_logserver['source'] = 'newyear13';
    } elseif (!$match[81] == '') {       //handicaped
        $sesn = 'myths';
        $que = 'dec12'; //$match[82];
        $to_logserver['source'] = 'dec12myths';
    }
    elseif (!$match[80] == '') {       //handicaped
        $sesn = 'rajinikanth';
        $que = $match[80];
        $to_logserver['source'] = 'rajinispl';
    } elseif (!$match[79] == '') {       //handicaped
        $sesn = 'rajinikanth';
        $que = $match[79];
        $to_logserver['source'] = 'rajinispl';
    } elseif (!$match[78] == '') {       //handicaped
        $sesn = 'rajinikanth';
        $que = $match[78];
        $to_logserver['source'] = 'rajinispl';
    } elseif (!$match[77] == '') {       //handicaped
        $sesn = 'disability';
        $que = $match[77];
        $to_logserver['source'] = 'saibaba';
    } else if (!$match[76] == '') {       //sathya sai baba
        $sesn = 'sai baba';
        $que = $match[76];
        $to_logserver['source'] = 'saibaba';
    } elseif (!$match[75] == '') {       //Childrens Day
        $sesn = 'bhau beej';
        $que = $match[75];
        $to_logserver['source'] = 'bhau-beej';
    } elseif (!$match[74] == '') {       //Childrens Day
        $sesn = 'cd';
        $que = $match[74];
        $to_logserver['source'] = 'childrensday';
    } elseif (!$match[73] == '') {       //shayari
        $sesn = 'obama';
        $que = $match[73];
        $to_logserver['source'] = 'obama';
    }
    elseif (!$match[71] == '') {           //Ayyappa
        $sesn = 'ayyappa';
        $que = $match[71];
        $to_logserver['source'] = 'ayyappa';
        //special code to handle language option on 07/11/12

        if (in_array($circle_short, array('KL', 'KA', 'TN', 'CH', 'AP'))) {
            $mylang_handle = " and language like '$circle_lang'";
        }
    } elseif (!$match[70] == '') {           //Dussehra
        $sesn = 'karva';
        $que = $match[70];
        $to_logserver['source'] = 'karvachauth';
    } elseif (!$match[69] == '') {           //Dussehra
        $sesn = 'bond';
        $que = $match[69];
        $to_logserver['source'] = 'bond';
    } elseif (!$match[68] == '') {           //Dussehra
        $sesn = 'dussehra';
        $que = 'ramlyrics'; //$match[68];
        $to_logserver['source'] = 'dussehra';
    } elseif (!$match[66] == '') {           //christmas
        $sesn = 'bakrid';
        $que = $match[66];
        $to_logserver['source'] = 'bakrid';
    } elseif (!$match[65] == '') {           //christmas
        $sesn = 'smoke';
        $que = $match[65];
        $to_logserver['source'] = 'smoke';
    } elseif (!$match[63] == '') {           //christmas
        $sesn = 'navratri';
        $que = $match[63];
        $to_logserver['source'] = 'navratri';
    } elseif (!$match[62] == '') {           //christmas
        $sesn = 'jain';
        $que = $match[62];
        $to_logserver['source'] = 'vasthu tips';
    } elseif (!$match[61] == '') {           //christmas
        $sesn = 'vishwakarma';
        $que = $match[61];
        $to_logserver['source'] = 'vasthu tips';
    } elseif (!$match[60] == '') {           //christmas
        $sesn = 'vasthu tips';
        $que = 'vasthu tips';
        $to_logserver['source'] = 'vasthu tips';
    } elseif (!$match[59] == '') {           //christmas
        $sesn = 'feng shui tips';
        $que = 'feng shui tips';
        $to_logserver['source'] = 'feng shui tips';
    } elseif (!$match[58] == '') {           //christmas
        $sesn = 'td';
        $que = $match[58];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[57] == '') {           //christmas
        $sesn = 'td';
        $que = $match[57];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[56] == '') {           //christmas
        $sesn = 'mj';
        $que = $match[56];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[53] == '') {           //christmas
        $sesn = 'eid';
        $que = $match[53];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[54] == '') {           //christmas
        $sesn = 'kishore';
        $que = $match[54];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[52] == '') {           //christmas
        $sesn = 'monsoon';
        $que = $match[52];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[51] == '') {           //christmas
        $sesn = 'rakhi';
        $que = $match[51];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[50] == '') {           //christmas
        $sesn = 'friend';
        $que = $match[50];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[48] == '') {           //christmas
        $sesn = 'fools day';
        $que = $match[48];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[47] == '') {           //christmas
        $sesn = 'sajibu';
        $que = $match[47];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[46] == '') {           //christmas
        $sesn = 'ram navami';
        $que = $match[46];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[45] == '') {           //christmas
        $sesn = 'gudi padwa';
        $que = $match[45];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[44] == '') {           //christmas
        $sesn = 'ugadi';
        $que = $match[44];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[43] == '') {           //christmas
        $sesn = 'sri krishna';
        $que = $match[43];
        $to_logserver['source'] = 'k_' . $sesn;
    } elseif (!$match[42] == '') {           //christmas
        $sesn = 'Shivratri';
        $que = $match[42];
        $to_logserver['source'] = 'k_' . $sesn;
    } else if (!$match[41] == '') {           //christmas
        $sesn = 'Shivratri';
        $que = $match[41];
        $to_logserver['source'] = 'k_' . $sesn;
    } else if (!$match[39] == '') {           //christmas
        $sesn = $match[37];
        $que = $match[39];
        $to_logserver['source'] = 'val_' . $sesn;
    } else if (!$match[36] == '') {           //christmas
        $sesn = 'val day';
        $que = $match[36];
        $to_logserver['source'] = 'val';
    } else if (!$match[34] == '') {           //christmas
        $sesn = 'rep';
        $que = $match[34];
        $to_logserver['source'] = 'republic';
    } else if (!$match[32] == '') {           //christmas
        $sesn = 'christmas';
        $que = $match[32];
        $to_logserver['source'] = 'christmas';  //added story and recipe on 10-12-2012
    }
    else if (!$match[28] == '') {           //Divali
        $sesn = 'diwali';
        $que = $match[28];
        $to_logserver['source'] = 'k_divali';
    } else if (!$match[57] == '') {           //Teachers day
        $sesn = 'TD';
        $que = $match[57];
        $to_logserver['source'] = 'k_teacher';
    } else if (!$match[24] == '') {           //onam
        $sesn = 'onam';
        $que = $match[24];
        $to_logserver['source'] = 'k_onam';
    } else if (!$match[23] == '') {           //chathurthi
        $sesn = 'lg';
        $que = $match[23];
        $to_logserver['source'] = 'k_chathurthi';
    } else if (!$match[18] == '') {           //eid
        $sesn = 'ramadan';
        $que = $match[18];
        $to_logserver['source'] = 'k_ramadan';
    } else if (!$match[17] == '') {           //hfz
        $sesn = 'krishna';
        $que = $match[17];
        $to_logserver['source'] = 'k_krishna';
    } else if (!$match[16] == '') {           //krishna 
        $sesn = 'krishna';
        $que = $match[16];
        if ($circle == 'UE' || $circle == 'UW') {
            include 'closedb.php';
            include 'lib/mainconfigdb.php';
            $query = "SELECT number FROM photo_search WHERE (number='$numbers' AND status=1 AND channel=10)";
            $result = mysql_query($query) or die(mysql_error());
            if (!mysql_num_rows($result)) {
                $free = false;
                $showsuboption = false;
            } else {
                $free = true;
            }
            include 'closedb.php';
            include 'lib/appconfigdb.php';
        }
        $to_logserver['source'] = 'k_krishna';
    } else if (!$match[10] == '') {           //shammi kapoor
        $sesn = 'SK';
        $que = $match[10];
        $to_logserver['source'] = 'k_shammi';
    } else if (!$match[11] == '') {           //shammi kapoor
        $sesn = 'ramadan';
        $que = $match[11];
        $to_logserver['source'] = 'k_shammi';
    } else if (!$match[10] == '') {           //indipendence day
        $sesn = 'id';
        $que = $match[10];
        $to_logserver['source'] = 'k_indipendence';
    } else if (!$match[6] == '') {           //Rakhi
        $sesn = 'quran';
        $que = 'quran';
        $to_logserver['source'] = 'k_quran';
    } else if (!$match[8] == '') {           //Rakhi
        $sesn = 'rakhi';
        $que = $match[8];
        $to_logserver['source'] = 'k_rakhi';
    } else if (!$match[4] == '') {     //quran
        $que = $match[4];
        $sesn = 'onam';
        $to_logserver['source'] = 'k_indi';
    } else if (!$match[5] == '') {     //quran
        $que = 'pickup lines';
        $sesn = 'pickup lines';
        $to_logserver['source'] = 'k_pickup';
    } else if (!$match[2] == '') {     //sex
        $sesn = 'sex';
        $que = $match[2];
        $to_logserver['source'] = 'k_sex';
    } elseif (!$match[3] == '') {                          //friendship
        $que = $match[3];
        $sesn = 'friendship';
        $isfs = true;
        $to_logserver['source'] = 'k_friendship';
    }

    if (!$match[98] == '') {
        $notmsgid = $match[98];
    } else {
        $notmsgid = 0;
    }

    echo $questr = $match[1];
    echo $searchstr = $match[1];
    echo "QUE $que SESSION $sesn<br>";

    include 'knowledge.php';
//    if ($isfs && ($circle == 'UW' || $circle == 'UE'))        //friendship day
//        $charge_per_query = 3;
    putOutput($total_return);
    exit();
}
?>