<?php

$private_ip = array("IPs");
$machines = array("IPs");

function set_machine_id() {
    global $machine_id;
    $machine_id = $machines[$_SERVER['HTTP_HOST']];
}

function get_file_contents($path, $machine) {
    global $machine_id;
    if ($machine_id == $machine)
        return file_get_contents($path);
    else {
        $host = "http://" . $private_ip[$machine];
        return file_get_contents($host . "/storage/read.php?file=$path");
    }
}

function does_file_exist($path, $machine) {
    global $machine_id;
    if ($machine_id == $machine) {
        return file_exists($path);
    } else {
        $host = "http://" . $private_ip[$machine];
        return file_get_contents($host . "/storage/check.php?file=$path");
    }
}

?>