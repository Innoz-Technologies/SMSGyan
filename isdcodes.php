<?php

echo 'search word before preg checking isd: ' . $spell_checked . '<br>';
if (preg_match("~__isdcode__(.+)__~si", $spell_checked, $matches)) {

    $query = "SELECT * FROM `isdcode` WHERE id=" . $matches[1];
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $total_return .= "ISD CODE " . ucfirst($isdWord) . "\n";
        $total_return .= "Country : " . $row["country"] . "\n";
        $total_return .= "Country Code (ISD Code) : " . $row["isdcode"] . "\n";
        if (!empty($row["iddcode"])) {
            $total_return .= "IDD prefix : " . $row["iddcode"] . "\n";
        }
    }
} elseif (preg_match("~\b((isd) ?(codes?)?)\b (.+)~", $spell_checked, $match)) {//if (preg_match("~^isd (codes?)? (.+)~", $spell_checked,$match)) {
    //$isdWord = trim(str_replace("isd", "", $spell_checked));
    if (strpos($spell_checked, 'isd') === 0) {
        $first_ISD = true;
    } else {
        $first_ISD = false;
    }
    echo "isd query: $spell_checked [$first_ISD]<br>";

    $isdWord = $match[4];    //getting rest of keyword
    $isdWord = trim(remwords($isdWord));    //removing unnecessary wordss
    /* foreach ($match as $key => $value) {
      echo "$key => $value<br>";
      } */

    //code for checking given isd code
    echo 'check for numeric<br>';
    if (is_numeric($isdWord)) {   //isd isdcode found
        echo 'found numeric<br>';
        echo $query = "SELECT * FROM isdcode where isdcode = " . $isdWord . " order by iddcode";
        $result = mysql_query($query);

        if (mysql_num_rows($result) == 0) {
            echo $query = "SELECT * FROM isdcode where concat(isdcode,isdcode) = " . $isdWord . " order by iddcode";
            $result = mysql_query($query);
        }
        if (mysql_num_rows($result) == 1) {
            $row = mysql_fetch_array($result);
            $total_return .= "ISD CODE " . ucfirst($isdWord) . "\n";
            $total_return .= "Country : " . $row["country"] . "\n";
            $total_return .= "Country Code (ISD Code) : " . $row["isdcode"] . "\n";
            if (!empty($row["iddcode"])) {
                $total_return .= "IDD prefix : " . $row["iddcode"] . "\n";
            }
        } elseif (mysql_num_rows($result) > 1) {
            while ($row = mysql_fetch_array($result)) {

                $country = $row["country"];

                $options_list[] = $country;
                $list[] = array("content" => "__isdcode__" . $row["id"] . "__");
            }
            $total_return = "SELECTION AN OPTION FOR ISD CODE " . $isdWord;
        }
    } elseif (!empty($isdWord)) {  //isd country found
        echo 'found no numeric<br>';
        echo $query = "SELECT * FROM isdcode where country like '%" . $isdWord . "%'";
        $result = mysql_query($query);

        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_array($result);
            $total_return .= "ISD " . ucfirst($isdWord) . "\n";
            $total_return .= "Country : " . $row["country"] . "\n";
            $total_return .= "Country Code (ISD Code) : " . $row["isdcode"] . "\n";
            if (!empty($row["iddcode"])) {
                $total_return .= "IDD prefix : " . $row["iddcode"] . "\n";
            }
        } else {
            if ($first_ISD) {
                $total_return = "Sorry, couldn't find isd code for $isdWord\n";
                $to_logserver['isresult'] = 0;
            }
        }
    }//is_numeric else close
} elseif ($spell_checked == 'isd') {
    echo 'found empty<br>';
    $total_return = "Use correct format. 'ISD<space>country' to find isd code or 'ISD<space>isdcode' to find country\n";
}
echo 'search word: ' . $spell_checked . '<br>';

if ($total_return) {
    $source_machine = 'db';
    include 'allmanip.php';
    $to_logserver['source'] = 'isd';
    putOutput($total_return);
    exit();
}

if ((strpos($spell_checked, 'mobile numb') !== false || strpos($spell_checked, 'contact numb') !== false || strpos($spell_checked, 'phone numb') !== false) && (strpos($spell_checked, 'add') !== false || strpos($spell_checked, 'append') !== false || strpos($spell_checked, 'begin') !== false || strpos($spell_checked, 'start') !== false || strpos($spell_checked, 'dial') !== false || strpos($spell_checked, 'enter') !== false)) {
    $country_list = apc_fetch('country_list', $success);
    if (!$success) {
        //if (true) {
        echo $query = "SELECT * FROM isdcode";
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $country_list[$i]['country'] = $row['country'];
            $country_list[$i]['isd'] = $row['isdcode'];
            $i++;
        }
        apc_store('country_list', $country_list);
    }
    foreach ($country_list as $value) {
        if (stripos($spell_checked, $value['country']) !== false) {
            $total_return = "Country : " . $value["country"] . "\n";
            $total_return .= "Country Code (ISD Code) : " . $value["isd"];
            include 'allmanip.php';
            $to_logserver['source'] = 'isd';
            putOutput($total_return);
            exit();
        }
    }
}
?>
