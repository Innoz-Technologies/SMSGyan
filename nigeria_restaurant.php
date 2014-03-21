<?php

/*
  $url_root = 'http://www.tripadvisor.in';
  $url_main = '/Restaurants-g293824-Nigeria.html';

  $url_cats['lagos'] = '/Restaurants-g304026-Lagos_Lagos_State.html';
  $url_cats['abuja'] = '/Restaurants-g293825-Abuja_Abuja_State.html';
  $url_cats['bali'] = '/Restaurants-g1887541-Bali_Taraba_State.html';
  $url_cats['kano'] = '/Restaurants-g317072-Kano_Kano_State.html';
  $url_cats['ikeja'] = '/Restaurants-g1902847-Ikeja_Lagos_State.html';
  $url_cats['kaduna'] = '/Restaurants-g676697-Kaduna_Kaduna_State.html';
  $url_cats['port harcourt'] = '/Restaurants-g298363-Port_Harcourt_Rivers_State.html';
  $url_cats['uyo'] = '/Restaurants-g663676-Uyo_Akwa_Ibom_State.html';
  $url_cats['lekki'] = '/Restaurants-g2492082-Lekki_Lagos_State.html';
  $url_cats['Ibadan'] = '/Restaurants-g317071-Ibadan_Oyo_State.html';
 */
