<?php

include 'configdb2.php';
set_time_limit(0);

$query = "SELECT * FROM `lyrics` WHERE `title` is null order by id";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {

    $url = $row["url"];
    $id = $row["id"];
    $content = file_get_contents($url);
    $content = preg_replace("[\s]", " ", $content);

    if (preg_match_all("~Song-<strong>(.+)</strong>.+\((.+)\).+Singers?-(.+), ?Lyrics-.+Lyrics</strong>.+</p>(.+)<div class=\"wpadvert\">~Usi", $content, $matches)) {

        $title = html_entity_decode(strip_tags($matches[1][0]));
        $matches[2][0] = str_replace("&#8217;", "'", $matches[2][0]);
        $movie = html_entity_decode(strip_tags($matches[2][0]));
        $singer = html_entity_decode(strip_tags($matches[3][0]));

        $out = html_entity_decode($matches[4][0]);
        $out = str_replace("<br />", "***", $out);
        $out = strip_tags($out);
        $out = preg_replace("[\s]", " ", $out);
        $out = str_replace("***", "\n", $out);
        $out = str_replace("\n ", "\n", $out);
        $out = str_replace("&#8217;", "'", $out);
        $out = trim($out);

        if (!empty($out)) {
            $q = "UPDATE `lyrics` SET `title`='" . mysql_real_escape_string($title) . "',`movie`='" . mysql_real_escape_string($movie) . "',`singers`='" . mysql_real_escape_string($singer) . "',`language`='hindi',`lyrics`='" . mysql_real_escape_string($out) . "' WHERE id=$id";
            if (mysql_query($q)) {
                echo "<br>Record Updated";
                $title = "";
                $movie = "";
                $singer = "";
                $out = "";
            }
        }
    }
    sleep(1);
}
?>