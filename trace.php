<?php

$exp_circle = array("AP" => "Andhra Pradesh", "AS" => "Assam ", "BH" => "Bihar", "BR" => "Bihar", "DL" => "Delhi", "GJ" => "Gujarat", "HP" => "Himachal Pradesh", "HR" => "Haryana", "JK" => "Jammu & Kashmir", "KA" => "Karnataka", "KL" => "Kerala", "KO" => "Kolkata", "MH" => "Maharashtra", "MP" => "Madhya Pradesh", "MU" => "Mumbai", "NE" => "North East", "OR" => "Orissa", "PB" => "Punjab", "RJ" => "Rajasthan", "TN" => "Tamilnadu", "CH" => "Chennai", "UE" => "Uttar Pradesh (East)", "UW" => "Uttar Pradesh (West)", "WB" => "West Bengal", "MB" => "Mumbai");
$file_circle = fopen("NPDP.csv", "r");
$trace_return = '';
if (($data1 = apc_fetch("cir")) && ($data2 = apc_fetch("ope")) && ($data3 = apc_fetch("typ"))) {
    $cir_arr = $data1;
    $operator_arr = $data2;
    $type_arr = $data3;
    echo '<br>Already cached<br>';
} else {
    while ($data = fgetcsv($file_circle, 0, ',')) {
        $cir_arr[$data[0]] = $data[3];
        $operator_arr[$data[0]] = $data[2];
        $type_arr[$data[0]] = $data[5];
    }
    apc_store("cir", $cir_arr);
    apc_store("ope", $operator_arr);
    apc_store("typ", $type_arr);
}
$cir_arr['7387'] = "MH";
$cir_arr['7389'] = "MP";
$cir_arr['8292'] = "BH";
$cir_arr['7388'] = "UE";

$cir_arr['7304'] = "MH";
$cir_arr['7350'] = "MH";
$cir_arr['7385'] = "MH";
$cir_arr['7359'] = "GJ";

$operator_arr['7387'] = "AIRTEL";
$operator_arr['7389'] = "AIRTEL";
$operator_arr['8292'] = "AIRTEL";
$operator_arr['7388'] = "AIRTEL";

$operator_arr['7304'] = "AIRTEL";
$operator_arr['7350'] = "IDEA";
$operator_arr['7385'] = "AIRTEL";
$operator_arr['7359'] = "AIRTEL";

$type_arr['7387'] = "GSM";
$type_arr['7389'] = "GSM";
$type_arr['8292'] = "GSM";
$type_arr['7388'] = "GSM";

$type_arr['7304'] = "GSM";
$type_arr['7350'] = "GSM";
$type_arr['7385'] = "GSM";
$type_arr['7359'] = "GSM";
echo"<br>Trace Match:";
var_dump($word);
$num_word = trim($word);
if (strlen($num_word) == 10) {
    $level = substr($num_word, 0, 4);
    if (isset($cir_arr[$level])) {
        $type_service = $type_arr[$level];
        $operator_trace = $operator_arr[$level];
        $op_circle = $exp_circle[$cir_arr[$level]];

        if ($num_word == $numbers) {
            switch ($operator) {
                case 'airtel':
                    $operator_trace = "AIRTEL";
                    break;
                case 'docomo':
                    $operator_trace = "TATA_GSM";
                    break;
                case 'loop':
                    $operator_trace = "LOOP";
                    break;
                case 'vodafone':
                    $operator_trace = "VODAFONE";
                    break;
                case 'idea':
                    $operator_trace = "IDEA";
                    break;
                case 'idea55444':
                    $operator_trace = "IDEA";
                    break;
                case 'aircel':
                    $operator_trace = "AIRCEL";
                    break;
            }
        }
        
        $trace_return = "Service Provider : $operator_trace\nService Region : $op_circle\nService Type : $type_service";
        $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
    }
}
//else if (strlen($num_word) == 12) {
//    $level = substr($num_word, 2, 4);
//    if (isset($cir_arr[$level])) {
//        $type_service = $type_arr[$level];
//        $operator = $operator_arr[$level];
//        $op_circle = $exp_circle[$cir_arr[$level]];
//        $trace_return = "Service Provider : $operator\nService Region : $op_circle\nService Type : $type_service";
//    }
//} else if (strlen($num_word) == 11) {
//    $level = substr($num_word, 1, 4);
//    if (isset($cir_arr[$level])) {
//        $type_service = $type_arr[$level];
//        $operator = $operator_arr[$level];
//        $op_circle = $exp_circle[$cir_arr[$level]];
//        $trace_return = "Service Provider : $operator\nService Region : $op_circle\nService Type : $type_service";
//    }
//}
//if ($trace_return) {
//    if ($free == false) {
//
//        $addon = "\nOPTIONS (Reply with option, eg. 1):";
//        $key = 1;
//        if ($validity == 1) {
//            $addon .= "\n$key: UNLIMITED SEARCH AT Rs $price_point/day";
//        } else {
//            $addon .= "\n$key: UNLIMITED SEARCH AT Rs $price_point/$validity days";
//        }
//
//        $options = array();
//        $options[] = array("content" => "sub_gyan", "count" => 1);
//        $outs = serialize($options);
//        file_put_contents(DATA_PATH . "/lists/$numbers", $outs);
//        $q = 'delete from lists where number="' . $numbers . '"';
//        mysql_query($q) or trigger_error(mysql_error() . " in $lq", E_USER_ERROR);
//        $q = 'insert into lists (machine_id,number,query_id) VALUES ("' . $machine_id . '","' . $numbers . '","' . $query_id . '")';
//        mysql_query($q) or trigger_error(mysql_error() . " in $lq", E_USER_ERROR);
//        $trace_return = $trace_return . "\n--\n$addon" . "\nInternet search on sms! Sms HELP to $shortcode to find out more. (Tollfree)";
//        //$trace_return = $trace_return . "\n--\n$addon" . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name>TO <friends name> to $shortcode @ Rs. 3.";
//    } else if ($musttrace){
//        $trace_return = $trace_return . "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more. (Tollfree)";
//        //$trace_return = $trace_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
//    }
//}
?>