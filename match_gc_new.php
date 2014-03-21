<?php

if (preg_match("~_gc_next_(.+)__(.+)__(.+)__(.+)__(.+)__~", $req, $match)) {

    echo "<h3>GC NEXT</h3>";

    echo "gcfrom: " . $gcfrom = $match[1];
    echo "gcto: " . $gcto = $match[2];
    echo "gcgroup: " . $gcgroup = $match[3];
    echo "gcsubgroup: " . $gcsubgroup = $match[4];
    echo "cardname: " . $card_name = $match[5];

    $uniq_id = uniqid();
    mysql_close();
    include 'lib/configdb_up.php';
    $num_row = 0;

    echo $q = "select subname from gc_subgroup where id=$gcsubgroup";
    $r = mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
    if (mysql_num_rows($r)) {
        $row = mysql_fetch_array($r);
        $card_name = ucwords($row['subname']);
    } else {
        $card_name = 'customized';
    }
    echo "<h2>Before calling function</h2>";
    $total_return = gclink($gcto, $gcfrom, $number, $circle, $gcsubgroup, $gcgroup, $uniq_id);
    echo "<h2>After calling function</h2>";
    if ($operator != "airtel") {
        include 'allmanip.php';
    }
    putOutput($total_return);
    exit();
}

//GREETING CARD
if (preg_match("~^__hlpgc__(.+)__$~", $query_in, $match)) {
    echo "<br>GREETING CARD<br>";
    $total_return = $match[1];
    //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
    $free = true;
    $service_name = 'gyan';
    $product_name_tag = 'mCards';
    $to_logserver['source'] = 'gc';
    putOutput($total_return);
    exit();
}

if (preg_match("~^__gc__(.+)__from__(.+)__to__(.+)__charge__(\d{1,2}(\.\d{1,2})?)__only$~", $req, $match)) {
    echo "<br>GREETING CARD<br>";

    $total_return = "Dear $match[3], $match[2] has sent a customized greeting card for you! To open click on\n";
    if (trim($match[3]) == "" && trim($match[2]) == "") {
        $total_return = "Your friend has sent a greeting card for you! To open click on\n";
    }

    $total_return .= $match[1] . "\n$brows_charge";
    //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
    $charge_per_query = 3;
    if ($match[4] == 0) {
        $free = true;
//        $total_return .= "\n--\nDial *321*552# to send unlimited greeting cards.";
    } else {
        $charge_per_query = $match[4];
        $free = false;
//        $total_return .= "\n--\nDial *321*552# to send greeting cards to your loved ones.";
    }
    if ($operator == 'airtel')
        $total_return .= "\n--\nTo send free unlimited greeting cards dial *321*552# at Rs. 10/7 days.";
    $service_name = 'gc';
    $product_name_tag = 'mCards';
    $to_logserver['source'] = 'gc';
    putOutput($total_return);
    exit();
} else if (preg_match("~^__gv__(.+)__from__(.+)__to__(.+)__charge__(\d{1,2}(\.\d{1,2})?)__only$~", $req, $match)) {
    echo "<br>GREETING CARD<br>";
    $total_return = "Dear $match[3], $match[2] has sent a video greeting for you! To open click on\n";
    $total_return .= $match[1] . "\n$brows_charge";
    //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
    $charge_per_query = 3;
    if ($match[4] == 0) {
        $free = true;
//        $total_return .= "\n--\nDial *321*552# to send unlimited greeting cards.";
    } else {
        $charge_per_query = $match[4];
        $free = false;
//        $total_return .= "\n--\nDial *321*552# to send greeting cards to your loved ones.";
    }
    if ($operator == 'airtel')
        $total_return .= "\n--\nTo send free unlimited greeting cards dial *321*552# at Rs. 10/7 days.";
    $service_name = 'gc';
    $product_name_tag = 'mCards';
    $to_logserver['source'] = 'gv';
    putOutput($total_return);
    exit();
} else if (preg_match("~^__mpix__(.+)__charge__([\d]{1,2})__only$~", $req, $match)) {
    echo "<br>MPIX CARD<br>";
    $total_return = "mPix card.\nTo open click on\n";
    $total_return .= $match[1] . "\n$brows_charge";
    //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
    $charge_per_query = 2;
    if ($match[4] == 0) {
        $free = true;
//        $total_return .= "\n--\nDial *321*552# to send unlimited greeting cards.";
    } else {
        $charge_per_query = $match[4];
        $free = false;
//        $total_return .= "\n--\nDial *321*552# to send greeting cards to your loved ones.";
    }
    //$total_return .= "\n--\nDial *321*553#$tollfree to send customised cards anytime!";
    $service_name = 'gc';
    $product_name_tag = 'mPixs';
    $to_logserver['source'] = 'mpix';
    putOutput($total_return);
    exit();
}


