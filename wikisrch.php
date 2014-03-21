<?php

ini_set("display_errors", "off");
ob_start();
echo "<pre>";
include 'lib/appconfigdb.php';
include 'class.Resource.php';
include 'functions.php';
include 'lib/data-files.php';
include 'tagging.php';

include 'class.Mediawiki.php';
$infoArr = array();
$$quArr = array();
//$query = remwords($query);

$machine_id = set_machine_id();

$query = $_GET['q'];
$query = remwords(urldecode($query));
echo "<br>Query: $query <br>";

$quArr = explode(' ', trim($query));
echo "<br>After Explode";
var_dump($quArr);

$gid = $_GET['gid'];
$sm = $_GET['sm'];
$direct = (isset($_GET['direct']) && ($_GET['direct'] == 'true' || $_GET['direct'] == 1) ) ? true : false;

$mwiki = new Mediawiki($gid, $sm);

echo $query . '<br>';
print_r($mwiki->get_data($query));
if (isset($_GET['debug'])) {
    echo "</pre>";
    ob_end_flush();
} else {
    ob_end_clean();
}

$infoArr1 = objectsIntoArray($mwiki->infobox);
var_dump($infoArr1);
echo "<h1>image</h1>";
echo $mwiki->infobox['image'];

foreach ($infoArr1 as $id1 => $val) {
    $id = preg_replace("~ies$~", "y", $id1);
    $id = preg_replace("~e?s$~", "", $id);
            
    $infoArr[$id] = preg_replace('~<ref(.+)</ref>~Ui', '', $infoArr1[$id1]);
    $infoArr[$id] = strip_tags($infoArr[$id]);
    $infoArr[$id] = preg_replace('~\{\{(.+)\[\[~Ui', '', $infoArr[$id]);
    $infoArr[$id] = preg_replace('~\{\{~Usi', '', $infoArr[$id]);
    $infoArr[$id] = preg_replace('~\}\}~Ui', '', $infoArr[$id]);
    $infoArr[$id] = str_replace(']] | [[', ',', $infoArr[$id]);

    $infoArr[$id] = str_replace('&nbsp;', ',', $infoArr[$id]);
    $infoArr[$id] = str_replace('| [[', ',', $infoArr[$id]);
    $infoArr[$id] = preg_replace('~\|(.+)\]\]~Ui', '', $infoArr[$id]);
    $infoArr[$id] = preg_replace('~[^a-zA-Z0-9\(\)\.\,\|,/,:,\+,\-,_]~Ui', ' ', $infoArr[$id]);
    $infoArr[$id] = trim(preg_replace("~[\s]+~", " ", $infoArr[$id]));
    $infoArr[$id] = preg_replace('~file:|nowrap~Ui', '', $infoArr[$id]);
    $infoArr[$id] = preg_replace('~url[\|]?~Ui', '', $infoArr[$id]);
    if ($id == 'birth_date' || $id == 'alexa') {
        $infoArr[$id] = preg_replace('~\|~Ui', '-', $infoArr[$id]);
    } else {
        $infoArr[$id] = preg_replace('~\|~Ui', '', $infoArr[$id]);
    }

    $infoArr[$id] = trim($infoArr[$id]);
}

echo "<br>the result is <br>";
echo "<pre>";
$flag = 0;
var_dump($infoArr);
echo "<br>";

foreach ($quArr as $id=> $qval) {
    $quArr[$id] = preg_replace("~ies$~", "y", $quArr[$id]);
    $quArr[$id] = preg_replace("~e?s$~", "", $quArr[$id]);
}

var_dump($quArr);
foreach ($quArr as $qval) {
    if (isset($infoArr[$qval])) {
        echo $out = $infoArr[$qval];
        break;
    }
}
//print_r($mwiki);
echo "</pre>";
?>