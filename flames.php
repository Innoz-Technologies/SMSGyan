<?php

$flames_result = "";

//$first_name=$_GET['fname'];
//$second_name=$_GET['sname'];
$name11 = preg_split('//', $first_name, -1, PREG_SPLIT_NO_EMPTY);
$name22 = preg_split('//', $second_name, -1, PREG_SPLIT_NO_EMPTY);
$s = 0;
$count1 = strlen($first_name);
$count2 = strlen($second_name);
for ($x = 0; $x < $count1; $x++) {
    $m = $name11[$x];
    for ($y = 0; $y < $count2; $y++) {
        if ($m == $name22[$y]) {
            unset($name11[$x]);
            unset($name22[$y]);
            $s = $s + 2;
            break;
        }
    }
}
$tp = $count1 + $count2;
$t = $tp - $s;
if ($t == 2 || $t == 4 || $t == 7 || $t == 9) {
    $flames_result = $first_name . " is ENEMY to " . $second_name . ".";
    $val = 1;
} else if ($t == 3 || $t == 5 || $t == 14) {
    $flames_result = $first_name . " is FRIEND to " . $second_name . ".";
    $val = 2;
} else if ($t == 6 || $t == 11 || $t == 15) {
    $flames_result = $first_name . " is going to MARRY " . $second_name . ".";
    $val = 3;
} else if ($t == 10) {
    $flames_result = $first_name . " is in LOVE with " . $second_name . ".";
    $val = 4;
} else if ($t == 8) {
    $flames_result = $first_name . " has more AFFECTION on " . $second_name . ".";
    $val = 5;
} else {
    $flames_result = $first_name . " and " . $second_name . " are sweetheart.";
    $val = 6;
}

$add_below = "\n--\nINTERNET SEARCH ON SMS! SMS HELP TO $shortcode TO FIND OUT MORE.$tollfree";
$total_return = $flames_result;
include 'allmanip.php';
$to_logserver['source'] = 'flames';
if ($fromHi == true) {
    $total_return = str_replace("OPTIONS", "ALSO TRY", $total_return);
    $total_return = str_replace("Reply with", "Try with", $total_return);
}
putOutput($total_return);
exit();
?>
