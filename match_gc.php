<?php

//Another Design

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
    $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',$gcgroup,$gcsubgroup)";
    mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);

    echo $gclink = 'http://IP/?c=' . urlencode($uniq_id);
    if ($operator == 'airtel') {
        if ($gcfree) {
            $free = true;
        } else {
            $charge_per_query = 3;
            $free = false;
        }
    }
    echo $total_return = "Dear $gcto, $gcfrom has sent a $card_name greeting card for you! To open click on\n$gclink\n";
    $total_return .= "$brows_charge";
    if ($operator == "vodafone") {
        $total_return.="\nPlease forward this link to your friend if you have liked this or else press 1 for Another design";
    }

    $options_list[] = "another design";
    $list[] = array("content" => "_gc_next_" . $gcfrom . "__$gcto" . "__" . $gcgroup . "__" . $gcsubgroup . "__" . $card_name . "__");

    $to_logserver['source'] = 'gc';
    include 'allmanip.php';
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

//if (preg_match("~^__gc__(.+)__charge__([\d]{1,2})__only$~", $req, $match)) {
//    echo "<br>GREETING CARD<br>";
//    $total_return = "Your customized Greeting Card link:\n";
//    $total_return .= $match[1] . "\nBrowsing charges($brows_charge) apply.";
//    //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
//    $charge_per_query = 3;
//    if ($match[2] == 0) {
//        $free = true;
//        $total_return .= "\n--\nDial *321*552# to send unlimited greeting cards.";
//    } else {
//        $charge_per_query = $match[2];
//        $free = false;
//        $total_return .= "\n--\nDial *321*552# to send greeting cards to your loved ones.";
//    }
//    $service_name = 'gc';
//    putOutput($total_return);
//    exit();
//}

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

//if (preg_match("~^_gc_(b2s|s2b)_(.+)__(.+)~", $req, $match)) {
//    echo "<br>GREETING brother to sister<br>";
//    $gcfrom = $match[2];
//    $gcto = $match[3];
//    if($match[1] == 'b2s'){
//        $towhom = 'sister';
//        $subgroup = 1;
//    }else{
//        $towhom = 'brother';
//        $subgroup = 2;
//    }
//    $uniq_id = uniqid();
//    mysql_close();
//    include 'lib/configdb_up.php';
//    $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',1,$subgroup)";
//    mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
//    


