<?php

if (preg_match('~^\bnamemean (.+)\b~si', $req, $match) && count($req) <= 5) {

    var_dump($match);
    $name = trim($match[1]);
    $content = getresultname($name);

    if (!empty($name)) {
        if (preg_match("~<div id=contentstart>(.+)</div>~Usi", $content, $match)) {
            $out = trim($match[1]);
            $out = str_replace("<p><b>", "***", $out);
            $out = str_replace("<br>", "***", $out);
            $out = str_replace("</b><p>", "+++", $out);
            $out = strip_tags($out);
            $out = html_entity_decode($out);
            $out = str_replace("***", "\n", $out);
            $out = str_replace("+++", "\n", $out);
            $total_return = $out;
        }


        if ($total_return) {
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = 'namemean';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}

function getresultname($name) {
    $url = "http://www.paulsadowski.com/NameData.asp";
    $fields_string = "strName=" . urlencode($name) . "&B1=Submit";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.paulsadowski.com", 'Referer: http://www.paulsadowski.com/Numbers.asp'));
    $result = curl_exec($ch);
    return $result;
}

?>
