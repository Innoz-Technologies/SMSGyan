<?php

define ('AppID', "ID");
$place = $word;
$weather_return = "";
$gctr = 0;
$info = array();
$woeid = false;
do {
    $gctr++;
    if ($response = geoPlanet($place)) {
        $correctResp = true;
        $xmlObj = simplexml_load_string($response);
        $arrXml = objectsIntoArray($xmlObj);
        if ($arrXml['place']['name'] == $arrXml['place']['locality1'] || $arrXml['place']['name'] == $arrXml['place']['locality2']) {
            $woeid = true;
        } else {
            $place = ($arrXml['place']['locality1'] != "") ? $arrXml['place']['locality1'] : $arrXml['place']['locality2'];
        }
    } else {
        $correctResp = false;
    }
} while (!$woeid && $gctr <= 2 && $correctResp);

if ($woeid) {
    if (($weather = getWeather($arrXml['place']['woeid'])) !== false) {
        $weather_return = $arrXml['place']['name'] . "\n";
        $weather_return.="Temperature: " . $weather['temperature'] . " C \n";
        $weather_return.="Weather: " . $weather['text'] . "\n";
        $weather_return.="Humidity: " . $weather['humidity'] . " % \n";
        $weather_return.="Pressure: " . $weather['pressure'] . " bar \n";
        $weather_return.="Tomorrow's Forecast\n";
        $weather_return.="Temperature: " . $weather['forecast'][1]['low'] . ' C - ' . $weather['forecast'][1]['high'] . " C \n";
        $weather_return.="Weather: " . $weather['forecast'][1]['text'] . " \n";
    } else {
        $weather_return = '';
    }
}

/** GET WOEID * */
function geoPlanet($place) {
    $place = @urlencode($place);
    $url = "API";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    if ($info['http_code'] == 200)
        return $response;
    else {
        return false;
    }
}

/** GET WEATHER * */
function getWeather($w = '', $u = 'c') {
    $wURI = 'API';
    $weather = array();
    $reader = new XMLReader();
    $reader->open($wURI);
    $i = -1;
    while ($reader->read()) {
        if (strpos($reader->name, "yweather") !== false && $reader->hasAttributes) {
            switch ($reader->localName) {
                case 'atmosphere':
                    $reader->moveToAttribute('humidity');
                    $weather['humidity'] = $reader->value;
                    $reader->moveToAttribute('pressure');
                    $weather['pressure'] = $reader->value;
                    break;
                case 'astronomy':
                    $reader->moveToAttribute('sunrise');
                    $weather['sunrise'] = $reader->value;
                    $reader->moveToAttribute('sunset');
                    $weather['sunset'] = $reader->value;
                    break;
                case 'condition':
                    $reader->moveToAttribute('text');
                    $weather['text'] = $reader->value;
                    $reader->moveToAttribute('code');
                    $weather['code'] = $reader->value;
                    $reader->moveToAttribute('temp');
                    $weather['temperature'] = $reader->value;
                    break;
                case 'forecast':
                    $i++;
                    $reader->moveToAttribute('date');
                    $weather['forecast'][$i]['date'] = $reader->value;
                    $reader->moveToAttribute('low');
                    $weather['forecast'][$i]['low'] = $reader->value;
                    $reader->moveToAttribute('high');
                    $weather['forecast'][$i]['high'] = $reader->value;
                    $reader->moveToAttribute('text');
                    $weather['forecast'][$i]['text'] = $reader->value;
                    break;
            }
        }
    }
    if ($i == -1)
        return false;
    else
        return ($weather);
}

?>