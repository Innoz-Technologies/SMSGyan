<?php

include 'configdb2.php';

$query = "Select * from fabmart order by id";
$result = mysql_query($query);
$prevValue = "";

if (mysql_num_rows($result)) {
    while ($row = mysql_fetch_array($result)) {
        if (!empty($row["title"]))
            $title = $row["title"];
        if (!empty($row["vendor"]))
            $vendor = $row["vendor"];
        if (!empty($row["type"]))
            $type = $row["type"];
        if (!empty($row["tags"]))
            $tags = $row["tags"];
        if (!empty($row["img_src"]))
            $img_src = $row["img_src"];
        if (!empty($row["optionName1"])) {
            $optionName1 = $row["optionName1"];
            $optionValue1 = $row["optionValue1"];
            if ($prevValue != $optionName1) {
                $prevValue = $optionName1;
                $optionName2 = "";
                $optionValue2 = "";
                $optionName3 = "";
                $optionValue3 = "";
            }
        }
        if (!empty($row["optionName2"])) {
            $optionName2 = $row["optionName2"];
            $optionValue2 = $row["optionValue2"];
        }
        if (!empty($row["optionName3"])) {
            $optionName3 = $row["optionName3"];
            $optionValue3 = $row["optionValue3"];
        }
        if (!empty($row["price"]))
            $price = $row["price"];
        if (!empty($row["Shippig"]))
            $Shippig = $row["Shippig"];
        if (!empty($row["tax"]))
            $tax = $row["tax"];

        $q = "Update fabmart set title='$title',vendor='$vendor',type='$type',tags='$tags',img_src='$img_src',optionName1='$optionName1',optionValue1='$optionValue1',price='$price',Shippig='$Shippig',tax='$tax',optionName2='$optionName2',optionValue2='$optionValue2',optionName3='$optionName3',optionValue3='$optionValue3' where id=" . $row["id"];
        if (!mysql_query($q)) {
            echo "error in update" . $row["id"];
            echo $q;
            break;
        }
    }
}
?>
