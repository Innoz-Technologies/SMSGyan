<?php

set_time_limit(0);
include 'configdb.php';

$url = "http://www.brainyquote.com/quotes/topics.html";
$content = file_get_contents($url);

if (!empty($content)) {
    preg_match("~<div class=\"grid_12 body\" style=\"text-align: center;\">(.+)<span class=\"bigbold\">Your Favorite Authors</span>~Usi", $content, $matches);

    $matches[0] = preg_replace("~<a href=\"http://twitter.com.+</a>~", "", $matches[0]);
    if (!empty($matches[0])) {
        preg_match_all("~<a href=\"(.+)\">(.+)</a>~Usi", $matches[0], $match);

        for ($i = 0; $i < count($match[0]); $i++) {
            $query = "Replace into quotes (quote,url) values('" . mysql_real_escape_string($match[2][$i]) . "','" . mysql_real_escape_string($match[1][$i]) . "')";
            if(mysql_query($query)){
                echo "Record inserted<br>";
            }
        }
    }
}
?>