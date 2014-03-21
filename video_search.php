<?php

date_default_timezone_set("Asia/Calcutta");
include 'functions.php';
$srch = $_GET['srch'];
$url = 'API' . urlencode($srch) . '&n=5&o=0&a=true';
$xml_in = file_get_contents($url);
//var_dump($xml_in);
$xml = objectsIntoArray(simplexml_load_string($xml_in));
if (isset($xml['content'])) {
    $result = $xml['content'];
    //print_r($result);
    $out = '';
    for ($i = 0; $i < count($result); $i++) {
        $out .= $i + 1 . ". " . $result[$i]['title'];
        $out .="<br>";
    }
    echo $out;
    if (isset($_GET['input'])) {
        $input = $_GET['input'] - 1;
        if (isset($result[$input])) {
            $url = 'API' . $result[$input]['cid'];
            $xml_in = file_get_contents($url);
            $xml = objectsIntoArray(simplexml_load_string($xml_in));
            //print_r($xml);
            if (isset($xml['highresstreamingurl'])) {
//                $output = '<iframe width="310" height="160" src="' . $xml['highresstreamingurl'] . '"></iframe>';
                $output = '<a href="' . $xml['highresstreamingurl'] . '"><img width="310" height="160" title="See video" alt="See video" src="http://api.vuclip.com/p?cid=' . $result[$input]['cid'] . '" /></a>';
                echo $output;
            }
        } else {
            echo "Invalid selection";
        }
    }
} else {
    echo "No search result Found";
}


?>