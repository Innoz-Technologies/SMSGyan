<?php

if ($spell_checked == "inter" || $spell_checked == "inter result") {
    $total_return = "To know ANDHRA PRADESH IPE result SMS INTER <your rollnumber> to $shortcode";
    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'apInter';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~\b^(inter|ipe2|inter result|ipe|ipe result)(.+)\b~si", $spell_checked, $match)) {
//    var_dump($match);
    echo $apinter = $match[0];
    if (preg_match("~\b([\d]{10})\b~", $apinter, $matchn)) {
        $rollno = $matchn[1];
        echo $url = "http://www.results.manabadi.co.in/Inter2YR2013.aspx?htno=$rollno&bustcache=1366975956936";
        $content = file_get_contents($url);

        $result = explode('|', $content);

        $out = '';

        if (count($result) >= 68) {

            $out.=trim($result[2]) . "(" . trim($result[0]) . ")\n";
            $out .= trim($result[3]) . ": " . trim($result[4]) . "(" . trim($result[6]) . ")\n";
            $out .= trim($result[7]) . ": " . trim($result[8]) . "(" . trim($result[10]) . ")\n";
            $out .= trim($result[11]) . ": " . trim($result[12]) . "(" . trim($result[14]) . ")\n";
            $out .= trim($result[15]) . ": " . trim($result[16]) . "(" . trim($result[18]) . ")\n";
            $out .= trim($result[19]) . ": " . trim($result[20]) . "(" . trim($result[22]) . ")\n";
            $out .= trim($result[23]) . ": " . trim($result[24]) . "(" . trim($result[26]) . ")\n";
            $out .= trim($result[27]) . ": " . trim($result[28]) . "(" . trim($result[30]) . ")\n";
            $out .= trim($result[31]) . ": " . trim($result[32]) . "(" . trim($result[34]) . ")\n";
            $out .= trim($result[35]) . ": " . trim($result[36]) . "(" . trim($result[38]) . ")\n";
            $out .= trim($result[39]) . ": " . trim($result[40]) . "(" . trim($result[42]) . ")\n";
            $out .= trim($result[43]) . ": " . trim($result[44]) . "(" . trim($result[46]) . ")\n";
            $out .= trim($result[47]) . ": " . trim($result[48]) . "(" . trim($result[50]) . ")\n";
            $out .= trim($result[51]) . ": " . trim($result[52]) . "(" . trim($result[54]) . ")\n";
            $out .= trim($result[55]) . ": " . trim($result[56]) . "(" . trim($result[58]) . ")\n";
            $out .= "Total Mark : " . trim($result[67]) . "(" . trim($result[68]) . ")\n";

            $total_return = $out;
        }
    } else {
        $total_return = "Please check your register number and try again";
        $add_below = "To know ANDHRA PRADESH inter result SMS inter <your rollnumber> to $shortcode";
    }
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    include 'allmanip.php';
    $to_logserver['source'] = 'apInter';
    putOutput($total_return);
    exit();
}



//        var_dump($matchn);
//        echo $rollno = $matchn[1];
//
//        echo $url = "http://examresults.ap.nic.in/Gen/Inter1GENResults.asp";
//        $fields_string = "rollno=$rollno&B1=Submit";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host:examresults.ap.nic.in",
//            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2",
//            "Referer: http://examresults.ap.nic.in/Gen/Inter1GENGetRoll.htm",
//            "Content-Length: " . strlen($fields_string),
//            "Content-Type: application/x-www-form-urlencoded",
//            "Cookie: qsgr=1; qidxr=1; QUADIDX=3; qsg=4174; __utma=87642394.1828245828.1338356764.1338356764.1338356764.1; __utmb=87642394; __utmc=87642394; __utmz=87642394.1338356765.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none); qsmo=1"));
//        $result = curl_exec($ch);
//        curl_close($ch);
//        if (preg_match("~<table width=\"59%\" border=1 cellspacing=\"0\" bgcolor=\"#D7F2FF\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" cellpadding=\"0\">(.+)<a href=\"Inter1GENGetRoll.htm\">~Usi", $result, $match)) {
////    print_r($match);
//            $out = $match[1];
//            $out = trim(preg_replace("~[\s]+~", " ", $out));
//            $out = trim(str_replace("</tr>", "***", $out));
////            $out = trim(str_replace("</font></td>", "***", $out));
//            $out = strip_tags($out);
//            $out = html_entity_decode($out);
//            $out = trim(preg_replace("~[\s]+~", " ", $out));
//            $out = trim(str_replace("***", "\n", $out));
//            $out = trim(str_replace("\n\n", "\n", $out));
//            $out = trim(str_replace("\n ", "\n", $out));
//            $out = trim(str_replace("I year Paper  ENGLISH PAPER -I  SANSKRIT PAPER-I MATHEMATICS PAPER-I(A)  MATHEMATICS PAPER-I(B)  PHYSICS PAPER-I   CHEMISTRY PAPER-I", "Eng-I Sans-I Maths-I (A) Maths-I (B) Phy-I Che-I", $out));
//            echo $out;
//        }
//    }
//    if (!empty($out)) {
//        $total_return = $out;
//    } else {
//        $total_return = "Please check your register number and try again";
//        $add_below = "\n--\nTo know BIHAR 10th result SMS BSEB <your rollcode> <your rollnumber> to $shortcode";
//    }
//    if ($total_return) {
//        $source_machine = $machine_id;
//        $current_file = "/temp/$numbers";
//        file_put_contents(DATA_PATH . $current_file, $total_return);
//        include 'allmanip.php';
//        $to_logserver['source'] = 'bihar10';
//        putOutput($total_return);
//        exit();
//    }
//}
?>
