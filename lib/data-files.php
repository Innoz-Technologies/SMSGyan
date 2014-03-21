<?php

$private_ip = array("IPs");

function set_machine_id() {
    return "1";
}

function get_file_contents($path, $machine) {
    global $machine_id;
    global $private_ip;
    echo "<br>$machine:$path<br>##$machine##<br>";

    if ($machine_id == $machine) {

        return file_get_contents("/data" . $path);
    } else {
        echo "<h3>Machine id is : $machine</h3>";
        $host = "http://" . $private_ip[$machine];
        if ($machine == '1')
            $host .= ":7000";
        echo $host . "/storage/read.php?file=$path";
        return file_get_contents($host . "/storage/read.php?file=" . urlencode($path));
    }
}

function does_file_exist($path, $machine) {
    global $machine_id;
    global $private_ip;
    if ($machine_id == $machine) {
        return file_exists("/data" . $path);
    } else {
        $host = "http://" . $private_ip[$machine];
        if ($machine == '1')
            $host .= ":7000";
        return file_get_contents($host . "/storage/check.php?file=$path");
    }
}

?>