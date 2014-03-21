<?php

if (substr($spell_checked, 0, 5) == 'sell ') {
    $sell_item = trim(substr($spell_checked, 5));

    echo $q = "select city from city_circle where circle='$circle_short'";
    $result = mysql_query($q);

    while ($row = mysql_fetch_array($result)) {
        $city = $row["city"];
        $options_list_sugg[] = "$city";
        $list_sugg[] = "__city__" . $city . "__" . $sell_item . "__";
    }


    if ($free) {
        $tot_len = 400;
    } else {
        $tot_len = 190;
    }
    $len = 0;

    $total_return = "Select Your City";
    foreach ($options_list_sugg as $id => $val) {
        $len +=strlen($id . ". " . $val);
        if ($len < $tot_len) {
            $options_list[] = $val;
            $list[] = array("content" => $list_sugg[$id]);
        }
    }
    var_dump($options_list);
    var_dump($list);


    $to_logserver['source'] = 'sell';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (preg_match("~__city__(.+)__(.+)__~Usi", $req, $match)) {
    $city = $match[1];
    $sell_item = $match[2];
    echo $query = "insert into buysell(msisdn,circle,city,item,status) values('$number','$circle_short','$city','" . mysql_real_escape_string($sell_item) . "',1)";
    mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    $total_return = "Thank you for registering with $shortcode classifieds.";
    $to_logserver['source'] = 'sell';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (substr($spell_checked, 0, 4) == 'buy ' or $spell_checked == 'buy') {
    $sell_item = trim(substr($spell_checked, 4));
    if ($sell_item) {
        echo $query = "select *,MATCH(item) against('" . mysql_real_escape_string($sell_item) . "') as relv from buysell where status=1 and MATCH(item) against('" . mysql_real_escape_string($sell_item) . "') order by relv desc limit 10";
    } else {
        echo $query = "select * from buysell where status=1 and circle = '$circle_short' order by `timestamp` desc limit 10";
    }

    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    if (mysql_num_rows($result)) {
        if (mysql_num_rows($result) == 1) {
            $row = mysql_fetch_array($result);
            $total_return = "Number: " . $row['msisdn'];
            $total_return .= "\nDetails : " . $row['item'];
        } else {
            if ($free) {
                $max_len = 360;
            } else {
                $max_len = 310;
            }
            $tot_len = 0;
            $total_return = "List of matching results";
            while ($row = mysql_fetch_array($result)) {
                if (strlen($row['item']) > 50) {
                    $opt_str = substr($row['item'], 0, 47) . '...';
                } else {
                    $opt_str = $row['item'];
                }
                $tot_len += strlen($opt_str);
                if ($tot_len <= $max_len) {
                    $options_list[] = $opt_str;
                    $list[] = array("content" => "__buy__" . $row['msisdn'] . "__" . $row["item"] . "__");
                } else {
                    break;
                }
            }
        }
    } else {
        $total_return = "Sorry, No item matches your query.";
    }
    $to_logserver['source'] = 'buy';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (preg_match("~__buy__(.+)__(.+)__~", $req, $match)) {

    $total_return = "Number: " . $match[1];
    $total_return .= "\nDetails : " . $match[2];
    $to_logserver['source'] = 'buy';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>