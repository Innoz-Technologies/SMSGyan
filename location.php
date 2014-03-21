<?php

function get_string_btn($string, $start, $end) {
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return false;
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    if (strpos($string, $end)) {
        return substr($string, $ini, $len);
    } else {
        return false;
    }
}

$place_return = "";
$no = 0;
//echo "<br>Google Return:<br>";
//var_dump($location_in);
//echo "<br>Google Return Ends<br>";
$htm = $html = $location_in;
//die($htm);
$str = "<div class=g style=\"padding-top:2px\">";
$html = stristr($html, $str);
// echo $html;
$html = str_ireplace($str, "^", $html, $j);
$st = "<div class=s style=margin-top:8px>";
$html = str_ireplace($st, "ENDOFSTRING", $html, $j);
$html = strip_tags($html);
$html = str_ireplace("&nbsp;", " ", $html, $j);
$html = str_ireplace("- Place pagemaps.google.co.in", "", $html);
$html = str_ireplace("More results near", "ENDOFSTRING", $html, $j);
$fullstring = "STARTOFSTRING" . $html;
$f = get_string_btn($fullstring, "STARTOFSTRING", "ENDOFSTRING");
$ar = array();
$token = strtok($f, "^");
while ($token != false) {
    $ar[] = $token;
    //echo "$token<br />";
    $token = strtok("^");
}

foreach ($ar as $key => $value) {
    $fullstring = $value;
    $arraycom = array("in","com","edu","org","net","us","uk","pk");
    foreach($arraycom as $aqr){
         $f = get_string_btn($fullstring, "- Place", "$aqr -");
         if($f){
            $f = "- Place" . $f . "$aqr ";
            break;
         }
    }
    var_dump ($f);
    $value = str_ireplace($f, " ", $value, $j);
    $value = str_ireplace("reviews", "review", $value, $j);
    $sv = get_string_btn($value, "-", "review");
    $value = str_ireplace("-" . $sv . "review", " ", $value, $j);
    $ar[$key] = str_ireplace($f, " ", $value, $j);
    $no = $key + 1;
    $place_return = "$place_return\n$no: $value";
}
$f = get_string_btn($htm, "<table class=ts>", "<div class=gl");
$str1 = "<span class=wrt style=display:none>";
$str2 = "</span>";
$g = get_string_btn($f, $str1, $str2);
$f = str_ireplace($str1 . $g . $str2, "", $f, $j);
$f = str_ireplace("<br>", "\n", $f, $j);
$f = str_ireplace("Place page", "\n", $f, $j);
$f = strip_tags($f);
if ($f != "")
    $place_return = "$place_return\n$f";
$place_return = clean(trim($place_return));

$files = DATA_PATH . "/loc/$global_id";
@unlink($files);
file_put_contents($files, $place_return);

echo "\n<br>location: $place_return<br>\n";
$location_return = $place_return;
?>