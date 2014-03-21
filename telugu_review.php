<?php

echo "<h2>TELUGU MOVIE REVIEW</h2>";

$ajax_query = trim(strtolower($insr_movie));

echo "MOVIE TILLE: $ajax_query</br>";

$url = "http://www.galatta.com/ajax_reviews.php";
$fields_string = "page=1&typ=search&review_search_name=$ajax_query&language_id=2";
$arrHeader = array("Content-Length:" . strlen($fields_string),
    "Cookie:PHPSESSID=skmislthp1bp49v6tur5amctc1; __utma=101034135.985956242.1350460510.1350460510.1350480752.2; __utmc=101034135; __utmz=101034135.1350460510.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __gads=ID=3302f6f1d9c370f0:T=1350460507:S=ALNI_Mbe8Df6b5h4Fxn39d5bTa7VQQ7Wqg; HstCfa1802789=1350460527029; HstCla1802789=1350481069474; HstCmu1802789=1350460527029; HstPn1802789=5; HstPt1802789=8; HstCnv1802789=2; HstCns1802789=2; c_ref_1802789=http%3A%2F%2Fwww.google.co.in%2Furl%3Fsa%3Dt%26rct%3Dj%26q%3D%26esrc%3Ds%26source%3Dweb%26cd%3D7%26ved%3D0CFQQFjAG%26url%3Dhttp%253A%252F%252Fwww.galatta.com%252Ftelugu%252Freviews%252F%26ei%3Df2J-ULTKNsnirAflzYEI%26usg%3DAFQjCNHC4r7zpBByaH5da3E-SlfH5O9q1g%26cad%3Drja; __unam=f0ae9f7-13a6db85509-47ae7252-7; __qca=P0-1830232387-1350460527942; 4ed60db6288c336e86432ac251f40c7b=n5q3ivuk62ab1q64oomuc60mp7; session.counter=4; session.timer.start=1350480237; session.timer.last=1350480314; session.timer.now=1350480361; session.client.browser=Mozilla%2F5.0+%28Windows+NT+6.1%3B+rv%3A16.0%29+Gecko%2F20100101+Firefox%2F16.0; user_lastactive=1350480361; se_language_autodetected=1; MLRV_71802789=1350480790555; MLR71802789=1350480755000; __atuvc=2%7C42; __utmb=101034135.5.10.1350480752",
    "Host:www.galatta.com",
    "Referer:http://www.galatta.com/telugu/reviews/search/%20/");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
$result = curl_exec($ch);
curl_close($ch);

//echo $result;

$my_url = "";
$my_key = -1;

if (preg_match_all('~<a href="(.+)">(.+)</a>~', $result, $matches)) {
    var_dump($matches);
    foreach ($matches[2] as $key => $value) {

        echo "<br>loop : " . $tmp = trim(strtolower(str_replace("!", "", $value)));
        if ($tmp == $ajax_query) {
            echo "matched<br>";
            echo $my_key = $key;
            break;
        }
    }

    if ($my_key>=0) {
        $my_url = "http://www.galatta.com" . $matches[1][$my_key];
        echo "url set $my_url<br>";

        $movie_data = file_get_contents($my_url);
        if (preg_match('~<span class="description">(.+)</div>~Usi', $movie_data, $matches)) {
            $review = $matches[1];
            $review = strip_tags($review);
            $review = preg_replace('~[\s]+~', " ", trim(html_entity_decode($review)));

            echo "<br>" . $movie_return = $review;
        }
    }
}
?>