if (preg_match("~^(gc|greet(ings?)?)\b~", $req, $match)) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    if ($operator == 'airtel' && ($circle == 'MB' || $circle == 'MH' || $circle == 'AP')) {
        $free = true;
        $total_return = "Thank you for using this service. You will receive a card selection menu shortly.";
        $total_return .= "\n--\nDial *321*552#$tollfree to send customised cards anytime!";
        $service_name = 'gc';
        $product_name_tag = 'mCards';
        $to_logserver['source'] = 'gc';
        putOutput($total_return);
        $url = "http://IP/niussd/udppush.php?msisdn=$numbers&circle=$circle";
        $resp = httpGet($url);
        exit();
    } else {
        $isgcmatch = false;
        $req = trim(preg_replace("~[\s]+~", " ", $req));
        if (preg_match("~^(gc|greet(ings?)?) (fro?m)? ?(.+) (to|2|and) (.+)~", $req, $match)) {
            echo '<br>Match at preg 1';
            $gcfrom = $match[4];
            $gcto = $match[6];
            $isgcmatch = true;
        } else if (preg_match("~^(gc|greet(ings?)?) (to|2)? ?(.+) (fro?m) (.+)~", $req, $match)) {
            echo '<br>Match at preg 2';
            $gcfrom = $match[6];
            $gcto = $match[4];
            $isgcmatch = true;
        } else if (preg_match("~^(gc|greet(ings?)?)\b ?\((.+)\).*\((.+)\)~", $req, $match)) {
            echo '<br>Match at preg 3';
            $gcfrom = trim($match[3]);
            $gcto = trim($match[4]);
            $isgcmatch = true;
        } else if (preg_match("~^(gc|greet(ings?)?) <(.+)>.*<(.+)>~", strtolower(trim($query_in)), $match)) {
            echo '<br>Match at preg 4';
            $gcfrom = trim($match[3]);
            $gcto = trim($match[4]);
            $isgcmatch = true;
        } else if (preg_match("~^(gc|greet(ings?)?) \b(.+)\b[,-:/|]\b(.+)\b~", $req, $match)) {
            echo '<br>Match at preg 5';
            $gcfrom = trim($match[3]);
            $gcto = trim($match[4]);
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
                if ($operator == 'airtel' && !$is_ussd) {
                    echo $from_time = date("Y/m/d H:i:s", strtotime("now - 24 hour"));
                    echo $q = "select gcgroup,gcsubgroup from gc_data where msisdn = '$numbers' and gcgroup <> 0 and gcsubgroup <> 0 and istweet = 0 and isvideo = 0 and `timestamp` > '$from_time' order by `timestamp` desc limit 1";
                    $r = mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
                    $num_row = mysql_num_rows($r);
                }
                if ($num_row) {
                    $row = mysql_fetch_array($r);
                    $gcgroup = $row['gcgroup'];
                    $gcsubgroup = $row['gcsubgroup'];
                } else {
                    echo "circle__:$circle";

//                    if (($operator == 'airtel' || $operator == 'aircel' || $operator == 'docomo') && ($circle == 'JK' || $circle == 'JAMMU & KASHMIR')) {
//                        $gcgroup = 58;
//                        $gcsubgroup = 85;
//                    } elseif (($operator == 'airtel' || $operator == 'aircel' || $operator == 'docomo') && ($circle == 'UE' || $circle == 'DL' || $circle == 'UW' || $circle == 'PB' || $circle == 'HR' || $circle == 'HP' || $circle == 'DELHI' || $circle == 'HIMACHAL PRADESH' || $circle == 'HARYANA' || $circle == 'PUNJAB' || $circle == 'UTTAR PRADESH (W) & UTTARAKHAND' || $circle == 'UTTAR PRADESH (E)')) {
//                        $gcgroup = 61;
//                        $gcsubgroup = 88;
//                    } elseif (($operator == 'airtel' || $operator == 'aircel' || $operator == 'docomo') && ($circle == 'KL' || $circle == 'KERALA' || $circle == 'KA' || $circle == 'KARNATAKA')) {
//                        $gcgroup = 62;
//                        $gcsubgroup = 89;
//                    } elseif (($operator == 'airtel' || $operator == 'aircel' || $operator == 'docomo') && ($circle == 'TN' || $circle == 'CH' || $circle == 'TAMILNADU' || $circle == 'CHENNAI' )) {
//                        $gcgroup = 63;
//                        $gcsubgroup = 90;
//                    } else {
//                    if ($circle_short == "KL") {
//                        $gcgroup = 89;
//                        $gcsubgroup = 125;
//                    } else {
                    $gcgroup = 44;
                    $gcsubgroup = 64;
//                    }
//                    }
                }
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
                    if ($gcfree) {
                        $free = true;
                    } else {
                        $charge_per_query = 3;
                        $free = false;
                    }
                }
                $total_return = "Dear $gcto, $gcfrom has sent a $card_name greeting card for you! To open click on\n$gclink\n";
                $total_return .= "$brows_charge";

                if ($operator == "vodafone") {
                    $total_return.="\nPlease forward this link to your friend if you have liked this or else press 1 for Another design";
                }

                if ($operator == 'airtel') {
                    $total_return .= "\n--\nTo send free unlimited greeting cards dial *321*552# at Rs. 10/7 days.";
                } else if ($operator == 'aircel') {
                    $total_return = "Dear $gcto. I have sent a $card_name greeting card for you! To open click on link\n$gclink\n";
                    $total_return .= "$brows_charge";
                    $total_return .= "\n--\nSMS GC<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Aircel Number. @Rs1";
                }


                //next card
                if ($operator == "vodafone") {
                    $options_list[] = "another design";
                    $list[] = array("content" => "_gc_next_" . $gcfrom . "__$gcto" . "__" . $gcgroup . "__" . $gcsubgroup . "__" . $card_name . "__");
                }

                //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
                $service_name = 'gc';
                $product_name_tag = 'mCards';
                $to_logserver['source'] = 'gc';

//                if ($numbers == "9741804522" || $numbers == "9741931588" || $numbers = "9895336078") {
//                    include 'allmanip.php';
//                }
                if ($operator != 'airtel') {
                    include 'allmanip.php';
                }
                putOutput($total_return);
//            } else {
////                $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',1,2)";
////                mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
////                mysql_close();
////                include 'lib/appconfigdb.php';
////                $charge_per_query = 3;
//                $free = true;
//                $total_return = "Happy Raksha Bandhan!! Select your card type:\n";
//                $options_list[] = "Sister to Brother @Rs 3 per card";
//                $list[] = array("content" => "_gc_s2b_$gcfrom" . "__$gcto", "count" => 1);
//                $options_list[] = "Brother to Sister @Rs 3 per card";
//                $list[] = array("content" => "_gc_b2s_$gcfrom" . "__$gcto", "count" => 2);
//                include 'allmanip.php';
//                putOutput($total_return);
//            }
                exit();
            }
        }
    }
}
//}
elseif (($operator == 'aircel') && preg_match("~^(gcusa|usa|gcmonsoon|monsoon)\b~", $req, $match)) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    $isgcmatch = false;
    $req = trim(preg_replace("~[\s]+~", " ", $req));
    $mch = trim(preg_replace("~[\s]+~", " ", $mch));
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

            $total_return = "Dear $gcto, $gcfrom has sent a $card_name greeting card for you! To open click on link\n$gclink\n";
            $total_return .= "$brows_charge";



            if ($operator == 'airtel') {
                $total_return .= "\n--\nDial *321*552#$tollfree to send customized cards to your loved ones!";
            } else if ($operator == 'aircel') {
                $total_return = "Dear $gcto. I have sent a $card_name greeting card for you! To open click on link\n$gclink\n";
                $total_return .= "$brows_charge";
                $total_return .= "\n--\nSMS $mch<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Aircel Number. @Rs1";
            }

            //gcnext
