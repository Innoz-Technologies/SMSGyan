<?php

//if (preg_match("~__mukhwaak__(.+)__~Usi", $req, $match)) {
//    echo $query = "Select * from mukhwaak where date(fetch_date)='" . date("Y-m-d") . "'";
//    $result = mysql_query($query);
//    $tppe = $match[1];
//
//    if (mysql_num_rows($result)) {
//        $row = mysql_fetch_array($result);
//        if ($tppe == "eng") {
//            $total_return = $row["english"];
//        } else {
//            $total_return = $row["punjabi"];
//        }
//
//        if (!empty($total_return)) {
//            $source_machine = $machine_id;
//            $current_file = "/temp/$numbers";
//            file_put_contents(DATA_PATH . $current_file, $total_return);
//            $to_logserver['source'] = 'hukumnama';
//            include 'allmanip.php';
//            putOutput($total_return);
//            exit();
//        }
//    }
//}

if (preg_match("~\b(mukhwaak|mukh[vw]aakh|mukh[vw]akh|muk[vw]ak|mukh[vw]ak|muk[vw]aak|mukh[vw]aak)\b~si", $spell_checked)) {
    echo $spell_checked;
//if ($spell_checked == "mukhwaak") {
    echo $query = "Select * from mukhwaak where date(fetch_date)='" . date("Y-m-d") . "'";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $total_return = $row["english"];

//        if (!empty($row["english"])) {
//            $options_list[] = "English Translation";
//            $list[] = array("content" => "__mukhwaak__eng__");
//        }
//        if (!empty($row["punjabi"])) {
//            $options_list[] = "Punjabi Translation";
//            $list[] = array("content" => "__mukhwaak__pun__");
//        }
    } else {
        echo $query = "Select * from mukhwaak order by fetch_date desc limit 1";
        $result = mysql_query($query);
        $prevResult = "";

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $prevResult = $row["response"];
        }
        echo $url = "http://www.sikhnet.com/Hukam";
        $content = file_get_contents($url);

        if (preg_match("~<meta property=\"og:description\" content=\"(.+)\".+/>~Usi", $content, $matches)) {
            var_dump($matches);
            $out = $matches[1];
            if (!empty($out)) {
                $out = "English Translation :\n" . $out;
            }
        }

        if (!empty($out)) {
            $total_return = $out;

            if ($prevResult != $out) {
                $q = "Insert into mukhwaak(`english`) values ('" . mysql_real_escape_string($out) . "')";
                if (mysql_query($q)) {
                    echo "Record Inserted";
                }
            }
        }
    }

    if (!empty($total_return)) {
        $add_below = "\n----\n INTERNET SEARCH ON SMS! SMS HELP TO 55444 TO FIND OUT MORE. (Tollfree)";
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'hukumnama';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>