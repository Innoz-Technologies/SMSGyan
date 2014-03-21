<?php

//ready to fetch data from the website
$sp_code = $flicode;    //flight code
$sp_name = rawurlencode($airName);    //flight name Airline
$domDepart = $method; //action domestic departure
$sp_place = rawurlencode($place); //destination
$to_method = $request_type;

$url_flight = 'http://www.nepalsutra.com/getDescription.php';

//based on the type of request, POST parameters may vary
if ($to_method == 'getFlightDetails')
    $fields_string = "req=$domDepart&sp_code=$sp_code&sp_name=$sp_name&sp_place=$sp_place&to=$to_method";
elseif ($to_method == 'getFlightNameFromPlace')
    $fields_string = "req=$domDepart&sp_name=$sp_place&to=$to_method";
elseif ($to_method == 'getFlightCodes')
    $fields_string = "req=$domDepart&sp_place=$sp_place&sp_name=$sp_name&to=$to_method";

echo "<h2>TYPE: $to_method - STRING: $fields_string</h2>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url_flight);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$content = curl_exec($ch);
//echo $content;
?>
