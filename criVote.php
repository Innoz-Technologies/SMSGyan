<?php

if (preg_match("~votes? (.+)~", $spell_checked, $match)) {

    $cri_return = "";
    if ($match[1] == "a") {
        $query = "update crivotes set a_count=a_count+1 where id=1";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    } elseif ($match[1] == "b") {
        $query = "update crivotes set b_count=b_count+1 where id=1";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    } elseif ($match[1] == "c") {
        $query = "update crivotes set c_count=c_count+1 where id=1";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    } elseif ($match[1] == "d") {
        $query = "update crivotes set d_count=d_count+1 where id=1";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    } elseif ($match[1] == "1") {
        $query = "update crivotes set a_count=a_count+1 where id=2";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    } elseif ($match[1] == "2") {
        $query = "update crivotes set b_count=b_count+1 where id=2";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    } elseif ($match[1] == "3") {
        $query = "update crivotes set c_count=c_count+1 where id=2";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    } elseif ($match[1] == "4") {
        $query = "update crivotes set d_count=d_count+1 where id=2";
        if (mysql_query($query)) {
            echo "Record Updated<br>";
        }
    }

    $q = "";

    if (is_numeric($match[1])) {
        $query = "Select * from crivotes where id=2";
        $q = "select * from ad_scripts where id=33";
    } else {
        $query = "Select * from crivotes where id=1";
        $q = "select * from ad_scripts where id=36";
    }

    if (!empty($q)) {
        $res = mysql_query($q);

        if (mysql_num_rows($res)) {
            $r = mysql_fetch_array($res);
            $add_below = "\n--\n" . $r["script"];
        }
    }

    $result = mysql_query($query);

    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $cri_return .= "Total Votes\n";
        $cri_return .= $row["a_ans"] . ": " . $row["a_count"] . "\n";
        $cri_return .= $row["b_ans"] . ": " . $row["b_count"] . "\n";
        if ($row["c_enable"] > 0) {
            $cri_return .= $row["c_ans"] . ": " . $row["c_count"] . "\n";
        }
        if ($row["d_enable"] > 0) {
            $cri_return .= $row["d_ans"] . ": " . $row["d_count"] . "\n";
        }
    }

    echo $cri_return;
    if ($cri_return) {
        $total_return = $cri_return;
        $to_logserver['source'] = 'vote';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
