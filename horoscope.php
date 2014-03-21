<?php

$hor_req = strtolower($hor_req);
$horo_len = strlen($hor_req);
echo "<br>HOROSCOPEREQUERST: $hor_req <br>";
$return_zodiac = "";
$hor = '';
$time = (int) date('G');
echo $time;

$flag = 0;
if ($horo_len > 2) {
    $srchs = explode(' ', $hor_req);
    print_r($srchs);
    $lev_arry = array();
    if ($appQueryFrom == "thai")
        $zodiac = array("rat", "ox", "tiger", "rabbit", "dragon", "snake", "horse", "sheep", "monkey", "rooster", "dog", "pig");
    else
        $zodiac = array('aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'scorpio', 'sagittarius', 'aquarius', 'pisces', 'libra', 'capricorn');

    foreach ($srchs as $que) {
        foreach ($zodiac as $key => $ti) {
            if (strcmp($ti, $que) == 0) {
                $hor = $ti;
                break;
            } else if ($horo_len <= 15) {
                $leven = levenshtein($ti, $que);
                if ($leven <= strlen($ti) / 3) {
                    if (!isset($lev_arry[$key]) || $leven > $lev_arry[$key]) {
                        $lev_arry[$key] = $leven;
                    }
                }
            }
        }
        if ($hor)
            break;
    }
    if ($horo_len <= 15 && count($lev_arry)) {
        asort($lev_arry);
        print_r($lev_arry);
        $temp = each($lev_arry);
        $key = $temp["key"];
        $hor = $zodiac[$key];
    }

    if ($hor) {
        $result1 = mysql_query("SELECT details FROM horoscope where sign='$hor' and time='" . (date("Y-m-d")) . "' ");
        $row = mysql_fetch_array($result1);
        if ($row) {
            echo'its entering';
            echo '<br>...From Database....';
            $return_zodiac = $row['details'];
            if ($userid == "51de6d17b3e9a")
                $add_below = "";
            else
                $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
        } else {

            //$url = "http://astrology.oneindia.in/include/signname.asp?content=d&subcontent=$hor";
//            $url = "http://astrology.oneindia.in/horoscopes/daily-horoscope/$hor/";
//            
            // start changes made on 02/02/2012

            if ($appQueryFrom == "thai") {
                echo $url = "http://www.chinese-tools.com/astrology/horoscope/daily/sign_$hor.html";
                $content = file_get_contents($url);
                if (preg_match('~<div class="astroTitle">(.+)</table></div>~Usi', $content, $match)) {
                    $hordata = $match[1];
                    $hordata = preg_replace("~[\s]+~", " ", $hordata);
                    $hordata = str_replace("</div>", ":", $hordata);
                    $hordata = str_replace("</p>", "+++", $hordata);
                    $hordata = str_replace("</td></tr>", "+++", $hordata);
                    $hordata = strip_tags($hordata);
                    $hordata = preg_replace("~[\s]+~", " ", $hordata);
                    $hordata = str_replace("+++", "\n", $hordata);

                    $return_zodiac = trim($hordata);
                    //$add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";

                    if ($time >= 8) {
                        echo $query = "replace into horoscope(sign,time,details) values ('" . mysql_escape_string($hor) . "','" . (date("Y-m-d ")) . "','" . mysql_escape_string($return_zodiac) . "')";
                        $result1 = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                    }
                }
            } else {
                $url = "http://my.horoscope.com/astrology/free-daily-horoscope-$hor.html";
                echo "<br>................$url.................<br>";
                $result = file_get_contents($url);

                if (preg_match("~<div class=\".+\" style=\".+\" id=\".+\">(.+)</div>~", $result, $match)) {
                    $data = strip_tags($match[1]);
                    $return_zodiac = trim($data);
                    $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";

                    if ($time >= 8) {
                        echo $query = "replace into horoscope(sign,time,details) values ('" . mysql_escape_string($hor) . "','" . (date("Y-m-d ")) . "','" . mysql_escape_string($return_zodiac) . "')";
                        $result1 = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                    }
                }
            }

            //end hanges made on 02/02/2012
//        var_dump($result);
//            $start = strpos($result, "Horoscope for");
//            if ($start != 0) {
//                $result = substr($result, $start);
//                $end = strpos($result, '<br />');
//                if ($end != 0) {
//                    $result = trim(substr($result, 0, $end));
//                    $result = str_replace('</h1>', ' *** ', $result);
//                    $result = strip_tags($result);
//                    $result = preg_replace("~[\s]+~", " ", $result);
//                    $result = str_replace(' *** ', "\n", $result);
//                    $return_zodiac = trim($result);
//                    $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
//                }
//                if ($time >= 8) {
//                    echo $query = "replace into horoscope(sign,time,details) values ('" . mysql_escape_string($hor) . "','" . (date("Y-m-d ")) . "','" . mysql_escape_string($return_zodiac) . "')";
//                    $result1 = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//                }
//            }
        }
    } else if ($horo_must) {
        $return_zodiac = "Sorry, no horoscope found for $hor_req\nSelect one.";
        $to_logserver['isresult'] = 0;
        $free = true;
        foreach ($zodiac as $key => $ti) {
            $options_list[] = strtoupper($ti);
            $list[] = array('content' => "horoscope $ti");
        }
    }
}
//    $url = "http://living.oneindia.in/astrology/astro/horoscope.php?func=change_sunsign&duration=daily&sunsign=$hor";
//    echo "<br>................$url.................<br>";
//    $data = file_get_contents($url);
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/aries.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/taurus.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/gemini.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/cancer.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/leo.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/virgo.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/scorpio.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/sagittarius.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/aquarius.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/pisces.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/libra.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//    $find = "<div class='sun_sign_horscope_top sun_sign_horscope'><img src='/astrology/astro/images/horoscope/capricorn.jpg' border='0' align='left' class='sunsign_image_alignment'>";
//    $data = (str_replace($find, "", $data));
//
//    $data = (str_replace('</div>', "", $data));
//    $data = trim($data);
?>
