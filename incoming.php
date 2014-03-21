<?php

ini_set("display_errors", "off");
error_reporting(E_ALL);
include 'functions.php';
set_error_handler("error_handler");
register_shutdown_function("on_exit");

$ip = $_SERVER['REMOTE_ADDR'];
//$data = implode(',', $_REQUEST) . ",$ip";
//$export = var_export($_REQUEST, true);
//file_put_contents("log/incoming.request.dmp", $export . "\n", FILE_APPEND);

$input = isset($_GET['input']) ? $_GET['input'] : '';
if ($input == "321*554") {
    $input = "";
}
$session_id = $_GET['session'];
$msisdn = $mobile = substr($_GET['msisdn'], 2);
$circle_id = $_GET['region'];

$dt_tm = date("Y-m-d H:i:s");
$log_data = "$dt_tm $ip $session_id $msisdn $circle_id " . urlencode($input);
put_file_contents("log/incoming.log", "$log_data\n", 5000000);

$ussd_name = 'ussd554';
$response = "Please try again.";
$freeflow = "FC";
$is_gc = false;

include 'product-details.php';
$product = new Product($circle_id, '554');

$product_name = $product->name;
$price_point = $product->price_point; //edited on 05/03/2012
$ussd_msg = $product->ussd_msg;
$single_conf = $product->single_confirmation;
$forced_pricepoint = 0;
$nowtime = date("Y-m-d H:i:s");

$channel = 5;
$service = "gyan";
$subs_table = "user_channels";
if ($circle_id == 'MH' || $circle_id == 'MB' || $circle_id == 'MU') {
    $channel = 6;
    $subs_table = "photo_search";
    $service = "photos";
//} else if ($circle_id == 'UPW' || $circle_id == 'UPE') {
//    $channel = 10;
//    $subs_table = "photo_search";
//    $service = "krishna";
//    $forced_pricepoint = 5;
} else if ($circle_id == "XXX") {
    $channel = 9;
    $subs_table = "photo_search";
    $service = "friendship";
}

$no_unsubscribe = false;
$single_conf_nite = false;

include 'configdb.php';

$dbnameni = 'niussd_q';
switch ($circle_id) {
    case 'DL':
    case 'UPW':
    case 'UPE':
    case 'PJ':
    case 'HR':
    case 'HP':
    case 'JK':
        $dbnameni = 'niussd_north';
        break;
    case 'AP':
    case 'KN':
    case 'CN':
    case 'KL':
    case 'TN':
        $dbnameni = 'niussd_south';
        break;
    case 'MB':
    case 'MH':
    case 'MP':
    case 'GJ':
    case 'RJ':
        $dbnameni = 'niussd_west';
        break;
    case 'KC':
    case 'WB':
    case 'OR':
    case 'BH':
    case 'NE':
    case 'AS':
        $dbnameni = 'niussd_east';
        break;
}
$niq = "UPDATE $dbnameni SET hits = hits +1 WHERE msisdn='$msisdn'";
mysql_query($niq) or trigger_error(mysql_error() . " in $niq", E_USER_WARNING);

if ($circle_id == 'GJ' && !isblacklisted($msisdn)) {
    $price_point = 1;
    $ussd_msg = str_replace("30", "1", $ussd_msg);
    $forced_pricepoint = 1;
}


