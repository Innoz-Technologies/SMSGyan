<?php

$url = "http://IP/solr/db/select/?version=2.2&start=0&rows=10&indent=on&q=" . urlencode($veg_word) . "&hl=true&hl.fl=name";
$content = file_get_contents($url);
$content_lst = $content;

$start = strpos($content_lst, "<lst name=\"highlighting\">");
if ($start !== false) {
    $content_lst = substr($content_lst, $start);
    $end = strpos($content_lst, "</response>");
    if ($end !== false) {
        $content_lst = substr($content_lst, 0, $end);
    }
}

$arXml = objectsIntoArray(simplexml_load_string($content));
$arXml_st = objectsIntoArray(simplexml_load_string($content_lst));

if (!empty($arXml_st["lst"])) {
    $arMatch = get_veg_Length($arXml_st);
    var_dump($arMatch);
}
$str_len_v = $act_len_v = 0;
$arVeg = array();

if (!empty($arXml["result"]["doc"])) {
    foreach ($arXml["result"]["doc"] as $doc => $arDocs) {
        if (is_numeric($doc)) {
            getVegData($arDocs);
        } else {
            if ($doc == "str") {
                getVegData($arXml["result"]["doc"]);
            }
        }
    }
}

$sug_options_list_veg = $sug_list_veg = $list_veg = $options_list_veg = array();

if (count($arVeg) >= 1) {
    if (count($arVeg) == 1) {
        $purl['veg'] = $arVeg[0]["veg_url"];
    } else {
        $sug_options_list_veg[] = "price grocery " . $veg_name;
        $sug_list_veg[] = array("content" => "__veg__" . $veg_name . "__" . $veg_url . "__");
        
        $veg_return = "Your query matches more than one result";
        foreach ($arVeg as $veg) {
            $options_list_veg[] = $veg["veg_name"];
            $list_veg[] = array("content" => "__veg__" . $veg["veg_name"] . "__" . $veg["veg_url"] . "__");
        }
    }
}
?>
