<?php

if ($req == "__trans__quit__") {

    echo "<h2>INSIDE QUIT OPTION</h2>";

    $total_return = "You have quit from the session";

    unset($arCacheData["trans"]);

    if ($total_return) {
        unset($options_list);
        unset($list);
        $to_logserver['source'] = 'trans';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if ($req == "__trans__main__") {

    $total_return = "Please select an option";

    unset($options_list);
    unset($list);

    $options_list[] = "English to Hindi";
    $list[] = array("content" => "__trans__hindi__");

    $options_list[] = "English to Telugu";
    $list[] = array("content" => "__trans__telugu__");

    $options_list[] = "English to Tamil";
    $list[] = array("content" => "__trans__tamil__");

    $options_list[] = "English to Marathi";
    $list[] = array("content" => "__trans__marathi__");

//    $options_list[] = "English to Gujarati";
//    $list[] = array("content" => "__trans__gujarati__");

    $options_list[] = "English to Bengali";
    $list[] = array("content" => "__trans__bengali__");
	
	$options_list[] = "Quit";
    $list[] = array("content" => "__trans__quit__");

    if ($total_return) {
        $to_logserver['source'] = 'trans';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
