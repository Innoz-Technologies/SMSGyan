<?php

if (strpos($req, 'hfz') !== false) {
    if (preg_match("~^mp3_download_hfz$~", $req)) {
        echo "<br>MP3 HFZ<br>";
        $total_return = "HFZ mp3 download link:\nhttp://203.115.112.5/promotiontracker/content/airtelhfzanthem.mp3";
        $total_return .= "\n$brows_charge";
        $free = false;
        $showsuboption = false;
        $charge_per_query = 3;
        $service_name = 'hfz';
        $to_logserver['source'] = 'hfz';
        $product_name_tag = 'HFZ';
        putOutput($total_return);
        exit();
    }

    if (preg_match("~^_hfz_har_friend_zaroori_$~", $req)) {
        $req = 'lyrics har friend zaroori hai Yaar';
        $spell_checked = 'lyrics har friend zaroori hai Yaar';
        $free = false;
        $showsuboption = false;
        $service_name = 'hfz';
        $to_logserver['source'] = 'hfz';
        $product_name_tag = 'HFZ';
    }

    if (preg_match("~^__helo__tune__hfz__$~", $req)) {
        $total_return = "Dial 5432111075643 to activate HFZ hello tune on your mobile.";
        $total_return .= "\nHello tune charges apply.";
        $free = false;
        $showsuboption = false;
        $service_name = 'hfz';
        $to_logserver['source'] = 'hfz';
        $product_name_tag = 'HFZ';
        putOutput($total_return);
        exit();
    }

    if (preg_match("~^photo_airtel_hfz_$~", $req)) {
        $total_return = "Wallpaper download link:\nhttp://203.115.112.5/promotiontracker/xhtml/hfzh.aspx?poid=27";
        $total_return .= "\n$brows_charge";
        $free = false;
        $showsuboption = false;
        $service_name = 'hfz';
        $to_logserver['source'] = 'hfz';
        $product_name_tag = 'HFZ';
        putOutput($total_return);
        exit();
    }

    if ($req == 'hfz') {
        echo "<br>HAR FRIEND ZAROORI";
        $total_return = "Welcome to Airtel HFZ:\n";
        $options_list[] = "LYRICS @Rs 1";
        $list[] = array("content" => "_hfz_har_friend_zaroori_", "count" => 1);
        $options_list[] = "JOKES @Rs 1";
        $list[] = array("content" => "hfz message", "count" => 2);
        $options_list[] = "HELLO TUNE @Rs 1";
        $list[] = array("content" => "__helo__tune__hfz__", "count" => 3);
        $options_list[] = "YOUTUBE VIDEO  @Rs 3";
        $list[] = array("content" => "video_id zEH6KFonIUg", "count" => 4);
        $options_list[] = "MP3 DOWNLOAD @Rs 3";
        $list[] = array("content" => "mp3_download_hfz", "count" => 5);
        $options_list[] = "QUOTES @Rs 1";
        $list[] = array("content" => "hfz quotes", "count" => 6);
        $options_list[] = "WALLPAPERS @Rs 1";
        $list[] = array("content" => "photo_airtel_hfz_", "count" => 7);

        $free = true;
        $service_name = 'hfz';
        $product_name_tag = 'HFZ';
        $to_logserver['source'] = 'hfz';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>