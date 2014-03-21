<?php

$zodiac_sugg = array('aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'scorpio', 'sagittarius', 'aquarius', 'pisces', 'libra', 'capricorn');
foreach ($query_words as $q_word) {
    if (in_array($q_word, $zodiac_sugg)) {
        $return_zodiac_suggestion = "horoscope " . $q_word;
        break;
    }
}
//$que = trim($que);
//echo $que;
//$que = strtolower(trim($que));
//echo "<br>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*HOROSCOPE*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~`<br>";
//
//foreach ($zodiac_sugg as $hk) {
//    echo "<br>......................Suggestion horoscope..........................</br>";
//    if (stripos($que, $hk) !== false) {
//        echo $que;
//        $horo = strtolower($que);
//        $horo_len = strlen($horo);
//        if ($horo_len > 2 && $horo_len <= 13 && !is_numeric($horo)) {
//            $lev_arry = array();
//            $zodiac = array('aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'scorpio', 'sagittarius', 'aquarius', 'pisces', 'libra', 'capricorn');
//            foreach ($zodiac as $key => $ti) {
//                if (strcmp($ti, $horo) == 0) {
//                    $hor = $ti;
//                    break;
//                } else {
//                    $lev_arry[$key] = levenshtein($ti, $horo);
//                }
//            }
//            asort($lev_arry);
//            print_r($lev_arry);
//            $temp = each($lev_arry);
//            if ($temp['value'] > $horo_len / 2) {
//                $return_zodiac = "";
//                //echo $return_zodiac;
//                //die();
//            }
//            $key = $temp["key"];
//            $hor = $zodiac[$key];
//
//            $url = "http://living.oneindia.in/astrology/astro/horoscope.php?func=change_sunsign&duration=daily&sunsign=$hor";
//            echo "<br>................$url.................<br>";
//            $data = file_get_contents($url);
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/aries.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/taurus.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/gemini.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/cancer.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/leo.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/virgo.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/scorpio.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/sagittarius.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/aquarius.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/pisces.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/libra.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//            $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/capricorn.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//            $data = (str_replace($find, "", $data));
//
//            $data = (str_replace('</div>', "", $data));
//            $data = trim($data);
//            echo "<br>.....data.....</br>";
//            echo $data;
//            $return_zodiac = $data;
//            echo "<br>.....return_zodiac.....</br>";
//            echo $return_zodiac;
//        } else {
//            $return_zodiac = "";
//        }
//
//        if ($return_zodiac) {
//            $return_zodiac_suggestion = "Horoscope " . $hk;
//        }
//    }
//}
?>