echo '<h2>NIGREST</h2>';
if (preg_match('~^food|restaurants?|hotels?~Usi', $spell_checked)) {

    $hotel_name = preg_replace('~^(food|restaurants?|hotels?)~', '', $spell_checked);
    $hotel_name = trim($hotel_name);

    if (!checkWithCity($hotel_name)) {
        $root_url = 'http://www.nigeriagalleria.com/Events_Entertainment/';
        $base_name = 'Restaurants';
        $first = substr($hotel_name, 0, 1);
        if ($first && $first != 'a') {
            $base_name .= "_$first";
        } else {
            $base_name .= "";
        }
        $url = "$root_url$base_name.html";

        $preg_reg = '</script><br><br><b>(.+)<b>Restaurants in Nigeria A-Z Index</b><br>';
        $url_ar = array();

        $data = file_get_contents($url);
        if (preg_match("~$preg_reg~Usi", $data, $match)) {
            //var_dump($match);
            $result = $match[1];
            //$result = str_replace('<br>', "", $result);
            //$result = str_replace("\n\n", "\n", $match[1]);

            if (preg_match_all('~<a href="(.+)" style="color: brown">(.+)</a>~Usi', $result, $matches)) {
                //var_dump($matches);
                foreach ($matches[2] as $k => $value) {
                    if ($k > 0) {
                        $v = trim($value);
                        $url_ar[] = "$root_url$base_name$v.html";
                    }
                }
            }
            //$result = strip_tags($result);
            $pos = strpos($result, 'Continued on Page');
            if ($pos !== false) {
                $result = substr($result, 0, $pos);
            }
            //if hotel name present
            if ($hotel_name != '') {
                $ind = null;
                $mHotel = '';
                if (preg_match_all('~(.+)</b><br>(.+)<br><br><b>~Usi', $result, $res_s)) {
                    //var_dump($res_s);
                    //echo "HOTEL: $hotel_name<br>";
                    foreach ($res_s[1] as $key => $value) {

                        $hotel_name = preg_replace('~(Restaurants?|restaurants?|hotels?|Hotels?)~', '', $hotel_name);
                        $rest_name = preg_replace('~(Restaurants?|restaurants?|hotels?|Hotels?)~', '', $value);

                        echo "$value - $hotel_name - $rest_name<br>";

                        if (metaphone($hotel_name, 5) == metaphone($rest_name, 5)) {
                            $ind = $key;
                            $mHotel = $value;
                            $url_ar = array();
                            break;
                        }
                    }
                    $result = "$mHotel\n";
                    $result .= $res_s[2][$ind];
                }
            }
            $total_return .= strip_tags($result);
            //var_dump($url_ar);
        }
        /* foreach ($url_ar as $value) {
          $options_list[] = "Next  Page";
          $list[] = array("content" => "__next__page__$value");
          } */
    }

    if ($total_return) {
        if(strpos($total_return, 'sorry')){
            $to_logserver['isresult'] = 0;
        }
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'hotel-nigeria';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

/*
 * POST CURL FUNCTION
 */

function curlPOST($loc, $key) {
    echo $url = "http://nigerianyellowpages.com/search-name_g.php";
    $fields_string = "location=$loc&skey=$key&submit=Search";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: nigerianyellowpages.com", 'Referer: http://nigerianyellowpages.com/searchByName_g.php'));
    $result = curl_exec($ch);
    return $result;
    curl_close($ch);
}

/*
 *  CITY SEARCH FUNCTION
 */

function checkWithCity($searchCity) {
    global $total_return;
    $arData = array();  //array to hold all details

    $arCity["1"] = "Abia";
    $arCity["2"] = "Abuja";
    $arCity["3"] = "Adamawa";
    $arCity["4"] = "Akwa Ibom";
    $arCity["5"] = "Anambra";
    $arCity["6"] = "Bauchi";
    $arCity["7"] = "Bayelsa";
    $arCity["8"] = "Benue";
    $arCity["9"] = "Borno";
    $arCity["10"] = "Cross River";
    $arCity["11"] = "Delta";
    $arCity["12"] = "Ebonyi";
    $arCity["13"] = "Edo";
    $arCity["14"] = "Ekiti";
    $arCity["15"] = "Enugu";
    $arCity["16"] = "Gombe";
    $arCity["53"] = "Gongola";
    $arCity["17"] = "Imo";
    $arCity["18"] = "Jigawa";
    $arCity["19"] = "Kaduna";
    $arCity["20"] = "Kano";
    $arCity["21"] = "Katsina";
    $arCity["22"] = "Kebbi";
    $arCity["23"] = "Kogi";
    $arCity["24"] = "Kwara";
    $arCity["25"] = "Lagos";
    $arCity["26"] = "Nassarawa";
    $arCity["27"] = "Niger";
    $arCity["28"] = "Ogun";
    $arCity["29"] = "Ondo";
    $arCity["30"] = "Osun";
    $arCity["40"] = "Others - Africa";
    $arCity["39"] = "Others - Asia";
    $arCity["43"] = "Others - Caribbean";
    $arCity["48"] = "Others - Central America";
    $arCity["38"] = "Others - Europe";
    $arCity["44"] = "Others - Middle East";
    $arCity["41"] = "Others - North America";
    $arCity["47"] = "Others - Not Listed";
    $arCity["45"] = "Others - Oceania";
    $arCity["42"] = "Others - South America";
    $arCity["31"] = "Oyo";
    $arCity["32"] = "Plateau";
    $arCity["54"] = "River";
    $arCity["33"] = "Rivers";
    $arCity["34"] = "Sokoto";
    $arCity["35"] = "Taraba";
    $arCity["36"] = "Yobe";
    $arCity["37"] = "Zamfara";

    //seraching for available cities

    $myCityID = '';
    $skey = 'restaurant';  //fixed search what
    $return = '';   //return from CURL
    echo 'inside City<br>';
    foreach ($arCity as $cityID => $cityName) {
        if (metaphone($searchCity, 5) == metaphone($cityName, 5)) {
            $myCityID = $cityID;
            break;
        }
    }
    echo "$myCityID city id<br>";
    if ($myCityID) {
        echo 'City id found<br>';
        $index = 0;

        //$return = curlPOST($loc, $myCityID);

        /* echo $url = "http://nigerianyellowpages.com/search-name_g.php";
          $fields_string = "location=$myCityID&skey=$skey&submit=Search";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: nigerianyellowpages.com", 'Referer: http://nigerianyellowpages.com/searchByName_g.php'));
          $result = curl_exec($ch);
          //return $result;
          curl_close($ch); */
        echo $url = "http://nigerianyellowpages.com/search-name_g.php?search=$skey&locationcoded=$myCityID&cat=&subcat=&spage=0&page=0";
        $return = file_get_contents($url);

        //echo "curl returned FSTR LEN " . ($return) . '<br>';
        $preg_match1 = '<table class="style84" cellspacing="1" cellpadding="5" border="0" width="97%">(.+)</table><br>';
        $preg_match2 = '<a href="(.+)"><b>(\d{,1})</b></a>';

        $preg_all = '<td (.+) />(.+)</td>';
        /* $preg_phone = '<td align="left" valign="center" width="20%" bgcolor="#FFFF99" />(.+)</td>';
          $preg_addr = '<td align="left" valign="center" width="20%" bgcolor="#FFFF99" />(.+)</td>'; */
        $inner = 0;
        //echo 'line 223<br>';
        if (preg_match("~$preg_match1~Usi", $return, $matches)) {
            //echo '<br>**************************************************** first PM *****************************************<br>';
            //var_dump($matches[1]);
            //echo 'line 227<br>';
            if (preg_match_all('~<tr>(.+)</tr>~Usi', $matches[1], $mRow)) {
                //echo '<br>****************************************** second PM ***********************************************<br>';
                //var_dump($mRow[1]);
                //echo '<br>****************************************** second PM END***********************************************<br>';
                //echo 'line 232<br>';
                $arTmp[] = 'name';
                $arTmp[] = 'phone';
                $arTmp[] = 'addr';
                //echo '<br>Size1: '.count($mRow[1]);
                foreach ($mRow[1] as $key => $valueOuter) {
                    //echo 'line 238<br>';
                    if (preg_match_all("~$preg_all~Usi", $valueOuter, $mAll)) {
                        //echo '<br>Size2: '.count($mAll[1]);
                        foreach ($mAll[2] as $valueInner) {
                            //echo "<br>inner foreach $index - $inner<br>";
                            if ($inner != 0) {
                                $tmp = trim(strip_tags($valueInner));
                                if (substr($tmp, 0, 1) == ',') {
                                    echo '<br>'.$tmp = substr($tmp, 1);
                                }
                                $arData[$index][$arTmp[$inner - 1]] = $tmp;
                            }
                            $inner++;
                            if ($inner > 3) {
                                $index++;
                                $inner = 0;
                            }
                        }
                        //$arData[$index]['name'] = strip_tags($mName[1]);
                    }

                    //$index++;
                }
            }
        }
    }
    if ($arData) {
        var_dump($arData);
        //$total_return = implode("\n\n", implode("\n",$arData));
        $total_return = '';
        foreach ($arData as $value) {
            $total_return .= implode(" - ", $value);
            $total_return .= "\n";
        }
        return true;
    } elseif($myCityID){
        $total_return = "Sorry no restaurant found for this city";
        return true;
    }
    return false;
}

?>
