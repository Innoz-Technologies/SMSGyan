<?php

$circle_lang = '';
$tele_state = '';
$circle_city = $circle_state = '';
$circle_short = $circle_c = strtoupper($circle);
$rcode = '';

if ($country == "dubai") {
    $circle_city = 'dubai';
    $circle_state = 'uae';
    $circle_lang = 'arabi';
    $tele_state = 'uae';
    $circle_short = "AE";
} elseif ($country == "nepal") {
    $circle_city = 'kathmandu';
    $circle_state = 'nepal';
    $circle_lang = 'nepali';
    $tele_state = 'nepal';
    $circle_short = "NEPAL";
} elseif ($country == "srilanka") {
    $circle_city = 'colombo';
    $circle_state = 'srilanka';
    $circle_lang = 'sinhala';
    $tele_state = 'srilanka';
    $circle_short = "SL";
} else {
    switch ($circle) {

        case 'AP':
        case 'ANDHRA PRADESH':
        case 'ANDHRAPRADESH':
            $circle_city = 'hyderabad';
            $circle_state = 'andhra pradesh';
            $circle_lang = 'telugu';
            $tele_state = 'andhra_pradesh';
            $circle_short = "AP";
            $rcode = 2;
            $comm_circle_city = "HYDERABAD";
            break;
        case 'AS':
        case 'ASSAM':
            $circle_city = 'guwahati';
            $circle_state = 'assam';
            $circle_lang = 'assamese';
            $tele_state = 'assam';
            $circle_short = "AS";
            $rcode = 3;
            $comm_circle_city = "GUWAHATI";
            break;
        case 'BH':
        case 'BIHAR & JHARKHAND':
        case 'BIHAR&JHARKHAND':
            $circle_city = 'patna';
            $circle_state = 'bihar';
            $circle_lang = 'hindi';
            $tele_state = 'bihar';
            $circle_short = "BH";
            $rcode = 4;
            $comm_circle_city = "PATNA";
            break;
        case 'CH':
        case 'CN':
        case 'CHENNAI':
            $circle_city = 'chennai';
            $circle_state = 'tamil nadu';
            $circle_lang = 'tamil';
            $tele_state = 'chennai_metro';
            $circle_short = "CH";
            $rcode = 23;
            $comm_circle_city = "CHENNAI";
            break;
        case 'DL':
        case 'DELHI':
            $circle_city = 'delhi';
            $circle_state = 'delhi';
            $circle_lang = 'hindi';
            $tele_state = 'delhi_metro';
            $circle_short = "DL";
            $rcode = 5;
            $comm_circle_city = "DELHI";
            break;
        case 'GJ':
        case 'GUJARAT':
            $circle_city = 'ahmedabad';
            $circle_state = 'gujarat';
            $circle_lang = 'gujarati';
            $tele_state = 'gujarat';
            $circle_short = "GJ";
            $rcode = 6;
            $comm_circle_city = "AHMEDABAD";
            break;
        case 'HP':
        case 'HIMACHAL PRADESH':
        case 'HIMACHALPRADESH':
            $circle_city = 'shimla';
            $circle_state = 'himachal pradesh';
            $circle_lang = 'hindi';
            $tele_state = 'himachal_pradesh';
            $circle_short = "HP";
            $rcode = 8;
            $comm_circle_city = "SHIMLA";
            break;
        case 'HR':
        case 'HARYANA':
            $circle_city = 'gurgaon';
            $circle_state = 'haryana';
            $circle_lang = 'hindi';
            $tele_state = 'haryana';
            $circle_short = "HR";
            $rcode = 7;
            $comm_circle_city = "DELHI";
            break;
        case 'JK':
        case 'JAMMU & KASHMIR':
        case 'JAMMU&KASHMIR':
            $circle_city = 'srinagar';
            $circle_state = 'jammu and kashmir';
            $circle_lang = 'urdu';
            $tele_state = 'jammu_kashmir';
            $circle_short = "JK";
            $rcode = 9;
            $comm_circle_city = "SRINAGAR";
            break;
        case 'KA':
        case 'KN':
        case 'KARNATAKA':
            $circle_city = 'bangalore';
            $circle_state = 'karnataka';
            $circle_lang = 'kannada';
            $tele_state = 'karnataka';
            $circle_short = "KA";
            $rcode = 10;
            $comm_circle_city = "BENGALURU";
            break;
        case 'KL':
        case 'KERALA':
            $circle_city = 'kochi';
            $circle_state = 'kerala';
            $circle_lang = 'malayalam';
            $tele_state = 'kerala';
            $circle_short = "KL";
            $rcode = 11;
            $comm_circle_city = "ERNAKULAM";
            break;
        case 'KC':
        case 'KO':
        case 'KOLKATA':
            $circle_city = 'kolkata';
            $circle_state = 'west bengal';
            $circle_lang = 'bengali';
            $tele_state = 'kolkata_metro';
            $circle_short = "KO";
            $rcode = 12;
            $comm_circle_city = "KOLKATA";
            break;
        case 'MB':
        case 'MUMBAI':
            $circle_city = 'mumbai';
            $circle_state = 'maharashtra';
            $circle_lang = 'marathi';
            $tele_state = 'mumbai_metro';
            $circle_short = "MB";
            $rcode = 15;
            $comm_circle_city = "MUMBAI";
            break;
        case 'MH':
        case 'MAHARASHTRA':
            $circle_city = 'pune';
            $circle_state = 'maharashtra';
            $circle_lang = 'marathi';
            $tele_state = 'maharashtra';
            $circle_short = "MH";
            $rcode = 13;
            $comm_circle_city = "MUMBAI";
            break;
        case 'MP':
        case 'MADHYA PRADESH & CHHATISGARH':
        case 'MADHYAPRADESH&CHHATISGARH':
            $circle_city = 'indore';
            $circle_state = 'madhya pradesh';
            $circle_lang = 'hindi';
            $tele_state = 'madhya_pradesh';
            $circle_short = "MP";
            $rcode = 14;
            $comm_circle_city = "INDORE";
            break;
        case 'NE':
        case 'NORTH EAST':
        case 'NORTHEAST':
            $circle_city = 'shillong';
            $circle_state = 'meghalaya';
            $circle_lang = 'hindi';
            $tele_state = 'northeast';
            $circle_short = "NE";
            $rcode = 16;
            $comm_circle_city = "GUWAHATI";
            break;
        case 'OR':
        case 'ORISSA':
            $circle_city = 'bhubaneswar';
            $circle_state = 'orissa';
            $circle_lang = 'oriya';
            $tele_state = 'orissa';
            $circle_short = "OR";
            $rcode = 17;
            $comm_circle_city = "BHUBANESHWAR";
            break;
        case 'PB':
        case 'PJ':
        case 'PUNJAB':
            $circle_city = 'ludhiana';
            $circle_state = 'punjab';
            $circle_lang = 'punjabi';
            $tele_state = 'punjab';
            $circle_short = "PB";
            $rcode = 18;
            $comm_circle_city = "CHANDIGARH";
            break;
        case 'RJ':
        case 'RAJASTHAN':
            $circle_city = 'jaipur';
            $circle_state = 'rajasthan';
            $circle_lang = 'hindi';
            $tele_state = 'rajasthan';
            $circle_short = "RJ";
            $rcode = 19;
            $comm_circle_city = "JAIPUR";
            break;
        case 'TN':
        case 'TAMILNADU':
            $circle_city = 'madurai';
            $circle_state = 'tamil nadu';
            $circle_lang = 'tamil';
            $tele_state = 'tamil_nadu';
            $circle_short = "TN";
            $rcode = 1;
            $comm_circle_city = "CHENNAI";
            break;
        case 'UE':
        case 'UPE':
        case 'UTTAR PRADESH (E)':
        case 'UTTARPRADESH(E)':
            $circle_city = 'kanpur';
            $circle_state = 'uttar pradesh';
            $circle_lang = 'hindi';
            $tele_state = 'uttar_pradesh_east';
            $circle_short = "UE";
            $rcode = 20;
            $comm_circle_city = "KANPUR";
            break;
        case 'UW':
        case 'UPW':
        case 'UTTAR PRADESH (W) & UTTARAKHAND':
        case 'UTTARPRADESH(W)&UTTARAKHAND':
            $circle_city = 'dehradun';
            $circle_state = 'uttarakhand';
            $circle_lang = 'hindi';
            $tele_state = 'uttar_pradesh_west';
            $circle_short = "UW";
            $rcode = 21;
            $comm_circle_city = "KANPUR";
            break;
        case 'WB':
        case 'WEST BENGAL':
        case 'WESTBENGAL':
            $circle_city = 'howrah';
            $circle_state = 'west bengal';
            $circle_lang = 'bengali';
            $tele_state = 'west_bengal';
            $circle_short = "WB";
            $rcode = 22;
            $comm_circle_city = "KOLKATA";
            break;
//        case 'SL':
//            $circle_short = "SL";
////            $rcode = 22;
//            break;

        default:
//            $circle_city = 'bangalore';
//            $circle_state = 'karnataka';
//            $circle_lang = 'kannada';
//            $tele_state = 'karnataka';
//            $circle_short = "KA";
            $rcode = 10;
            break;
    }
}

echo "<br> city is : $circle_city";
echo "<br> State is : $circle_state";
echo "<br> Language is : $circle_lang";
echo "<br> Telecomwise State  : $tele_state";
echo "<br> Short Circle  : $circle_short";
echo "<br> Recharge Code  : $rcode";
?>