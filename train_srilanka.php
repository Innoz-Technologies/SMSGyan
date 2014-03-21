<?php

if (preg_match("~\b(trains?|trauns?|tran|trian|trn|local|metro|to| 2 )\b~", $req, $match)) {
    echo "<br>TRAIN DETAILS<br>";
    echo "<br>FOR DIALOG OPERATOR<br>";
    $islocal = false;
    $islocalonly = false;
    $islocalmust = false;
    if (preg_match("~^(train )?local ~", $req)) {
        $islocalmust = true;
    }
    if ($match[1] == 'local' || $match[1] == 'metro') {
        $islocalonly = true;
    }

    if (preg_match("~local|metro~", $req)) {
        $islocal = true;
    }

    $datemust = false;
    if (($match[1] == 'to') || ($match[1] == ' 2 ')) {
        $datemust = true;
        $train_req = preg_replace("~\b(to|fro?m)\b~", '', $req);
    } else {
        $train_req = $req;
    }

    if (!preg_match("~\b(who|where|how|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review)\b~", $req)) {
        $train_req = preg_replace("~\b((trains?|trauns?|tran|trn|local|time|timing)s?|stations?|which|when|give me|tell me|please|pleese|what|go|show|me|long|travel|do|have|been|the|of|in|no|pnr|journey|need|know|help|all|and|or|before|after|then|list|first|last|i want to|want|for|go|is|was|i|express|exp|passenger|passanger|pasienger|mail|ticket|charge|fron|murder|metro|next|hour)\b~", "", $train_req);
        if (!($islocalmust || $datemust)) {
            $train_num = $train_req;
        } else {
            $train_num = '';
        }
        $splited = matchdate($train_req);
        if (isset($splited[2])) {
            $train_req = $splited[0];
            $getdate = $splited[2];
        }

        $splited = matchtime($train_req);
        if (isset($splited[2])) {
            $train_req = $splited[0];
            $gettime = $splited[2];
        }


        if (($match[1] == 'to') || ($match[1] == ' 2 ')) {
            $train_req = preg_replace("~ 2 ~", " ", $train_req);
        } else {
            $train_req = preg_replace("~ 2 ~", " to ", $train_req);
        }

        $train_req = preg_replace("~[^\w\s]|\d~", " ", $train_req);
        $train_req = trim(preg_replace("~[\s]+~", " ", $train_req));

        echo "<br>$train_req<br>";

        $ismatched = false;
        if (preg_match("~\bto\b ([\w\s]+) fro?m ([\w\s]+)~", $train_req, $match)) {
            echo '<br>Reg 1:';
            print_r($match);
            $placeFrom = $match[2];
            $placeTo = $match[1];
            $ismatched = true;
        } else if (preg_match("~.*(\b(fro?m)\b) ?([\w\s]+) to ([\w\s]+)~", $train_req, $match)) {
            echo '<br>Reg 2:';
            print_r($match);
            $placeFrom = $match[3];
            $placeTo = $match[4];
            $ismatched = true;
        } else if (preg_match("~([\w\s]+) to ([\w\s]+)~", $train_req, $match)) {
            echo '<br>Reg 3:';
            print_r($match);
            $placeFrom = $match[1];
            $placeTo = $match[2];
            $ismatched = true;
        } else if (preg_match("~([\w\s]+) (fro?m) ([\w\s]+)~", $train_req, $match)) {
            echo '<br>Reg 4:';
            print_r($match);
            $placeFrom = $match[3];
            $placeTo = $match[1];
            $ismatched = true;
        } else if (str_word_count($train_req) == 2 && $islocal) {
            echo '<br>Reg 5:';
            $match = explode(' ', $train_req);
            print_r($match);
            $placeFrom = $match[0];
            $placeTo = $match[1];
            $ismatched = true;
            $islocalonly = true;
        } //else if( str_word_count($train_req) == 6){
        //            echo '<br>Reg 6:';
        //            $match=explode(' ', $train_req);
        //            print_r($match);
        //            $placeFrom = "$match[0] $match[1] $match[2]";
        //            $placeTo = "$match[3] $match[4] $match[5]";
        //            include 'railway.php';
        //            putOutput($total_return);
        //            exit();
        //}

        if ($ismatched) {
            if ($islocal) {
                include 'sl_train.php';
                if ($total_return != '') {
                    putOutput($total_return);
                    exit();
                }
            }
            if (!$islocalonly) {
                $to_logserver['source'] = 'sl_train';
                include 'sl_train.php';
                putOutput($total_return);
                exit();
            }
        }
    }

    //If fails to give train result
    print_r($match);
    if (!$datemust) {
        if (preg_match("~train.?(time|timing|schedule)~", $spell_checked) || $spell_checked == 'train') {
            $total_return = "To get train timings SMS, TRAIN from <source> to <destination> on <date>. For eg: TRAIN FROM COLOMBO FORT TO RADELLA ON 2 JULY.";
            $free = true;
            $to_logserver['source'] = 'sl_train';
            $to_logserver['isresult'] = 0;
            include'allmanip.php';
            putOutput($total_return);
            exit();
        }
        $add_below = "\n--\nTo get train timings SMS, TRAIN from <source> to <destination> on <date>. For eg: TRAIN FROM COLOMBO FORT TO RADELLA ON 2 JULY.";
    }
}
?>
