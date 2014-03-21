<?php

apc_fetch("celebrityName", $success);

if (!$success) {
    echo "<h1>Connceting</h1>";
    mysql_close();
    include 'lib/configdb2.php';
}
require_once 'binary_search.php';
echo "<h4>CITY SEARCH</h4>";
$tree = new BinarySearch('celebrityName', 'msisdn', 1);
$btime = microtime(true);
echo $c_number = $tree->search($number, 1);

if (!$success) {
    mysql_close();
    include 'lib/appconfigdb.php';
}

if (!empty($c_number)) {

    mysql_close();
    include 'lib/configdb2.php';

    $query = "select * from celebrityName where msisdn='$c_number'";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $celebrityName = $row["name"];
        $celebrityID = $row["id"];

        $q = "INSERT INTO celebrityTweets(`celebrityID`,`tweets`) VALUES($celebrityID,'" . mysql_real_escape_string($query_in) . "')";
        if (mysql_query($q)) {
            echo "<br>Record Insertd";
        }
    }

    $total_return = "successfully posted";
    $isReturn = 0;

    mysql_close();
    include 'lib/appconfigdb.php';
} elseif (preg_match("~__celebrity__(.+)__(.+)__(.+)__~is", $req, $match)) {
    mysql_close();
    include 'lib/configdb2.php';

    $celebrityID = $match[1];
    $type = $match[2];
    $celebrityName = $match[3];

    if ($type == "list") {
        $cbTime = date("Y-m-d H:i:s");
    } else {
        $cbTime = $type;
    }
    echo $q = "select * from celebrityTweets where celebrityID=" . $celebrityID . " and `timestamp`< '$cbTime' order by `timestamp` desc limit 2";
    $result1 = mysql_query($q);

    if (mysql_num_rows($result1)) {
        $row1 = mysql_fetch_array($result1);
        $total_return = $celebrityName . " : " . $row1["tweets"];
        if (mysql_num_rows($result1) > 1) {
            $options_list[] = "Previous";
            $list[] = array("content" => "__celebrity__" . $row1["celebrityID"] . "__" . $row1["timestamp"] . "__" . $celebrityName . "__");
        }
    }

    if (empty($total_return)) {
        $total_return = "Sorry no celebrity data found";
    }

    mysql_close();
    include 'lib/appconfigdb.php';
} elseif (preg_match("~\b(celeb|celebrity)\b~is", $spell_checked)) {
    $search_celeb = trim(preg_replace("~\b(celebrity|celeb)\b~si", "", $spell_checked));

    mysql_close();
    include 'lib/configdb2.php';

    if (empty($search_celeb)) {
        $total_return = "List of matching celebrities are : ";
        $query = "select * from celebrityName";
        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result)) {
            $options_list[] = $row["name"];
            $list[] = array("content" => "__celebrity__" . $row["id"] . "__list__" . $row["name"] . "__");
        }
    } else {
        echo $query = "select * from celebrityName where name like '%$search_celeb%'";
        $result = mysql_query($query);

        if (mysql_num_rows($result) > 1) {
            $total_return = "List of matching celebrities are : ";

            while ($row = mysql_fetch_array($result)) {
                $options_list[] = $row["name"];
                $list[] = array("content" => "__celebrity__" . $row["id"] . "__list__" . $row["name"] . "__");
            }
        } elseif (mysql_num_rows($result) == 1) {
            $row = mysql_fetch_array($result);
            echo $q = "select * from celebrityTweets where celebrityID=" . $row["id"] . " order by `timestamp` desc limit 2";
            $result1 = mysql_query($q);

            if (mysql_num_rows($result1)) {
                $row1 = mysql_fetch_array($result1);
                $total_return = $row["name"] . " : " . $row1["tweets"];
                if (mysql_num_rows($result1) > 1) {
                    $options_list[] = "Previous";
                    $list[] = array("content" => "__celebrity__" . $row1["celebrityID"] . "__" . $row1["timestamp"] . "__" . $row["name"] . "__");
                }
            }
        }
    }

    if (empty($total_return)) {
        $total_return = "Sorry no celebrity data found";
    }

    mysql_close();
    include 'lib/appconfigdb.php';
}

if ($total_return) {
    $to_logserver['source'] = 'celeb';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
