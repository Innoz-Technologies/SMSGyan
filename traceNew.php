<?php

$file_circle = fopen("NPDP1.csv", "r");
$trace_return = '';
if (($data1 = apc_fetch("opcir")) && ($data2 = apc_fetch("mobope")) && ($data3 = apc_fetch("optype"))) {
    $cir_arr = $data1;
    $operator_arr = $data2;
    $type_arr = $data3;
    echo '<br>Already cached<br>';
} else {
    while ($data = fgetcsv($file_circle, 0, ',')) {
        $cir_arr[$data[0]] = $data[1];
        $operator_arr[$data[0]] = $data[3];
        $type_arr[$data[0]] = $data[2];
    }
    apc_store("opcir", $cir_arr);
    apc_store("mobope", $operator_arr);
    apc_store("optype", $type_arr);
}

echo"<br>Trace Match:";
var_dump($word);
$num_word = trim($word);
if (strlen($num_word) == 10) {
    $minDigit = 5;
    while ($minDigit != 2) {
        $level = substr($num_word, 0, $minDigit);
        echo "<h3>Series is $level</h3>";
        if (isset($cir_arr[$level])) {
            $type_service = $type_arr[$level];
            $operator_trace = $operator_arr[$level];
            $op_circle = $cir_arr[$level];

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

            $trace_return1 = "Service Provider : $operator_trace\nService Region : $op_circle\nService Type : $type_service";
            $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
            break;
        }
        $minDigit = $minDigit - 1;
    }

    echo "<h2>$req</h2>";

    if ($operator == "vodafone") {
        $trace_return = $trace_return1;
    } else {

        echo "<h2>INCLUDE TRUECALLER</h2>";
        $conn = getAppDB2Con();

        echo $query = "select * from truecaller where number='$num_word' and ccode=91";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result)) {

            echo "<h2>INCLUDE DB</h2>";

            $row = mysqli_fetch_array($result);
            var_dump($row);

            $name = $row['name'];
            $score = $row['score'];
        } else {


            echo $url = "API";
            $ttime = microtime(true);
            $content = httpGet($url);
            $ttime = microtime(true) - $ttime;

            $log_count = count($to_logserver['urls']);

            $to_logserver['urls'][$log_count]['truecaller']['fetch_time'] = $ttime;
            $to_logserver['urls'][$log_count]['truecaller']['url'] = $url;


            $content = json_decode($content, TRUE);
            if (!empty($content['name'])) {

                $name = $content['name'];
                $score = $content['trueScore'];

                $query = "replace into truecaller(number,name,score,ccode) values ('$num_word','$name','$score',91)";
                $result = mysqli_query($conn, $query);

                $to_logserver['urls'][$log_count]['truecaller']['status'] = 1;
            } else {
                $msg = $content['message'];
                $to_logserver['urls'][$log_count]['truecaller']['status'] = 0;
            }
        }
        if (!empty($name)) {
//            if ($operator == "airtel")
//                $free = FALSE;

            $trace_return = "\nName: $name\nTruescore: $score\n" . $trace_return1;
            $add_below = "\n--\nPowered by Truecaller";
        }
        else
            $trace_return.="$trace_return1.\nNo additional data found for the given phone number";
    }
}
?>