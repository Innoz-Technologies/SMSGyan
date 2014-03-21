<?php

$search = urlencode($word);
$url = "API";
$feed = file_get_contents($url);
$xmlObj = simplexml_load_string($feed);

$maxresults = 5;
$i = 0;
foreach ($xmlObj->entry as $entry) {
    $ent = objectsIntoArray($entry);
    $id = $entry->id;
    preg_match("~/videos/(.+)~", $id, $match);
    echo $id = $match[1];
    echo '<br>';
    $title = $ent['title'];
    $description = $entry->content;
    $link = $entry->link;
    $attr = $link->attributes();
    $options_list[] = strlen($title) > 60 ? substr($title, 0, 60) : $title;
    $list[] = array("content" => "video_id $id");
    $videosearch_return = "Search results:";
    //echo "$id<h4><a href='" . $attr['href'] . "'>$title</a></h4>$description<br>";
    $i++;
    if ($i == $maxresults)
        break;
}
?>
