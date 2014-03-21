<?php

echo "<br>Cricket Schedule<br>";
$result = '';
$query = "select * from cri_sch where dated = '" . date("Y-m-d") . "'";
$result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
if (mysql_num_rows($result)) {
    echo "<br>Cricket Schedule from DB " . date("Y-m-d") . "<br>";
    $row = mysql_fetch_array($result);
    $result = $row['sch'];
} else {
    $url = 'http://m.espncricinfo.com/s/5643/Fixtures?countryId=all';
    $content = file_get_contents($url);

    if (preg_match_all("~<td style=\"padding-left:4px;padding-bottom:4px\" width=\"100%\" bgcolor=\".*\">(.+)><td align=\"center\" valign=\"center\" style=\"border-top:1px solid #C1CDDB; border-bottom:1px solid #FEFEFE;\">~Usi", $content, $match)) {
//    var_dump($match);
        $result = "";
        $toadd = 19800;
        foreach ($match[1] as $val) {
            $out = $val;
            $out = str_replace("</tr>", '***', $out);
            $out = strip_tags($out);
            $out = preg_replace("~[\s]+~", " ", $out);
            $out = str_replace("***", "\n", $out);
            $out = str_replace("\n ", "\n", $out);
            $end = stripos($out, "GMT");
            $start = $end - 6;
            $temp = substr($out, $start, $end - $start);
            $gmttime = $temp;
            $timestamp = strtotime($temp) + $toadd;
            $IND_time = date('H:i', $timestamp);
            $temp = $IND_time . " IST " . $temp;
            $out = str_replace($gmttime, $temp, $out);
            $result .= trim($out) . "\n";
        }

        echo $result = "Fixtures are :\n" . trim($result);


        if (!empty($result)) {
            echo $query = "update cri_sch set sch='" . $result . "' ,dated='" . date("Y-m-d") . "' where id=1";
            if (mysql_query($query)) {
                echo "<br>Record Updated<br>";
            }
        }
    }
}

if (empty($result)) {
    $query = "select * from cri_sch";
    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    $row = mysql_fetch_array($result);
    echo "<br>Cricket Schedule from DB<br>";
    $result = $row['sch'];
}
$total_return = $result;
$source_machine = 'db';
$current_file = "cri_sch/sch/id/1";
include 'allmanip.php';
$to_logserver['source'] = 'cri_sch';
putOutput($total_return);
exit();
?>
