<?php

set_time_limit(0);
include 'configdb.php';

//$query = "DELETE FROM `currency`";
//if (mysql_query($query)) {
//    echo "Recode Deleted<br>";
//}

$out = '';
$url = "http://in.advfn.com/currency-converter/";
$content = file_get_contents($url);

if (!empty($content)) {
    preg_match_all("~morepairs\[(.+);~Usi", $content, $match);

    foreach ($match[0] as $id => $val) {
        $out = $val;
        preg_match("~morepairs\['(.+)'\]~", $out, $cval);
        $curval[] = $cval[1];

        preg_match("~= '(.+)';~", $out, $cname);
        $curname[] = $cname[1];
    }

    $out = '';
    foreach ($match[0] as $id => $val) {
        $query = "Replace into currency (cur_val,cur_name) values ('" . mysql_real_escape_string($curval[$id]) . "','" . mysql_real_escape_string($curname[$id]) . "')";
        if (mysql_query($query)) {
            echo "Recode inserted<br>";
        }
    }
}
?>
