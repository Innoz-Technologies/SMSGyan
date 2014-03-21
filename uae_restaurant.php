<?php

if (preg_match('~^(hotels?|restaurants?|food)$~', $req)) {

    echo "<h2>Inside DU restaurant</h2>";
    $total_return = "Please select your city";

    $options_list[] = "Dubai";
    $list[] = array("content" => "__uae__hotel__dubai__");

    $options_list[] = "Sharjah";
    $list[] = array("content" => "__uae__hotel__sharjah__");

    $options_list[] = "Abu Dhabi";
    $list[] = array("content" => "__uae__hotel__abudhabi__");
} elseif (preg_match('~__uae__hotel__(.+)__~', $req, $matches)) {

    $city = trim($matches[1]);
    $url = "http://www.zomato.com/$city";

    $total_return = "Trending restaurants in $city";

    $data_list = get25hotelsuae($url);

    $options_list = $data_list['options_list'];
    $list = $data_list['list'];
} elseif (preg_match('~__uae__url__(.+)__~', $req, $match)) {
    $url = trim($match[1]);

    $data = getaddressuae($url);
    $total_return = $data;
} elseif (preg_match('~^(hotels?|restaurants?|food) (.+)~', $req, $match)) {

    $total_return = "Please select your city";

    $search = trim($match[2]);

    $options_list[] = "Dubai";
    $list[] = array("content" => "__uae__search__dubai__" . $search . "__");

    $options_list[] = "Sharjah";
    $list[] = array("content" => "__uae__search__sharjah__" . $search . "__");

    $options_list[] = "Abu Dhabi";
    $list[] = array("content" => "__uae__search__abudhabi__" . $search . "__");
} elseif (preg_match('~__uae__search__(.+)__(.+)__~', $req, $matches)) {
    $city = trim($matches[1]);
    $query = trim($matches[2]);

    echo $url = "http://www.zomato.com/$city/restaurants?q=$query";

    $data = getuaehotelcity($url);
    if (isset($data['options_list'])) {
        $total_return = "Your query matches more than one result";
        $options_list = $data['options_list'];
        $list = $data['list'];
    } elseif (isset($data['url'])) {
        $data = getaddressuae($data['url']);
        $total_return = $data;
    } else {
        $total_return = "No hotels found matching your query";
    }
} elseif (preg_match('~__uae__citywisehotel__(.+)__~', $req, $match)) {
    $url = trim($match[1]);
    $url_next = "http://www.zomato.com/$url";

    $data = getaddressuae($url_next);
    $total_return = $data;
}

if (!empty($total_return)) {
    $to_logserver['source'] = 'dufood';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function get25hotelsuae($url) {
    $content = file_get_contents($url);

    if (preg_match_all('~<h4 class="top-res-box-name"><span>(.+)</span></h4>~Usi', $content, $matches)) {

        foreach ($matches[1] as $opt) {
            $options_list[] = $opt;
        }
    }

    if (preg_match_all('~<a class="left" href="(.+)".+>~Usi', $content, $matched)) {
        foreach ($matched[1] as $data) {
            $list[] = array("content" => "__uae__url__" . $data . "__");
        }
    }


    $return['options_list'] = $options_list;
    $return['list'] = $list;

    var_dump($return);

    return $return;
}

function getaddressuae($url) {

    $content = file_get_contents($url);

    if (preg_match('~<h4 class="res-main-address-text.+>(.+)</h4>~Usi', $content, $match)) {
        $address = $match[1];
        $address = strip_tags($address);
        $address = "Address: $address";
    }

    if (preg_match('~<span class="tel">(.+)</span>~Usi', $content, $match)) {
        $phno = $match[1];
        $phno = strip_tags($phno);
        $phno = "Phone No: $phno";
    }

    if (preg_match('~<span class="res-info-timings">(.+)</span>~Usi', $content, $match)) {
        $timngs = $match[1];
        $timngs = strip_tags($timngs);
        $timngs = "Timings: $timngs";
    }

    $data = $address . "\n" . $phno . "\n" . $timngs;

    if (!empty($data))
        return $data;
    else
        return "No hotels found";
}

function getuaehotelcity($url) {
    $content = file_get_contents($url);

    if (preg_match_all('~<h3 class="top-res-box-name ln24 left">.+<a.+href="(.+)".+title="(.+)".+</a>.+</h3>~Usi', $content, $match)) {
        var_dump($match);
        if (count($match[1]) > 1) {
            for ($i = 0; $i < count($match[1]); $i++) {
                $options_list[] = trim($match[2][$i]);
                $list[] = array("content" => "__uae__citywisehotel__" . $match[1][$i] . "__");
            }
            $return['options_list'] = $options_list;
            $return['list'] = $list;
        } else {
            $url_next = "http://www.zomato.com/" . $match[1][0];
            $return['url'] = $url_next;
        }
    }
    return $return;
}

?>