//NESA PHOTO SEARCH
if (in_array($circle_id, array("NE", "AS", "DL"))) {
    if ($input != '') {
        switch (trim($input)) {
            case 1:
                //Katrina Kaif
                $message = "photo katrina kaif";
                include 'config_appdb.php';
                $query = "INSERT IGNORE INTO query_q(query,msisdn) VALUES('" . mysql_real_escape_string($message) . "', '$msisdn')";
                mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                mysql_close();
                $response = "Thank you for using Photo Search. You'll receive the photo soon.";
                $freeflow = "FB";
                exit();
                break;
            case 2:
                //Anna Hazare
                $message = "photo anna hazare";
                include 'config_appdb.php';
                $query = "INSERT IGNORE INTO query_q(query,msisdn) VALUES('" . mysql_real_escape_string($message) . "', '$msisdn')";
                mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                mysql_close();
                $response = "Thank you for using Photo Search. You'll receive the photo soon.";
                $freeflow = "FB";
                exit();
                break;
            case 3:
                //ask input
                $response = "Enter name";
                exit();
                break;
            default:
                $message = "photo $input";
                include 'config_appdb.php';
                $query = "INSERT IGNORE INTO query_q(query,msisdn) VALUES('" . mysql_real_escape_string($message) . "', '$msisdn')";
                mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
                mysql_close();
                $response = "Thank you for using Photo Search. You'll receive the photo soon.";
                $freeflow = "FB";
                exit();
            //invalid input
        }
    }

    $response = "Welcome to photo search\n";
    $response .= "Reply back with option (eg 1)\n";
    $response .= "1) Katrina kaif @ Rs 3\n";
    $response .= "2) Anna Hazare @ Rs 3\n";
    $response .= "3) Enter any name @ Rs 3";
    exit();
}

//Greeting Card
//var_dump($msisdn);
//var_dump($circle_id);
//if (in_array($circle_id, array("KL", "KN", "CN", "TN", "DL", "AP"))) {
////if($is_gc){
//    $query = 'insert into ussd_554(number,circle,channel,input) values("' . $mobile . '","' . $circle_id . '","' . $nowtime . '","' . mysql_real_escape_string($input) . '")';
//    mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//    mysql_close();
//    include 'configDB_up.php';
//    include 'greetings.php';
//    exit();
//}

$inserted = false;
//if (in_array($circle_id, array("NE", "AS"))) {
////if($is_gc){
//    $nowtime = date("Y-m-d H:i:s");
//    $query = 'insert into ussd_554(number,circle,channel,input) values("' . $mobile . '","' . $circle_id . '","' . $nowtime . '","' . mysql_real_escape_string($input) . '")';
//    mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//    $inserted = true;
//    include 'ind_spl.php';
//    if (apc_store("session_$session_id", $sessions, 300) === false) {
//        trigger_error("Cache update failed", E_USER_WARNING);
//    }
//    if ($isSub) {
//        $input = 1;
//    } else {
//        exit();
//    }
//}
//friendship special ..nmk..
/* if (in_array($circle_id, array("WB", "OR","KO","KC"))) {
  //if($is_gc){
  $nowtime = date("Y-m-d H:i:s");
  $query = 'insert into ussd_554(number,circle,channel,input) values("' . $mobile . '","' . $circle_id . '","' . $nowtime . '","' . mysql_real_escape_string($input) . '")';
  mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
  $inserted = true;
  include 'friendship_spl_nmk.php';
  if (apc_store("session_$session_id", $sessions, 300) === false) {
  trigger_error("Cache update failed", E_USER_WARNING);
  }
  if ($isSub) {
  $input = 1;
  } else {
  exit();
  }
  } */

//for white listed users of MMG
if ($circle_id == 'MU' || $circle_id == 'MH' || $circle_id == 'MB') {
    $query = 'select * from whitelist where (msisdn="' . $mobile . '")';
    $myresult = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    $num_rows = mysql_num_rows($myresult);
    if ($num_rows != 0 && isblacklisted($mobile) == 0) {
        //$single_conf = true;
    }
}
//

