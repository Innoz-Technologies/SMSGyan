<?php

foreach ($search_url as $surl) {
    if (preg_match("~http://www.deccanherald.com/.+/.+/.+.html~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'deccan';
        break;
    } elseif (preg_match("~http://timesofindia.indiatimes.com/.+.cms~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'toi';
        break;
    } elseif (preg_match("~http://.+.reuters.com/.+~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'reuters';
        break;
    } elseif (preg_match("~http://ibnlive.in.com/.+.html~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'ibn';
        break;
    } elseif (preg_match("~http://www.ndtv.com/.+~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'ndtv';
        break;
    } elseif (preg_match("~http://www.bbc.co.uk/.+~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'bbc';
        break;
    } elseif (preg_match("~http://www.cricbuzz.com/.+~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'cricbuz';
        break;
    } elseif (preg_match("~http://www.mid-day.com/.+.htm~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'midday';
        break;
    } elseif (preg_match("~http://www.thehindu.com/.+.ece~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'hindu';
        break;
    } elseif (preg_match("~http://entertainment.oneindia.in/.+/.+/.+/.+.html~Usi", $surl, $match)) {
        print_r($match);
        echo $match_url = 'entertainment';
        break;
    }
}
//echo $match;
switch ($match_url) {

    case 'deccan':
        include 'deccanherald.php';
        break;
    case 'toi':
        include 'timesofindia.php';
        break;
    case 'ibn':
        include 'ibn.php';
        break;
    case 'ndtv':
        include 'ndtv_final.php';
        break;
    case 'bbc':
        include 'bbc.php';
        break;
    case 'cricbuz':
        include 'cricbuzz.php';
        break;
    case 'reuters':
        include 'reuters_final.php';
        break;
    case 'midday':
        include 'midday.php';
        break;
    case 'hindu':
        include 'hindu.php';
        break;
    case 'entertainment':
        include 'entertainment.php';
        break;
}
?>