<?php

echo "<h2>From Cache </h2>" . $gold_rates = apc_fetch("gold_price_response", $success);
if (!$success) {
    date_default_timezone_set('Asia/Calcutta');
    $date_gold = date('g:ia jS M Y');

    $url = "http://www.goldonlineprice.com/gold-silver-india.html";
    $content = file_get_contents($url);

    if (preg_match('~<table width="100%" border="0" cellspacing="0" cellpadding="2">(.+)<td height=\'30\' align=\'left\' class=\'blkstory_KTFRX\' colspan=\'8\'>~Usi', $content, $match)) {
        $golddata = $match[1];
        $golddata = preg_replace("~[\s]+~", " ", $golddata);
        $golddata = str_replace("</td><td class=\"boldblacsmall\">", " ", $golddata);
        $golddata = str_replace("</td><td class='boldblacsmall'>", " ", $golddata);
        $golddata = str_replace("<td class='red' valign='middle' align='center'>", " ", $golddata);
        $golddata = preg_replace("~</td><td class='red' valign='middle' align='center'.+>~Usi", " ", $golddata);
        $golddata = str_replace("</tr>", "\n", $golddata);
        $golddata = strip_tags($golddata);
        $golddata = str_replace("\n  ", "\n", $golddata);
        echo $golddata;

        $gold_rates = $golddata;

        if (!empty($gold_rates)) {
            echo apc_store("gold_price_response", $gold_rates, 180);
        }
    }
//    echo $url = "http://www.silvergoldrate.in/";
//    $contents = httpGet($url);
//
//    if (preg_match("~<th class=\"column-1\">City</th><th class=\"column-2\">22K</th><th class=\"column-3\">24K</th>(.+)</tbody>~Usi", $contents, $match)) {
//        $gold = $match[1];
//        $gold = trim(preg_replace("~[\s]+~", " ", $gold));
//        $gold = str_replace("<td class=\"column-2\">", " : ", $gold);
//        $gold = str_replace("<td class=\"column-3\">", ",", $gold);
//        $gold = str_replace("</tr>", "***", $gold);
//        $gold = strip_tags($gold);
//        $gold = trim(preg_replace("~[\s]+~", " ", $gold));
//        $gold = str_replace("***", "\n", $gold);
//        $gold = trim(str_replace("\n\n", "\n", $gold));
//        $gold = trim(str_replace("\n ", "\n", $gold));
//
//        if (!empty($gold)) {
//            $gold_rates.= "Gold Rates[10 gram](City,22K,24K) on $date_gold\n" . $gold . "\n--------------\n";
//        }
//    }
//
//    if (preg_match("~<th class=\"column-1\">City</th><th class=\"column-2\">Silver 999</th>(.+)</tbody>~Usi", $contents, $match)) {
//        $silver = $match[1];
//        $silver = trim(preg_replace("~[\s]+~", " ", $silver));
//        $silver = str_replace("<td class=\"column-2\">", " : ", $silver);
//        $silver = str_replace("</tr>", "***", $silver);
//        $silver = strip_tags($silver);
//        $silver = trim(preg_replace("~[\s]+~", " ", $silver));
//        $silver = str_replace("***", "\n", $silver);
//        $silver = trim(str_replace("\n\n", "\n", $silver));
//        $silver = trim(str_replace("\n ", "\n", $silver));
//        if (!empty($silver)) {
//            $gold_rates.= "Silver Rates[1 kg](City,999) on $date_gold\n" . $silver;
//        }
//        echo $gold_rates;
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