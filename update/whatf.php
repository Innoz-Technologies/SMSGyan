<?php

include 'configdb.php';
$url = "http://www.whattheffacts.com/adolf-hitler-had-only-one-testicle/";
$content = file_get_contents($url);

if (preg_match("~<div class=\"posttitle\"><h1>(.+)</h1>~Usi", $content, $title)) {
    $head = strip_tags($title[1]);
    echo "Heading:" . $head = html_entity_decode($title[1]) . "\n";
}
if (preg_match("~<b>(.+)</b></div>~Usi", $content, $subtitle)) {
    echo "Sub Heading:" . $subhead = html_entity_decode($subtitle[1]) . "\n";
}
if (preg_match("~<div class=\"singlepostcontent\">(.+)</script>~Usi", $content, $descrptn)) {
    $facts = $descrptn[1];
    $facts = trim(preg_replace("~[\s]+~", " ", $facts));
    $facts = strip_tags($facts);
    $facts = html_entity_decode($facts);
    $facts = trim(preg_replace("~[\s]+~", " ", $facts));
    $facts = trim(str_replace("[Source: Dailymail]", "", $facts));
    $facts = trim(str_replace("[Source: Lovepanky, Telegraph]", "", $facts));
    $facts = trim(str_replace("[Source: Wikipedia, Nytimes]", "", $facts));
    echo "Facts:" . $facts;
}
$query = "insert ignore into randomfacts(url,head,subhead,description) values('$url','" . mysql_real_escape_string($head) . "','" . mysql_real_escape_string($subhead) . "','" . mysql_real_escape_string($facts) . "')";
$result = mysql_query($query);
if ($result) {
    echo "updated";
}
?>