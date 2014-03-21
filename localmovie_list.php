<?php
$add_to_top = "SELECT MOVIE TITLE\n";
$options_list = array();
$list = array();
print_r($localmovie_list);
echo "<br>LISTING MOVIES<br>";
foreach ($localmovie_list['movies'] as $movie) {
    var_dump($movie);
    $options_list[] = strtoupper($movie);
    $list[] = array("content" => "showtimes for $movie at ".$localmovie_list['city']);
}
echo "<br>--<br>";
echo "<br>LOCAL MOVIE LIST<br>";
print_r($options_list);
print_r($list);
?>
