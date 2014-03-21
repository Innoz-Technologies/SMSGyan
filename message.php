<?php
if (preg_match("~\b(message|msg|jokes?)\b(.+)?~", strtolower($spell_checked), $match)) {
    echo "<br>MSG SEARCH<br>";
    if ($match [1] == "jokes" || $match [1] == "joke") {
        $que = $match [1];
        include 'goodmorning.php';
        $to_logserver['source'] = 'joke';
        putOutput($total_return);
        exit();
    }
    print_r($match);
    echo $que = $match[2];
    if (!empty($que)) {
        $direct = false;
        include 'goodmorning.php';
        if (!empty($total_return)) {
            $to_logserver ['source'] = 'msg';
            putOutput($total_return);
            exit();
        }
    }
}
?>