if ($input) {
    if (!$inserted) {
        $nowtime = date("Y-m-d H:i:s"); //number 	circle 	channel input
        $query = 'insert into ussd_554(number,circle,channel,input) values("' . $mobile . '","' . $circle_id . '","' . $nowtime . '","' . mysql_real_escape_string($input) . '")';
        mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        //    $data = "$mobile\t$circle_id\t$nowtime\t$input";
        //    put_file_contents("log/hit.log", "$data\n");
    }
    $inp = $input;

    if ($circle_id == "AP") {
        include '554menu.php';
        exit();
    }

    if ($circle_id != 'KL' && $circle_id != 'TN' && $circle_id != 'CN') {
        if ($inp != 1) {
            $response = "You have pressed an invalid key. Reply with 1 to confirm.";
            include 'closedb.php';
            exit();
        }
    } else {
        if ($inp != 1) {
            $response = "You have pressed an invalid key. Reply with 1 to confirm.";
            include 'closedb.php';
            exit();
        }
    }

    if ($circle_id == 'MU' || $circle_id == 'MH' || $circle_id == 'MB') {
        //PHOTO SEARCH
        $query = 'select * from ' . $subs_table . ' where (number="' . $mobile . '" and status=1 and channel=6)';
//    } else if ($circle_id == 'UPW' || $circle_id == 'UPE') {
//        //KRISHNA SEARCH
//        $query = 'select * from ' . $subs_table . ' where (number="' . $mobile . '" and status=1 and channel=10)';
    } else {
        $query = 'select * from ' . $subs_table . ' where (number="' . $mobile . '" and status=1)';
    }
    $myresult = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    $num_rows = mysql_num_rows($myresult);
    if ($num_rows != 0) {
        $row = mysql_fetch_assoc($myresult);
        $subid = stripslashes($row["sub_id"]);
        $subscribed = $row["subscribed"];

        //no unsubscribe for users in grace period
        if ($subscribed <= 0 && $circle_id != 'MP' && $circle_id != 'GJ' && $channel != 6 && 0) {
            $response = "You have insufficient Balance.";
            $freeflow = "FB";
            include 'closedb.php';
            exit();
        }
        /*
          if ($circle_id == 'MU' || $circle_id == 'MH') {
          $query = 'select * from whitelist where (msisdn="' . $mobile . '")';
          $myresult = mysql_query($query);
          $num_rows = mysql_num_rows($myresult);
          if ($num_rows != 0) {
          echo "Invalid request.";
          exit();
          }
          }
         */
        if ($circle_id != 'KA' || $circle_id != 'KK') {
            $url = "http://IP/unsubscriber/unsubscriber.php?subid=$subid&source=100&service=$service";
        } else {
            $url = "http://IP/unsubscriber/unsubscriber.php?subid=$subid&source=2&service=$service";
        }
        file_get_contents($url);
        $response = "You have been unsubscribed from $product_name.";
        $freeflow = "FB";
        include 'closedb.php';
        exit();
    } else {
        if ($circle_id == "KN" || $circle_id == "KA") { //05/03/2012 Avinash
            $forced_pricepoint = $price_point;
        }

        switch ($circle_id) {

            case "KL":
            case "TN":
            case "CN":
            case "CH":     ////edited on 05/03/2012
                //
//                if ($circle_id == 'CN') {
//                    $circle = 'CH';
//                } else {
//                    $circle = $circle_id;
//                }
//                $nowtime = date("F j, Y, g:i:s a");
//                file_put_contents("log/trialpack.log", "\n$mobile,$circle,$nowtime", FILE_APPEND);
//                $query = 'SELECT * FROM ' . $subs_table . ' WHERE (number="' . $mobile . '")';
//                $result1 = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
//                $num_rows = mysql_num_rows($result1);
//                if ($num_rows != 0) {
//                    $query = 'UPDATE ' . $subs_table . ' SET channel=7,pre_sent=0,subscribed="2",pricepoint="' . $price_point . '",status=1,expiry=DATE_ADD(NOW(),INTERVAL 10 DAY),time=NOW(),medium="2" where (number="' . $mobile . '")';
//                    $result1 = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
//                } else {
//                    $query = 'INSERT INTO ' . $subs_table . '(number,circle,channel,expiry,medium,status,pricepoint,subscribed) VALUES("' . $mobile . '","' . $circle . '",7,DATE_ADD(NOW(),INTERVAL 10 DAY),"2","1","' . $price_point . '",2)';
//                    $result1 = mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
//                }
//                $response = "Thank you for subscribing to $product_name. You will get a confirmation sms soon.";
//                $query = 'insert into trial_subscription(msisdn,circle,days,source) values("' . $mobile . '","' . $circle . '","10","USSD")';
//                mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_WARNING);
//                $arguments = array($mobile, $circle);
//                spawn($arguments);

                $channel = 7;
                break;
            default:
        }
        if (($circle_id == "KN" || $circle_id == "KA")) { //05/03/2012 Avinash
            $forced_pricepoint = 0;
            $query = 'replace into subs_queue(msisdn,channel,source,status) values("' . $mobile . '","' . $channel . '","USSDBQ","' . $forced_pricepoint . '")';
        } else {
            $query = 'replace into subs_queue(msisdn,channel,source,status) values("' . $mobile . '","' . $channel . '","USSD","' . $forced_pricepoint . '")';
        }
        if ($inp == 2) {
            $query = 'replace into subs_queue(msisdn,channel,source,status) values("' . $mobile . '","5","USSDT","' . $forced_pricepoint . '")';
        }
        mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        $nowtime = date("F j, Y, g:i:s a");
        file_put_contents("log/subscriber.log", "\n$mobile-5-$nowtime", FILE_APPEND);
        if ($channel == 7) {
            //$product_name .= " free trial pack";
        }

        $response = "Thank you for subscribing to $product_name. You will get a confirmation sms soon.";
        $freeflow = "FB";
        include 'closedb.php';
        exit();
    }

    //echo $input;
} else {
  

    $nowtime = date("Y-m-d H:i:s");
    $query = 'insert into ussd_554(number,circle,channel) values("' . $mobile . '","' . $circle_id . '","' . $nowtime . '")';
    mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//    $data = "$mobile\t$circle_id\t$nowtime";
//    put_file_contents("log/hit.log", "$data\n");

    if ($circle_id == "AP") {
        include '554menu.php';
        exit();
    }

    $query = 'select * from ' . $subs_table . ' where (number="' . $mobile . '" and status=1)';

    if ($circle_id == 'MU' || $circle_id == 'MH' || $circle_id == 'MB') {
        $query = 'select * from ' . $subs_table . ' where (number="' . $mobile . '" and status=1 and channel=6)';
//    } else if ($circle_id == 'UPW' || $circle_id == 'UPE') {
//        $query = 'select * from ' . $subs_table . ' where (number="' . $mobile . '" and status=1 and channel=10)';
    } else if ($circle_id == 'TST') {
        $query = 'SELECT * FROM ' . $subs_table . ' WHERE (number="' . $mobile . '" AND status=1 AND channel=9)';
    }
    $myresult = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

    $num_rows = mysql_num_rows($myresult);
    if ($num_rows != 0) {
        //SUBSCRIBED USER
        if ($no_unsubscribe === true) {
            $response = "Invalid request.";
            $freeflow = "FB";
            exit();
        } else if ($no_unsubscribe == 1) {
            $query = 'select * from whitelist where (msisdn="' . $mobile . '")';
            $myresult = mysql_query($query);
            $num_rows = mysql_num_rows($myresult);
            if ($num_rows != 0) {
                $response = "Invalid request.";
                $freeflow = "FB";
                exit();
            }
        }
        $row = mysql_fetch_array($myresult);
        if ($row["subscribed"] <= 0 && $circle_id != 'MP' && $circle_id != 'GJ' && $channel != 6) {
            $response = $ussd_msg;
        } else {
            
            $out = "Welcome to $product_name! Reply with 1 to unsubscribe from $product_name";
            if ($circle_id != "KL" || $circle_id != "TN" || $circle_id != "CH" || $circle_id != "CN") {
                $out .= " Pack";
            }
            $out .= ".";
            $response = $out;
        }
        include 'closedb.php';
        exit();
    } else {
        //show subscription menu

        $night = strtotime("10 pm");
        $morning = strtotime("6 am");
        $now = time();
        $flag = false;

        if ($circle_id == 'MB')
            $single_conf = TRUE; //22-03-2013


        if ($single_conf === true) {
            $query = "INSERT IGNORE INTO subs_queue(msisdn,channel,source) VALUES('$mobile','6','USSD')";
            mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_WARNING);
        }

        if ($single_conf_nite === true) {
            if ($now >= $night || $now < $morning) {
                if (isblacklisted($mobile) == 0) {
                    $query = 'insert ignore into subs_queue(msisdn,channel,source) values("' . $mobile . '","6","USSD")';
                    mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_WARNING);
                    $flag = true;
                }
            }
        }
