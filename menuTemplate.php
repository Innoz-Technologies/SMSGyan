<?php

echo "<h3>Menu Templates</h3>";

if (preg_match("~__menuTemplate__(.+)__~Usi", $req, $menuMatch)) {
    echo $search_word = $req = $spell_checked = $menuMatch[1];
} else {
    $jsonData = apc_fetch("menuData", $sucess);
    $curMenuDate = date("Y-m-d");
    $selectedkeyID = $keyID = 0;

    if ($sucess) {
        $arMenuData = json_decode($jsonData, true);
    }

    if (empty($arMenuData) || (!empty($arMenuData) && $arMenuData["date"] != $curMenuDate)) {
        unset($arMenuData);
        $query = "SELECT * FROM menu_keys WHERE date ='$curMenuDate' or isDaily=1 order by id";
        $result = mysql_query($query);
        $arMenuData["date"] = $curMenuDate;

        while ($row = mysql_fetch_array($result)) {
            $keyID = $row["id"];
            $arMenuData["menu"][$keyID]["mapKeys"] = $row["mapKeys"];
            $arMenuData["menu"][$keyID]["isAtStart"] = $row["isAtStart"];
            $arMenuData["menu"][$keyID]["isExact"] = $row["isExact"];
        }

        apc_store("menuData", json_encode($arMenuData, true));
    }

    var_dump($arMenuData);
    if (!empty($arMenuData["menu"])) {
        foreach ($arMenuData["menu"] as $keyID => $value) {
            if ($value["isAtStart"] == 0) {
                $pstr = '';
            } else {
                $pstr = '^';
            }

            if ($value["isExact"] == 0) {
                $sstr = '';
            } else {
                $sstr = '$';
            }

            echo "<br>~\b$pstr(" . $value["mapKeys"] . ")\b$sstr~si";

            if (preg_match("~\b$pstr(" . $value["mapKeys"] . ")\b$sstr~si", $spell_checked, $matches)) {
                echo "<br>Selected ID is: " . $selectedkeyID = $keyID;
                break;
            }
        }
    }

    if ($selectedkeyID > 0) {
        $query = "SELECT * FROM menu_keys WHERE id =$selectedkeyID";
        $result = mysql_query($query);

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $total_return = $row["totalReturn"];
            $menuSource = $row["source"];
            $qu = "SELECT * FROM menu_options WHERE keyID =$selectedkeyID order by `orderid` asc";
            $res = mysql_query($qu);

            while ($row1 = mysql_fetch_array($res)) {
                $options_list[] = $row1["optionKey"];
                $list[] = array("content" => $row1["optionValue"]);
            }
        }

        if ($total_return) {
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = $menuSource;
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}
?>
