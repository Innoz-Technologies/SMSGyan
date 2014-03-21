<?php

//temp code should replace later

if (!isset($placeFrom))
    $placeFrom = '';

if (!isset($placeTo))
    $placeTo = '';

echo "<h1>NEPAL BUS</h1>";
echo "<h3>FROM $placeFrom TO $placeTo</h3>";
if ($ismatched) {
    if (!empty($placeFrom) && !empty($placeTo)) {
        $bfrom = $placeFrom;
        $bfrom = srchstring_nepal($bfrom);

        $bto = $placeTo;
        $bto = srchstring_nepal($bto);
    }
    $qstring = '';
    if (!empty($bto)) {
        $qstring = "And Dest='$bto'";
    }
}
$query = "SELECT * FROM bus_routes_nepal WHERE source = 'Kathmandu' $qstring";
echo "<h3>QUERY $query</h3>";

$result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
$bus_return = '';

$a=range('a','z');

if (mysql_num_rows($result)) {
    $bus_return .= 'Bus Fare from Kanthmandu ' . "\n";
    $i=0;
    while ($row = mysql_fetch_array($result)) {
        //$bus_return .= 'SOURCE: ' . $row['source'] . "\n";
        $bus_return .= ' '.$a[$i++].' : ' . $row['dest'] . " - ";
        $tmp=$row['response'];
        $tmp=str_replace(' - Rs.', ' - NRs.', $tmp);
        $bus_return .= $tmp . "\n";
        
    }
}

function srchstring_nepal($mystring) {
    $words = explode(" ", $mystring);
    $ret = $words[0];
    for ($i = 1; $i < count($words); $i++) {
        if (strlen($words[$i - 1]) == 1 && strlen($words[$i]) == 1) {
            $ret .= $words[$i];
        } else {
            $ret .= " " . $words[$i];
        }
    }
    return $ret;
}

?>
