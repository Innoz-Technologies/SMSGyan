<?php

$content = file_get_contents('http://www.daily-gold-price.com/gold-price-in-pakistan.php');

if (preg_match_all('~<td nowrap="nowrap">PKR</td>(.+)</tr>~Usi', $content, $match)) {
    //var_dump($match[1]);

    if (preg_match_all('~<td>(.+)</td>~', $match[1][0], $matches)) {
        //var_dump($matches);
        $gold = "Gold Price\n";
        $gold.="Gold Ounce: " . $matches[1][0] . " PKR\n";
        $gold.="Gram Karat 24: " . $matches[1][1] . " PKR\n";
        $gold.="Gram Karat 22: " . $matches[1][2] . " PKR\n";
        $gold.="Gram Karat 21: " . $matches[1][3] . " PKR\n";
        $gold.="Gram Karat 18: " . $matches[1][4] . " PKR\n";
        $gold.="Gram Karat 14: " . $matches[1][5] . " PKR\n";
        $gold.="Gram Karat 12: " . $matches[1][6] . " PKR\n";
    }

    if (preg_match_all('~<td>(.+)</td>~', $match[1][1], $matches)) {
        $silver = "Silver Price\n";
        $silver.="Silver Ounce: " . $matches[1][0] . " PKR\n";
        $silver.="Silver Gram: " . $matches[1][1] . " PKR\n";
        $silver.="Silver Kilogram: " . $matches[1][2] . " PKR\n";
    }
    echo $gold . "\n" . $silver;

    if (!empty($gold)) {
        $total_return = "$gold\n$silver";
    }
}

if ($gold_rates) {
    $total_return = $gold_rates;
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    include 'allmanip.php';
    $to_logserver['source'] = 'gold';
    putOutput($total_return);
    exit();
}
?>