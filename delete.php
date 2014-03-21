<?php

function error_handle($errno, $errstr, $errfile, $errline) {
    $logtime = date("Y-m-d H:i:s");
    $data = "[$logtime] $errstr in $errfile at $errline\n";
    file_put_contents("log/errors.log", $data, FILE_APPEND);
    if ($errno == E_USER_ERROR)
        die();
}

error_reporting(E_ALL);
ini_set("display_errors", "off");

set_error_handler("error_handle");

$name = $_GET['name'];
if (apc_delete($name)) {
    echo 'T';
} else {
    echo 'F'; 
}
?>