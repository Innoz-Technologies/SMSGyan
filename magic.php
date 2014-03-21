<?php

if ($spell_checked == "magic") {

    if ($circle_short == "NE" || $circle_short == "AS") {
        $total_return = "1.Win Hyundai EON daily.. Dial 5670330(tollfree)\n2.Win Rs10 lacs GOLD….Dial 556770(tollfree)\n3.Win Wagon R, Honda stunner.. Dial 545450(tollfree)\n4.Win gift worth Rs5000, Participate on Assamese Megazine Bismoi Quiz Contest Sms BISMOI to 55444@Re1\n5.Latest hit Callertune! Dial 123(tollfree)\n6.Send sms at very cheap rate only on Vodafone Prepaid. Recharge Sms Bonus Card 34 & send v2v sms at 5p & V2O at 10p for 90 days";
        $showsuboption = FALSE;
//        $total_return = "1.Get 1000 sms only at Rs34, Sms ACT SEG34 to 144(tollfree), Val 30days.\n2.Get 500MB data free at Rs25, Sms ACT TRY2G to 111(tollfree), Val 7 days.\n3.Win Car, Bike, Cash & Talk time. Dial 123(tollfree)";
    } elseif ($circle_short == "CH" || $circle_short == "TN") {

        $total_return = "Please select any option";

        $options_list[] = "Win Movie tickets,Car,Ipads";
        $list[] = array("content" => "__magic__playnwinch__");
        $options_list[] = "VAS SPECIAL OFFERS";
        $list[] = array("content" => "__magic__vasspcloffr__");
        $options_list[] = "Vodafone Internet offers";
        $list[] = array("content" => "__magic__internetoffr__");
//        $options_list[] = "SPECIAL DEALS AND DISCOUNTS";
//        $list[] = array("content" => "__magic__deal__");
//        $options_list[] = "Vodafone Live";
//        $list[] = array("content" => "__magic__vodafonelive__");
    } else {
        $total_return = "Please select any option";

        $options_list[] = "caller tune";
        $list[] = array("content" => "__magic__callertune__");
        $options_list[] = "vas";
        $list[] = array("content" => "__magic__vas__");
//        $options_list[] = "special services";
//        $list[] = array("content" => "__magic__specialservices__");
        $options_list[] = "Play N Win";
        $list[] = array("content" => "__magic__playnwin__");
        $options_list[] = "SMS offers";
        $list[] = array("content" => "__magic__smsoffers__");
//        if ($userid == "voda_ussd") {
//            $options_list[] = "SMS + Data Offers";
//            $list[] = array("content" => "__magic__smsoffers__");
//        }
//        else
//            $add_below = "\n--\nSearch anything on your mobile! For eg To know word meaning type the word and send it to $shortcode @$charge_currency $charge_per_query";
    }
//    $add_below = "\n--\nData Offer - SMS TRY to 111";
//    $options_list[] = "main menu";
//    $list[] = array("content" => "magic");
} elseif ($req == "__magic__callertune__") {
    $total_return = "Free Caller Tune Dial 1234(Tollfree)\nLatest Caller Tune Dial *567# Rs30/Mth\nSearch Song- SMS \"SongName\" to 55655(FREE)";

    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__vas__") {
    $total_return = "Free Kundali Dial 55315\nCricket Alert Dial *567*4# Rs5\nDelhi Jobs *108*1#Rs30/mth\nMusic Magic Dial 573735(FREE) ";

    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__specialservices__") {
    $total_return = "5 in 1 Sports Dial *123*555#  Rs5/Matchday\nMusic Junction Dial *567*967# Rs30/Month\nAll Combo Pack  Dial *123*3# at Rs 3/Day\nFree Kundali Dial 55315\nBest Jobs *108*101# Rs2/day";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__playnwin__") {
    $total_return = "Win FLATS Dial *567*899# Rs5\nWin Gold Dial*545*1# at Rs3";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__smsoffers__") {
    $total_return = "Free 150 Local+National sms for 15 days.Dial *444*19# Rs19\nFree 500 Local+National sms for 28 days.Dial *444*49# Rs49.\nFree 1000 Local+National sms for 28 days.Dial *444*89# Rs89";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__playnwinch__") {
    $total_return = "1a)Play for 7 days a week and Win movie tickets.Walk to your nearest Vodafone store for details\n1b) Win SWIFT CAR.Dial 556770(Tollfree)\n1c)WIN IPAD and Daily Recharge.SMS ACT WIN to 111/144.Rs.2/day";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__vasspcloffr__") {
    $total_return = "2a)Get Missed calls details at Rs.1/day.SMS ACT DMCI to 111/144\n2b)Get Cricket score update. SMS ACT CRIC to 111/144.R5 /day\n2c) Jobs on SMS.Dial 54701 to subscribe\n2d) Google on SMS.Search unlimited for anything.SMS SEARCH to 55444.Re1/SMS";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__internetoffr__") {
    $total_return = "3a) Kollywood, Bollywood & Hollywood Songs!! Click here http://goo.gl/VP1h0E\n3b) Unlimited Tamil Mega Hits!! Click here http://goo.gl/h2iE3w\n3c)Ask questions to doctor on SEX,Diet tips,etc.SMS HC5 to 111(Tollfree)";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__deal__") {
    $total_return = "1.Dial *111# for Discounts and deals on mobile,food,etc";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
} elseif ($req == "__magic__vodafonelive__") {
    $total_return = "1.Download Songs,Images,wallpapers.SMS ONE to 111(Tollfree)\n2.Watch live tv channels on mobile.SMS TV to 111(Tollfree)\n3.Ask questions to doctor on SEX,Diet tips,etc.SMS HC5 to 111(Tollfree)";
    $options_list[] = "main menu";
    $list[] = array("content" => "magic");
}

if ($total_return) {
    if ($circle_short == 'DL' || $circle_short == 'NE' || $circle_short == 'AS')
        $nextfree = $free = TRUE;
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);

    if ($userid == "voda_ussd")
        $to_logserver['source'] = 'magicussd';
    else
        $to_logserver['source'] = 'magic';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
