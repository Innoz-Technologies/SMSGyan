<?php

echo "<h3> NowRunning</h3>";
$localmovie_return = '';
if (!empty($nowrun_city)) {
    echo $query = "select * from nowrun_city where city like '%" . $nowrun_city . "%'";
    $result = mysql_query($query);
//
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        echo $row["url"];
        $url = "http://www.nowrunning.com" . $row["url"];
        $content = file_get_contents($url);
    }

    if (!empty($content)) {
        preg_match_all("~<div class=\"ListTheaterHeader\"><a class=\"text3 large strong\" href=\"(.+)\">(.+)</a>~Usi", $content, $match);
//        var_dump($match);

        if (!empty($match)) {
            if (count($match[1]) == 1) {

                $url = "http://www.nowrunning.com" . $match[1][0];
                echo $content_cin = file_get_contents($url);

                if (!empty($content_cin)) {
                    echo $localmovie_return = showtimesn($content_cin);
                    if (!empty($localmovie_return)) {
                        $localmovie_return = $match[2][0] . "\n$localmovie_return";
                    }
                }
            } else {

                $len = 0;
                for ($i = 0; $i < count($match[1]); $i++) {
                    $len += strlen($match[2][$i]) + 3;
                    if ($len < 250) {
                        $options_list[] = $match[2][$i];
                        $list[] = array("content" => "__showtime__" . $match[1][$i] . "_" . $match[2][$i] . "__");
                    } else {
                        break;
                    }
                }
                var_dump($options_list);
                var_dump($list);
                if (!empty($options_list)) {
                    echo $localmovie_return = $nowrun_city;
                }
            }
        }
    }
}

function showtimesn($contents) {
    preg_match("~<div id=\"ctl00_ContentPlaceHolder_Middle_ShowtimesPanel\" class=\"Showtime\">(.+)</div><br />~Usi", $contents, $match_cin);
    $match_cin[0] = preg_replace("~<td style=\"width:90px;text-align:center;vertical-align:top;\">(.+)<span id=\"ctl00_ContentPlaceHolder_Middle_.+_showtimeDate.+>~Usi", "", $match_cin[0]);
    $match_cin[0] = trim(preg_replace("~[\s]+~", " ", $match_cin[0]));
    $match_cin[0] = trim(str_replace("</td> </tr>", "***", $match_cin[0]));
    $match_cin[0] = trim(strip_tags($match_cin[0]));
    $match_cin[0] = trim(preg_replace("~[\s]+~", " ", $match_cin[0]));
    $match_cin[0] = trim(str_replace("***", "\n", $match_cin[0]));
    $match_cin[0] = trim(str_replace("&nbsp;", "", $match_cin[0]));
    $match_cin[0] = trim(str_replace("\n ", "\n", $match_cin[0]));
    $match_cin[0] = trim(str_replace("\n\n", "\n", $match_cin[0]));
    return $match_cin[0];
}

?>