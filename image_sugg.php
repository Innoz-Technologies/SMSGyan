<?php

$imgresponse = $image_in;
$imgout = '';
if (is_numeric($imgresponse)) {
    if ($imgresponse != 0) {
        $query = "update data set image_id='$imgresponse' where global_id='$global_id'";
        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
        $imgout = "images for $word";
    } else {
        $query = "update data set image_id='$imgresponse' where global_id='$global_id'";
        mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
    }
}
?>