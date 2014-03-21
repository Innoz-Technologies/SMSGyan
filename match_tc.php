<?php

$isSpecial = false; //for rajinikanth
if (preg_match("~__tweet__from__(.*)__~", $req, $match)) {

    //tc_name_sugg:myname1__suggestion2

    echo "<h3>tc_name_sugg</h3>";
    $from = ucwords($match[1]);

    $tweet = "$from had sent you a birthday card!";
    do_tweet($tweet, "@arrahman");
    $charge_per_query = 3;
    $free = false;
    $total_return = "Thank you for using this service.";
    $service_name = 'tc';
    $product_name_tag = 'Tweet a Card';
    $to_logserver['source'] = 'tc';
    putOutput($total_return);
    exit();
} else if (strpos($query_in, "tc_name_sugg:") !== false) {

    //tc_name_sugg:myname1__suggestion2

    echo "<h3>tc_name_sugg</h3>";

    $sugg_query = str_replace("tc_name_sugg:", "", $query_in);
    $subs = explode("__", $sugg_query);

    $from = ucwords($subs[0]);
    $suggestion = ucwords($subs[1]);

    $tweet = "$from has suggested the name $suggestion for your Beti B";
    do_tweet($tweet, "@juniorbachchan");
    $charge_per_query = 3;
    $free = false;
    $total_return = "Thank you for using Tweet a Card. Your suggestion has been sent to Abhishek Bachchan from @mcardgreetings";
    $service_name = 'tc';
    $product_name_tag = 'Tweet a Card';
    $to_logserver['source'] = 'tc';
    putOutput($total_return);
    exit();
} else if (preg_match("~^__tc__(.+)__from__(.+)__to__(.+)__handle__(.+)__charge__([\d]{1,2})__only$~", $query_in, $match)) {
    echo "<br>TWEET CARD<br>";
    var_dump($match);

    if ($match[3] == 'Dear Sharuk') {
        $total_return = "Thank You for using tweet a card. Your card has been delivered to SRK on twitter.";
    } else if ($match[3] == 'Dear Knight Riders') {
        $total_return = "Thank You for using tweet a card. Your card has been delivered to KKR on twitter.";
    } else if ($match[3] == 'Dear Rajinikanth') {
        $isSpecial = true;
        $total_return = "Thank You for using tweet a card. Your card has been delivered to Rajini on twitter.";
    } else {
        $total_return = "Thank you for using Tweet a card. Your card has been sent to $match[3].";
    }
    if (!$isSpecial) {
        $status_msg = $match[4];
        $status_msg = str_replace('<gcfrom>', $match[2], $status_msg);
        $status_msg .= " " . $match[1];
        echo "<br> MSG READY";
        require_once('twitteroauth/twitteroauth.php');
        require_once('twitteroauth/config.php');
        echo "<br> included";
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
        echo "<br> object created";
        echo "<br> $status_msg";
        $connection->post('statuses/update', array('status' => $status_msg));

        $charge_per_query = 3;
        if ($match[5] == 0) {
            $free = true;
        } else {
            $charge_per_query = $match[5];
            $free = false;
        }
        $service_name = 'tc';
        $product_name_tag = 'Tweet a Card';
        $to_logserver['source'] = 'tc';
        putOutput($total_return);
        exit();
    }

    $req = 'tc ' . $match[2];
    $charge_per_query = 3;
    if ($match[5] == 0) {
        $free = true;
    } else {
        $charge_per_query = $match[5];
        $free = false;
    }
}

