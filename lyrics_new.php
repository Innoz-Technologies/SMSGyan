<?php

function error_handler($errno, $errstr, $errfile, $errline) {
    $dt_tm = date("Y-m-d H:i:s");
    $error = "$errstr in $errfile at $errline";
    $data = "$dt_tm $error\n";
    file_put_contents("log/lyerrors.log", $data,FILE_APPEND);
}

error_reporting(E_ALL);
if (isset($_GET['debug'])) {
    $display_errors = "on";
} else {
    $display_errors = "off";
}
ini_set("display_errors", $display_errors);
set_error_handler("error_handler");

$spell_checked = $_GET["q"];
include 'lyrics/class.LyricsSearchNew.php';
$lyricsearch = new LyricsSearch($spell_checked);
$lyricsearch->search();
var_dump($lyricsearch->result);

function objectsIntoArray($arrObjData, $arrSkipIndices = array()) {
    $arrData = array();
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}

?>