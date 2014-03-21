<?php

//if (preg_match("~^(sms )?(trace|trase|track) ?(number|no\.|no)?[\s]?[.,]?[\s]?[\+]?[^\w]+(\w+[^?]*)~", $query_alphabets, $match)) {
//    echo "<br>In Trace......";
//    $word = $match[4];
//    $word = str_ireplace(">", '', $word);
//    $word = str_ireplace("<", '', $word);
//    $word = str_ireplace("space", '', $word);
//    $word = str_ireplace("no", '', $word);
//    $musttrace = true;
//    include 'trace.php';
//    putOutput($trace_return);
//    exit();
//}

if (strlen($req) < 30 || strpos($query_alphabets, 'trace') !== FALSE || strpos($query_alphabets, 'truecaller') !== FALSE) {
    echo "<br>TRACE";
    $to_trace = '';
    if (preg_match("~\b(\+?91|0)?([1-9][\d]{9})\b~", $req, $match)) {
        echo "<br>TRACE MOBILE NUMBER";
        $flag_enabled = false;
        $word = $match[2];
        $to_trace = $match[0];
        include 'traceNew.php';
//        $trace_return="Sorry, No trace information found for $req";
        if ($trace_return) {
            $total_return = $trace_return . "\n" . $trace_append;
            include 'allmanip.php';
            $to_logserver['source'] = 'trace_mobile';
            putOutput($total_return);
            exit();
        } elseif ($trace_append) {
            $total_return = $trace_append;
            include 'allmanip.php';
            $to_logserver['source'] = 'regchat';
            putOutput($total_return);
            exit();
        }
    }
    if (preg_match("~\b([a-z]{2})[^\w\d]*([\d]{1,2})[^\w\d]*([a-z]{1,2})[^\w\d]*([\d]{1,4})~", $req, $match)) {
        echo "<br>TRACE VEHICLE NUMBER";
        $state = $match[1];
        $dist = $match[2];
        if ($match[2] > 9) {
            $to_trace = "$match[1]-$match[2]-$match[3]-" . (int) $match[4];
        } else {
            $to_trace = "$match[1]-0" . (int) $match[2] . "-$match[3]-" . (int) $match[4];
        }
        include 'trace_vehicle.php';
//        $trace_return = "Sorry, No trace information found for $req";
        if ($trace_return) {
            $total_return = $trace_return;
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            include 'allmanip.php';
            $to_logserver['source'] = 'trace_vehicle';
            putOutput($total_return);
            exit();
        }
    } elseif (preg_match("~\b([a-z]{2})[^\w\d]*([\d]{1,2})[^\w\d]+([\d]{1,4})~", $req, $match)) {
        echo "<br>TRACE VEHICLE NUMBER";
        $state = $match[1];
        $dist = $match[2];
        if ($match[2] > 9) {
            $to_trace = "$match[1]-$match[2]-$match[3]";
        } else {
            $to_trace = "$match[1]-0" . (int) $match[2] . "-$match[3]";
        }
        $to_trace = "$match[1]-$match[2]-" . (int) $match[3];

        include 'trace_vehicle.php';
//        $trace_return = "Sorry, No trace information found for $req";
        if ($trace_return) {
            $total_return = $trace_return;
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            include 'allmanip.php';
            $to_logserver['source'] = 'trace_vehicle';
            putOutput($total_return);
            exit();
        }
    } else if (preg_match("~\bk([a-z]{2})[^\w\d]*([\d]{1,4})~", $req, $match)) {
        echo "<br>TRACE VEHICLE NUMBER";
        $state = 'kl';
        $to_trace = "k$match[1]-" . (int) $match[2];
        include 'trace_vehicle.php';
//        $trace_return = "Sorry, No trace information found for $req";
        if ($trace_return) {
            $total_return = $trace_return;
            include 'allmanip.php';
            $to_logserver['source'] = 'trace_vehicle';
            putOutput($total_return);
            exit();
        }
    }

    if (strpos($spell_checked, 'trace') !== false && strpos($spell_checked, 'trace') == 0) {
        $free = true;
        if ($to_trace) {
            $total_return = "Sorry, No trace information found for $to_trace.";
        } else {
            $total_return = "Sorry, No trace information found for Your Query.";
        }
        $to_logserver['source'] = 'trace_vehicle';
        $to_logserver['isresult'] = 0;
        putOutput($total_return);
        exit();
    }
}
?>