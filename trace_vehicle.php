<?php

$trace_return = '';
if ($state == 'kl') {
    echo $url = "API";
    $fields_string = "veh_user=&regfield=$to_trace&chsis=&Submit=Get";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: smartweb.keralamvd.gov.in", 'Referer: API'));
    $result = curl_exec($ch);
//    echo $result;
    curl_close($ch);
    $start = strpos($result, 'darkgreen>RTO,');
    if (!$start || $start <= 0) {
        $start = strpos($result, 'darkgreen>SRTO,');
    }
    $rto = '';
    $owner_name = '';
    $det = array();
    if ($start != 0) {
        $result = substr($result, $start + 15);
        $end = strpos($result, '</font>');
        if ($end != 0) {
            $rto = trim(substr($result, 0, $end));
            $start = strpos($result, "Owner Details");
            if ($start != 0) {
                $result = substr($result, $start);
                $end = strpos($result, '</table></td>');
                if ($end != 0) {
                    $owner = trim(substr($result, 0, $end));
                    $start = strpos($owner, '<td height="20" bgcolor="#F0EBF1" class="style1"><div align="center">');
                    if ($start != 0) {
                        $owner = substr($owner, $start + 70);
                        $end = strpos($owner, "</div></td>");
                        if ($end != 0) {
                            $owner_name = trim(substr($owner, 0, $end));
                        }
                    }
                }
                $start = strpos($result, "Other Details");
                if ($start != 0) {
                    $result = substr($result, $start);
                    $start = strpos($result, "<td ");
                    if ($start != 0) {
                        $result = substr($result, $start);
                        $end = strpos($result, '</table></td>');
                        if ($end != 0) {
                            $detail = trim(substr($result, 0, $end));
                            $detail = str_replace(array('</tr>', '</td>'), array('###', '***'), $detail);
                            $detail = strip_tags($detail);
                            $details = explode('###', $detail);
                            $det['head'] = explode('***', $details[0]);
                            $det['val'] = explode('***', $details[1]);
//                            foreach($det['head'] as $key => $value){
//                                $value = trim($value);
//                                if($value > 0 || (!is_numeric($value) && ))
//                            }
                        }
                    }
                }
            }
        }
    }
    if ($rto) {
        $trace_return = "Number : $to_trace\nState : Kerala\nRegion : $rto";
    }
    if ($owner_name) {
        $trace_return .= "\nOwner : $owner_name";
    }
    foreach ($det['val'] as $key => $value) {
        if (trim($value) != 'Not Available' && trim($value) != '' && ($value != 0 || !is_numeric($value))) {
            $trace_return .= "\n" . trim($det['head'][$key]) . " : " . trim($value);
        }
    }
} elseif ($state == 'ap') {
    echo $url = "API";

    echo $to_ap_trace = strtoupper(str_replace('-', "", $to_trace));

    $fields_string = "__VIEWSTATE=%2FwEPDwUKMTA5NzY2NzY1NWRkaSCbydTZyAN2pWToiXRhAIB06fQ%3D&ctl00%24ContentPlaceHolder1%24txtreg=$to_ap_trace&ctl00%24ContentPlaceHolder1%24txteng=&ctl00%24ContentPlaceHolder1%24txtchasis=&ctl00%24ContentPlaceHolder1%24txttran=&ctl00%24ContentPlaceHolder1%24Button1=GetData&__EVENTVALIDATION=%2FwEWBwKmqsXRDALKmqGECgKhlYWbCgLkhIPoCAKem4SnDgKA4sljAoPiyWMJB2dMx2HS9oncTDBE8Wsa2ix6Mw%3D%3D";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: 210.212.213.82:81",
        "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0",
        "Referer: API",
        "Content-Length: " . strlen($fields_string)));
    $result = curl_exec($ch);
