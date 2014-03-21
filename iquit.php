<?php

if ($spell_checked == "iquit" || $spell_checked == "smoking and quit") {
    $total_return = "Thank you for taking first step";

    $options_list[] = "Harmfull effects of smoking";
    $list[] = array("content" => "harmful health effects of smoking");
    $options_list[] = "How to quit";
    $list[] = array("content" => "how to quit smoking?");
    $options_list[] = "Smoking Risk Calculator";
    $list[] = array("content" => "__smoke___0_0__calc__");
    $options_list[] = "Success stories";
    $list[] = array("content" => "smoke personality");

    if ($total_return) {
        $to_logserver['source'] = 'smokequit';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__smoke___(.+)_(.+)__calc__~", $req, $match)) {

    $total_return = "Smoking Risk Calculator.\n";

    if ($match[1] == 0) {
        unset($arCacheData["sq"]);  //reseting values
        $arCacheData["sq"]["count"] = 0;
    } else {
        $arCacheData["sq"]["count"]++;
    }
    echo '<h3>count: ' . $arCacheData["sq"]["count"] . '</h3';

    $cig_opt_list['age'][1] = 'Age 15-20';
    $cig_opt_list['age_c'][1] = '__smoke___15_20__calc__';
    $cig_opt_list['age'][] = 'Age 21-25';
    $cig_opt_list['age_c'][] = '__smoke___21_25__calc__';
    $cig_opt_list['age'][] = 'Age 26-30';
    $cig_opt_list['age_c'][] = '__smoke___26_30__calc__';
    $cig_opt_list['age'][] = 'Age 31-35';
    $cig_opt_list['age_c'][] = '__smoke___31_35__calc__';
    $cig_opt_list['age'][] = 'Age 36-40';
    $cig_opt_list['age_c'][] = '__smoke___36_40__calc__';
    $cig_opt_list['age'][] = 'Age 41-45';
    $cig_opt_list['age_c'][] = '__smoke___41_45__calc__';
    $cig_opt_list['age'][] = 'Age 46-50';
    $cig_opt_list['age_c'][] = '__smoke___46_50__calc__';
    $cig_opt_list['age'][] = 'Age 51-55';
    $cig_opt_list['age_c'][] = '__smoke___51_55__calc__';
    $cig_opt_list['age'][] = 'Age 56-60';
    $cig_opt_list['age_c'][] = '__smoke___56_60__calc__';
    $cig_opt_list['age'][] = 'Age Above 60';
    $cig_opt_list['age_c'][] = '__smoke___61_80__calc__';


    $cig_opt_list['nocig'][1] = '1-5';
    $cig_opt_list['nocig_c'][1] = '__smoke___1_5__calc__';
    $cig_opt_list['nocig'][] = '6-10';
    $cig_opt_list['nocig_c'][] = '__smoke___6_10__calc__';
    $cig_opt_list['nocig'][] = '11-15';
    $cig_opt_list['nocig_c'][] = '__smoke___11_15__calc__';
    $cig_opt_list['nocig'][] = '16-20';
    $cig_opt_list['nocig_c'][] = '__smoke___16_20__calc__';
    $cig_opt_list['nocig'][] = '21-25';
    $cig_opt_list['nocig_c'][] = '__smoke___21_25__calc__';
    $cig_opt_list['nocig'][] = '26-30';
    $cig_opt_list['nocig_c'][] = '__smoke___26_30__calc__';
    $cig_opt_list['nocig'][] = '31-35';
    $cig_opt_list['nocig_c'][] = '__smoke___31_35__calc__';
    $cig_opt_list['nocig'][] = '36-40';
    $cig_opt_list['nocig_c'][] = '__smoke___36_40__calc__';
    $cig_opt_list['nocig'][] = 'Above 40';
    $cig_opt_list['nocig_c'][] = '__smoke___41_50__calc__';

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["sq"]["expiry"] = $expiry_time;
    $arCacheData["sq"]["no"] = $number;

    switch ($arCacheData["sq"]["count"]) {

        case 0:
            echo "<h2>SELECT AGE RANGE</h3>";
            echo "<h3>Age Count: " . count($cig_opt_list['age']) . "</h3>";
            $total_return .= "Select your age range.\n";
            for ($count = 1; $count <= count($cig_opt_list['age']); $count++) {
                echo "<h2>" . $cig_opt_list['age'][$count] . "</h3>";
                $options_list[] = $cig_opt_list['age'][$count];
                $list[] = array("content" => $cig_opt_list['age_c'][$count]);
            }
            break;

        case 1:
            $arCacheData["sq"]["min_age"] = $match[1];
            $arCacheData["sq"]["max_age"] = $match[2];
            $arCacheData["sq"]["ag_c"] = $numeric_in;

            $total_return .= "Select your gender.\n";
            $options_list[] = "Male";
            $list[] = array("content" => "__smoke___1_0__calc__");
            $options_list[] = "Female";
            $list[] = array("content" => "__smoke___2_0__calc__");
            break;

        case 2:
            $arCacheData["sq"]["gender"] = $match[1];
            $total_return .= "When did you start smoking?\n";
            echo "<h4>NUMERIC IN: " . $arCacheData["sq"]["ag_c"] . "</h4>";
            for ($tmp_i = 1; $tmp_i <= $arCacheData["sq"]["ag_c"]; $tmp_i++) {
                $options_list[] = $cig_opt_list['age'][$tmp_i];
                $list[] = array("content" => $cig_opt_list['age_c'][$tmp_i]);
            }
            break;

        case 3:
            $arCacheData["sq"]["min_smok"] = $match[1];
            $arCacheData["sq"]["max_smok"] = $match[2];
            $total_return .= "Number of cigarettes per day\n";
            for ($count = 1; $count <= count($cig_opt_list['nocig']); $count++) {
                $options_list[] = $cig_opt_list['nocig'][$count];
                $list[] = array("content" => $cig_opt_list['nocig_c'][$count]);
            }
            break;

        case 4:
            $arCacheData["sq"]["min_nocg"] = $match[1];
            $arCacheData["sq"]["max_nocg"] = $match[2];

            //New calculation method
            //Average age calculating
            $iq_av_age = intval((($arCacheData["sq"]["min_age"]) + ($arCacheData["sq"]["max_age"])) / 2);

            //Average start years calculating
            $iq_av_start = intval((($arCacheData["sq"]["min_smok"]) + ($arCacheData["sq"]["max_smok"])) / 2);

            //Average no of cig calculating
            $iq_av_no_cig = intval((($arCacheData["sq"]["min_nocg"]) + ($arCacheData["sq"]["max_nocg"])) / 2);

            //No of years
            $iq_av_no_years = (($iq_av_age - $iq_av_start) + 1);

            //$total_return .="AVG YEAR $iq_av_no_years ";
            //Base value

            $base_value = 2;

            $mult_fact = $base_value + ($iq_av_no_years - 1) * 3;
            $add_year = ($iq_av_no_years - 1) * 3;
            $add_cig = ($iq_av_no_cig - 1) * 3;

            $mult_value = ($add_year + $add_cig) * ($iq_av_no_cig - 1);

            $iq_av_life_spoil_days = $mult_fact + $mult_value;

            $iq_max_days = 8783;
            $iq_perc = round($iq_av_life_spoil_days / $iq_max_days * 100, 2);

            //$total_return .="Average values Age: $iq_av_age  Start: $iq_av_start Cig count: $iq_av_no_cig Year: $iq_av_no_years";


            $total_return .= "You have approx. lost $iq_av_life_spoil_days days of your Life Span\n";
            $total_return .= "Your Smoking risk percentage is $iq_perc%\n";

            $total_return .= "Important Facts:
            There is absolutely no safer limit of exposure to tobacco smoke and on average smokers die 13 to 14 years earlier.
            Quitting to smoke at the age of 30 reduces the risk of premature death by nearly 90%.
            Quitting at the age of 50 reduces the risk of premature death by 50%.
            Quitting to smoke at 60 and above still makes a difference and enhances the chance of living longer than those who continue to smoke.\n";

            echo "Total return $total_return\n";
            unset($arCacheData["sq"]);
            break;  //count switch case ends here
        //**************************//
    }

    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'smokequit';
        putOutput($total_return);
        exit();
    }
} else if ($spell_checked == "alcohol" || $spell_checked == "alcohol self screening test" || $spell_checked == "alchometer" || $spell_checked == "alchopedia" || $spell_checked == "alcho") {
    $total_return = "Thank you for taking first step";

    $options_list[] = "Alcohol Self Screening Test";
    $list[] = array("content" => "__self___0_1__test__");
    $options_list[] = "How to quit";
    $list[] = array("content" => "how to quit drinking");
    $options_list[] = "Quick Alcohol Test for Drivers";
    $list[] = array("content" => "__alc___0_0__calc__");

    if ($total_return) {
        $to_logserver['source'] = 'alcohol';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__self___(.+)_(.+)__test__~", $req, $match)) {

    $total_return = "Alcohol Self Screening Test.\n";

    if ($match[1] == 0 && $match[2] == 1) {
        unset($arCacheData["ast"]);  //reseting values
        $arCacheData["ast"]["count"] = 0;
    } else {
        $arCacheData["ast"]["count"]++;
    }

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["ast"]["expiry"] = $expiry_time;
    $arCacheData["ast"]["no"] = $number;

    $cig_opt_list['age'][1] = 'Age 15-20';
    $cig_opt_list['age_c'][1] = '__self___15_20__test__';
    $cig_opt_list['age'][] = 'Age 21-25';
    $cig_opt_list['age_c'][] = '__self___21_25__test__';
    $cig_opt_list['age'][] = 'Age 26-30';
    $cig_opt_list['age_c'][] = '__self___26_30__test__';
    $cig_opt_list['age'][] = 'Age 31-35';
    $cig_opt_list['age_c'][] = '__self___31_35__test__';
    $cig_opt_list['age'][] = 'Age 36-40';
    $cig_opt_list['age_c'][] = '__self___36_40__test__';
    $cig_opt_list['age'][] = 'Age 41-45';
    $cig_opt_list['age_c'][] = '__self___41_45__test__';
    $cig_opt_list['age'][] = 'Age 46-50';
    $cig_opt_list['age_c'][] = '__self___46_50__test__';
    $cig_opt_list['age'][] = 'Age 51-55';
    $cig_opt_list['age_c'][] = '__self___51_55__test__';
    $cig_opt_list['age'][] = 'Age 56-60';
    $cig_opt_list['age_c'][] = '__self___56_60__test__';
    $cig_opt_list['age'][] = 'Age Above 60';
    $cig_opt_list['age_c'][] = '__self___61_80__test__';

    switch ($arCacheData["ast"]["count"]) {

        case 0:
            $total_return .= "Select your age range.\n";
            for ($count = 1; $count <= count($cig_opt_list['age']); $count++) {
                echo "<h2>" . $cig_opt_list['age'][$count] . "</h3>";
                $options_list[] = $cig_opt_list['age'][$count];
                $list[] = array("content" => $cig_opt_list['age_c'][$count]);
            }
            break;
        case 1:
            $arCacheData["ast"]["age_min"] = $match[1];
            $arCacheData["ast"]["age_max"] = $match[2];

            $total_return .= "Select your gender.\n";
            $options_list[] = "Male";
            $list[] = array("content" => "__self___1_0__test__");
            $options_list[] = "Female";
            $list[] = array("content" => "__self___2_0__test__");
            break;

        case 2:
            $arCacheData["ast"]["gender"] = $match[1];
            $total_return .= "How often do you have a drink containing alcohol?\n";

            $options_list[] = "Monthly or Less";
            $list[] = array("content" => '__self___0_0__test__');
            $options_list[] = "2 to 4 times a month";
            $list[] = array("content" => '__self___1_0__test__');
            $options_list[] = "2 to 3 times a week";
            $list[] = array("content" => '__self___2_0__test__');
            $options_list[] = "4 or more times a week";
            $list[] = array("content" => '__self___3_0__test__');
            break;

        case 3:
            $arCacheData["ast"]["ans1"] = $match[1];
            $total_return .= "How many drinks containing alcohol do you have on a typical day when you are drinking?\n";

            $options_list[] = "1 or 2";
            $list[] = array("content" => '__self___1_0__test__');
            $options_list[] = "3 or 4";
            $list[] = array("content" => '__self___2_0__test__');
            $options_list[] = "5 or 6";
            $list[] = array("content" => '__self___3_0__test__');
            $options_list[] = "7 to 9";
            $list[] = array("content" => '__self___4_0__test__');
            $options_list[] = "10 or more";
            $list[] = array("content" => '__self___5_0__test__');

            break;
        case 4:
            $arCacheData["ast"]["ans2"] = $match[1];
            $total_return .= "How often do you have six or more drinks on one occasion? \n";

            $options_list[] = "Never";
            $list[] = array("content" => '__self___0_0__test__');
            $options_list[] = "Less than monthly";
            $list[] = array("content" => '__self___1_0__test__');
            $options_list[] = "Monthly";
            $list[] = array("content" => '__self___2_0__test__');
            $options_list[] = "Weekly";
            $list[] = array("content" => '__self___3_0__test__');
            $options_list[] = "Daily or almost daily";
            $list[] = array("content" => '__self___4_0__test__');
            break;
        case 5:
            $arCacheData["ast"]["ans3"] = $match[1];
            $total_return .= "Have you or someone else been injured as the result of your drinking? \n";

            $options_list[] = "Never";
            $list[] = array("content" => '__self___0_0__test__');
            $options_list[] = "Yes, but not in the last year";
            $list[] = array("content" => '__self___2_0__test__');
            $options_list[] = "Yes, during the last year ";
            $list[] = array("content" => '__self___4_0__test__');
            break;
        case 6:
            $arCacheData["ast"]["ans4"] = $match[1];

            $self_test_result = $arCacheData["ast"]["ans1"] + $arCacheData["ast"]["ans2"] + $arCacheData["ast"]["ans3"] + $arCacheData["ast"]["ans4"];
            $result_notice[0] = "Your alcohol drinking is at present within safe limits.";
            $result_notice[1] = "Your alcohol consumption is well beyond the permissible limits as indicated by WHO.";

            $result_notice[2] = "";
            $result_notice[3] = "You must realize the dangers of use of excess alcohol on your health.";
            $result_notice[4] = "You are advised to go for counseling with a mental health worker or your doctor. You should also require continued monitoring.";

            $rst_ind1 = 0;
            $rst_ind2 = 0;

            if ($self_test_result <= 8) {
                $rst_ind1 = 0;
                $rst_ind2 = 2;
            } elseif ($self_test_result < 16) {
                $rst_ind1 = 1;
                $rst_ind2 = 3;
            } else {
                $rst_ind1 = 1;
                $rst_ind2 = 4;
            }
            
            $rst_max_score = 16;
            $rst_perc = round($self_test_result / $rst_max_score * 100, 2);
            
            $total_return = "Alcohol Self Screening Test Result.\n";
            $total_return .= "Your score is  $self_test_result\n";
            $total_return .= "Your risk percentage is $rst_perc%\n";
            $total_return .= $result_notice[$rst_ind1] . "\n";
            $total_return .= $result_notice[$rst_ind2] . "\n";

            unset($arCacheData["ast"]); //resetting cache array
            break;
        //**************************//
    }

    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'alcohol';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__alc___(.+)_(.+)__calc__~", $req, $match)) {

    $total_return = "QUICK ALCOHOL TEST FOR DRIVERS.\n";

    if ($match[1] == 0) {
        unset($arCacheData["bac"]);  //reseting values
        $arCacheData["bac"]["count"] = 0;
    } else {
        $arCacheData["bac"]["count"]++;
    }

    $hit_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
    $arCacheData["bac"]["expiry"] = $expiry_time;
    $arCacheData["bac"]["no"] = $number;

    $bld_alc['type'][1] = 'Beer';
    $bld_alc['type_c'][1] = '__alc___5_12__calc__';
    $bld_alc['type'][] = 'Wine';
    $bld_alc['type_c'][] = '__alc___12_5__calc__';
    $bld_alc['type'][] = 'Spirit';
    $bld_alc['type_c'][] = '__alc___40_1.5__calc__';   

    switch ($arCacheData["bac"]["count"]) {

        case 0:
            $total_return = "QUICK ALCOHOL TEST FOR DRIVERS.\n";
            $total_return .= "Select your drink type.\n";
            for ($count = 1; $count <= count($bld_alc['type']); $count++) {
                echo "<h2>" . $bld_alc['type'][$count] . "</h3>";
                $options_list[] = $bld_alc['type'][$count];
                $list[] = array("content" => $bld_alc['type_c'][$count]);
            }
            break;
        case 1:
            $arCacheData["bac"]["drp"] = $match[1];
            $arCacheData["bac"]["drv"] = $match[2];
            
            $total_return = "QUICK ALCOHOL TEST FOR DRIVERS.\n";
            $total_return .= "Select your gender.\n";
            $options_list[] = "Male";
            $list[] = array("content" => "__alc___1_0__calc__");
            $options_list[] = "Female";
            $list[] = array("content" => "__alc___2_0__calc__");
            break;

        case 2:
            $arCacheData["bac"]["gender"] = $match[1];
            $total_return = "QUICK ALCOHOL TEST FOR DRIVERS.\n";
            $total_return .= "Number of drinks?\n";
    }

    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'alcohol';
        putOutput($total_return);
        exit();
    }
} if (!empty($arCacheData["bac"])) {
    if (preg_match("~\b^([\d]{1,3})\b~", $spell_checked, $match)) {

        $hit_time = date("Y-m-d H:i:s");
        $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +30 minute"));
        $arCacheData["bac"]["expiry"] = $expiry_time;
        $arCacheData["bac"]["no"] = $number;

        $arCacheData["bac"]["count"]++;
        switch ($arCacheData["bac"]["count"]) {
            case 3:
                $arCacheData["bac"]["drk"] = $match[1];
                $total_return = "QUICK ALCOHOL TEST FOR DRIVERS.\n";
                $total_return .= "Weight in Kg?\n";
                break;
            case 4:
                $arCacheData["bac"]["wegt"] = $match[1];
                $total_return = "QUICK ALCOHOL TEST FOR DRIVERS.\n";
                $total_return .= "Number of hours after the drink?\n";
                break;
            case 5:
                $arCacheData["bac"]["hrs"] = $match[1];
                
                
                //calculation begins
                $w_c=.49;//66;
                if($arCacheData["bac"]["gender"]==1){
                    $w_c=.58;//.75;
                }
                
                $stddrnk=$arCacheData["bac"]["drp"]/100*$arCacheData["bac"]["drv"];
                
                $acl_content=$arCacheData["bac"]["drk"]*$stddrnk;
                
                $weight=$arCacheData["bac"]["wegt"]*2.2;
                
                $wt_in_lbs=$weight/2.2046;
                
                $water=$w_c*$wt_in_lbs;
                
                $watermill=$water*1000;
                
                $ounce=23.36/$watermill;  
                
                $gram=$ounce*.806;
                
                $grammilli=$gram*100;
                
                
                $mtabolism=$arCacheData["bac"]["hrs"]*.015;
                
                $bac1=($grammilli*$acl_content);
                
                $bac=$bac1-$mtabolism;
                
                $bac=round(($bac<0?0:$bac),3);
                
                $msg=($bac<=.03?"Safe to drive":($bac<=.08?"50% risk to drive":"Do not drive, you can injure another person."));
                
                $warning="Note: This result is not 100% accurate. It will depends many factors.";
                
                /*$alc_v1=($arCacheData["bac"]["drk"]*$arCacheData["bac"]["drv"])/($arCacheData["bac"]["wegt"]*$w_c);
                
                $alc_v2=$alc_v1/210;*/
                
                /*$total_return .= "No of drinks: ".$arCacheData["bac"]["drk"];
                $total_return .= "\nDrink ounce: ".$arCacheData["bac"]["drp"];
                $total_return .= "\nYour weight: ".$arCacheData["bac"]["wegt"];
                $total_return .= "\nDuration: ".$arCacheData["bac"]["hrs"];
                $total_return .= "\nGender: ".$w_c;
                $total_return .= "\ndrink: ".$stddrnk;
                $total_return .= "\nweight: ".$weight;
                $total_return .= "\nwt in BS: ".$wt_in_lbs;
                $total_return .= "\nalcohol: ".$acl_content;
                $total_return .= "\nwater: ".$water;
                $total_return .= "\nwater milli: ".$watermill;
                $total_return .= "\nOunce: ".$ounce;
                $total_return .= "\ngram: ".$gram;
                $total_return .= "\nGrammilli: ".$grammilli;
                $total_return .= "\nmetabolism: ".$mtabolism;
                $total_return .= "\nBAC!: ".$bac1;*/
                
                $total_return = "QUICK ALCOHOL TEST FOR DRIVERS.\n";
                $total_return .= "Your Blood Alcohol Content $bac % \n";
                $total_return .= "$msg \n";
                //$total_return .= "$warning \n";
                unset($arCacheData["bac"]);
                break;
            default:
                unset($arCacheData["bac"]);
                break;
        }
        
        if ($total_return) {
            include 'allmanip.php';
            $to_logserver['source'] = 'alcohol';
            putOutput($total_return);
            exit();
        }
    }
}
?>