if (preg_match("~^(gc|greet(ings?)?)\b~", $req, $match)) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    if ($operator == "airtelsl" && !$free) {
        $number1 = substr($number, 2);
        echo $url = "http://IP/Airtel_Srilanka/subscriber/subscriber.php?msisdn=$number1&circle=$circle_short&price=1.23";
        $data = file_get_contents($url);
//        $free = TRUE;
    }
//    if ($operator == 'airtel' && ($circle == 'MB' || $circle == 'MH' || $circle == 'AP')) {
//        $free = true;
//        $total_return = "Thank you for using this service. You will receive a card selection menu shortly.";
//        $total_return .= "\n--\nDial *321*552#$tollfree to send customised cards anytime!";
//        $service_name = 'gc';
//        $product_name_tag = 'mCards';
//        $to_logserver['source'] = 'gc';
//        putOutput($total_return);
//        $resp = httpGet($url);
//        exit();
//    } else {
    $isgcmatch = false;
    $req = trim(preg_replace("~[\s]+~", " ", $req));

    echo "<h2>Before calling function gcmatch</h2>";
    $match = gcmatch($req, $mch); //calling gcmatch
    var_dump($match);

    $isgcmatch = $match['isgcmatch'];
    $gcfrom = $match['gcfrom'];
    $gcto = $match['gcto'];

    echo "<h2>After calling function gcmatch</h2>";

    if (!$isgcmatch) {
        $gc_req = preg_replace("~^(gc|greet(ings?)?) ~", '', $req);
        if (preg_match_all("~[\w\d]{3,}~", $gc_req, $match)) {
            print_r($match);
            $gc_count = count($match[0]);
            if ($gc_count > 0 && $gc_count < 9) {
                echo '<br>Match at preg 8';
                $gcfrom = '';
                $gcto = '';
                for ($i = 0; $i < $gc_count / 2; $i++)
                    $gcfrom .= $match[0][$i] . ' ';
                for ($i; $i < $gc_count; $i++)
                    $gcto .= $match[0][$i] . ' ';
                echo $gcfrom = trim($gcfrom);
                echo $gcto = trim($gcto);
                $isgcmatch = true;
            }
        }
    }

    if ($isgcmatch) {
        $gcfrom = ucwords((string) $gcfrom);
        $gcto = ucwords((string) $gcto);
        echo "<br>From:";
        var_dump($gcfrom);
        echo "<br>To:";
        var_dump($gcto);

        if (strlen($gcfrom) < 30 && (strlen($gcto) < 30 )) {
            echo "<br>Inside GC result";
//            if ($circle == 'KL' || $circle == 'TN' || $circle == 'CN') {
            $uniq_id = uniqid();
            mysql_close();
            include 'lib/configdb_up.php';
            $num_row = 0;
//                if ($operator == 'airtel' && !$is_ussd) {
//                    echo $from_time = date("Y/m/d H:i:s", strtotime("now - 24 hour"));
//                    echo $q = "select gcgroup,gcsubgroup from gc_data where msisdn = '$numbers' and gcgroup <> 0 and gcsubgroup <> 0 and istweet = 0 and isvideo = 0 and `timestamp` > '$from_time' order by `timestamp` desc limit 1";
//                    $r = mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
//                    $num_row = mysql_num_rows($r);
//                }
            if ($num_row) {
                $row = mysql_fetch_array($r);
                $gcgroup = $row['gcgroup'];
                $gcsubgroup = $row['gcsubgroup'];
            } else {
                echo "circle__:$circle";

//                    $gcgroup = 44; // BEST FRIENDS CARDS
//                    $gcsubgroup = 64;

                $gcgroup = 40; // VALENTINE DAYS
                $gcsubgroup = 62;

                echo "<h2>GROUP:$gcgroup</h2>";
                echo "<h2>SUBGROUP:$gcsubgroup</h2>";

//                    if ($circle_short == "GJ" && $operator == "vodafone") {
//                        //NAVRATRI SPECIAL
//                        $gcgroup = 52;
//                        $gcsubgroup = 79; //CHANGED ON 05-04-2013
//                    } else {
//                        //HOLI SPECIAL
//                        $gcgroup = 44;
//                        $gcsubgroup = 64; //CHANGED ON 07-03-2013
//                    }
            }


            echo "<h2>Before calling function</h2>";
            $total_return = gclink($gcto, $gcfrom, $number, $circle, $gcsubgroup, $gcgroup, $uniq_id);
            echo "<h2>After calling function</h2>";

            if ($operator != 'airtel') {
                include 'allmanip.php';
            }
            putOutput($total_return);

            exit();
        }
    }
