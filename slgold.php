<?php

$data = apc_fetch('SLGOLD', $success);

if (!$success) {
    $url = "http://www.goldpricerate.com/english/gold-price-in-sri_lanka.php";
    $content = file_get_contents($url);

    if (preg_match('~<td class="serving" colspan="2">(.+)</div>~Usi', $content, $match)) {
        $data = trim($match[1]);
        $data = trim(preg_replace("~[\s]+~", " ", $data));
        $data = trim(str_replace("</tr>", "***", $data));
        $data = strip_tags($data);
        $data = trim(preg_replace("~[\s]+~", " ", $data));
        $data = trim(str_replace("***", "\n", $data));
        $data = trim(str_replace("\n ", "\n", $data));

        if (!empty($data))
            apc_store('SLGOLD', $data, 300);
    }
}
if (!empty($data)) {
    $total_return = "Gold Price Today in Sri Lanka Rupee (LKR)\n" . $data;
    $source_machine = $machine_id;
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'slgold';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>