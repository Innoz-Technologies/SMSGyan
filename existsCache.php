
<?php

ini_set("display_errors", "on");
$file = $_GET['file'];
if (isset($_GET['file'])) {
    $private_ip = array("IP");
    foreach ($private_ip as $ip) {
        echo "Server: $ip<br>";
        $url = "http://$ip/gyan/exists.php?name=" . urlencode($file);
        $content = file_get_contents($url);
        if ($content == "T") {
            echo 'Cache found<br>';
        } else {
            echo 'No Cache found<br>';
        }
    }
} else {
    echo "Please set cache name";
}
?>
