<?php

if ($req == "localmovie_list") {
    echo "<br>LOCALMOVIE LIST<br>";
    $localmovie_list = unserialize(get_file_contents("/localmovie/" . $numbers, $m));
    echo "<br>localmovie_list: ";
    print_r($localmovie_list);
    echo "<br>";
    include 'localmovie_list.php';
    $total_return = "Movie listing for " . $localmovie_list ['city'] . "\n";
    include 'allmanip.php';
    $to_logserver['source'] = 'showtimes';
    if ($fromHi == true) {
        $total_return = str_replace("OPTIONS", "ALSO TRY", $total_return);
        $total_return = str_replace("Reply with", "Try with", $total_return);
    }
    putOutput($total_return);
    die();
}
?>