//        if ($mobile == '7259876655') {
//            echo "$single_conf $circle_id ";
//        }
//
//        if ($mobile == "7259876655" || $mobile == "9600000178" || $mobile == "9741804522") {
//            $response = "Welcome to Bikers quiz contest reply with 1 to confirm";
//        } else {
        if ($single_conf) {
            $response = "Thank you for subscribing to $product_name. You will get a confirmation sms soon.";
            $freeflow = 'FB';
        } else {
            $response = $ussd_msg;
        }
//        }

        include 'closedb.php';
        exit();
    }
}

function on_exit() {
    global $response;
    global $freeflow;
    header("Content-Encoding: UTF-8");
    header("Freeflow: $freeflow");
    header("charge: N");
    header("Content-Length: " . strlen($response));
    echo $response;
}

////////////////////////////////////////////////////////////////////////

function put_file_contents($file, $data, $max = 1000000) {
    $file_size = filesize($file);
    if ($file_size >= $max) {
        $info = pathinfo($file);
        $file_name = basename($file, '.' . $info['extension']);
        $new_name = dirname($file) . "/" . $file_name . "." . time() . "." . $info['extension'];
        $ren = rename($file, $new_name);
    }
    file_put_contents($file, $data, FILE_APPEND);
}

function isblacklisted($msisdn) {
    $query = 'select * from blacklist where (msisdn="' . $msisdn . '")';
    $myresult = mysql_query($query) or trigger_error(mysql_error(), E_USER_WARNING);

    $num_rows = mysql_num_rows($myresult);
    if ($num_rows != 0) {
        return "1";
    }
    $word = substr($msisdn, 0, 4);
    if ($word == "9810" || $word == "9818" || $word == "9871" || $word == "9971") {
        return "1";
    }
    $word = substr($msisdn, 0, 5);
    if ($word == "96000" || $word == "98150" || $word == "98290" || $word == "98310" || $word == "98451" || $word == "98719" || $word == "98920" || $word == "98930" || $word == "98950" || $word == "99020" || $word == "99060" || $word == "99080" || $word == "99340" || $word == "99350" || $word == "99540" || $word == "99980") {
        return "1";
    }
    //9937049
//9831049
//9932449

    $word = substr($msisdn, 0, 7);
    if ($word == "9932449" || $word == "9831049" || $word == "9937049" || $word == "9589622" || $word == "9589623" || $word == "9589624" || $word == "9631949" || $word == "9685814" || $word == "9685815" || $word == "9685884" || $word == "9685885" || $word == "9752393" || $word == "9752394" || $word == "9892049" || $word == "9892051" || $word == "9934049" || $word == "9934059" || $word == "9934549") {
        return "1";
    }
    return "0";
}

function spawn($arguments) {
    $worker = dirname(__FILE__) . "/trial_child.php";
    $args = implode(' ', $arguments);
    $comm = "/usr/bin/php $worker $args";

    $p = popen($comm, "r"); //spawn child
    if ($p === false)
        return false;

    $time = date("Y-m-d H:i:s");
    $to_log = "$time $args\n";
    file_put_contents("log/spawn.log", $to_log, FILE_APPEND);
    usleep(500);
    pclose($p);
    return true;
}

?>
