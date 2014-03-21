<?php


echo '<h3>Inside Nepal Price FIRST </h3>';

echo $url = "http://pricenepal.com/search.php?search_query=" . urlencode(trim($cleared));
$content = httpGet($url);

if (preg_match_all('~<div class="center_block">(.+)</li>~Usi', $content, $matches)) {
//    var_dump($matches[1]);

    $i = 0;
    $out = array();
    $return = '';
    foreach ($matches[1]as $mob) {

        if (preg_match('~<h3><a href="(.+)" title=".+">(.+)</a></h3>~', $mob, $data)) {
            $out[$i]['url'] = $data[1];
            $out[$i]['title'] = $data[2];
        }
        if (preg_match('~<span class="price" style="display: inline;">(.+)</span>~', $mob, $price)) {
            $out[$i]['price'] = $price[1];
        }
        if (preg_match('~<p class="product_desc"><a.+>(.+)</a></p>~', $mob, $pdt)) {
            $out[$i]['pdt'] = $pdt[1];
        }
        $i++;
    }

    if ($i > 1) {
        $total_return = 'Your query matches more than one result';
        foreach ($out as $data) {
            $options_list[] = $data['title'] . "(" . $data['price'] . ")";
            $list[] = array("content" => "__nepalprice__" . $data['url'] . "__");
        }
        var_dump($options);
        var_dump($list);
    } else {

        $pdt_url = trim($out[0]['url']);

        $details = getNepaldetails($pdt_url);

        $total_return.="Name : " . $out[0]['title'] . "\n";
        $total_return.="Price : " . $out[0]['price'] . "\n";
        $total_return.=$details;
    }

    echo $total_return;
}

if (!empty($total_return)) {
    include 'allmanip.php';
    $to_logserver['source'] = 'price_nepal';
    putOutput($total_return);
    exit();
}



?>