<?php

if (preg_match("~\b(price|grocery price)\b(.+)~", $spell_checked, $match) && !preg_match("~\b(apple i phone|apple 4s|apple iphone|apple 3g|apple 5s|apple ipad|appleipad|apple (.+))\b~", $spell_checked)) {
    echo $spell_checked;
    echo $query = $match[1];
    if (isset($match[2])) {
        $query = $match[2];
    }
    $query = remwords($query);
    $query = trim($query);
    $url = "http://IP/solr/db/select/?version=2.2&start=0&rows=10&indent=on&q=" . urlencode($query) . "";
    $content = file_get_contents($url);
    $arXml = objectsIntoArray(simplexml_load_string($content));
    
    if (!empty($arXml["result"]["doc"])) {
        foreach ($arXml["result"]["doc"] as $doc => $arDocs) {
            var_dump($arDocs);
            echo $doc;
            if (is_numeric($doc)) {
                foreach ($arDocs as $res => $arDoc) {
//                    echo $res . "\n";
                    if ($res == "str") {
                        $vegname[] = $arDoc[1];
                        $vegurl[] = $arDoc[3];
//                        $url[] = $arDoc[3];
                    }
                }
            } else {
                $vegname = $arDocs[1];
                $vegurl = $arDocs[3];
                $content = file_get_contents($vegurl);
                if (preg_match("~<span id=\"our_price_display\">(.+)</span>~Usi", $content, $match)) {
                    echo $out = $match[1];
                    echo $out = "Mumbai Market Price\n" . $out;

                    if (preg_match("~<h1>(.+)</h1>~Usi", $content, $matches)) {
                        echo $matches[1];
                        $vegetable = $matches[1];
                    }
                    $out = $vegname . "\n" . $vegetable . "\n" . $out;
                }
                $total_return = $out;
            }
        }
        var_dump($vegname);
        var_dump($vegurl);
        $content = file_get_contents($vegurl[0]);
        if (preg_match("~<span id=\"our_price_display\">(.+)</span>~Usi", $content, $match)) {
            echo $out = $match[1];
            echo $out = "Mumbai Market Price\n" . $out;

            if (preg_match("~<h1>(.+)</h1>~Usi", $content, $matches)) {
                echo $matches[1];
                $vegetable = $matches[1];
            }
            $out = $vegname[0] . "\n" . $vegetable . "\n" . $out;
        }
        $total_return = $out;
        for ($i = 1; $i < count($vegurl); $i++) {
            $options_list_sugg[] = "$vegname[$i]";
            $list_sugg[] = "__veg_price__" . $vegname[$i] . "__" . $vegurl[$i] . "__";
        }
        $len = 0;
        $tot_len = 300;
        foreach ($options_list_sugg as $id => $val) {
            $len +=strlen($id . ". " . $val);
            if ($len < $tot_len) {
                $options_list[] = $val;
                $list[] = array("content" => $list_sugg[$id]);
            }
        }
        if ($total_return) {
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = 'vegprice';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}
if (preg_match("~__veg_price__(.+)__(.+)__~Usi", $req, $matches)) {
    echo "its here";
    echo $vegname = $matches[1];
    echo $url = $matches[2];
    $content = file_get_contents($url);
    if (preg_match("~<span id=\"our_price_display\">(.+)</span>~Usi", $content, $match)) {
        echo $out = $match[1];
        echo $out = "Mumbai Market Price\n" . $out;

        if (preg_match("~<h1>(.+)</h1>~Usi", $content, $matches)) {
            echo $matches[1];
            $vegetable = $matches[1];
        }
        $out = $vegname . "\n" . $vegetable . "\n" . $out;
    }
    $total_return = $out;
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'vegprice';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

//    mysql_close();
//    include 'lib/configdb2.php';
//    echo $q = "select url,vegname from vegprice where vegname like '%$query%'";
//    $result = mysql_query($q);
//    if (mysql_num_rows($result) == 1) {
//        $row = mysql_fetch_array($result);
//        echo $vegname = $row["vegname"] . "\n";
//        echo $url = $row["url"] . "\n";
//
//        mysql_close();
//        include 'lib/appconfigdb.php';
//
//        $content = file_get_contents($url);
//        if (preg_match("~<span id=\"our_price_display\">(.+)</span>~Usi", $content, $match)) {
//            echo $out = $match[1];
////        $out = trim(preg_replace("~[\s]+~", " ", $out));
////        $out = trim(str_replace("</span></p>", "***", $out));
////        $out = strip_tags($out);
////        $out = trim(preg_replace("~[\s]+~", " ", $out));
////        $out = trim(str_replace("***", "\n", $out));
////        $out = trim(str_replace("\n ", "\n", $out));
//            echo $out = "Mumbai Market Price\n" . $out;
//
//            if (preg_match("~<h1>(.+)</h1>~Usi", $content, $matches)) {
//                echo $matches[1];
//                $vegetable = $matches[1];
//            }
//            $out = $vegetable . "\n" . $out;
//        }
//        $total_return = $out;
//    } else {
//        mysql_close();
//        include 'lib/configdb2.php';
//        while ($row = mysql_fetch_array($result)) {
//            echo $vegname = $row["vegname"];
//            echo $url = $row["url"];
//            $options_list_sugg[] = "$vegname";
//            $list_sugg[] = "__veg_price__" . $vegname . "__" . $url . "__";
//            $total_return = "Your query matches more than one result";
//        }
//
//
//        $len = 0;
//        $tot_len = 300;
//        foreach ($options_list_sugg as $id => $val) {
//            $len +=strlen($id . ". " . $val);
//            if ($len < $tot_len) {
//                $options_list[] = $val;
//                $list[] = array("content" => $list_sugg[$id]);
//            }
//        }
//        var_dump($options_list);
//        var_dump($list);
//        mysql_close();
//        include 'lib/appconfigdb.php';
//    }
//
//
//    if ($total_return) {
//        $source_machine = $machine_id;
//        $current_file = "/temp/$numbers";
//        file_put_contents(DATA_PATH . $current_file, $total_return);
//        $to_logserver['source'] = 'vegprice';
//        include 'allmanip.php';
//        putOutput($total_return);
//        exit();
//    }
//}
//
//if (preg_match("~__veg_price__(.+)__(.+)__~Usi", $req, $matches)) {
//    echo "its here";
//    echo $vegname = $matches[1];
//    echo $url = $matches[2];
//    $content = file_get_contents($url);
//    if (preg_match("~<span id=\"our_price_display\">(.+)</span>~Usi", $content, $match)) {
//        echo $out = $match[1];
//        echo $out = "Mumbai Market Price\n" . $out;
//
//        if (preg_match("~<h1>(.+)</h1>~Usi", $content, $matches)) {
//            echo $matches[1];
//            $vegetable = $matches[1];
//        }
//        $out = $vegetable . "\n" . $out;
//    }
//    $total_return = $out;
//    if ($total_return) {
//        $source_machine = $machine_id;
//        $current_file = "/temp/$numbers";
//        file_put_contents(DATA_PATH . $current_file, $total_return);
//        $to_logserver['source'] = 'vegprice';
//        include 'allmanip.php';
//        putOutput($total_return);
//        exit();
//    }
//}
?>
