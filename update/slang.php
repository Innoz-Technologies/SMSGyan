<?php

set_time_limit(0);
include 'configdb.php';
//$query = "TRUNCATE TABLE `slang`";
//if (mysql_query($query)) {
//    echo "Recode Deleted<br>";
//}

$content = file_get_contents("http://www.internetslang.com/list.asp?i=all");
$out = '';
if (!empty($content)) {
    preg_match_all("~<UL>(.+)</UL>~Usi", $content, $match);

    foreach ($match[0] as $id => $val) {
        preg_match_all("~<A href=.+>(.+)</A>~Usi", $val, $code);
        $tmp = preg_replace("~[\s]+~", " ", $code[1][0]);
        $tmp = str_replace(",", " ", $tmp);
        $tmp = strip_tags($tmp);
        $tmp = trim($tmp);
        $inter_code[$id] = $tmp;

        preg_match_all("~<TD width=\"70%\">(.+)</TD>~Usi", $val, $means);
        $tmp = preg_replace("~[\s]+~", " ", $means[1][0]);
        $tmp = str_replace("<BR>", " ", $tmp);
        $tmp = strip_tags($tmp);
        $tmp = trim($tmp);
        $inter_means[$id] = $tmp;
    }
    
    for ($i = 0; $i < count($inter_code); $i++) {
        $q = "Replace into slang(scode,smean) values('" . mysql_real_escape_string($inter_code[$i]) . "','" . mysql_real_escape_string($inter_means[$i]) . "')";
        if (mysql_query($q)) {
            echo "<br>Record inserted " . ($i + 1);
        }
    }
}
?>