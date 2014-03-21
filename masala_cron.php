<?php

$url = "http://www.masala.com/news";
$contents = file_get_contents($url);
if (!empty($contents)) {
    if (preg_match_all('~<div class="tab-news">(.+)<div id="interviews">~Usi', $contents, $match)) {

        for ($i = 0; $i < count($match[1]); $i++) {
            if (preg_match_all('~<a href="(.+)">~Usi', $match[1][$i], $match1)) {
                $out[].=$match1[1][0];
            }
            if (preg_match_all('~<h(2|1)><a href=".+">(.+)</a></h(2|1)>~Usi', $match[1][$i], $match2)) {
                $head[].=$match2[2][0];
            }
        }
    }

    $i = 0;
    $count = count($out);
//        $surl = $out[$i];
    foreach ($out as $a) {
        $data = file_get_contents($a);
        if (!empty($data)) {
            $head[$i] . "\n";
            if (preg_match('~<div class="caption" style="background:#E6E6E6;">(.+)</div>~Usi', $data, $match3)) {
                $story = $match3[1];
                $story = preg_replace("~[\s]+~", " ", $story);
                $story = html_entity_decode($story);
                $story = $head[$i] . "\n" . strip_tags($story);
                $total_return = $story;
            }
            if (!empty($story)) {
                $query = "insert into masala (data,dated,url,head) values( '" . mysql_real_escape_string($story) . "' ,'" . date("Y-m-d") . "','" . mysql_real_escape_string($out[$i]) . "','" . mysql_real_escape_string($head[$i]) . "')";
                if (mysql_query($query)) {
                    echo "<br>Record Updated<br>";
//                        $url = $out[$i];
                }
            }
            $i++;
        }
    }
}
?>