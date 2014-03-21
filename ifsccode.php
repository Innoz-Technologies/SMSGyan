<?php

if (preg_match("~\b(ifsc)\b(.+)~", $spell_checked, $match)) {
    $ifsc_req = $spell_checked;
    $ifsc_req = trim(str_replace("code", "", $ifsc_req));
    $ifsc_req = trim(str_replace("bank", "", $ifsc_req));
    $ifsc_req = trim(str_replace("ifsc", "", $ifsc_req));
    $ifsc_req = trim(preg_replace("~\b(ltd|limited|co-operative|co-op|of|and|co op|the|co operative|cooperative|n|na|ag|plc|ufg|corp|psc|saog|\(mumbai\)|nv)\b~i", " ", $ifsc_req));
    $ifsc_req = trim(preg_replace("~\.|\-|,~", " ", $ifsc_req));
    $ifsc_req = trim(preg_replace("~[\s]+~", " ", $ifsc_req));
    $ifsc_req = srchstring_ifsc($ifsc_req);
    var_dump($ifsc_req);
    $query = "select * from ifsc_bank order by length(srch) desc";
    $result = mysql_query($query);

    echo "<br> word is :" . $ifsc_req;

    while ($row = mysql_fetch_array($result)) {
        $srch = $row["srch"];
        $srch = trim(str_ireplace("bank", "", $srch));
        if (preg_match("~\b" . trim($srch) . "\b~si", $ifsc_req)) {
            $ifsc_req = trim(str_ireplace(trim($srch), "", $ifsc_req));
            echo "<br>srch : " . $srch;
            echo "<br>Bank Name : " . $bank_name = $row["bank"];
            break;
        }
    }
    echo $ifsc_req;
    if (!empty($bank_name)) {
        echo $q = "select * from ifsc where branch_name like '%$ifsc_req%' and bank_name like '%$bank_name%' ";
        $result1 = mysql_query($q);
        if (mysql_num_rows($result1)) {
            $row = mysql_fetch_array($result1);
            echo $ifsc_code = $row["ifsc_code"] . "\n";
            echo $address = $row["address"] . "\n";
            echo $contact = $row["contact"] . "\n";
            $total_return = "IFSC CODE: " . $ifsc_code . "\n" . "ADDRESS: " . $address . "\n" . "CONTACT NO: " . $contact;
        } else {
            echo $q = "select * from ifsc where (city like '%$ifsc_req%' or district like '%$ifsc_req%') and bank_name like '%$bank_name%' limit 10";
            $q = mysql_query($q);
            if (mysql_num_rows($q) == 1) {
                $row = mysql_fetch_array($q);
                echo $ifsc_code = $row["ifsc_code"] . "\n";
                echo $address = $row["address"] . "\n";
                echo $contact = $row["contact"] . "\n";
                $total_return = "IFSC CODE: " . $ifsc_code . "\n" . "ADDRESS: " . $address . "\n" . "CONTACT NO: " . $contact;
            } else {
                while ($row = mysql_fetch_array($q)) {
                    $city = $row["city"];
                    echo $bank_name = $row["bank_name"];
                    echo $branch = $row["branch_name"];
                    $total_return = $bank_name . " " . $city . " " . "BRANCHES";
                    $options_list[] = $branch;
                    $list[] = array("content" => "ifsc" . " " . $bank_name . " " . $branch);
                }
            }
        }
    }

    if (empty($total_return) && str_word_count($spell_checked) <= 4) {
        $total_return = 'Sorry we cannot find the answer for your query';
    } else {
        $total_return = str_replace("?", "\n", $total_return);
        $total_return = str_replace("\n ", "\n", $total_return);
    }
}
if (!empty($total_return)) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'ifsccode';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function srchstring_ifsc($mystring) {
    $words = explode(" ", $mystring);
    $ret = $words[0];
    for ($i = 1; $i < count($words); $i++) {
        if (strlen($words[$i - 1]) == 1 && strlen($words[$i]) == 1) {
            $ret .= $words[$i];
        } else {
            $ret .= " " . $words[$i];
        }
    }
    return $ret;
}

?>