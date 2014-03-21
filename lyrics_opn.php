<?php

$l_title = $lyricsearch->result['title'];
$l_artist = $lyricsearch->result['artist'];
$l_album = $lyricsearch->result['album'];
$l_id = $lyricsearch->result['id'];
$isLySet = false;

if (!empty($l_album)) {
    echo "<br>" . $query = "SELECT id,title, singers, movie FROM lyrics_central WHERE movie = '$l_album' AND title NOT LIKE '$l_title' ORDER BY rand() limit 0,1";
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $l_srch = "Lyrics " . $row["title"];
        if (!empty($row["movie"])) {
            $l_srch .= " from " . $row["movie"];
        }
        $options_list[] = $l_srch;
        $list[] = array("content" => "$l_srch");
        $isLySet = true;
        var_dump($options_list);
    } else {
        echo "<br>" . $q = "SELECT language FROM lyrics_central WHERE id = $l_id limit 0,1";
        $result = mysql_query($q);
        if (mysql_num_rows($result) > 0) {
            $r = mysql_fetch_array($result);
            $l_lang = $r["language"];

            echo "<br>" . $query = "SELECT id,title, singers, movie FROM lyrics_central WHERE singers = '$l_artist' AND language = '" . trim($l_lang) . "' and title NOT LIKE '$l_title' ORDER BY rand() limit 0,1";
            $result = mysql_query($query);
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_array($result);
                $l_srch = "Lyrics " . $row["title"];
                if (!empty($row["movie"])) {
                    $l_srch .= " from " . $row["movie"];
                }
                $options_list[] = $l_srch;
                $list[] = array("content" => "$l_srch");
                $isLySet = true;
                var_dump($options_list);
            }
        }
    }
}

if (!$isLySet && !empty($l_artist)) {
    echo "<br>" . $query = "SELECT id,title, singers, movie FROM lyrics_central WHERE singers = '$l_artist' and title NOT LIKE '$l_title' ORDER BY rand() limit 0,1";
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $l_srch = "Lyrics " . $row["title"];
        if (!empty($row["movie"])) {
            $l_srch .= " from " . $row["movie"];
        }
        $options_list[] = $l_srch;
        $list[] = array("content" => "$l_srch");
        $isLySet = true;
        var_dump($options_list);
    }
}

//if (!$isLySet) {
//    echo "<br>" . $query = "SELECT id,title, singers, movie FROM lyrics_central where title NOT LIKE '$l_title' ORDER BY rand() LIMIT 0 , 1";
//    $result = mysql_query($query);
//    if (mysql_num_rows($result) > 0) {
//        $row = mysql_fetch_array($result);
//        $l_srch = "Lyrics " . $row["title"];
//        if (!empty($row["movie"])) {
//            $l_srch .= " from " . $row["movie"];
//        }
//        $options_list[] = $l_srch;
//        $list[] = array("content" => "$l_srch");
//        $isLySet = true;
//        var_dump($options_list);
//    }
//}
?>
