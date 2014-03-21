<?php

$imgresponse = $image_in;
echo "<br>Image search out: $imgresponse<br>";
if (is_numeric($imgresponse)) {
    if ($imgresponse != 0) {
        $query = "update data set image_id='$imgresponse' where global_id='$global_id'";
        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
        if($operator == 'aircel' && $is_adult){
            $op_kript = 'x';
        }
        $kcr = kript($numbers, $imgresponse, $op_kript);
        $img_return = 'http://IP/' . $kcr . "\n$brows_charge";
    } else {
        $query = "update data set image_id='$imgresponse' where global_id='$global_id'";
        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
    }
}
echo "<br>IMAGE_RETURN: $img_return";
if (!$img_return && $photo_must) {
    $img_return = "Sorry, no photo found for " . $word;
    $to_logserver['isresult'] = 0;
    $free = true;
}
?>