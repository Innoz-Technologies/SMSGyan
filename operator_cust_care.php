<?php

if (preg_match('~customer care number~Usi', $spell_checked)) {
    $matched = $spell_checked;
    $def_op = strtolower($operator);    //default oprator
    $def_circle = strtolower($circle_short);    //default circle
    
    //variables
    $cur_circle = '';
    $cur_op = '';

    $isMatch = false;

    //Filters
    $op_rem_words = array('of', 'the', 'what', 'is', 'tell', 'me');
    //Operators
    $operators['airtel'] = 'airtel';
    $operators['vodafone'] = 'vodafone';
    $operators['idea'] = 'idea';
    $operators['docomo'] = 'docomo';
    $operators['aircel'] = 'aircel';
    $operators['loop'] = 'loop';
    $operators['du'] = 'du';

    //CIRCLES LIST
    $circles['ae'] = array('dubai', 'uae');
    $circles['ap'] = array('andrapradesh','andra pradesh');
    $circles['as'] = array('asam','aassam','aasam');
    $circles['bh'] = array('bhihar','bheehar');
    $circles['ch'] = array('chennai','chenai','madras');
    $circles['dl'] = array('delhi','new delhi','newdelhi');
    $circles['gj'] = array('gujarat','gujarath');
    $circles['hp'] = array('himachal pradesh','himachalpradesh');
    $circles['hr'] = array('hariyana','haryana');
    $circles['jk'] = array('jammu','kashmir','jammu kashmir','jammu & kashmir');
    $circles['ka'] = array('karanataka','karnatka');
    $circles['kl'] = array('kerala','keralam');
    $circles['ko'] = array('kolkata');
    $circles['mb'] = array('mumbai','bombay');
    $circles['mh'] = array('maharastra','maha rastra');
    $circles['mp'] = array('madhya pardesh','madhyapradesh');
    $circles['ne'] = array('meghalaya','northeast','north east');
    $circles['or'] = array('orissa','bhubaneswar');
    $circles['pb'] = array('punjab','ludhiana');
    
    $circles['rj'] = array('rajastan','jaipur');
    $circles['tn'] = array('tamilnadu','tamil nadu');
    $circles['uw'] = array('uttarakhand','uttarpradesh west');
    $circles['ue'] = array('utter pradesh','utar pradesh','kanpur');    
    $circles['wb'] = array('west bengal','west bangal');
    
    $filtered = str_replace('customer care number', '', $matched);

    echo "<h3>FILTERED $filtered</h3>";

    $filtered = str_replace($op_rem_words, '', $filtered);

    echo "<h3>REMOVED $filtered</h3>";

    foreach ($operators as $key => $value) {
        if (preg_match("~$key~Usi", $filtered, $matches)) {
            $cur_op = $key;
            $isMatch = true;
        } else {
            /*foreach ($value as $v) {
                if (preg_match("~$v~Usi", $filtered)) {
                    $cur_op = $key;
                    $isMatch = true;
                }
            }*/
        }
        if ($isMatch)
            break;
    }
    echo "<h3>OPERATOR $cur_op</h3>";

    $isMatch = false;
    foreach ($circles as $key => $value) {
        if (preg_match("~$key~Usi", $filtered, $matches)) {
            $cur_circle = $key;
            $isMatch = true;
        } else {
            foreach ($value as $v) {
                if (preg_match("~$v~Usi", $filtered)) {
                    $cur_circle = $key;
                    $isMatch = true;
                }
            }
        }
        if ($isMatch)
            break;
    }
    if ($cur_op == '') {
        $cur_op = $def_op;
    }
    echo "<h3>CIRCLE AFTER CHECK $cur_circle</h3>";

    if ($cur_circle == '') {
        $isMatch = false;
        foreach ($circles as $key => $value) {
            if (preg_match("~$key~Usi", $def_circle, $matches)) {
                $cur_circle = $key;
                $isMatch = true;
            } else {
                foreach ($value as $v) {
                    if (preg_match("~$v~Usi", $def_circle)) {
                        $cur_circle = $key;
                        $isMatch = true;
                    }
                }
            }
            if ($isMatch)
                break;
        }
    }
    echo "<h3>CIRCLE AFTER AUTO $cur_circle</h3>";
    
    //query section
    $query = "SELECT message from operator_cust_care where operator = '$cur_op' and circle = '$cur_circle'";
    
    echo "<h3>$query</h3>";
    $result = mysql_query($query) or trigger('Error '.mysql_error());
    
    $total_return = "";
    while($row = mysql_fetch_array($result)){
        $total_return .= $row['message'];
        $total_return .= "\n";
    }
    
    echo "<h5>OUTPUT $total_return</h5>";
    
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'opCustCareNumbers';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
