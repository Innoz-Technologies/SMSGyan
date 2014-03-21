<?php

$flag_enabled = FALSE;
echo "<h3>Valentine's</h3>";
echo $req;
if (preg_match("~__gc__(.+)_day_help__~", $req, $match)) {
    $total_return = "SMS gc <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to $shortcode and wish your loved ones with a greeting card.";

    $to_logserver['source'] = "val_$match[1]";
}

if (preg_match("~rose|rose day|roseday|propose|propose day|proposeday|chocolate|chocolate day|chocolateday|teddy|teddy day|teddyday|promise|promise day|promiseday|kiss|kiss day|kissday|hug|hug day|hugday|valentine|valentine day|valentineday|valentine's|valentine's day|valentine'sday|val day|valday|valentinesday|valentines day|valentines day special|vc|vday~", $spell_checked)) {
    echo "<br> just before aircel rose: $spell_checked";
    $spell_checked = trim($spell_checked);
    if ($spell_checked == 'rose' || $spell_checked == 'rose day' || $spell_checked == 'roseday') {
        echo "<br>inside aircel rose";
        $total_return = "Rose day special..!";
        $options_list[] = "Significance";
        $list[] = array("content" => "rose day significance");
        $options_list[] = "Messages";
        $list[] = array("content" => "rose day messages");
//        if ($operator == "aircel") {
//            $options_list[] = "Send rose day greeting cards";
//            $list[] = array("content" => "__gc__rose_day_help__");
//        } else {
//            $add_below = "\n--\nSMS rose<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Airtel Number.";
//            if ($gcfree == false) {
//                $add_below .=" @Rs. 3";
//            }
//        }
        $options_list[] = "Rose day photos";
        $list[] = array("content" => "photo rose");

        $to_logserver['source'] = 'val_rose';
    }

    if ($spell_checked == 'propose' || $spell_checked == 'propose day' || $spell_checked == 'proposeday') {
        echo "<br>inside aircel propose";
        $total_return = "Propose day special..!";
        $options_list[] = "Significance";
        $list[] = array("content" => "propose day significance");
        $options_list[] = "Messages";
        $list[] = array("content" => "propose day messages");
//        if ($operator == "aircel") {
//            $options_list[] = "Send propose day greeting cards";
//            $list[] = array("content" => "__gc__propose_day_help__");
//        } else {
//            $add_below = "\n--\nSMS propose<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Airtel Number.";
//            if ($gcfree == false) {
//                $add_below .=" @Rs. 3";
//            }
//        }
        $options_list[] = "Propose day photos";
        $list[] = array("content" => "photo propose");

        $to_logserver['source'] = 'val_propose';
    }

    if ($spell_checked == 'chocolate' || $spell_checked == 'chocolate day' || $spell_checked == 'chocolateday') {
        echo "<br>inside aircel chocolate";
        $total_return = "Chocolate day special..!";
        $options_list[] = "Significance";
        $list[] = array("content" => "chocolate day significance");
        $options_list[] = "Messages";
        $list[] = array("content" => "chocolate day messages");
//        if ($operator == "aircel") {
//            $options_list[] = "Send chocolate day greeting cards";
//            $list[] = array("content" => "__gc__chocolate_day_help__");
//        } else {
//            $add_below = "\n--\nSMS chocolate<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Airtel Number.";
//            if ($gcfree == false) {
//                $add_below .=" @Rs. 3";
//            }
//        }
        $options_list[] = "Chocolate day photos";
        $list[] = array("content" => "photo chocolate day");

        $to_logserver['source'] = 'val_chocolate';
    }

    if ($spell_checked == 'teddy' || $spell_checked == 'teddy day' || $spell_checked == 'teddyday') {
        echo "<br>inside aircel Teddy";
        $total_return = "Teddy day special..!";
        $options_list[] = "Significance";
        $list[] = array("content" => "teddy day significance");
        $options_list[] = "Messages";
        $list[] = array("content" => "teddy day messages");
//        if ($operator == "aircel") {
//            $options_list[] = "Send teddy day greeting cards";
//            $list[] = array("content" => "__gc__teddy_day_help__");
//        } else {
//            $add_below = "\n--\nSMS teddy<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Airtel Number.";
//            if ($gcfree == false) {
//                $add_below .=" @Rs. 3";
//            }
//        }
        $options_list[] = "Teddy day photos";
        $list[] = array("content" => "photo teddy day");

        $to_logserver['source'] = 'val_teddy';
    }

    if ($spell_checked == 'promise' || $spell_checked == 'promise day' || $spell_checked == 'promiseday') {
        echo "<br>inside aircel Promise";
        $total_return = "Promise day special..!";
        $options_list[] = "Significance";
        $list[] = array("content" => "promise day significance");
        $options_list[] = "Messages";
        $list[] = array("content" => "promise day messages");
//        if ($operator == "aircel") {
//            $options_list[] = "Send promise day greeting cards";
//            $list[] = array("content" => "__gc__promise_day_help__");
//        } else {
//            $add_below = "\n--\nSMS promise<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Airtel Number.";
//            if ($gcfree == false) {
//                $add_below .=" @Rs. 3";
//            }
//        }
        $options_list[] = "Promise day photos";
        $list[] = array("content" => "photo promise day");

        $to_logserver['source'] = 'val_promise';
    }

    if ($spell_checked == 'kiss' || $spell_checked == 'kiss day' || $spell_checked == 'kissday') {
        echo "<br>inside aircel Kiss";
        $total_return = "Kiss day special..!";
        $options_list[] = "Significance";
        $list[] = array("content" => "kiss day significance");
        $options_list[] = "Messages";
        $list[] = array("content" => "kiss day messages");
//        if ($operator == "aircel") {
//            $options_list[] = "Send kiss day greeting cards";
//            $list[] = array("content" => "__gc__kiss_day_help__");
//        } else {
//            $add_below = "\n--\nSMS kiss<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Airtel Number.";
//            if ($gcfree == false) {
//                $add_below .=" @Rs. 3";
//            }
//        }
        $options_list[] = "Kiss day photos";
        $list[] = array("content" => "photo kiss day");

        $to_logserver['source'] = 'val_kiss';
    }

    if ($spell_checked == 'hug' || $spell_checked == 'hug day' || $spell_checked == 'hugday') {
        echo "<br>inside aircel Hug";
        $total_return = "Hug day special..!";
        $options_list[] = "Significance";
        $list[] = array("content" => "hug day significance");
        $options_list[] = "Messages";
        $list[] = array("content" => "hug day messages");

//        if ($operator == "aircel") {
//            $options_list[] = "Send hug day greeting cards";
//            $list[] = array("content" => "__gc__hug_day_help__");
//        } else {
//            $add_below = "\n--\nSMS hug<space>name1 (Sender’s Name) <space>name2 (Receiver’s Name)  to 55444 and wish your loved ones from your Airtel Number.";
//            if ($gcfree == false) {
//                $add_below .=" @Rs. 3";
//            }
//        }
        $options_list[] = "Hug day photos";
        $list[] = array("content" => "photo hug day");

        $to_logserver['source'] = 'val_hug';
    }

    if ($spell_checked == 'valentine' || $spell_checked == 'valentine day' || $spell_checked == 'valentines day' || $spell_checked == 'valentinesday' || $spell_checked == 'valentineday' || $spell_checked == "valentine's day" || $spell_checked == "valentine's" || $spell_checked == "valentine'sday" || $spell_checked == 'val day' || $spell_checked == 'valday' || $spell_checked == 'valentines day special' || $spell_checked == 'vc' || $spell_checked == 'vday') {
        echo "<br>inside aircel Valentine's";
        if (($operator == "idea" || $operator == "idea55444") && $circle_short == "KL")
            $total_return = "Valentine's Day is a day to celebrate love, the most beautiful feeling in the world !!!";
        else
            $total_return = "Valentine's day special..!";

        $options_list[] = "GREETING CARDS";
        $list[] = array("content" => "__gc__vc_day_help__");
        $options_list[] = "Wishing Messages";
        $list[] = array("content" => "valentine's day messages");

        $options_list[] = "Valentine's day tips";
        $list[] = array("content" => "__valentine__tips__");

        $options_list[] = "Valentine's week";
        $list[] = array("content" => "__valentine__week__");

//        $options_list[] = "Valentine's song";
//        $list[] = array("content" => "valentine lyrics");
        $options_list[] = "Valentine's quotes";
        $list[] = array("content" => "valentine quotes");

//        $options_list[] = "Valentine's day photos";
//        $list[] = array("content" => " photo valentines day");

        $options_list[] = "About valentine's day";
        $list[] = array("content" => "valentines");

        $to_logserver['source'] = 'val_valentine';
    }

    if (preg_match("~__valentine__week__~", $req)) {
        $total_return = "Valentine's Week";

        $options_list[] = "Rose Day";
        $list[] = array("content" => "rose day");
        $options_list[] = "Propose Day";
        $list[] = array("content" => "propose day");
        $options_list[] = "Chocolate Day";
        $list[] = array("content" => "chocolate day");
        $options_list[] = "Teddy Day";
        $list[] = array("content" => "teddy day");
        $options_list[] = "Promise Day";
        $list[] = array("content" => "promise day");
        $options_list[] = "Kiss Day";
        $list[] = array("content" => "kiss day");
        $options_list[] = "Hug Day";
        $list[] = array("content" => "hug day");

        $to_logserver['source'] = 'val_valentine';
    }

    if (preg_match("~__valentine__tips__~", $req)) {
        $total_return = "Valentine Tips";


        $options_list[] = "Costume";
        $list[] = array("content" => "valentines day costume");
        $options_list[] = "how to plan";
        $list[] = array("content" => "valentines day how to plan");
        $options_list[] = "gift ideas";
        $list[] = array("content" => "valentines day gift ideas");
        $options_list[] = "how to surprise";
        $list[] = array("content" => "valentines day how to surprise");
    }
}
if ($total_return) {
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
