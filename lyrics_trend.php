<?php

$l_title = $lyricsearch->result['title'];
echo "<br>" . $query = "SELECT lyrics_central.id,title, singers, movie FROM lyrics_central,lyrics_trend WHERE lyrics_central.id=lyrics_trend.lyrics_id and (lyrics_trend.language = '$circle_lang' or lyrics_trend.language = 'hindi' or lyrics_trend.language = 'english') and title not like '$l_title' ORDER BY rand() limit 0,1";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_array($result);
    $l_srch = "Lyrics " . $row["title"];
    if (!empty($row["movie"])) {
        $l_srch .= " from " . $row["movie"];
    } elseif (!empty($row["singers"])) {
        $l_srch .= " by " . $row["singers"];
    }

    $options_list[] = $l_srch;
    $list[] = array("content" => "$l_srch");
    $isLySet = true;
    var_dump($options_list);
}
?>
