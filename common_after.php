<?php

include 'menuTemplate.php';

echo"<br>TIPS CONTENT<br>";
include 'tips_content.php';

echo '<br>Quotes<br>';
include 'quotes.php';

include 'tennis_sportskeda.php';
include 'football_sportskeeda.php';

echo '<br>Currency Converter<br>';
include 'cur_converter.php';

echo"<br>whatthefact<br>";
include 'whattheffacts.php';

include 'googleLocal.php';


echo"<br>TIPS CONTENT<br>";
include 'classAids.php';

//Greeting Card
include 'match_gc_new.php';

//message
include 'message.php';

if ($hor_res) {
    include 'sign_comp.php';
    include 'horoscopeYr.php';
    include 'match_horoscope.php';
}

include 'xmas.php';

include 'wishlist.php';

include 'resolution.php';

//recipe
include 'recipe.php';

//localmovie list
include 'localmovielist.php';

//VIDEO SEARCH
if (substr($req, 0, strlen('video_id')) == 'video_id') {
    preg_match("~video_id (.+)~", $req, $match);
    if ($match[1] == 'zEH6KFonIUg') {
        $vid = kript($numbers, $match[1]);
        $free = false;
        $showsuboption = false;
        $service_name = 'hfz';
        $product_name_tag = 'HFZ';
        $charge_per_query = 3;
        $video_url = "http://domaim/video/watch.php?v=$vid ";

    } else {

        $video_url = "http://domain/w?cid=$match[1]";
    }
    $total_return = $video_url;

    $total_return .= "\n$brows_charge";

    echo '<br>' . $total_return;
    $to_logserver['source'] = 'video';
    putOutput($total_return);
    exit();
} if (substr($req, 0, strlen('__mwiki__image__')) == '__mwiki__image__') {
    preg_match("~__mwiki__image__(.+)~", $req, $match);
    if (( ($circle == 'NE' || $circle == 'AS' ) && !$free ) || $circle == 'DL') {
        $charge_per_query = 3;
        $free = false;
        $showsuboption = false;
    }

    if (strpos($match [1], "x__") !== false) {
        $im_type = "x";
        $im_content = str_replace("x__", "", $match[1]);
    } else {
        if ($operator == 'aircel') {
            $im_type = "w";
        } else {
            $im_type = "v";
        }
        $im_content = $match [1];
    }
    $img_id = kript($numbers, $im_content, $im_type);
    $image_url = "http://domain/w/?id=$img_id";
    $total_return = $image_url;
    if ($operator == 'airtel') {
        $total_return .= "\n$brows_charge";
    }
    echo '<br>' . $total_return;
    $to_logserver['source'] = 'photo';
    putOutput($total_return);
    exit();
}

if (preg_match("~(http://([\w\d]{,4}\.)?[\w\d-]+\.[\w]{2,4}(\.[\w]{2,4})?)\b~", $req, $match)) {
    echo "<br>URL FOUND: ";
    echo $requrl = $match[1];
} elseif (preg_match("~(([\w\d]{,4}\.)?[\w\d-]+\.[\w]{2,4}(\.[\w]{2,4})?)\b~", $req, $match)) {
    echo "<br>URL FOUND: ";
    echo $requrl = "http://$match[1]";
}
echo "<h3>City </h3>";
include 'msi_city.php';

if ($spell_checked == 'bhitarkanika mangroves') {
    $options_list[] = "Bhitarkanika National Park";
    $list[] = array("content" => "bhitarkanika national park");
}
//IDENTIFY KEYWORDS<bR>';
$isMsi = false;

$weather_word = trim(remwords($spell_checked));

include 'lyricsOpnList.php';

//include 'linkedin.php';

echo $spell_checked;

echo "<h2>BEFORE WEATHER RESULT : </h2>" . $weather_word;

//Love and Flame Calculator
include 'loveFlame.php';
?>
