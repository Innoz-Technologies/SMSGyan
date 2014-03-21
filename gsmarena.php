<?php

$phone_return = '';
$phone_brand = '';
$phone_model = '';
$brand_id = 0;

if (preg_match("~\bspec\b (.+)~", $spell_checked, $matches)) {
    $phone_srch = $matches[1];
    $resultMust = true;
} else {
    $phone_srch = trim(preg_replace("~\bspec\b~", "", $spell_checked));
    $resultMust = false;
}
$phone_srch = trim(str_replace(",", " ", $phone_srch));
$arPhone = explode(" ", $phone_srch);

if (!empty($arPhone)) {
    $pStr = '';
    foreach ($arPhone as $val) {
        if ($pStr == "") {
            $pStr = "'" . $val . "'";
        } else {
            $pStr .= ",'" . $val . "'";
        }
    }

    $query = "Select * from gsmarena_brand where brandName in ($pStr)";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $phone_brand = trim($row["brandName"]);
        $phone_model = trim(str_ireplace($phone_brand, "", $phone_srch));
        $brand_id = $row["id"];
        $q_model = "Select * from gsmarena_model where model like '%" . $phone_model . "%' and brand_id=$brand_id";
        $result_model = mysql_query($q_model);

        if (mysql_num_rows($result_model)) {
            $r = mysql_fetch_array($result_model);
            $total_return = $r["spec"];

            $count = 0;
            if ($options = unserialize($r["options"])) {
                $phone_list = unserialize($r["list"]);
                for ($i = 0; $i < count($options); $i++) {
                    if ($count < 2) {
                        $option_list[] = "spec " . $options[$i];
                        $list[] = array("content" => "spec " . $phone_list[$i]);
                        $count +=1;
                    }
                }
            }
        }

        if (empty($option_list) && !empty($total_return)) {
            $q_opnlist = "Select * from gsmarena_model,gsmarena_brand where gsmarena_model.brand_id=gsmarena_brand.id and brand_id=$brand_id order by rand() limit 0,2";
            $result_opnlist = mysql_query($q_opnlist);

            while ($row1 = mysql_fetch_array($result_opnlist)) {
                $option_list[] = "spec " . $row1["brandName"] . " " . $row1["model"];
                $list[] = array("content" => "spec " . $row1["brandName"] . " " . $row1["model"]);
            }
        }
        echo $total_return;
        var_dump($option_list);
        var_dump($list);
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'spec';
        putOutput($total_return);
        exit();
    }
}
?>