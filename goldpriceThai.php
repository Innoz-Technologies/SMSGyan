<?php

$url = "http://www.goldrate24.com/gold-prices/asia/thailand/";
$content = file_get_contents($url);

if (preg_match('~</thead>(.+)</div>~Usi', $content, $match)) {
    //var_dump($match[1]);

    $golddata = trim($match[1]);
    $golddata = preg_replace('~[\s]+~', ' ', $golddata);
    $golddata = str_replace('</th>', '+++', $golddata);
    $golddata = str_replace('</tr>', '***', $golddata);
    $golddata = strip_tags($golddata);
    $golddata = str_replace('+++', ':', $golddata);
    $golddata = str_replace('***', "\n", $golddata);

    if (!empty($golddata))
        $golddata = "GoldUnit GoldPrice in(THB) GoldPrice in U.S Dollar\n" . $golddata;

    echo $golddata;
}

if (!empty($golddata)) {
    $total_return = $golddata;
    $to_logserver['source'] = 'gold';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
