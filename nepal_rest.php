<?php

echo "<h3>Nepal Restaurant</h3>";
$list_re = $options_list_re = array();
if (preg_match("~^(Food Courts|Food Delivery Service|Hotel|Bakery|Bar|Lounge|Pub|Kitchen Supplie|Furniture Dealer|night club|disco|Restaurants?|sweet|sltie|Wine Supplier|Fast Food)s? (.+)~si", $spell_checked, $matches)) {
    $nepalRest = $spell_checked;
    echo $nepalRest = trim(preg_replace("~\b(in|near|at)\b~", "", $nepalRest));

    echo "<br>" . $query = "SELECT *,MATCH (tag,name,location) AGAINST('" . $nepalRest . "') as relv FROM nepal_restaurants WHERE MATCH (tag,name,location) AGAINST('" . $nepalRest . "') having relv >7 order by relv desc limit 0,10";
    $result = mysql_query($query);

    while ($row = mysql_fetch_array($result)) {
        $options_list_re[] = $row["name"] . " " . $row["location"];
        $list_re[] = array("content" => "__nepalRest__id__" . $row["id"] . "__");

        if (empty($total_return)) {
            $total_return = $row["details"] . "\n" . $row["location"];
        }
    }

    if (count($options_list_re) > 1) {
        $total_return = "Query matching more than one result";
        $options_list = array_merge($options_list, $options_list_re);
        $list = array_merge($list, $list_re);
    } else if (empty($options_list_re)) {
        echo "<br>" . $query = "SELECT *,MATCH (tag,name,location) AGAINST('" . $nepalRest . "') as relv FROM nepal_restaurants WHERE MATCH (tag,name,location) AGAINST('" . $nepalRest . "') order by relv desc limit 0,10";
        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result)) {
            $options_list_re[] = $row["name"] . " " . $row["location"];
            $list_re[] = array("content" => "__nepalRest__id__" . $row["id"] . "__");

            if (empty($total_return)) {
                $total_return = $row["details"] . "\n" . $row["location"];
            }
        }

        if (count($options_list_re) > 1) {
            $total_return = "Query matching more than one result";
            $options_list = array_merge($options_list, $options_list_re);
            $list = array_merge($list, $list_re);
        }
    }
} elseif (preg_match("~__nepalRest__id__(.+)__~", $req, $matches)) {
    echo "<br>" . $query = "SELECT * FROM nepal_restaurants WHERE id=" . $matches[1];
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $total_return = $row["details"] . "\n" . $row["location"];
    }
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'nepalrest';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