//    }
} elseif (($operator == 'aircel') && preg_match("~^(gcusa|usa|gcmonsoon|monsoon)\b~", $req, $match)) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    $isgcmatch = false;
    $req = trim(preg_replace("~[\s]+~", " ", $req));
    $mch = trim(preg_replace("~[\s]+~", " ", $mch));


    echo "<h2>Before calling function gcmatch</h2>";
    $match = gcmatch($req, $mch); //calling gcmatch
    var_dump($match);

    $isgcmatch = $match['isgcmatch'];
    $gcfrom = $match['gcfrom'];
    $gcto = $match['gcto'];

    echo "<h2>After calling function gcmatch</h2>";

    if (!$isgcmatch) {
        $gc_req = preg_replace("~^$mch ~", '', $req);
        if (preg_match_all("~[\w\d]{3,}~", $gc_req, $match)) {
            print_r($match);
            $gc_count = count($match[0]);
            if ($gc_count > 0 && $gc_count < 9) {
                echo '<br>Match at preg 8';
                $gcfrom = '';
                $gcto = '';
                for ($i = 0; $i < $gc_count / 2; $i++)
                    $gcfrom .= $match[0][$i] . ' ';
                for ($i; $i < $gc_count; $i++)
                    $gcto .= $match[0][$i] . ' ';
                echo $gcfrom = trim($gcfrom);
                echo $gcto = trim($gcto);
                $isgcmatch = true;
            }
        }
    }

    if ($isgcmatch) {
        $gcfrom = ucwords((string) $gcfrom);
        $gcto = ucwords((string) $gcto);
        echo "<br>From:";
        var_dump($gcfrom);
        echo "<br>To:";
        var_dump($gcto);
        if (strlen($gcfrom) < 30 && (strlen($gcto) < 30 )) {
            echo "<br>Inside GC result";
            $uniq_id = uniqid();
            mysql_close();
            include 'lib/configdb_up.php';
            echo "circle__:$circle";
            switch ($mch) {
                case 'gcusa':
                    $gcgroup = 76;
                    $gcsubgroup = 111;
                    break;
                case 'usa':
                    $gcgroup = 76;
                    $gcsubgroup = 111;
                    break;
                case 'gcmonsoon':
                    $gcgroup = 77;
                    $gcsubgroup = 112;
                    break;
                case 'monsoon':
                    $gcgroup = 77;
                    $gcsubgroup = 112;
                    break;
                default:
                    break;
            }


            echo "<h2>Before calling function</h2>";
            $total_return = gclink($gcto, $gcfrom, $number, $circle, $gcsubgroup, $gcgroup, $uniq_id);
            echo "<h2>After calling function</h2>";

            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
} elseif ($operator == "vodafone" && preg_match("~^\b(fb|fd|kj|gac|nv|hc|gpc|rd) (.+)\b~", $req, $match)) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    $isgcmatch = false;
    $req = trim(preg_replace("~[\s]+~", " ", $req));
    $mch = trim(preg_replace("~[\s]+~", " ", $mch));


    echo "<h2>Before calling function gcmatch</h2>";
    $match = gcmatch($req, $mch); //calling gcmatch
    var_dump($match);

    $isgcmatch = $match['isgcmatch'];
    $gcfrom = $match['gcfrom'];
    $gcto = $match['gcto'];

    echo "<h2>After calling function gcmatch</h2>";


    if (!$isgcmatch) {
        $gc_req = preg_replace("~^$mch ~", '', $req);
        if (preg_match_all("~[\w\d]{3,}~", $gc_req, $match)) {
            print_r($match);
            $gc_count = count($match[0]);
            if ($gc_count > 0 && $gc_count < 9) {
                echo '<br>Match at preg 8';
                $gcfrom = '';
                $gcto = '';
                for ($i = 0; $i < $gc_count / 2; $i++)
                    $gcfrom .= $match[0][$i] . ' ';
                for ($i; $i < $gc_count; $i++)
                    $gcto .= $match[0][$i] . ' ';
                echo $gcfrom = trim($gcfrom);
                echo $gcto = trim($gcto);
                $isgcmatch = true;
            }
        }
    }

    if ($isgcmatch) {
        $gcfrom = ucwords((string) $gcfrom);
        $gcto = ucwords((string) $gcto);
        echo "<br>From:";
        var_dump($gcfrom);
        echo "<br>To:";
        var_dump($gcto);
        if (strlen($gcfrom) < 30 && (strlen($gcto) < 30 )) {
            echo "<br>Inside GC result";
            $uniq_id = uniqid();
            mysql_close();
            include 'lib/configdb_up.php';
            echo "circle__:$circle";
            switch ($mch) {
                case 'fb':
                    $gcgroup = 85;
                    $gcsubgroup = 121;
                    break;
                case 'fd':
                    $gcgroup = 82;
                    $gcsubgroup = 118;
                    break;
                case 'kj':
                    $gcgroup = 86;
                    $gcsubgroup = 122;
                    break;
                case 'ind':
                    $gcgroup = 87;
                    $gcsubgroup = 123;
                    break;
                case 'gac':
                    $gcgroup = 9;
                    $gcsubgroup = 14;
                    break;
                case 'nv':
                    $gcgroup = 52;
                    $gcsubgroup = 79;
                    break;
                case 'hc':
                    $gcgroup = 45;
                    $gcsubgroup = 65;
                    break;
                case 'gpc':
                    $gcgroup = 54;
                    $gcsubgroup = 81;
                    break;
                case 'rd':
                    $gcgroup = 127;
                    $gcsubgroup = 163;
                    break;
                default:
                    break;
            }


            echo "<h2>Before calling function</h2>";
            $total_return = gclink($gcto, $gcfrom, $number, $circle, $gcsubgroup, $gcgroup, $uniq_id);
            echo "<h2>After calling function</h2>";
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
} elseif (preg_match("~^\b(gclove|gcg|gcfrnd|gconam|gcthank|gcsorry|gcbday|gcstb|gcbts|gcfriend|gcm|gcw|gcf|gcs|bgc|est|nc|uc|vc|rc|kc|rd|kj|gac|nv|dw) (.+)\b~", $req, $match) || (preg_match("~^\b(dw\d{1,2}) (.+)\b~", $req, $match) && $operator == "idea")) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    $isgcmatch = false;
    $req = trim(preg_replace("~[\s]+~", " ", $req));
    $mch = trim(preg_replace("~[\s]+~", " ", $mch));

    echo "<h2>Before calling function gcmatch</h2>";
    $match = gcmatch($req, $mch); //calling gcmatch
    var_dump($match);

    $isgcmatch = $match['isgcmatch'];
    $gcfrom = $match['gcfrom'];
    $gcto = $match['gcto'];

    echo "<h2>After calling function gcmatch</h2>";

    if (!$isgcmatch) {
        $gc_req = preg_replace("~^$mch ~", '', $req);
        if (preg_match_all("~[\w\d]{3,}~", $gc_req, $match)) {
            print_r($match);
            $gc_count = count($match[0]);
            if ($gc_count > 0 && $gc_count < 9) {
                echo '<br>Match at preg 8';
                $gcfrom = '';
                $gcto = '';
                for ($i = 0; $i < $gc_count / 2; $i++)
                    $gcfrom .= $match[0][$i] . ' ';
                for ($i; $i < $gc_count; $i++)
                    $gcto .= $match[0][$i] . ' ';
                echo $gcfrom = trim($gcfrom);
                echo $gcto = trim($gcto);
                $isgcmatch = true;
            }
        }
    }

    if ($isgcmatch) {
        $gcfrom = ucwords((string) $gcfrom);
        $gcto = ucwords((string) $gcto);
        echo "<br>From:";
        var_dump($gcfrom);
        echo "<br>To:";
        var_dump($gcto);
        if (strlen($gcfrom) < 30 && (strlen($gcto) < 30 )) {
            echo "<br>Inside GC result";
            $uniq_id = uniqid();
            mysql_close();
            include 'lib/configdb_up.php';
            echo "circle__:$circle";
            switch ($mch) {
                case 'gclove':
                    $gcgroup = 5;
                    $gcsubgroup = 6;
                    break;
                case 'gcfrnd':
                    $gcgroup = 44;
                    $gcsubgroup = 64;
                    break;
                case 'gcthank':
                    $gcgroup = 7;
                    $gcsubgroup = 12;
                    break;
                case 'gcsorry':
                    $gcgroup = 2;
                    $gcsubgroup = 10;
                    break;
                case 'gcbday':
                    $gcgroup = 6;
                    $gcsubgroup = 11;
                    break;
                case 'gcstb':
                    $gcgroup = 1;
                    $gcsubgroup = 2;
                    break;
                case 'gcbts':
                    $gcgroup = 1;
                    $gcsubgroup = 1;
                    break;
                case 'gcfriend':
                    $gcgroup = 82;
                    $gcsubgroup = 118;
                    break;

                case 'gcg':
                    $gcgroup = 97;
                    $gcsubgroup = 133;
                    break;

                case 'bgc':
                    $gcgroup = 115;
                    $gcsubgroup = 151;
                    break;

                case 'est':
                    $gcgroup = 60;
                    $gcsubgroup = 87;
                    break;
                case 'nc':
                    $gcgroup = 52;
                    $gcsubgroup = 79;
                    break;
                case 'uc':
                    $gcgroup = 53;
                    $gcsubgroup = 80;
                    break;
                case 'vc':
                    $gcgroup = 62;
                    $gcsubgroup = 89;
                    break;
                case 'rc':
                    $gcgroup = 55;
                    $gcsubgroup = 82;
                    break;
                case 'kc':
                    $gcgroup = 119;
                    $gcsubgroup = 155;
                    break;
                case 'rd':
                    $gcgroup = 127;
                    $gcsubgroup = 163;
                    break;
                case 'kj':
                    $gcgroup = 86;
                    $gcsubgroup = 122;
                    break;
                case 'gac':
                    $gcgroup = 9;
                    $gcsubgroup = 14;
                    break;
                case 'gconam':
                    $gcgroup = 89;
                    $gcsubgroup = 125;
                    break;
                case 'nv':
                    $gcgroup = 52;
                    $gcsubgroup = 79;
                    break;
                case 'dw':
                    $gcgroup = 102;
                    $gcsubgroup = 138;
                    break;

                default:
                    break;
            }
            echo "<h2>Before calling function</h2>";
            $total_return = gclink($gcto, $gcfrom, $number, $circle, $gcsubgroup, $gcgroup, $uniq_id);
            echo "<h2>After calling function</h2>";
            if ($operator != "airtel") {
                include 'allmanip.php';
            }
            putOutput($total_return);
            exit();
        }
    }
}

function gclink($gcto, $gcfrom, $number, $circle, $gcsubgroup, $gcgroup, $uniq_id) {

    global $operator, $charge_per_query, $brows_charge, $free, $is_ussd, $options_list, $list, $service_name, $product_name, $to_logserver, $gcfree, $tollfree, $numbers, $mch;

    echo "<h2>$gcgroup,$gcsubgroup</h2>";
    $q = "select subname from gc_subgroup where id=$gcsubgroup";
    $r = mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
    if (mysql_num_rows($r)) {
        $row = mysql_fetch_array($r);
        $card_name = ucwords($row['subname']);
    } else {
        $card_name = 'customized';
    }
    $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',$gcgroup,$gcsubgroup)";
    mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
    $gclink = 'http://IP/?c=' . urlencode($uniq_id);
    if ($operator == 'airtel') {
        if (!$is_ussd) {
            if ($gcfree) {
                $free = true;
            } else {
                $charge_per_query = 3;
                $free = false;
            }
        }
    }

    $total_return = "Dear $gcto, $gcfrom has sent a $card_name greeting card for you! To open click on link\n$gclink\n";
    $total_return .= "$brows_charge";
    if ($operator == "vodafone") {
        $total_return.="\nPlease forward this link to your friend if you have liked this or else press 1 for Another design";
    }
    if ($operator == 'airtel') {
        $total_return .= "\n--\nDial *321*552#$tollfree to send customized cards to your loved ones!";
    } else if ($operator == 'aircel') {
        $total_return = "Dear $gcto. I have sent a $card_name greeting card for you! To open click on link\n$gclink\n";
        $total_return .= "$brows_charge";
        $total_return .= "\n--\nSMS $mch <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Aircel Number. @Rs1";
    }
    if ($operator == "vodafone") {
        $options_list[] = "another design";
        $list[] = array("content" => "_gc_next_" . $gcfrom . "__$gcto" . "__" . $gcgroup . "__" . $gcsubgroup . "__" . $card_name . "__");
    }
    $service_name = 'gc';
    $product_name_tag = 'mCards';
    $to_logserver['source'] = 'gc';
    return $total_return;
}

function gcmatch($req, $mch) {

    $match_out = array();

    if (preg_match("~^$mch (fro?m)? ?(.+) (to|2|and) (.+)~", $req, $match)) {
        echo '<br>Match at preg 1';
        $gcfrom = $match[2];
        $gcto = $match[4];
        $isgcmatch = true;
    } else if (preg_match("~^$mch (to|2)? ?(.+) (fro?m) (.+)~", $req, $match)) {
        echo '<br>Match at preg 2';
        $gcfrom = $match[4];
        $gcto = $match[2];
        $isgcmatch = true;
    } else if (preg_match("~^$mch \((.+)\).*\((.+)\)~", $req, $match)) {
        echo '<br>Match at preg 3';
        $gcfrom = trim($match[1]);
        $gcto = trim($match[2]);
        $isgcmatch = true;
    } else if (preg_match("~^$mch <(.+)>.*<(.+)>~", strtolower(trim($query_in)), $match)) {
        echo '<br>Match at preg 4';
        $gcfrom = trim($match[1]);
        $gcto = trim($match[2]);
        $isgcmatch = true;
    } else if (preg_match("~^$mch \b(.+)\b[,-:/|]\b(.+)\b~", $req, $match)) {
        echo '<br>Match at preg 5';
        $gcfrom = trim($match[1]);
        $gcto = trim($match[2]);
        $isgcmatch = true;
    } else if (str_word_count($req) == 3) {
        echo '<br>Match at preg 6';
        $match = explode(' ', $req);
        print_r($match);
        $gcfrom = $match[1];
        $gcto = $match[2];
        $isgcmatch = true;
    } else if (str_word_count($req) == 5) {
        echo '<br>Match at preg 7';
        $match = explode(' ', $req);
        print_r($match);
        $gcfrom = "$match[1] $match[2]";
        $gcto = "$match[3] $match[4]";
        $isgcmatch = true;
    }

    $match_out['gcfrom'] = $gcfrom;
    $match_out['gcto'] = $gcto;
    $match_out['isgcmatch'] = $isgcmatch;

    return $match_out;
}

?>