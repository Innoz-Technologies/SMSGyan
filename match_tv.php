<?php
include_once 'check_tvchannel.php'; //check whether any channel name present without keywords

if (preg_match("~\b(t\.?v|channel|schedule|programs?|(timing)s?)\b~", $spell_checked)) {
    echo "<br>TV SCHDULE<br>";

    if (preg_match("~^[^\w]*tv~", $spell_checked)) {
        $tvmust = true;
    } else {
        $tvmust = false;
    }

    if (!preg_match("~\b(who|where|how|route|direction|poem|climate|cri|score|review|train)\b~", $spell_checked) || $tvmust) {
        $tv_req = preg_replace("~\b(t\.?v|channel|schedule|programs?|(timing)s?|name|which|when|give me|tell me|please|pleese|what|long|have|been|of|in|no|pnr|journey|need|help|all|or|before|after|then|list|i want to|want|for|is|was|i|mail|charge|fron|murder|metro)\b~", "", $spell_checked);

        $splited = matchdate($tv_req);
        if (isset($splited[2])) {
            $tv_req = $splited[0];
            $getdate = $splited[2];
        }

        $tv_srch = $tv_req;

        $tv_req = preg_replace("~[^\w\s]~", " ", $tv_req);
        $tv_req = preg_replace("~\btv|channel\b~i", "", $tv_req);
        $tv_req = trim(preg_replace("~[\s]+~", "", $tv_req));

        echo "<br>keyword $tv_req<br>";
        if (strlen($tv_req) > 0) {
            echo "<br>Including tvnow<br>";
            include 'tvin_guide.php';
        } else if ($tvmust) {
            $total_return = "Sorry, we could not find a tv channel name in your query.";
            $free = TRUE;
            $to_logserver['isresult'] = 0;
            $add_below = "\n--\nTo get TV schedule sms TV <channel name> to $shortcode";
        }
        if (strlen($total_return) > 0) {
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = 'tv';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        } else {
            $add_below = '';
        }
    }

    //If fails to give train result
//    print_r($match);
//    if (!$datemust) {
//        $add_below = "\n--\nTo get train timings SMS, TRAIN from <source> to <destination> on <date>. For eg: TRAIN FROM TRIVANDRUM TO NEW DELHI ON 2 JULY.";
//    }
}
?>