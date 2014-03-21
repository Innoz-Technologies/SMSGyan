<?php

//ini_set("display_errors","on");
//error_reporting(E_ALL);
//include 'functions.php';
$url = 'http://www.sify.com/finance/';
$sify_response = httpGet($url);
$response = "";
echo "<br>SIFY RESPONSE<br>";
//echo $sify_response;
echo "<br>";
$gold_rates = "";
if (strpos($sify_response, 'gold rates')) {
    $p1 = strpos($sify_response, 'gold rates');
    $p2 = strpos($sify_response, 'investor tips', $p1);
    $part = substr($sify_response, $p1, $p2 - $p1);
//    echo $part;
    preg_match_all('~<table.+</table>~Us', $part, $parts);
    print_r($parts);
    echo $parts[0][0];
    echo $parts[0][2];
    preg_match_all('~<td align="left".+class="border-R arial12black-n">(.+)</td>~', $parts[0][0], $matches);
//    print_r($matches);
    $cities = $matches[1];
    preg_match_all('~<td align="left".+class="arial12black-n">(.+)<span class=".+">(.+)</span></td>~', $parts[0][0], $matches);
    print_r($matches);
    $gold_p = $matches[1];
    $gold_c = $matches[2];
    preg_match_all('~<td align="left".+class="arial12black-n">(.+)<span class=".+">(.+)</span></td>~', $parts[0][2], $matches);
    print_r($matches);
    $silver_p = $matches[1];
    $silver_c = $matches[2];

    foreach ($cities as $k => $city) {
        $response .= $city . ":\nGold(10g):" . $gold_p[$k] . $gold_c[$k] . "\nSilver(1Kg):" . $silver_p[$k] . $silver_c[$k] . "\n";
    }

    $gold_rates = $response;
    apc_store("gold_price_response", $gold_rates, 43200);
} else {
    echo "<br>From Cache<br>";
    $gold_rates = apc_fetch("gold_price_response");
}
?>
