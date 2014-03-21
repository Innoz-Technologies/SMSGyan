<?php

if (preg_match("~^sfind~", $req)) {
    echo "<br>SULEKHA FIND";
    $total_return = "Thank you for using this Service. Our agent will be calling you Shortly";
    putOutput($total_return);
    exit();
}

?>