<?php

echo "<h3>Setting Global Variables</h3>";

$shortcode = '55444';
$examplPrefix = "";
$charge_currency = "Re ";
$charge_currency1 = "Rs ";
$charge_per_query = 1;
$blockINDSpec = false; // Block indian content
$isOneAPI = false; // For general API
$setOpn = true;
// User IDs
// india dubai srilanka nepal pakistan thailand nigeria ghana kenya philippines

switch ($userid) {

    case "nepal":
        echo "<h3>NEPAL</h3>";
        $shortcode = "6622";
//        $shortcode = "3131";
        $max_length = 160;
        $blockINDSpec = true;
        setUserCountry("nepal");
        break;
    case "pakistan":
        echo "<h3>Pakisthan</h3>";
        $blockINDSpec = true;
        $charge_currency = "PKR ";
        $charge_currency1 = "PKR ";
        $charge_per_query = "1";
        $shortcode = "5544";
        setUserCountry("pakistan");
        break;
    case "ghana":
        setUserCountry("ghana");
        $blockINDSpec = true;
        $charge_currency = "GHS ";
        $charge_currency1 = "GHS ";
        $charge_per_query = "1";
        break;
    case "philippines":
        setUserCountry("philippines");
        break;
    case "thailand":
        setUserCountry("thailand");
        break;
    case "kenya":
        setUserCountry("kenya");
        $blockINDSpec = true;
        $charge_currency = "PKR ";
        $charge_currency1 = "PKR ";
        $charge_per_query = "1";
        break;
    case "nigeria":
        $blockINDSpec = true;
        $show_add_below = false;
        $max_length = 320;
        $shortcode = $opShortCode;
        $charge_per_query = "0";
        $charge_currency = "KES ";
        $charge_currency1 = "KES ";
        setUserCountry("nigeria");
        break;

    case "india":
        setUserCountry("india");
        break;
    case "dubai":
        setUserCountry("dubai");
        $shortcode = "9056";
        break;
    case "srilanka":
        setUserCountry("srilanka");
        break;
}


setUserCountry("india");

echo "<br>Operator : $operator";
echo "<br>User ID : $userid";
echo "<br>User Country : $user_country";
echo "<br>Shortcode : $shortcode";
echo "<br>Maximun character : $max_length";
echo "<br>Charge currency : $charge_currency";
echo "<br>Charge currency1 : $charge_currency1";
echo "<br>Charge per query : $charge_per_query";
?>
