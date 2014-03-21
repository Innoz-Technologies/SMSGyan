<?php

if (preg_match("~\b(pincode|pin code|pin)\b (.+)~si", $spell_checked, $match)) {
    mysql_close();
    include 'lib/configdb2.php';

    $p_district = $p_city = srchstring_trim($match[2]);
    $pin_districtid = 0;

    $out = "";

    echo "<br>" . $q_city = "Select * from pin_district where length(srch)<=length('$p_city')";
    $result_city = mysql_query($q_city);

    while ($row = mysql_fetch_array($result_city)) {
        if (preg_match("~\b" . trim($row["srch"]) . "\b~Usi", $p_city)) {
            $p_city = trim(str_ireplace(trim($row["srch"]), "", $p_city));
            echo "<br>" . $pin_district = $row["district"];
            echo "<br>" . $pin_districtid = $row["id"];
            break;
        }
    }
    $q_d = "";
    $result_dis = "";
    if (!empty($p_city)) {

        $p_city1 = str_replace(" ", "%", $p_city);
        if ($pin_districtid > 0) {
            echo "<br>" . $query = "select pincode,city,district from pin_city,pin_district where pin_city.district_id=pin_district.id and pin_city.srch='%" . trim(mysql_real_escape_string($p_city1)) . "%' and district_id=$pin_districtid";
        } else {
            echo "<br>" . $query = "select pincode,city,district from pin_city,pin_district where pin_city.district_id=pin_district.id and pin_city.srch='%" . trim(mysql_real_escape_string($p_city1)) . "%'";
            echo "<br>" . $q_d = "select pincode,city from pin_city where district_id=0 and pin_city.srch='%" . trim(mysql_real_escape_string($p_city1)) . "%'";
        }
        $result = mysql_query($query);
        if (!empty($q_d)) {
            $result_dis = mysql_query($q_d);
            if (mysql_num_rows($result_dis) == 0) {
                echo "<br>" . $q_d = "select pincode,city from pin_city where district_id=0 and strcmp(soundex(pin_city.srch), soundex('" . trim(mysql_real_escape_string($p_city)) . "')) = 0";
                $result_dis = mysql_query($q_d);
            }
        }

        if (mysql_num_rows($result) == 0) {
            if ($pin_districtid > 0) {
                echo "<br>" . $query = "select pincode,city,district from pin_city,pin_district where pin_city.district_id=pin_district.id and strcmp(soundex(pin_city.srch), soundex('" . trim(mysql_real_escape_string($p_city)) . "')) = 0 and district_id=$pin_districtid";
            } else {
                echo "<br>" . $query = "select pincode,city,district from pin_city,pin_district where pin_city.district_id=pin_district.id and strcmp(soundex(pin_city.srch), soundex('" . trim(mysql_real_escape_string($p_city)) . "')) = 0";
            }
            $result = mysql_query($query);
        }

        while ($row = mysql_fetch_array($result)) {
            $out .= $row["city"] . " " . $row["district"] . " - " . $row["pincode"] . "\n";
        }

        if (!empty($result_dis)) {
            while ($row_d = mysql_fetch_array($result_dis)) {
                $out .= $row_d["city"] . " - " . $row_d["pincode"] . "\n";
            }
        }
    }

    if (empty($out) && $pin_districtid > 0) {
        echo "<br>" . $query = "select pincode,city,district from pin_city,pin_district where pin_city.district_id=pin_district.id and district_id=$pin_districtid group by pincode";
        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result)) {
            $out .= $row["city"] . " " . $row["district"] . " - " . $row["pincode"] . "\n";
        }
    }

    if (empty($out)) {
        echo "<br>" . $query = "select * from pin_district where strcmp(soundex(pin_district.srch), soundex('" . trim(mysql_real_escape_string($p_city)) . "')) = 0 limit 1";
        $result = mysql_query($query);

        if (mysql_fetch_array($result)) {
            $row = mysql_fetch_array($result);
            $pin_districtid = $row["id"];

            echo "<br>" . $q = "select pincode,city,district from pin_city,pin_district where pin_city.district_id=pin_district.id and district_id=$pin_districtid group by pincode";
            $result_c = mysql_query($q);
            while ($r = mysql_fetch_array($result_c)) {
                $out .= $r["city"] . " " . $r["district"] . " - " . $r["pincode"] . "\n";
            }
        }
    }

    if (!empty($out)) {
        $total_return = "Pincode of " . ucfirst($p_district) . "\n" . $out;
    } else {
        $total_return = "Sorry Pincode found for " . ucfirst($p_district);
    }

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
