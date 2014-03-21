<?php

if (preg_match("~^\b(fortune|luck) (.+)\b~", $req, $match) && str_word_count($req) <= 5) {

       $name = trim($match[2]);

    $result = getresultfortune($name);

    if (preg_match("~<h2>Your lucky number</h2>(.+)<table>~Usi", $result, $match)) {
        $data = $match[1];
        $data = preg_replace("~[\s]+~", " ", $data);
        $data = str_replace("</h1>", "\n", $data);
        $data = str_replace("\n  ", "\n", $data);
        $data = strip_tags($data);
        echo $data;
        $total_return = $data;

        if (!empty($total_return)) {
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = 'luckyNO';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}

function getresultfortune($name) {
    $url = "http://www.my-fortune-teller.com/luckynumber";
    $fields_string = "name=$name&today=y";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.my-fortune-teller.com", 'Referer: http://www.my-fortune-teller.com/luckynumber'));
    $result = curl_exec($ch);
    return $result;
}

?>
