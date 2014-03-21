<?php

include 'configdb.php';

$url = "http://www.nowrunning.com/bengaluru/showtimes.htm";
$content = file_get_contents($url);

if (!empty($content)) {
    preg_match_all("~<div id=\"ctl00_ContentPlaceHolder_Left_1_RegionSelector1_RegionAccordionPane.+>(.+)</div>~Usi", $content, $match);
//    var_dump($match);

    if (!empty($match[1])) {
        foreach ($match[1] as $val) {
            preg_match_all("~<a title=\"(.+)\" href=\"(.+)\" class=\"text1 med-large strong\">(.+)</a>~Usi", $val, $match2);
//            var_dump($match2);

            for ($i = 0; $i < count($match2[0]); $i++) {
//                echo $match2[3][$i];
                echo "<br>" . $query = "replace into nowrun_city(title,url,city) values('" . mysql_real_escape_string($match2[1][$i]) . "','" . mysql_real_escape_string($match2[2][$i]) . "','" . mysql_real_escape_string($match2[3][$i]) . "')";
                if (mysql_query($query)) {
                    echo "<br>Record inserted";
                }
            }
        }
    }
}
?>