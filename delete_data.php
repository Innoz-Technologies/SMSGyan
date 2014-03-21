<?php
set_time_limit(0);
if (isset($_GET['from'])) {
    $from = $_GET['from'];
    if (isset($_GET['to'])) {
        $to = $_GET['to'];
        define("DATA_PATH", "/data");
        for($i=$from; $i <= $to;$i++){
            $myFile = DATA_PATH . '/wiki/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/dict/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/loc/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/how/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/acry/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/directions/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/movie/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/trueknowledge/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/urlmeta/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/horoscope/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/pnr/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/ask/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/localmovie/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/train/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/lyrics/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/recipe/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);
            $myFile = DATA_PATH . '/google/' . $i;
            //echo "Deleting: " . $myFile;
            unlink($myFile);

        }
    } else {
        echo "to not set";
    }
} else {
    echo "from not set";
}
?>