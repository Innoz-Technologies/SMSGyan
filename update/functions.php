<?php

function put_file_contents($file, $data, $max) {
    clearstatcache();
    $file_size = filesize($file);
    if ($file_size >= $max) {
        $info = pathinfo($file);
        $file_name = basename($file, '.' . $info['extension']);
        $new_name = dirname($file) . "/" . $file . "." . time();
        $ren = rename($file, $new_name);
    }
    file_put_contents($file, $data, FILE_APPEND);
}

function error_handler($errno, $errstr, $errfile, $errline) {
    $dt_tm = date("Y-m-d H:i:s");
    $log = "[$dt_tm] $errstr in  $errfile at $errline\n";
    file_put_contents("/var/www/test/update/log/errors.log", $log, FILE_APPEND);
    
    $err_return;
    switch ($errno) {
        case E_USER_ERROR:
        case E_ERROR:
            $err_return = "[$dt_tm]\nError: $errstr in file $errfile at $errline";
            send_sms($err_return, $errfile, $errline);
            exit(1);
            break;

        case E_USER_WARNING:
        case E_WARNING:
            $err_return = "[$dt_tm]\nWarning: $errstr in file $errfile at $errline";
            break;

        case E_USER_NOTICE:
        case E_NOTICE:
            $err_return = "[$dt_tm]\nNotice: $errstr on line $errline at $errfile\n";
            break;

        default:
            $err_return = "[$dt_tm]\n$errstr in $errfile at $errline";
            break;
    }
    send_sms($err_return, $errfile, $errline);
    return true;
}

function send_sms($message, $errfile, $errline) {
    $message_to_send = "$message";
    $url = 'API';
    file_get_contents($url);
}

?>