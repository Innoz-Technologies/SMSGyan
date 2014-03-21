<?php

if (preg_match("~\b(pincodes?|pin codes?|pin)\b~", $spell_checked, $match)) {
    echo "input: $spell_checked<br>";

    if (strpos($spell_checked, 'pincode') === 0 || strpos($spell_checked, 'pincodes') === 0 || strpos($spell_checked, 'pin code') === 0 || strpos($spell_checked, 'pin codes') === 0 || strpos($spell_checked, 'pin') === 0) {
        $first_PIN = true;
    } else {
        $first_PIN = false;
    }
    echo "pin query: $spell_checked [$first_PIN]<br>";

    $pin_req = $spell_checked;
    $pin_req = trim(str_replace($match[0], "", $pin_req));

    echo "input after replace: $pin_req<br>";
    $pin_req = trim(preg_replace("~[\s]+~", " ", $pin_req));
    echo "input after preg replace: $pin_req<br>";
    $pin_req = trim(remwords($pin_req));  //getting unwanted words cleared
    echo "input after remove: $pin_req<br>";
    mysql_close();
    include 'lib/configdb2.php';

    //checking for pincode <pincode> format nmk

    if (is_numeric($pin_req)) {
        if (strlen($pin_req) == 6) {
            echo $query = "SELECT `city`,`district`,`state`,pincode FROM `pin_city`,`pin_district`,`pin_state` WHERE `pin_city`.state_id = `pin_state`.id and `pin_city`.district_id = `pin_district`.id AND `pincode`=$pin_req order by pincode DESC LIMIT 0 , 30";
            $result = mysql_query($query);

            if (mysql_num_rows($result)) {
                while ($row = mysql_fetch_array($result)) {
                    $out .= $row["city"] . ', ' . $row["district"] . ', ' . $row["state"] . "\n";
                }
            }
        }
        if (!empty($out)) {
            $total_return = 'Details of PINCODE ' . ucfirst($pin_req) . "\n" . $out;
        } else {
            if ($first_PIN) {
                $total_return = 'Sorry, wrong pincode format (Correct format: PINCODE <6 digit pincode> eg. PINCODE 560001)';
                $to_logserver['isresult'] = 0;
            }
        }
    } else {  //checking for numeric ends here
        if (!empty($pin_req)) {
            $pin_req_org = $pin_req;
            echo $query = "SELECT *,MATCH (`state`) AGAINST('$pin_req') as relv FROM `pin_state`  WHERE MATCH (`state`) AGAINST('$pin_req') >2.5  order by relv DESC LIMIT 1";
            $result = mysql_query($query);

            $pincode_stateid = 0;
            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);
                $pincode_state = $row["state"];
                $pincode_stateid = $row["id"];
                $pin_req = trim(str_ireplace($row["state"], "", $pin_req));
            }

            if (!empty($pin_req)) {
                if ($pincode_stateid > 0) {
                    echo $query = "SELECT *,MATCH (`district`) AGAINST('$pin_req') as relv FROM `pin_district`  WHERE MATCH (`district`) AGAINST('$pin_req') > 3.5 and state_id=$pincode_stateid  order by relv DESC LIMIT 0 , 1";
                } else {
                    echo $query = "SELECT *,MATCH (`district`) AGAINST('$pin_req') as relv FROM `pin_district`  WHERE MATCH (`district`) AGAINST('$pin_req') > 3.5 order by relv DESC LIMIT 0 , 1";
                }
                $result = mysql_query($query);

                $pincode_disid = 0;
                if (mysql_num_rows($result)) {
                    $row = mysql_fetch_array($result);
                    $pincode_district = $row["district"];
                    $pincode_disid = $row["id"];
                    $pin_req = trim(str_ireplace($row["district"], "", $pin_req));
                }

                if (!empty($pin_req)) {
                    if ($pincode_stateid > 0) {
                        echo $query = "SELECT `city`,`district`,`state`,pincode,MATCH (`city`) AGAINST('$pin_req') as relv FROM `pin_city`,`pin_district`,`pin_state` WHERE `pin_city`.state_id = `pin_state`.id and `pin_city`.district_id = `pin_district`.id AND MATCH (`city`) AGAINST('$pin_req') > 7 and `pin_city`.`state_id` = $pincode_stateid order by relv DESC LIMIT 0 , 30";
                    } elseif ($pincode_disid > 0) {
                        echo $query = "SELECT `city`,`district`,`state`,pincode,MATCH (`city`) AGAINST('$pin_req') as relv FROM `pin_city`,`pin_district`,`pin_state` WHERE `pin_city`.state_id = `pin_state`.id and `pin_city`.district_id = `pin_district`.id AND MATCH (`city`) AGAINST('$pin_req') > 7 and `pin_city`.`district_id` = $pincode_disid order by relv DESC LIMIT 0 , 30";
                    }
                    $result = mysql_query($query);

                    if (mysql_num_rows($result) == 0) {
                        echo $query = "SELECT `city`,`district`,`state`,pincode,MATCH (`city`) AGAINST('$pin_req') as relv FROM `pin_city`,`pin_district`,`pin_state` WHERE `pin_city`.state_id = `pin_state`.id and `pin_city`.district_id = `pin_district`.id AND MATCH (`city`) AGAINST('$pin_req') > 7 order by relv DESC LIMIT 0 , 30";
                        $result = mysql_query($query);
                    }
                } else {
                    echo $query = "SELECT `city`,`district`,`state`,pincode FROM `pin_city`,`pin_district`,`pin_state` WHERE `pin_city`.state_id = `pin_state`.id and `pin_city`.district_id = `pin_district`.id AND `pin_city`.`district_id` = $pincode_disid order by rand() LIMIT 0 , 30";
                    $result = mysql_query($query);
                }
            } else {
                echo $query = "SELECT `city`,`district`,`state`,pincode FROM `pin_city`,`pin_district`,`pin_state` WHERE `pin_city`.state_id = `pin_state`.id and `pin_city`.district_id = `pin_district`.id AND `pin_city`.`state_id` = $pincode_stateid order by rand() LIMIT 0 , 30";
                $result = mysql_query($query);
            }
        } else {
            $pin_req = $circle_city;
            echo $query = "SELECT `city`,`district`,`state`,pincode,MATCH (`city`) AGAINST('$circle_city') as relv FROM `pin_city`,`pin_district`,`pin_state` WHERE `pin_city`.state_id = `pin_state`.id and `pin_city`.district_id = `pin_district`.id AND MATCH (`city`) AGAINST('$circle_city') > 7 order by relv DESC LIMIT 0 , 30";
            $result = mysql_query($query);
            $pin_req_org = $circle_city;
        }

        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_array($result)) {
                $out .= $row["city"] . "," . $row["district"] . "," . $row["state"] . " - " . $row["pincode"] . "\n";
            }
        }

        if (!empty($out)) {
            $total_return = "Pincode of " . ucfirst($pin_req_org) . "\n" . $out;
        } else {
            if ($first_PIN) {
                $total_return = "Sorry, Pincode not found. Use pincode <city> <district>. eg pincode highcourt bangalore\npincode <pincode> eg. pincode 560001" . ucfirst($pin_req_org);
                $to_logserver['isresult'] = 0;
            }
        }
    }   //else close for numeric entry

    mysql_close();
    include 'lib/appconfigdb.php';

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'pincode';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
