<?php

if (preg_match("~__ifsc__(.+)__~si", $req, $matches)) {

    $q = "SELECT * FROM `ifsc` WHERE id=" . $matches[1];
    $res = mysql_query($q);

    if (mysql_num_rows($res)) {
        $r = mysql_fetch_array($res);
        $total_return = "BANK NAME: " . $r["bank_name"] . "\nIFSC CODE: " . $r["ifsc_code"] . "\nMICR CODE: " . $r["micr_code"] . "\n";
        $total_return .= "BRANCH: " . $r["branch_name"] . "\nADDRESS: " . $r["address"] . "\nCITY: " . $r["city"] . "\nDISTRICT: " . $r["district"] . "\nSTATE: " . $r["state"] . "\nCONTACT NO: " . $r["contact"];
    }
}

if (preg_match("~\b((ifsc|micr) ?(codes?)?)\b (.+)~", $spell_checked, $match)) {
    if(strpos($spell_checked, 'ifsc') === 0 || strpos($spell_checked, 'micr') === 0){
        $first_IFSC = true;
    } else{
        $first_IFSC = false;
    }
    echo "ifsc query: $spell_checked [$first_IFSC]<br>";
    $ifsc_req = trim(remwords($spell_checked)); //reemoving unwanted words
    $ifsc_req = trim(str_replace($match[1], "", $ifsc_req));
    $ifsc_req = trim(preg_replace("~[\s]+~", " ", $ifsc_req));
    $bank_name = $district = $total_return = "";
    $options_list = $list = array();
    
    echo 'Printing matches<br>';
    foreach ($match as $key=>$value) {
        echo "$key => $value<br>";
    }
        
    $codecheck=trim($match[2]);   //first code 
    echo "Code caught:  $codecheck<br>length: ".strlen($ifsc_req)."<br>";
    if($codecheck=='ifsc' && strlen($ifsc_req)===11){  //ifsc <ifsccode> entered
        echo "<br>" . $q = "SELECT * FROM `ifsc` WHERE ifsc_code LIKE '" . $ifsc_req . "' order by id LIMIT 0 , 30";
        $res = mysql_query($q);
    }else if($codecheck=='micr' && is_numeric ($ifsc_req)){  //micr <micrcode> entered
        echo "<br>" . $q = "SELECT * FROM `ifsc` WHERE micr_code LIKE '" . $ifsc_req . "' order by id LIMIT 0 , 30";
        $res = mysql_query($q);
    }else{
        echo $query = "SELECT *,MATCH (`bank_name`) AGAINST('" . $ifsc_req . "') as relv FROM `ifsc` WHERE (MATCH (`bank_name`) AGAINST('" . $ifsc_req . "')) >3 order by relv DESC LIMIT 1";
        $result = mysql_query($query);

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $bank_name = $row["bank_name"];

            echo "<br>" . $q = "SELECT *,MATCH (`bank_name`,`branch_name`,`city`,`district`) AGAINST('" . $ifsc_req . "') as relv FROM `ifsc` WHERE MATCH (`bank_name`,`branch_name`,`city`,`district`) AGAINST('" . $ifsc_req . "') > 15 AND `bank_name` = '$bank_name' order by relv DESC LIMIT 0 , 30";
            $res = mysql_query($q);

            if (mysql_num_rows($res) == 0) {
                echo "<br>" . $q = "SELECT *,MATCH (`bank_name`,`branch_name`,`city`,`district`) AGAINST('" . $ifsc_req . "') as relv FROM `ifsc` WHERE MATCH (`bank_name`,`branch_name`,`city`,`district`) AGAINST('" . $ifsc_req . "') > 7 AND `bank_name` = '$bank_name' order by relv DESC LIMIT 0 , 30";
                $res = mysql_query($q);
            }
        }

        if (empty($q) || mysql_num_rows($res) == 0) {
            echo "<br>" . $q = "SELECT *,MATCH (`bank_name`,`branch_name`,`city`,`district`) AGAINST('" . $ifsc_req . "') as relv FROM `ifsc` WHERE MATCH (`bank_name`,`branch_name`,`city`,`district`) AGAINST('" . $ifsc_req . "') > 7 order by relv DESC LIMIT 0 , 30";
            $res = mysql_query($q);
        }
    }   //ends ifsc micr code checking

    if (mysql_num_rows($res) == 1) {
        $r = mysql_fetch_array($res);
        $total_return = "BANK NAME: " . $r["bank_name"] . "\nIFSC CODE: " . $r["ifsc_code"] . "\nMICR CODE: " . $r["micr_code"] . "\n";
        $total_return .= "BRANCH: " . $r["branch_name"] . "\nADDRESS: " . $r["address"] . "\nCITY: " . $r["city"] . "\nDISTRICT: " . $r["district"] . "\nSTATE: " . $r["state"] . "\nCONTACT NO: " . $r["contact"];
    } elseif (mysql_num_rows($res) > 1) {
        $len = 0;
        while ($r = mysql_fetch_array($res)) {
            if (empty($district)) {
                $district = $r["district"];
            }
            $bank_name = $r["bank_name"];

            $branch = $r["branch_name"];
            $options_list[] = $bank_name . " " . $branch;
            $list[] = array("content" => "__ifsc__" . $r["id"] . "__");
        }
        $total_return = $district . " BRANCHES";
    }

    if (empty($total_return) && $first_IFSC) {
        $total_return = 'Sorry we cannot find the answer for your query';
        $to_logserver['isresult'] = 0;
    }
}

echo $total_return;
var_dump($options_list);

if (!empty($total_return)) {
    $total_return = str_replace("?", " ", $total_return);
    $total_return = str_replace("\n ", "\n", $total_return);
    $to_logserver['source'] = 'ifsccode';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
