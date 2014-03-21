<?php

set_time_limit(0);
include 'configdb.php';
$url = "http://narasimhadatta.info/bmtc_query.html";
$content = file_get_contents($url);

if (preg_match("~<td><select name=\"from\">(.+)</td>~Usi", $content, $match)) {
//    var_dump($match);
    if (!empty($match[1])) {
        preg_match_all("~<option>(.+)</option>~Usi", $match[1], $matchs);
//        var_dump($matchs);
        foreach ($matchs[0] as $val) {
            $val = trim(strip_tags($val));
            if (!empty($val)) {
//                echo $val . "<br>";
                $val = trim($val);
                $val2 = srchstring($val);
                
                $query = "Replace into bus_stops_blr (place,srch) values ('" . mysql_real_escape_string($val) . "','" . strtolower(mysql_real_escape_string($val)) . "')";
                if (mysql_query($query)) {
                    echo "<br>Record Inserted";
                }
                if (strpos($val, "(") !== FALSE) {
                    preg_match("~(.+)\((.+)\)~", $val, $matches);
//                    var_dump($matches);
                    if (!empty($matches)) {
                        $matches[1] = srchstring($matches[1]);
                        $matches[1] = srchstring($matches[2]);
                        $query = "Replace into bus_stops_blr (place,srch) values ('" . mysql_real_escape_string($val) . "','" . trim(strtolower(mysql_real_escape_string($matches[1]))) . "'),('" . mysql_real_escape_string($val) . "','" . trim(strtolower(mysql_real_escape_string($matches[2]))) . "')";
                        if (mysql_query($query)) {
                            echo "<br>Record Inserted";
                        }
                    }
                } elseif (strpos($val, "/") !== FALSE) {
                    preg_match("~(.+)\/(.+)~", $val, $matches);
//                    var_dump($matches);
                    if (!empty($matches)) {
                        $matches[1] = srchstring($matches[1]);
                        $matches[1] = srchstring($matches[2]);
                        $query = "Replace into bus_stops_blr (place,srch) values ('" . mysql_real_escape_string($val) . "','" . trim(strtolower(mysql_real_escape_string($matches[1]))) . "'),('" . mysql_real_escape_string($val) . "','" . trim(strtolower(mysql_real_escape_string($matches[2]))) . "')";
                        if (mysql_query($query)) {
                            echo "<br>Record Inserted";
                        }
                    }
                }
            }
        }
    }
}

function srchstring($mystring) {
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