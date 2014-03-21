<?php

$msisdn = $_GET["msisdn"];
if (isset($_GET["operator"])) {
    $operator = $_GET["operator"];
    $operator = strtolower($operator);
}
else
    $operator = "airtel";

if (strlen($msisdn) != 10) {
    if (substr($msisdn, 0, 2) == "91") {
        $msisdn = substr($msisdn, 2);
    } else if (substr($msisdn, 0, 1) == "+") {
        $msisdn = substr($msisdn, 3);
    } else if (substr($msisdn, 0, 1) == "0") {
        $msisdn = substr($msisdn, 1);
    }
}

if (!empty($msisdn) && strlen($msisdn) == 10) {
    $code = random_string(4);
    include 'configdb2.php';

    $query = "INSERT INTO `wapCode` ( `msisdn` , `code` ) VALUES ('" . $msisdn . "','" . $code . "')";
    if (mysql_query($query)) {

        $circle_arr = array();
        if (($data = apc_fetch("circles_waps"))) {
            // It was stored, return the value
            $circle_arr = $data;
        } else {
            $circles_file = fopen("NPDP.csv", "r");
            while ($data = fgetcsv($circles_file, 0, ',')) {
                $circle_arr[$data[0]] = $data[2];
            }
            apc_store("circles_waps", $circle_arr);
        }

        $minDigit = 5;
        $circle = "";
        while ($minDigit != 3) {
            $series = substr($number, 0, $minDigit);
            if (isset($circle_arr[$series])) {
                $circle = $circle_arr[$series];
                break;
            }
            $minDigit = $minDigit - 1;
        }

        if (empty($circle))
            $circle = 'XX';

        if ($operator == "airtel" || $operator == "aircel" || $operator == "idea" || $operator == "loop" || $operator == "docomo" || $operator == "vodafone") {
            $msg = "Your $msisdn : 55444 app registration code is : $code";
            $q_p = "INSERT INTO `push_q`(`msisdn`, `circle`, `operator`, `response`) VALUES ('$msisdn','$circle','$operator','" . mysql_real_escape_string($msg) . "')";
            if (mysql_query($q_p)) {
                echo "OK";
            } else {
                echo "FAIL";
            }
        } else {
            echo "FAIL";
        }
//        
    }
}

function random_string($length) {
    $str = "";
    $chars = "aA1bB2cC3dD4eE5fF6gG7hH8iI9jJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str;
}

?>
