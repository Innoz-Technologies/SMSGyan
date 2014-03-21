<?php

$gold_rates = apc_fetch('gold_price_response_aed', $success);

if (!$success) {
    $url = "http://www.khaleejtimes.com/forex.asp";
    $content = file_get_contents($url);
//var_dump($content);
    if (preg_match("~<div id=\"futurbox\">(.+)</div>~Usi", $content, $match)) {
        $gprice = $match[1];
        $gprice = trim(preg_replace("~[\s]+~", " ", $gprice));
        $gprice = trim(str_replace("</tr>", "***", $gprice));
        $gprice = trim(str_replace("<td valign=\"middle\" class=\"boldgray\"></td>", "<td valign=\"middle\" class=\"boldgray\">-</td>", $gprice));
        $gprice = strip_tags($gprice);
        $gprice = trim(preg_replace("~[\s]+~", " ", $gprice));
        $gprice = trim(str_replace("***", "\n", $gprice));
        $gprice = clean($gprice);
        $gprice = trim(str_replace("\n ", "\n", $gprice));
        $gprice = trim(str_replace("Source: Dubai Gold &amp; Jewellery Group", "", $gprice));
        echo $gprice;
    }

    if (preg_match("~<div id=\"westfocusbottom_KTFRXbusiness\">(.+)<td height=\"50\" class=\"title_KTFRX\">.+</td>~Usi", $content, $match)) {
        $sprice = $match[1];
        $sprice = trim(preg_replace("~[\s]+~", " ", $sprice));
        $sprice = trim(str_replace("</tr>", "***", $sprice));
        $sprice = trim(str_replace("<td valign=\"middle\" class=\"boldgray\"><div align=\"center\"></div></td>", "<td valign=\"middle\" class=\"boldgray\"><div align=\"center\">-</div></td>", $sprice));
        $sprice = strip_tags($sprice);
        $sprice = trim(preg_replace("~[\s]+~", " ", $sprice));
        $sprice = trim(str_replace("***", "\n", $sprice));
        $sprice = clean($sprice);
        $sprice = trim(str_replace("\n ", "\n", $sprice));
        $sprice = trim(str_replace("Source: Dubai Gold &amp; Jewellery Group", "", $sprice));
        echo $sprice;
    }


    $gold_rates = $gprice . "\n" . $sprice;
    $gold_rates = str_replace("TYPE Morning Evening Yesterday", "", $gold_rates);
    apc_store("gold_price_response_aed", $gold_rates, 1800);
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
