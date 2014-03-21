<?php

echo "<h3> JustDial Showtimes</h3>";
$localmovie_return = '';
if (!empty($jdial_city)) {
    echo $query = "select url from justdial_city where city like '%" . $jdial_city . "%'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        echo $row["url"];
        echo $url = "http://movies.justdial.com" . $row["url"];
        $content = file_get_contents($url);
        if (preg_match("~<div id=\"leftnav\" class=\"leftNav\">(.+)<div id=\"rightnav\" class=\"rightNav\">~si", $content, $match)) {
            echo "its here";
//        var_dump($match);
            $out = $match[1];
            $out = str_replace("<div class=\"rhl\" >", "***", $out);
            $out = str_replace("</a></div></div>", "***", $out);
            $out = str_replace("<span class=\"bt\">", "***", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace("Rating:Rate this movie&nbsp; | &nbsp;Read Review", "", $out);
            $out = str_replace("Rating:Be First to Rate", "", $out);
            $out = str_replace("Cinema New Releases", "", $out);
            $out = str_replace("***", "\n", $out);
            $out = str_replace("\n ", "\n", $out);
            $out = str_replace("\n\n", "\n", $out);
            $out = str_replace("\n\n\n", "\n", $out);
            echo $out;
        }
        $localmovie_return = $out;
        $localmovie_return = strip_tags($localmovie_return);
        $localmovie_return = html_entity_decode($localmovie_return);
        $localmovie_return = clean($localmovie_return);
    }
}
?>