if (preg_match("~^(tc|tweet(cards?)?)\b~", $req)) {
    echo "<br>TWEET CARD WITH NAME<br>";
    $u_name = preg_replace("~^(tc|sachin|tweet(cards?)?|cards?)\b~", '', $req);
    $u_name = remwords($u_name);
    $u_name = SafeSearch($u_name);
    $u_name = trim(preg_replace("~[\s]+~", " ", $u_name));
    $w_count = str_word_count($u_name);
    if ($w_count > 0 && $w_count < 4 && strlen($u_name) < 25) {
        echo strtoupper($circle_short);
        $gcfrom = (string) ucfirst($u_name) . "," . strtoupper($circle_short);

        /* $gcto = 'Dear Amitabh Bachchan';
          $gcmsg = 'Amitabh Bachchan'; */

        $gcto = 'Dear AR Rahman';
        $gcmsg = 'AR Rahman';

        echo "<br>From:";
        var_dump($gcfrom);
        echo "<br>To:";
        var_dump($gcto);

        echo "<br>Inside TC result";
        $uniq_id = uniqid();
        mysql_close();
        include 'lib/configdb_up.php';
//            $gcgroup = 15;
//            $gcsubgroup = 23;

        $gcgroup = 31;
        $gcsubgroup = 44;  //Deepika Padukone

        $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup,istweet) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',$gcgroup,$gcsubgroup,1)";
        mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
        $gclink = 'http://domain/' . urlencode($uniq_id);

        if (!$isSpecial) {
            if ($operator == 'airtel') {
                $charge_per_query = 3;
                $free = false;
            }
        }
        //$status_msg = "@SrBachchan Happy Birthday Amitabh Bachchan : $gcfrom $gclink";

        $status_msg = "@arrahman Happy Birthday! $gcmsg : $gcfrom $gclink";
        echo "<br> MSG READY [ $status_msg ]<br>";
        require_once('twitteroauth/twitteroauth.php');
        require_once('twitteroauth/config.php');
        echo "<br> included";
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
        echo "<br> object created";
        var_dump($connection->post('statuses/update', array('status' => $status_msg)));
        echo "<br>tweeted";
        $total_return = "Thank you for using Tweet a card service. Your card has been sent to $gcmsg.\nImage: $gclink ";
//        $total_return .= "Browsing charges(10p/10kB) apply.";
//        $total_return .= "\n--\nDial *321*552# (Tollfree) to send customized cards to your loved ones!";
        //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
        $service_name = 'tc';
        $product_name_tag = 'Tweet a Card';
        $to_logserver['source'] = 'tc';
        putOutput($total_return);

        exit();
    }
} elseif (preg_match("~^(bp)\b~", $req)) {
    if ($number != '7709087556') {
        echo "<br>TWEET CARD WITH NAME<br>";
        $u_name = preg_replace("~^(bp)\b~", '', $req);
        $u_name = remwords($u_name);
        $u_name = SafeSearch($u_name);
        $u_name = trim(preg_replace("~[\s]+~", " ", $u_name));
        $w_count = str_word_count($u_name);
        if ($w_count > 0 && $w_count < 4 && strlen($u_name) < 20) {
            $gcfrom = (string) ucfirst($u_name);
            $gcto = 'Dear Bipasha';
            $gcmsg = 'Bipasha Basu';
            echo "<br>From:";
            var_dump($gcfrom);
            echo "<br>To:";
            var_dump($gcto);

            echo "<br>Inside TC result";
            $uniq_id = uniqid();
            mysql_close();
            include 'lib/configdb_up.php';
            $gcgroup = 32;
            $gcsubgroup = 45;

            $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup,istweet) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',$gcgroup,$gcsubgroup,1)";
            mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
            $gclink = 'http://domain/?c=' . urlencode($uniq_id);

            if ($operator == 'airtel') {
                $charge_per_query = 3;
                $free = false;
            }
            $status_msg = "@bipsluvurself Happy Birthday Bipasha Basu : $gcfrom $gclink";
            echo "<br> MSG READY";
            require_once('twitteroauth/twitteroauth.php');
            require_once('twitteroauth/config.php');
            echo "<br> included";
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
            echo "<br> object created";
            $connection->post('statuses/update', array('status' => $status_msg));
            echo "<br>tweeted";
            $total_return = "Thank you for using Tweet a card service. Your card has been sent to $gcmsg.";
//            $total_return .= "Browsing charges(10p/10kB) apply.";
//            $total_return .= "\n--\nDial *321*552# (Tollfree) to send customized cards to your loved ones!";
            //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
            $service_name = 'tc';
            $product_name_tag = 'Tweet a Card';
            $to_logserver['source'] = 'tc';
            putOutput($total_return);

            exit();
        }
    }
}
/* elseif (preg_match("~^(fa)\b~", $req)) {
  if ($number != '7709087556') {
  echo "<br>TWEET CARD WITH NAME<br>";
  $u_name = preg_replace("~^(fa)\b~", '', $req);
  $u_name = remwords($u_name);
  $u_name = SafeSearch($u_name);
  $u_name = trim(preg_replace("~[\s]+~", " ", $u_name));
  $w_count = str_word_count($u_name);
  if ($w_count > 0 && $w_count < 4 && strlen($u_name) < 20) {
  $gcfrom = (string) ucfirst($u_name);
  $gcto = 'Dear Farhan';
  $gcmsg = 'Farhan Akhtar';
  echo "<br>From:";
  var_dump($gcfrom);
  echo "<br>To:";
  var_dump($gcto);

  echo "<br>Inside TC result";
  $uniq_id = uniqid();
  mysql_close();
  include 'lib/configdb_up.php';
  $gcgroup = 33;
  $gcsubgroup = 46;

  $q = "insert into gc_data(sesn,msisdn,circle,gcfrom,gcto,gcgroup,gcsubgroup,istweet) values('$uniq_id','$numbers','$circle','" . mysql_real_escape_string($gcfrom) . "','" . mysql_real_escape_string($gcto) . "',$gcgroup,$gcsubgroup,1)";
  mysql_query($q) or trigger_error(mysql_error(), E_USER_ERROR);
  $gclink = 'http://domain/?c=' . urlencode($uniq_id);

  if ($operator == 'airtel') {
  $charge_per_query = 3;
  $free = false;
  }
  $status_msg = "@FarOutAkhtar Happy Birthday Farhan Akhtar : $gcfrom $gclink";
  echo "<br> MSG READY";
  require_once('twitteroauth/twitteroauth.php');
  require_once('twitteroauth/config.php');
  echo "<br> included";
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
  echo "<br> object created";
  $connection->post('statuses/update', array('status' => $status_msg));
  echo "<br>tweeted";
  $total_return = "Thank you for using Tweet a card service. Your card has been sent to $gcmsg.";
  //            $total_return .= "Browsing charges(10p/10kB) apply.";
  //            $total_return .= "\n--\nDial *321*552# (Tollfree) to send customized cards to your loved ones!";
  //$total_return = $total_return . "\n--\nTo send your Friend a customised greeting card, Sms GC <your name> TO <friends name> to $shortcode @ Rs. 3.";
  $service_name = 'tc';
  $product_name_tag = 'Tweet a Card';
  $to_logserver['source'] = 'tc';
  putOutput($total_return);

  exit();
  }
  }
  } */

function do_tweet($tweet, $to) {
    $status_msg = "$to $tweet";
    require_once('twitteroauth/twitteroauth.php');
    require_once('twitteroauth/config.php');
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
    $connection->post('statuses/update', array('status' => $status_msg));
}

?>