//            if ($numbers == "9741804522") {
//                $options_list[] = "another design";
//                $list[] = array("content" => "_gc_next_" . $gcfrom . "__$gcto" . "__" . $gcgroup . "__" . $gcsubgroup . "__" . $card_name . "__");
//            }
            $service_name = 'gc';
            $product_name_tag = 'mCards';
            $to_logserver['source'] = 'gc';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}

//elseif (($operator == 'aircel' || $operator == 'airtel') && preg_match("~^(gcm|gcf|gcw|gcg|gcs)\b~", $req, $match)) {
//    echo "<br>GREETING CARD WITH NAME<br>";
//    $mch = $match[1];
//    $flag_enabled = false;
//    $isgcmatch = false;
//    $req = trim(preg_replace("~[\s]+~", " ", $req));
//    $mch = trim(preg_replace("~[\s]+~", " ", $mch));
//    if (preg_match("~^$mch (fro?m)? ?(.+) (to|2|and) (.+)~", $req, $match)) {
//        echo '<br>Match at preg 1';
//        $gcfrom = $match[2];
//        $gcto = $match[4];
//        $isgcmatch = true;
//    } else if (preg_match("~^$mch (to|2)? ?(.+) (fro?m) (.+)~", $req, $match)) {
//        echo '<br>Match at preg 2';
//        $gcfrom = $match[4];
//        $gcto = $match[2];
//        $isgcmatch = true;
//    } else if (preg_match("~^$mch \((.+)\).*\((.+)\)~", $req, $match)) {
//        echo '<br>Match at preg 3';
//        $gcfrom = trim($match[1]);
//        $gcto = trim($match[2]);
//        $isgcmatch = true;
//    } else if (preg_match("~^$mch <(.+)>.*<(.+)>~", strtolower(trim($query_in)), $match)) {
//        echo '<br>Match at preg 4';
//        $gcfrom = trim($match[1]);
//        $gcto = trim($match[2]);
//        $isgcmatch = true;
//    } else if (preg_match("~^$mch \b(.+)\b[,-:/|]\b(.+)\b~", $req, $match)) {
//        echo '<br>Match at preg 5';
//        $gcfrom = trim($match[1]);
//        $gcto = trim($match[2]);
//        $isgcmatch = true;
//    } else if (str_word_count($req) == 3) {
//        echo '<br>Match at preg 6';
//        $match = explode(' ', $req);
//        print_r($match);
//        $gcfrom = $match[1];
//        $gcto = $match[2];
//        $isgcmatch = true;
//    } else if (str_word_count($req) == 5) {
//        echo '<br>Match at preg 7';
//        $match = explode(' ', $req);
//        print_r($match);
//        $gcfrom = "$match[1] $match[2]";
//        $gcto = "$match[3] $match[4]";
//        $isgcmatch = true;
//    }
//
//    if (!$isgcmatch) {
//        $gc_req = preg_replace("~^$mch ~", '', $req);
//        if (preg_match_all("~[\w\d]{3,}~", $gc_req, $match)) {
//            print_r($match);
//            $gc_count = count($match[0]);
//            if ($gc_count > 0 && $gc_count < 9) {
//                echo '<br>Match at preg 8';
//                $gcfrom = '';
//                $gcto = '';
//                for ($i = 0; $i < $gc_count / 2; $i++)
//                    $gcfrom .= $match[0][$i] . ' ';
//                for ($i; $i < $gc_count; $i++)
//                    $gcto .= $match[0][$i] . ' ';
//                echo $gcfrom = trim($gcfrom);
//                echo $gcto = trim($gcto);
//                $isgcmatch = true;
//            }
//        }
//    }
//
//    if ($isgcmatch) {
//        $gcfrom = ucwords((string) $gcfrom);
//        $gcto = ucwords((string) $gcto);
//        echo "<br>From:";
//        var_dump($gcfrom);
//        echo "<br>To:";
//        var_dump($gcto);
//        if (strlen($gcfrom) < 30 && (strlen($gcto) < 30 )) {
//            echo "<br>Inside GC result";
//            $uniq_id = uniqid();
//            mysql_close();
//            include 'lib/configdb_up.php';
//            echo "circle__:$circle";
//            switch ($mch) {
//                case 'gcm':
//                    $gcgroup = 47;
//                    $gcsubgroup = 70;
//                    break;
//                case 'gcs':
//                    $gcgroup = 47;
//                    $gcsubgroup = 71;
//                    break;
//                case 'gcg':
//                    $gcgroup = 47;
//                    $gcsubgroup = 72;
//                    break;
//                case 'gcw':
//                    $gcgroup = 47;
//                    $gcsubgroup = 73;
//                    break;
//                case 'gcf':
//                    $gcgroup = 47;
//                    $gcsubgroup = 74;
//                    break;
//                default:
//                    break;
//            }
//            $q = "select subname from gc_subgroup where id=$gcsubgroup";
//            $r = mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
//            if (mysql_num_rows($r)) {
//                $row = mysql_fetch_array($r);
//                $card_name = ucwords($row['subname']);
//            } else {
//                $card_name = 'customized';
//            }
//            $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',$gcgroup,$gcsubgroup)";
//            mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
//            $gclink = 'http:///?c=' . urlencode($uniq_id);
//
//            $total_return = "Dear $gcto, $gcfrom has sent a $card_name greeting card for you! To open click on link\n$gclink\n";
//            $total_return .= "Browsing charges$brows_charge apply.";
//            if ($operator == 'airtel') {
//                $total_return .= "\n--\nDial *321*552#$tollfree to send customized cards to your loved ones!";
//            } else if ($operator == 'aircel') {
//                $total_return = "Dear $gcto. Happy $card_name. I have sent a $card_name greeting card for you! To open click on link\n$gclink\n";
//                $total_return .= "Browsing charges$brows_charge apply.";
//                $total_return .= "\n--\nSMS $mch<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Aircel Number. @Rs1";
//            }
//
//
//            $options_list[] = "another design";
//            $list[] = array("content" => "_gc_next_" . $gcfrom . "__$gcto" . "__" . $gcgroup . "__" . $gcsubgroup . "__" . $card_name . "__");
//
//            $service_name = 'gc';
//            $product_name_tag = 'mCards';
//            $to_logserver['source'] = 'gc';
//            include 'allmanip.php';
//            putOutput($total_return);
//            exit();
//        }
//    }
//} 
elseif ($operator == "vodafone" && preg_match("~^\b(fb|fd|kj|ind|gac|nv) (.+)\b~", $req, $match)) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    $isgcmatch = false;
    $req = trim(preg_replace("~[\s]+~", " ", $req));
    $mch = trim(preg_replace("~[\s]+~", " ", $mch));
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

                default:
                    break;
            }
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

            $total_return = "Dear $gcto, $gcfrom has sent a $card_name greeting card for you! To open click on link\n$gclink\n";
            $total_return .= "$brows_charge";

            if ($operator == "vodafone") {
                $options_list[] = "another design";
                $list[] = array("content" => "_gc_next_" . $gcfrom . "__$gcto" . "__" . $gcgroup . "__" . $gcsubgroup . "__" . $card_name . "__");
            }

            $service_name = 'gc';
            $product_name_tag = 'mCards';
            $to_logserver['source'] = 'gc';
            include 'allmanip.php';

            putOutput($total_return);
            exit();
        }
    }
} elseif (preg_match("~^\b(gclove|gcg|gcfrnd|gcthank|gcsorry|gcbday|gcstb|gcbts|gcfriend|rb|rd|gcramadan|gcjan|gc15|gceid|gconam|gcvk|md|dp|em|ds|kc|kl|ka|hr|dw|cd|mc|bd|bb) (.+)\b~", $req, $match) || (preg_match("~^\b(dw\d{1,2}) (.+)\b~", $req, $match) && $operator == "idea")) {
    echo "<br>GREETING CARD WITH NAME<br>";
    $mch = $match[1];
    $flag_enabled = false;
    $isgcmatch = false;
    $req = trim(preg_replace("~[\s]+~", " ", $req));
    $mch = trim(preg_replace("~[\s]+~", " ", $mch));
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
                case 'gcramadan':
                case 'rd':
                    $gcgroup = 79;
                    $gcsubgroup = 114;
                    break;
                case 'rb':
                    $gcgroup = 83;
                    $gcsubgroup = 119;
                    break;
                case 'gcjan':
                    $gcgroup = 86;
                    $gcsubgroup = 122;
                    break;
                case 'gc15':
                    $gcgroup = 87;
                    $gcsubgroup = 123;
                    break;
                case 'gceid':
                    $gcgroup = 88;
                    $gcsubgroup = 124;
                    break;
                case 'gconam':
                    $gcgroup = 89;
                    $gcsubgroup = 125;
                    break;
                case 'gcvk':
                    $gcgroup = 93;
                    $gcsubgroup = 129;
                    break;
                case 'gcg':
                    $gcgroup = 97;
                    $gcsubgroup = 133;
                    break;
                case 'md':
                    $gcgroup = 94;
                    $gcsubgroup = 130;
                    break;
                case 'dp':
                    $gcgroup = 12;
                    $gcsubgroup = 17;
                    break;
                case 'em':
                    $gcgroup = 8;
                    $gcsubgroup = 13;
                    break;
                case 'ds':
                    $gcgroup = 13;
                    $gcsubgroup = 21;
                    break;
                case 'kc':
                    $gcgroup = 98;
                    $gcsubgroup = 134;
                    break;
                case 'kl':
                    $gcgroup = 99;
                    $gcsubgroup = 135;
                    break;
                case 'ka':
                    $gcgroup = 100;
                    $gcsubgroup = 136;
                    break;
                case 'hr':
                    $gcgroup = 101;
                    $gcsubgroup = 137;
                    break;
                case 'dw':
                case 'dw1':
                case 'dw2':
                case 'dw3':
                case 'dw4':
                case 'dw5':
                case 'dw6':
                case 'dw7':
                case 'dw8':
                case 'dw9':
                case 'dw10':
                    $gcgroup = 102;
                    $gcsubgroup = 138;
                    break;
                case 'cd':
                    $gcgroup = 104;
                    $gcsubgroup = 140;
                    break;
                case 'mc':
                    $gcgroup = 105;
                    $gcsubgroup = 141;
                    break;
                case 'bd':
                case 'bb':
                    $gcgroup = 106;
                    $gcsubgroup = 142;
                    break;
                default:
                    break;
            }
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

            if ($operator != 'airtel') {
                include 'allmanip.php';
            }
            putOutput($total_return);
            exit();
        }
    }
}
?>