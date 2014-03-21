<<<<<<< .mine
<?php

if ($spell_checked == "women helpline" || $spell_checked == "women safety" || $spell_checked == "womens safety" || $spell_checked == "help women" || $spell_checked == "women safety tips" || $spell_checked == "safety tips for women" || $spell_checked == 'sos' || ($spell_checked == "bachao" && $operator == "vodafone")) {


    switch ($circle_short) {
        case 'AP':
            $sosn = '(040) 27733745';
            break;
        case 'AS':
        case 'NE':
            $sosn = '1091';
            break;
        case 'BH':
            $sosn = '1091';
//            $city = 'bihar';
            break;
        case 'CH':
        case 'TN':
            $sosn = '(044) 26530504';
//            $city = 'tamil nadu';
            break;
        case 'DL':
            $sosn = '181';
//            $city = 'delhi';
            break;
        case 'GJ':
            $sosn = '(0265) 2486487';
//            $city = 'gujarat';
            break;
        case 'HP':
            $sosn = '1800 180 8005';
//            $city = 'himanchal pradesh';
            break;
        case 'HR':
            $sosn = '1091';
//            $city = 'haryana';
            break;
        case 'JK':
            $sosn = '(0191) 2501537';
//            $city = 'jammu and kashmir';
            break;
        case 'KA':
            $sosn = '1800 425 90 900';
//            $city = 'karnataka';
            break;
        case 'KL':
            $sosn = '(0471) 10920';
//            $city = 'kerala';
            break;
        case 'KO':
        case 'WB':
            $sosn = '(0361) 2524627';
            break;
        case 'OR':
            $sosn = '(0674) 2573850';
//            $city = 'west bengal';
            break;
        case 'MB':
        case 'MH':
            $sosn = '(022)-10920';
//            $city = 'maharashtra';
            break;
        case 'MP':
        case 'CG':
            $sosn = '(0771) 2420338';
//            $city = 'madhya pradesh';
            break;
        case 'PB':
            $sosn = '1091';
            break;
        case 'RJ':
            $sosn = '(0141) 1091';
            break;
        case 'UP':
            $sosn = '1090';
            break;
        case 'UE':
        case 'UW':
            $sosn = '(0135) 2103865';
            break;
        default:
            $sosn = '181';
            break;
    }

    $total_return = "Women Safety Numbers\nPolice Station: 100\nWomen helpline: 1091\nAnti Harassment Cell for Women: $sosn\n";

    mysql_close();
    include 'lib/configdb2.php';

    $type = array("telephone safety", "automobile safety", "elevator safety", "other safety measures");


    echo $query = "select content from tips_content where type= '" . $type[array_rand($type)] . "' order by rand() limit 1";
    $result = mysql_query($query);

    if (mysql_num_fields($result)) {
        $row = mysql_fetch_array($result);
        echo $tip = $row['content'];
        $total_return.="\n--\nSelf Defense Tip :$tip";
    }

    mysql_close();
    include 'lib/appconfigdb.php';

    switch ($circle_short) {
        case 'AP':
            $city = 'andhra pradesh';
            break;
        case 'AS':
            $city = 'north east';
            break;
        case 'BH':
            $city = 'bihar';
            break;
        case 'CH':
        case 'TN':
            $city = 'tamil nadu';
            break;
        case 'DL':
            $city = 'delhi';
            break;
        case 'GJ':
            $city = 'gujarat';
            break;
        case 'HP':
            $city = 'himanchal pradesh';
            break;
        case 'HR':
            $city = 'haryana';
            break;
        case 'JK':
            $city = 'jammu and kashmir';
            break;
        case 'KA':
            $city = 'karnataka';
            break;
        case 'KL':
            $city = 'kerala';
            break;
        case 'KO':
        case 'WB':
        case 'OR':
            $city = 'west bengal';
            break;
        case 'MB':
        case 'MH':
            $city = 'maharashtra';
            break;
        case 'MP':
        case 'CG':
            $city = 'madhya pradesh';
            break;
        case 'PB':
        case 'RJ':
            $city = 'punjab';
            break;
        case 'UP':
        case 'UE':
        case 'UW':
            $city = 'uttar pradesh';
            break;
        default:
            $city = 'kerala';
            break;
    }

    $options_list[] = "Other Self defense tips";
    $list[] = array("content" => "__self__defense__tips__");
//    $options_list[] = "emergency helpline numbers";
//    $list[] = array("content" => "emergency helpline for women");
    $options_list[] = "women helpline numbers";
    $list[] = array("content" => "women helpline numbers $city");


    $options_list[] = "do's and don'ts";
    $list[] = array("content" => "women safety dos and donts");

    if ($total_return) {
        $to_logserver['source'] = 'womenSafety';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__self__defense__tips__~", $req)) {
    $total_return = "Women Self Defense Tips";

    $options_list[] = "telephone safety";
    $list[] = array("content" => "telephone safety tips");
    $options_list[] = "automobile safety";
    $list[] = array("content" => "automobile safety tips");
    $options_list[] = "elevator safety";
    $list[] = array("content" => "elevator safety tips");
    $options_list[] = "other safety measures";
    $list[] = array("content" => "other safety measures tips");

    if ($total_return) {
        $to_logserver['source'] = 'womenSafety';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
=======
<?php

if ($spell_checked == "women helpline" || $spell_checked == "women safety" || $spell_checked == "womens safety" || $spell_checked == "help women" || $spell_checked == "women safety tips" || $spell_checked == "safety tips for women" || $spell_checked == 'sos' || ($spell_checked == "bachao" && $operator == "vodafone")) {


    switch ($circle_short) {
        case 'AP':
            $sosn = '(040) 27733745';
            break;
        case 'AS':

            $sosn = '0361-2733392(O)';
//            $sosn = "Prof.Smt.Meera Barooh(Chairperson)\nOffice:Assam State Commission for Women, Bal Bhawan, Uzanbazar, Guwahati -781001 
//Phone:
//0361-2733392(O)
//0361-2519875(Fax)";
            break;
        case 'NE':

            $sosn = '0385-2411880';
//            $sosn = "Ms. Theilin Phanbuh(Chairperson)\nOffice:Meghalaya State Commission for Women, Lower Lachumiere, Shillong, Meghalaya 
//Telefax: 0364-2501998\nDr.L.Ipetombi Devi(Chairperson)\nOffice:DC Office Complex, North Block, Post Office LAMPHELPAT, Imphal, Manipur-795001
//Phone:0385-2411880";
            break;
        case 'BH':
            $sosn = '1091';
//            $city = 'bihar';
            break;
        case 'CH':
        case 'TN':
            $sosn = '(044) 26530504';
//            $city = 'tamil nadu';
            break;
        case 'DL':
            $sosn = '181';
//            $city = 'delhi';
            break;
        case 'GJ':
            $sosn = '(0265) 2486487';
//            $city = 'gujarat';
            break;
        case 'HP':
            $sosn = '1800 180 8005';
//            $city = 'himanchal pradesh';
            break;
        case 'HR':
            $sosn = '1091';
//            $city = 'haryana';
            break;
        case 'JK':
            $sosn = '(0191) 2501537';
//            $city = 'jammu and kashmir';
            break;
        case 'KA':
            $sosn = '1800 425 90 900';
//            $city = 'karnataka';
            break;
        case 'KL':
            $sosn = '(0471) 10920';
//            $city = 'kerala';
            break;
        case 'KO':
        case 'WB':
            $sosn = '(0361) 2524627';
            break;
        case 'OR':
            $sosn = '(0674) 2573850';
//            $city = 'west bengal';
            break;
        case 'MB':
        case 'MH':
            $sosn = '(022)-10920';
//            $city = 'maharashtra';
            break;
        case 'MP':
        case 'CG':
            $sosn = '(0771) 2420338';
//            $city = 'madhya pradesh';
            break;
        case 'PB':
            $sosn = '1091';
            break;
        case 'RJ':
            $sosn = '(0141) 1091';
            break;
        case 'UP':
            $sosn = '1090';
            break;
        case 'UE':
        case 'UW':
            $sosn = '(0135) 2103865';
            break;
        default:
            $sosn = '181';
            break;
    }

    $total_return = "Women Safety Numbers\nPolice Station: 100\nWomen helpline: 1091\nAnti Harassment Cell for Women: $sosn\n";

    mysql_close();
    include 'lib/configdb2.php';

    $type = array("telephone safety", "automobile safety", "elevator safety", "other safety measures");


    echo $query = "select content from tips_content where type= '" . $type[array_rand($type)] . "' order by rand() limit 1";
    $result = mysql_query($query);

    if (mysql_num_fields($result)) {
        $row = mysql_fetch_array($result);
        echo $tip = $row['content'];
        $total_return.="\n--\nSelf Defense Tip :$tip";
    }

    mysql_close();
    include 'lib/appconfigdb.php';

    switch ($circle_short) {
        case 'AP':
            $city = 'andhra pradesh';
            break;
        case 'AS':
//            $city = 'assam';
//            break;
        case 'NE':
            $city = 'north east';
            break;
        case 'BH':
            $city = 'bihar';
            break;
        case 'CH':
        case 'TN':
            $city = 'tamil nadu';
            break;
        case 'DL':
            $city = 'delhi';
            break;
        case 'GJ':
            $city = 'gujarat';
            break;
        case 'HP':
            $city = 'himanchal pradesh';
            break;
        case 'HR':
            $city = 'haryana';
            break;
        case 'JK':
            $city = 'jammu and kashmir';
            break;
        case 'KA':
            $city = 'karnataka';
            break;
        case 'KL':
            $city = 'kerala';
            break;
        case 'KO':
        case 'WB':
        case 'OR':
            $city = 'west bengal';
            break;
        case 'MB':
        case 'MH':
            $city = 'maharashtra';
            break;
        case 'MP':
        case 'CG':
            $city = 'madhya pradesh';
            break;
        case 'PB':
        case 'RJ':
            $city = 'punjab';
            break;
        case 'UP':
        case 'UE':
        case 'UW':
            $city = 'uttar pradesh';
            break;
        default:
            $city = 'kerala';
            break;
    }

    $options_list[] = "Other Self defense tips";
    $list[] = array("content" => "__self__defense__tips__");
//    $options_list[] = "emergency helpline numbers";
//    $list[] = array("content" => "emergency helpline for women");
    $options_list[] = "women helpline numbers";
    $list[] = array("content" => "women helpline numbers $city");


    $options_list[] = "do's and don'ts";
    $list[] = array("content" => "women safety dos and donts");

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'womenSafety';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__self__defense__tips__~", $req)) {
    $total_return = "Women Self Defense Tips";

    $options_list[] = "telephone safety";
    $list[] = array("content" => "telephone safety tips");
    $options_list[] = "automobile safety";
    $list[] = array("content" => "automobile safety tips");
    $options_list[] = "elevator safety";
    $list[] = array("content" => "elevator safety tips");
    $options_list[] = "other safety measures";
    $list[] = array("content" => "other safety measures tips");

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'womenSafety';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
>>>>>>> .r757
