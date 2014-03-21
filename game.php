<?php

if ($allow_game) {

    echo "<h2>Games</h2>";

    echo "<br>Game Word<br>";
    include 'gameWordNew.php';
}
echo "<br>Game Cricket<br>";
include 'game_cricket.php';

include 'game_ttt.php';
echo "<br><h2>TIME after ttt :" . (microtime(TRUE) - $time_start) . "</h2><br>";
?>
