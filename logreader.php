<?php

error_reporting(E_ALL);
ini_set("display_errors","on");
$date = date("j");
$date = '9';
$month = date("n");
$year = date("y");
//define("LOG_DIR", "9/");
define("LOG_DIR", "Path");

$dir = LOG_DIR;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == "." || $file == ".." || is_dir($file) || strpos("$file", ".log") === false)
                continue;
            if ($file == "gyan.log") {
                $gyan_log = file_get_contents(LOG_DIR . $file);
                $gyan_log_data = explode("\n", $gyan_log);
            } else if ($file == "response.log") {
                $response_log = file_get_contents(LOG_DIR . $file);
                $response_log_data = explode("\n", $response_log);
            }
        }
        closedir($dh);
    }


    echo '<table style="border-collapse:collapse" border="1" width="80%">';
    foreach ($gyan_log_data as $l) {
        if (strlen($l) <= 0)
            break;
        $log = unserialize($l);
        echo "<tr>";
        //echo $log["Qid"]."<br>";
        foreach ($log as $i => $d) {
            $d = str_replace("\n", "<br/>", $d);
            echo "<td align='center'>$d</td>";
        }
        echo "</tr>";
        foreach ($response_log_data as $rl) {
            if (strlen($rl) <= 0)
                break;

            $rlog = unserialize($rl);
            $temp = 0;
            if ($rlog["Qid"] == $log["Qid"]) {
                //echo $rlog["Qid"]."<br>";
                $temp = 1;
                echo "<tr>";
                foreach ($rlog as $i => $dd) {
                    $dd = str_replace("\n", "<br/>", $dd);
                    echo "<td align='center'>$dd</td>";
                }

                echo "</tr>";
            }


            // echo "</tr>";
        }

        // echo "</tr>";
    }
}
?>