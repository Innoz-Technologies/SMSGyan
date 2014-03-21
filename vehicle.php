<?php

$arEmirate = array("DXB" => "dubai", "SHJ" => "sharjah", "AJM" => "ajman", "UMQ" => "um al quewain", "RAK" => "ras al khaymah", "FUJ" => "al fujairah");
$vehicle_num = "";

if ($spell_checked == "fine" || $spell_checked == "fine") {
    $total_return = "Reply with your vehicle number Eg: 7xxx6. For your infomation it is live in following countries Dubai, Sharjah, Ajman, Um Al Quewain, Ras Al Khaymah and Al Fujairah";
    $arCacheData["du"]["expiry"] = date("Y-m-d H:i:s", strtotime(" +30 minute"));
} elseif (!empty($arCacheData["du"])) {
    if (preg_match("~\b([\d]{5})\b~", $spell_checked, $matchn)) {
        var_dump($matchn);
        $vehicle_num = $matchn[1];
        $spell_checked = "fine $vehicle_num";
    }
}

if (preg_match("~^fines? (.+)~", $spell_checked, $matchesD)) {
    echo $search = $matchesD[1];
    $code = "";

    if (empty($vehicle_num) && preg_match("~\b([\d]{5})\b~", $search, $matchn)) {
        var_dump($matchn);
        $vehicle_num = $matchn[1];
    }

    $search = str_replace($vehicle_num, "", $search);
    $search = str_replace("/", " ", $search);
    echo "<br>After removing:" . $search = trim(str_replace("-", " ", $search));

    if (!empty($search)) {
        $vehicle_emirate = array_search($search, $arEmirate);
    }

    if (empty($vehicle_emirate)) {
        $total_return = "Please select the Emirates";
        foreach ($arEmirate as $id => $value) {
            $options_list[] = $value;
            $list[] = array("content" => "__duemirated__" . $vehicle_num . "__" . $id . "__");
        }
    } else {
        $query = "SELECT * FROM `fine_du` WHERE `emid`='$vehicle_emirate'";
        $result = mysql_query($query);

        $total_return = "Please select the category";
        while ($row = mysql_fetch_array($result)) {
            $options_list[] = $row["category"];
            $list[] = array("content" => "__ducat__" . $vehicle_num . "__" . $vehicle_emirate . "__" . $row["catid"] . "__");
        }
    }
} elseif (preg_match("~__duemirated__(.+)__(.+)__~Usi", $req, $matchesD)) {
    $vehicle_num = $matchesD[1];
    $vehicle_emirate = $matchesD[2];

    $query = "SELECT  DISTINCT (catid) as cid, `category` FROM `fine_du` WHERE `emid`='$vehicle_emirate' order by catid";
    $result = mysql_query($query);

    $total_return = "Please select the category";
    while ($row = mysql_fetch_array($result)) {
        $options_list[] = $row["category"];
        $list[] = array("content" => "__ducat__" . $vehicle_num . "__" . $vehicle_emirate . "__" . $row["cid"] . "__");
    }
} elseif (preg_match("~__ducat__(.+)__(.+)__(.+)__~Usi", $req, $matchesD)) {
    $vehicle_num = $matchesD[1];
    $vehicle_emirate = $matchesD[2];
    $vehicle_cat = $matchesD[3];

    $query = "SELECT * FROM `fine_du` WHERE `catid`='$vehicle_cat' and `emid`='$vehicle_emirate'";
    $result = mysql_query($query);
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_array($result);
        $vehicle_code = $row["codeid"];
        $total_return = getFineResult();
    } else {
        $total_return = "Please select the Code";
        while ($row = mysql_fetch_array($result)) {
            $options_list[] = $row["code"];
            $list[] = array("content" => "__ducode__" . $vehicle_num . "__" . $vehicle_emirate . "__" . $vehicle_cat . "__" . $row["codeid"] . "__");
        }
    }
} elseif (preg_match("~__ducode__(.+)__(.+)__(.+)__(.+)__~Usi", $req, $matchesD)) {
    $vehicle_num = $matchesD[1];
    $vehicle_emirate = $matchesD[2];
    $vehicle_cat = $matchesD[3];
    $vehicle_code = $matchesD[4];

    $total_return = getFineResult();
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'trace_vehicle';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function getFineResult() {
    global $vehicle_cat, $vehicle_code, $vehicle_emirate, $vehicle_num;
    $out = $total_return = "";

    $content = httpTraceDu();
    if (preg_match('~<table class="srchrsult" width="100%" >(.+)</table>~Usi', $content, $matches)) {

        if (preg_match_all("~<td.+>(.+)</td>~Usi", $matches[1], $match)) {
//        var_dump($match);
            foreach ($match[1] as $id => $val) {
                if ($id % 8 != 3 && $id % 8 != 5 && $id % 8 != 0) {
                    $val = strip_tags($val);
                    $val = trim(preg_replace("~[\s]+~", " ", $val));
                    $val = str_replace("More Info Violations ", "Violations: ", $val);
                    $val = str_replace(" Location", "\nLocation: ", $val);
                    $val = trim(preg_replace("~Location:(.+)/~Usi", "Location: ", $val));
                    $val = preg_replace('/[^A-Za-z0-9\-\\s\:]/', '', $val);
                    if ($id % 8 == 4)
                        $val = "Fine Amount: " . $val . " AED";
                    elseif ($id % 8 == 6)
                        $val = "Fine Nummber: " . $val;
                    elseif ($id % 8 == 1)
                        $val = "Date: " . $val;
                    elseif ($id % 8 == 2)
                        $val = "Source: " . $val;
                    $out .= $val . "\n";
                }
            }
            var_dump($out);
        }

        echo $query = "SELECT * FROM `fine_du` WHERE  `emid`='$vehicle_emirate' AND `catid`='$vehicle_cat' AND `codeid`='$vehicle_code'";
        $result = mysql_query($query);

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);

            $total_return = $row["emirates"] . " - " . $row["category"] . " - " . $row["code"] . " - " . $vehicle_num . "\n" . $out;
        }
    }
    return $total_return;
}

function httpTraceDu() {
    global $vehicle_cat, $vehicle_code, $vehicle_emirate, $vehicle_num;

    $url = "API";
    $field_strings = "searchMethod=1&isPlCListDisbaled=false&selectedTicketIds=&selectedCircularIds=&selectedLocalIds=&paymentType=&totalAmountOfFines=&totalNoOfFine=&searchCriteria=&q=&searchType=1&plateNo=" . $vehicle_num . "&plateSource=" . $vehicle_emirate . "&plateCategory=" . $vehicle_cat . "&plateCodeId=" . $vehicle_code;

    $curl = curl_init();
    $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
    $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: close";
    $header[] = "Accept-Charset: ISO-8859-1;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: ";
    $header[] = "Cookie:JSESSIONID=ac18074230dd24cac9a46d2a4836ab4bb5de3f060588.e34QchqMbN4Oc40LaNaPbhiSahiSe6fznA5Pp7ftolbGmkTy";

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $field_strings);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_REFERER, 'http://traffic.rta.ae/trfesrv/public_resources/ffu/fines-payment.do?actionParam=doSearch&searchMethod=2');
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);

    $html = curl_exec($curl);
    if (curl_error($curl)) {
        trigger_error(curl_error($curl), E_USER_WARNING);
    }
    curl_close($curl);
    if (empty($html)) {
        $html = "Sorry!! Internal server error. Please try again later.";
    }
    return $html;
}

?>
