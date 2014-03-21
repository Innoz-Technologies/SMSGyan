<?php

echo "<br>Enterd to livecricket.php<br>";
$out = '';

$cri_url = 'API';
//****Test match or Oneday*****//
//$istest1 = false;
$istest1 = true;
//*****************************//

$content = httpGet($cri_url);

//346/346215/346215
$cri_url3 = 'API';
//****Test match or Oneday*****//
$istest2 = true;
//$istest2 = false;
//*****************************//

$content3 = httpGet($cri_url3);

//first url
$xmlObj = simplexml_load_string($content);
$arrXml = objectsIntoArray($xmlObj);
foreach ($arrXml["score"] as $k => $v) {
    if ($k == "overs") {
        $out = $out . "Overs: " . $v . "\n";
    } else if ($k == "status" && $istest1) {
        
    } else {
        if (!is_array($v))
            $out = $out . $v . "\n";
    }
}
echo "<br>Out from 1st url:\n $out<br>";
if (trim($out) != '') {
    $out = $out . "\n--\n"; //should uncomment when more matches
}

//second url
//$xmlObj = simplexml_load_string($content2);
//$arrXml = objectsIntoArray($xmlObj);
//foreach ($arrXml["score"] as $k => $v) {
//    if ($k == "overs") {
//        $out = $out . "Overs: " . $v . "\n";
//    } else {
//        if (!is_array($v))
//            $out = $out . $v . "\n";
//    }
//}
//$temperory = $out;
//if (count($arrXml["score"])) {
//    $out = $out . "\n--\n";
//}
//third(Test Cricket)

$xmlObj = simplexml_load_string($content3);
$arrXml = objectsIntoArray($xmlObj);
foreach ($arrXml["score"] as $k => $v) {
    if ($k == "overs") {
        $out = $out . "Overs: " . $v . "\n";
    } else if ($k == "status" && $istest2) {
        
    } else {
        if (!is_array($v))
            $out = $out . $v . "\n";
    }
}
//else if ($k == "status") {
//
//    }
//if(strlen($out)>480){
//    $out = $temperory;
//}

if (trim($out) == '') {
    echo "<br>No result from cri url<br>";
    if (($cached = apc_fetch("livecricket"))) {
        $out = $cached;
    }
} else {
    apc_store("livecricket", $out);
}
$out = trim($out);
$live_return = $out;
if ($out) {
    $add_below = "\n--\nTo get TV show schedule, send TV<SPACE>channel name to 55444. Eg: TV STAR PLUS";
    $total_return = $out;
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>