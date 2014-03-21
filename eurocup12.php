<?php

if (preg_match("~\b(eurocup|euro cup|football scores|euro 2012)\b(.+)?~", $spell_checked)) {
    $ouput = "";
    mysql_close();
    include 'lib/configdb2.php';

        echo $query = "Select * from eurocup where dated between '" . date("Y-m-d", strtotime("-2 day")) . "' and '" . date("Y-m-d", strtotime("+2 day")) . "'";
        $result = mysql_query($query);
        $count = 1;

        while ($row = mysql_fetch_array($result)) {
            $ouput .=$count . ". " . $row["week"] . " " . date("d-m-Y", strtotime($row["dated"])) . " " . date("H:i", strtotime($row["time"])) . "\n" . $row["matches"] . "\n" . $row["result"] . "\n";
            $count = $count + 1;
        }

        mysql_close();
        include 'lib/appconfigdb.php';

        if (!empty($ouput)) {
            $total_return = "Euro Cup Fixture & Results\n" . $ouput;
        }
    }
    if ($total_return) {
        $options_list[] = "All Fixtures";
        $list[] = array("content" => "__eurofixture__");
        $options_list[] = "All Results";
        $list[] = array("content" => "__euroresult__");
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'euro';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
//    }
}
if ($req == "__euroresult__") {
    mysql_close();
    include 'lib/configdb2.php';
    echo $query = "Select * from eurocup where result!=''";
    $result = mysql_query($query);
    $count = 1;
    while ($row = mysql_fetch_array($result)) {
        $ouput .=$count . ". " . $row["week"] . " " . date("d-m-Y", strtotime($row["dated"])) . "\n" . $row["matches"] . "\nResult : " . $row["result"] . "\n";
        $count = $count + 1;
    }
    mysql_close();
    include 'lib/appconfigdb.php';
    if (!empty($ouput)) {
        $total_return = "Euro Cup Results\n" . $ouput;
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'euro';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if ($req == "__eurofixture__") {
    mysql_close();
    include 'lib/configdb2.php';
    $query = "Select * from eurocup where dated>='" . date("Y-m-d") . "'";
    $result = mysql_query($query);
    $count = 1;
    while ($row = mysql_fetch_array($result)) {
        $ouput .=$count . ". " . $row["week"] . " " . date("d-m-Y", strtotime($row["dated"])) . " " . date("H:i", strtotime($row["time"])) . "\n" . $row["matches"] . "\n";
        $count = $count + 1;
    }
    mysql_close();
    include 'lib/appconfigdb.php';
    if (!empty($ouput)) {
        $total_return = "Euro Cup Fixture & Results\n" . $ouput;
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'euro';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>