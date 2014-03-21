<?php

echo"<br>NEPAL JOBS<br>";
include 'job_nepal.php';
echo "<br><h2>TIME after NEPAL JOBS :" . (microtime(TRUE) - $time_start) . "</h2><br>";

echo"<br>TRUECALLER NEPAL<br>";
include 'truecaller_nepal.php';

include 'nepalquiz.php';
include 'Load_Shedding_Nepal.php';
include 'nepal_rest.php';
echo "<br>NPL TOUR<br>";
include 'nepal_tourism.php';
echo "<br>NEPAL FLIGHT<br>";
include 'nepal_flight.php';
include 'priceNepal.php';
include 'nepalBus.php';
?>
