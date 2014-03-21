<?php

if ($circle_short == "PB" && preg_match("~\bvisa\b~", $spell_checked, $matches)) {

    $curCountry = trim(str_replace('visa', '', trim(strtolower($spell_checked))));    //country name typed
    echo "<br>Catched country: $curCountry<br>";

    if ($curCountry == "") {    //only VISA keyword typed  show menu
        $total_return = "Select Country for Visa Information\n";

        $options_list[] = "United States of America";
        $list[] = array("content" => "visa usa");
        $options_list[] = "United Kingdom";
        $list[] = array("content" => "visa uk");
        $options_list[] = "Canada";
        $list[] = array("content" => "visa canada");
        $options_list[] = "Australia";
        $list[] = array("content" => "visa australia");
    } else {
        $arrCountries['usa'] = array('us', 'u.s', 'usa', 'u.s.a', 'u s', 'u s a', 'united state', 'united states', 'unitedstate', 'unitedstates', 'america', 'united state of america');
        $arrCountries['uk'] = array('uk', 'u.k', 'u k', 'united kingdom', 'unitedkingdom');
        $arrCountries['canada'] = array('canada', 'canda');
        $arrCountries['australia'] = array('australia', 'astralia', 'aastralia');

        $key_country = "";
        foreach ($arrCountries as $key => $value) {
            foreach ($value as $country) {
                if ($country == $curCountry) {
                    $key_country = $key;
                    break;
                }
            }
        }
        //unset($curCountry);
        unset($arrCountries);

        echo "key country: $key_country<br>";
        if ($key_country != "") {
            $total_return = "Visa Information [ ".strtoupper($curCountry)." ]\n";

            $docreq_content = "";
            $eligible_content = "";
            if ($key_country == 'uk') {
                $docreq_content = "documents for $key_country visa";
            } else {
                $docreq_content = "__visa_docs__$key_country";
            }

            if ($key_country == 'uk' || $key_country == 'canada') {
                $eligible_content = "eligibility for $key_country visa";
            } else {
                $eligible_content = "__visa_elig__$key_country";
            }

            //Visa office address details

            $visa_addr['new delhi'] = array('dl', 'jk', 'hp', 'ne');
            $visa_addr['jalandhar'] = array('pb', 'rj');
            $visa_addr['chandigarh'] = array('hr', 'ue', 'uw', 'pb', 'rj');
            $visa_addr['hyderbad'] = array('ap');
            $visa_addr['chennai'] = array('tn', 'ch', 'ap');
            $visa_addr['bangalore'] = array('ka');
            $visa_addr['kochi'] = array('kl', 'ka');
            $visa_addr['pune'] = array('mh');
            $visa_addr['mumbai'] = array('mb', 'mp', 'mh');
            $visa_addr['kolkata'] = array('ko', 'or', 'wb', 'as', 'bh');

            if ($key_country == 'usa') {
                $visa_addr['bangalore'] = array('');
                $visa_addr['hyderbad'] = array('');
            }
            if ($key_country == 'canada') {
                $visa_addr['kochi'] = array('');
                $visa_addr['pune'] = array('');
                $visa_addr['bangalore'] = array('ka', 'kl');
            }
            if ($key_country == 'australia') {
                $visa_addr['jalandhar'] = array('');
                $visa_addr['pune'] = array('');
            }

            $visaloc = "";    //visa location name for the circle

            foreach ($visa_addr as $key => $value) {
                /* echo "<br>" . strtolower($circle_short) . "<br>";
                  echo "location $key<br>"; */
                var_dump($value);
                if (in_array(strtolower($circle_short), $value) === true) {
                    $visaloc = $key;
                    break;
                }
            }
            echo "VISA LOCATION $visaloc<br>";


            //Passport office address details

            $pport_addr['punjab'] = array('pb');
            $passloc = "";    //passport location name for the circle

            foreach ($pport_addr as $key => $value) {
                if (in_array(strtolower($circle_short), $value) === true) {
                    $passloc = $key;
                    break;
                }
            }
            echo "PASSPORT LOCATION $passloc<br>";

            $options_list[] = "How to apply";   //done for all
            $list[] = array("content" => "how to apply for $key_country visa");
            $options_list[] = "Visa office address";
            $list[] = array("content" => "visa office address for $key_country $visaloc");
            $options_list[] = "Passport info";  //done for all
            $list[] = array("content" => "indian passport information");
            $options_list[] = "Passport center address";
            $list[] = array("content" => "passport office in $passloc");
            $options_list[] = "Documents required"; //done for all
            $list[] = array("content" => "$docreq_content");
            $options_list[] = "Eligibility";    //done for all
            $list[] = array("content" => "$eligible_content");
        }

        if ($total_return) {
            $to_logserver['source'] = 'visainfo';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
} elseif (preg_match("~__visa_docs__(usa)~", $req, $match)) {
    $key_country = trim($match[1]);

    $total_return = "Documents details\n";

    $options_list[] = "Business/Tourist visa";
    $list[] = array("content" => "documents for $key_country business visa");
    $options_list[] = "Work visa";
    $list[] = array("content" => "documents for $key_country work visa");
    $options_list[] = "Student visa";
    $list[] = array("content" => "documents for $key_country student visa");

    if ($total_return) {
        $to_logserver['source'] = 'visainfo';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__visa_docs__(.+)~", $req, $match)) {
    $key_country = trim($match[1]);

    $total_return = "Documents details for $key_country\n";

    $options_list[] = "Business visa";
    $list[] = array("content" => "documents for $key_country business visa");
    $options_list[] = "Tourist visa";
    $list[] = array("content" => "documents for $key_country tourist visa");

    if ($total_return) {
        $to_logserver['source'] = 'visainfo';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__visa_elig__(usa)~", $req, $match)) {
    $key_country = trim($match[1]);

    $total_return = "Eligibility\n";

    $options_list[] = "H1B Visa - Work";
    $list[] = array("content" => "eligibility for $key_country h1b work visa");
    $options_list[] = "H2B Visa - Work";
    $list[] = array("content" => "eligibility for $key_country h2b work visa");
    $options_list[] = "Green Card Visa - Work";
    $list[] = array("content" => "eligibility for $key_country green card visa");
    $options_list[] = "F1 Visa - Student";
    $list[] = array("content" => "eligibility for $key_country f1 student visa");
    $options_list[] = "B1/B2 Visa - Business/Travel";
    $list[] = array("content" => "eligibility for $key_country b1 visa");
    $options_list[] = "L1 Visa - Work";
    $list[] = array("content" => "eligibility for $key_country l1 work visa");
    $options_list[] = "J1 Visa - Trainee";
    $list[] = array("content" => "eligibility for $key_country j1 visa");


    if ($total_return) {
        $to_logserver['source'] = 'visainfo';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__visa_elig__(.+)~", $req, $match)) {
    $key_country = trim($match[1]);

    $total_return = "Eligibility\n";

    $options_list[] = "Working visa";
    $list[] = array("content" => "eligibility for $key_country work visa");
    $options_list[] = "Student visa";
    $list[] = array("content" => "eligibility for $key_country student visa");
    $options_list[] = "Business Owner Visa";
    $list[] = array("content" => "eligibility for $key_country business owner visa");
    $options_list[] = "State Sponsored Business Owner Visa";
    $list[] = array("content" => "eligibility for $key_country state sponsored business owner visa");
    $options_list[] = "Business Senior Executive Visa";
    $list[] = array("content" => "eligibility for $key_country business senior executive visa");
    $options_list[] = "State Sponsored Business Senior Executive Visa";
    $list[] = array("content" => "eligibility for $key_country state sponsored business senior executive visa");
    $options_list[] = "Business Investor Visa";
    $list[] = array("content" => "eligibility for $key_country business investor visa");
    $options_list[] = "State Sponsored Business Investor Visa";
    $list[] = array("content" => "eligibility for $key_country state sponsored business investor visa");


    if ($total_return) {
        $to_logserver['source'] = 'visainfo';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