//    echo $result;
    curl_close($ch);

    if (preg_match('~<table class="style46" bgcolor="#FFE1E1" cellpadding="0" cellspacing="0">(.+)</table>~Usi', $result, $content)) {
//    var_dump($content);

        $data = $content[1];
        $data = trim(preg_replace("~[\s]+~", " ", $data));
//    $data = trim(str_replace("</tr>", "***", $data));
        $data = trim(str_replace("</span>", "***", $data));
        $data = strip_tags($data);
//    $data = html_entity_decode($data);
        $data = trim(preg_replace("~[\s]+~", " ", $data));
        $data = trim(str_replace("&#39;", "'", $data));
        $data = trim(str_replace("***", "\n", $data));
//    $data = trim(str_replace("\n\n", "\n", $data));
//    $data = trim(preg_replace("~[\s]+~", " ", $data));
        $data = trim(str_replace("&nbsp;", "", $data));
        $data = trim(str_replace("\n  ", "\n", $data));
        $data = trim(str_replace("Registering Authority       Status", "Registering Authority Status : NIL", $data));


        echo $data;
        $data = clean($data);
        $trace_return = $data;
    }
} else {
    $query = "select id,state_name,dist_name from rto_reg where state = '$state' and dist = $dist";
    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    if (mysql_num_rows($result)) {
        echo "<br>TRACE FROM DB";
        $row = mysql_fetch_array($result);
        $trace_return = "Number : $to_trace\nState : " . $row['state_name'] . "\nRegion : " . $row['dist_name'];
        $query = "update rto_reg set hits = hits + 1 where id = " . $row['id'];
        mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    } else {
        echo "<br>TRACE FROM WEB";
        $url = "API";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.techdreams.org", "Referer: http://www.techdreams.org/trace-vehicle"));
        $result = curl_exec($ch);
        var_dump($result);
        curl_close($ch);
//        echo $array;
        $array = json_decode(trim($result, '()'));
        var_dump($array);
        if (isset($array->st)) {
            echo "<br>Trace Found:";
            $trace_return = "Number : $to_trace\nState : " . $array->st . "\nRegion : " . $array->ln;
            $query = "insert into rto_reg(state,dist,state_name,dist_name,hits) values('$state',$dist,'" . $array->st . "','" . $array->ln . "', 1)";
            mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        }
    }
    if ($state == 'ka' && ($dist == '01' || $dist == '02' || $dist == '03' || $dist == '04' || $dist == '05')) {
        echo "<br>", "TRACE FROM BITS";
        echo $url = "http://www.btis.in/rto/fetch";
//        $fields_string = "authenticity_token=iFBjhJRdIEwWJLilffBUFcATzWYZc%2BALz9BWirXVJfY%3D&rto_num=$to_trace";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.btis.in", 'Referer: http://www.btis.in/rto', 'Content-Length: ' . strlen($fields_string), 'Cookie: __unam=abe84eb-133ea3d3c0c-19957ad8-15; _btis.in_session=BAh7BzoPc2Vzc2lvbl9pZCIlNjZkNjNiNTg1NjBkOWU3MTY0ODYwMDY0YzY4ZTYxYmM6EF9jc3JmX3Rva2VuIjFpRkJqaEpSZElFd1dKTGlsZmZCVUZjQVR6V1laYytBTHo5QldpclhWSmZZPQ%3D%3D--265501745960ee60a31b8b88befcf824df0c6bd9'));
//        $result = curl_exec($ch);
//        curl_close($ch);

        $fields_string = "authenticity_token=6DkZQtUHUoqMSOWY45cOxfSHwns7Mt8Gjj%2BeWFVj5Yg%3D&rto_num=$to_trace";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.btis.in",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2",
            "Referer: http://www.btis.in/rto",
            "Content-Length: " . strlen($fields_string),
            "Cookie: _btis.in_session=BAh7BzoPc2Vzc2lvbl9pZCIlMmE5MWVkYWVkZTgxNDUxNzRkZjFjM2FkOGFiZjhmYTY6EF9jc3JmX3Rva2VuIjE2RGtaUXRVSFVvcU1TT1dZNDVjT3hmU0h3bnM3TXQ4R2pqK2VXRlZqNVlnPQ%3D%3D--44d082921a5ebe5c845bd17ce8f146811e1ac912; __unam=abe84eb-1367266ba28-7348ea58-1"));
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;

        $start = strpos($result, "<TABLE cellspacing='5'>");
        if ($start != 0) {
            echo "entering here";
            $end = strpos($result, "</TABLE>");
            $result = substr($result, $start, $end - $start);
            $result = str_replace('</TR>', ' *** ', $result);
            $result = strip_tags($result);
            $result = html_entity_decode($result);
            $result = str_replace(' *** ', "\n", $result);
            $result = preg_replace('~\w(.+):\s(.+)~', "", $result);
//            echo $result;
            $trace_return .= "\n$result";
        }
    }
}
if ($trace_return) {
    $add_below = "\n--\nInternet search on sms! Sms HELP to $shortcode to find out more.$tollfree";
    $vehicle_p = "";
    $start = stripos($trace_return, "Maker Class :");
    if ($start != FALSE) {
        $vehicle_p = substr($trace_return, $start + 13);
        $end = stripos($vehicle_p, "C.C :");
        if ($end != FALSE) {
            $vehicle_p = substr($vehicle_p, 0, $end);
        }
    }
    if (empty($vehicle_p)) {
        $start = stripos($trace_return, "Maker Name :");
        if ($start != FALSE) {
            $vehicle_p = substr($trace_return, $start + 12);
            $end = stripos($vehicle_p, "C.C :");
            if ($end != FALSE) {
                $vehicle_p = substr($vehicle_p, 0, $end);
            }
        }
    }
    $vehicle_p = preg_replace("~\((.+)\)|auto|ltd|india~Usi", "", $vehicle_p);
    echo "<h1>$vehicle_p</h1>";
    if (!empty($vehicle_p)) {
        if (stripos($trace_return, "MOTOR CYCLE") !== false) {
            $list[] = array("content" => "bike price $vehicle_p");
            $options_list[] = "bike price $vehicle_p";
        } elseif (stripos($trace_return, "CAR ") !== false) {
            $list[] = array("content" => "car price $vehicle_p");
            $options_list[] = "car price $vehicle_p";
        }
        var_dump($options_list);
    }
}
?>

