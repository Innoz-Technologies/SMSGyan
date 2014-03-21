<?php

if ($spell_checked == "tourist place" || $spell_checked == "tourism") {
    $total_return = "Select your state";

    $options_list[] = "ASSAM";
    $list[] = array("content" => "__tourist__assam__");
    $options_list[] = "ARUNACHAL PRADESH";
    $list[] = array("content" => "__tourist__arunachal pradesh__");
    $options_list[] = "MANIPUR";
    $list[] = array("content" => "__tourist__manipur__");
    $options_list[] = "MEGHALAYA";
    $list[] = array("content" => "__tourist__meghalaya__");
    $options_list[] = "MIZORAM";
    $list[] = array("content" => "__tourist__mizoram__");
    $options_list[] = "TRIPURA";
    $list[] = array("content" => "__tourist__tripura__");
    $options_list[] = "NAGALAND";
    $list[] = array("content" => "__tourist__nagaland__");

    if ($total_return) {
        $to_logserver['source'] = 'tourist_NE';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__tourist__(.+)__~Usi", $req, $match)) {
    $state = $match[1];


    switch ($state) {

        case 'assam':
            $total_return = "Tourist places of Assam";

            $options_list[] = "Assam Tea Garden";
            $list[] = array("content" => "Assam Tea Garden");
            $options_list[] = "Kaziranga National park";
            $list[] = array("content" => "Kaziranga National park");
            $options_list[] = "Manas National Park";
            $list[] = array("content" => "Manas National Park");
            $options_list[] = "Orang National Park";
            $list[] = array("content" => "Orang National Park");
            $options_list[] = "Pobitora Wildlife Sanctuary";
            $list[] = array("content" => "Pobitora Wildlife Sanctuary");
            $options_list[] = "Adventure Sports in Assam";
            $list[] = array("content" => "Adventure Sports in Assam");
            $options_list[] = "Fairs and Festivals of Assam";
            $list[] = array("content" => "Fairs and Festivals of Assam");
            $options_list[] = "Dance and Music of Assam";
            $list[] = array("content" => "Dance and Music of Assam");
            $options_list[] = "assamese cuisine";
            $list[] = array("content" => "assamese cuisine");
            break;

        case 'arunachal pradesh':

            $total_return = "Tourist places of Arunachal Pradesh";

            $options_list[] = "Tawang Monastery";
            $list[] = array("content" => "Tawang Monastery");
            $options_list[] = "Bomdila Monastery";
            $list[] = array("content" => "Bomdila Monastery");
            $options_list[] = "Urgelling Monastery";
            $list[] = array("content" => "Urgelling Monastery");
            $options_list[] = "Namdapha National Park";
            $list[] = array("content" => "Namdapha National Park");
            $options_list[] = "Adventure in Arunachal Pradesh";
            $list[] = array("content" => "Adventure in Arunachal Pradesh");
            $options_list[] = "Adventure Sports in Assam";
            $list[] = array("content" => "Adventure Sports in Assam");
            $options_list[] = "Fairs and Festivals of Arunachal Pradesh";
            $list[] = array("content" => "Fairs and Festivals of Arunachal Pradesh");
            $options_list[] = "Art and Craft of Arunachal Pradesh";
            $list[] = array("content" => "Art and Craft of Arunachal Pradesh");
            $options_list[] = "Flora and Fauna of Arunachal Pradesh";
            $list[] = array("content" => "Flora and Fauna of Arunachal Pradesh");
            $options_list[] = "Arunachali Cuisine";
            $list[] = array("content" => "Arunachali Cuisine");
            break;


        case 'manipur':

            $total_return = "Tourist places of Manipur";

            $options_list[] = "Keibul Lamjao National Park";
            $list[] = array("content" => "Keibul Lamjao National Park");
            $options_list[] = "Culture of Manipur";
            $list[] = array("content" => "Culture of Manipur");
            break;

        case 'meghalaya':

            $total_return = "Tourist places of Meghalaya";

            $options_list[] = "Cherrapunji";
            $list[] = array("content" => "Cherrapunji");
            $options_list[] = "Flora And Fauna";
            $list[] = array("content" => "Flora And Fauna");
            $options_list[] = "Adventure in Meghalaya";
            $list[] = array("content" => "Adventure in Meghalaya");
            $options_list[] = "Dance And Music";
            $list[] = array("content" => "Dance And Music");
            $options_list[] = "Festivals Of Meghalaya";
            $list[] = array("content" => "Festivals Of Meghalaya");
            $options_list[] = "Shopping In Meghalaya";
            $list[] = array("content" => "Shopping In Meghalaya");
            break;

        case 'mizoram':

            $total_return = "Tourist places of Mizoram";

            $options_list[] = "Tourist attractions";
            $list[] = array("content" => "Tourist attractions");
            $options_list[] = "Ngengpui Wildlife Sanctuary";
            $list[] = array("content" => "Ngengpui Wildlife Sanctuary");
            $options_list[] = "Khawnglung Wildlife Sanctuary";
            $list[] = array("content" => "Khawnglung Wildlife Sanctuary");
            $options_list[] = "Lengteng Wildlife Sanctuary";
            $list[] = array("content" => "Lengteng Wildlife Sanctuary");
            $options_list[] = "Thorangtlang Wildlife Sanctuary";
            $list[] = array("content" => "Thorangtlang Wildlife Sanctuary");
            $options_list[] = "Phawngpui National Park";
            $list[] = array("content" => "Phawngpui National Park");
            $options_list[] = "Dampa Sanctuary";
            $list[] = array("content" => "Dampa Sanctuary");
            $options_list[] = "Murlen National Park";
            $list[] = array("content" => "Murlen National Park");
            $options_list[] = "Lodaw Wildlife Sanctuary ";
            $list[] = array("content" => "Lodaw Wildlife Sanctuary ");
            $options_list[] = "Flora and Fauna of Mizoram";
            $list[] = array("content" => "Flora and Fauna of Mizoram");
            $options_list[] = "Caves Of Mizoram";
            $list[] = array("content" => "Caves Of Mizoram");
            $options_list[] = "Lakes";
            $list[] = array("content" => "lakes");
            $options_list[] = "Dances of Mizoram";
            $list[] = array("content" => "Dances of Mizoram");
            $options_list[] = "Festivals of Mizoram";
            $list[] = array("content" => "Festivals of Mizoram");
            $options_list[] = "Cuisine of Mizoram";
            $list[] = array("content" => "Cuisine of Mizoram");
            break;

        case 'tripura':

            $total_return = "Tourist places of Tripura";

            $options_list[] = "Ujjayanta Palace";
            $list[] = array("content" => "Ujjayanta Palace");
            $options_list[] = "Kunjaban Palace";
            $list[] = array("content" => "Kunjaban Palace");
            $options_list[] = "Neermahal Palace";
            $list[] = array("content" => "Neermahal Palace");
            $options_list[] = "Ujjayanta Palace Malancha Niwas";
            $list[] = array("content" => "Ujjayanta Palace Malancha Niwas");
            $options_list[] = "Tripura Government Museum";
            $list[] = array("content" => "Tripura Government Museum");
            $options_list[] = "Gumti Wildlife Sanctuary";
            $list[] = array("content" => "Gumti Wildlife Sanctuary");
            $options_list[] = "Sepahijala Wildlife Sanctuary";
            $list[] = array("content" => "Sepahijala Wildlife Sanctuary");
            $options_list[] = "Gondacherra Wild Life Sanctuary";
            $list[] = array("content" => "Gondacherra Wild Life Sanctuary");
            $options_list[] = "The Trishna Wildlife Sanctuary";
            $list[] = array("content" => "The Trishna Wildlife Sanctuary");
            $options_list[] = "temples of tripura";
            $list[] = array("content" => "temples of tripura");
            $options_list[] = "Art And Craft";
            $list[] = array("content" => "Art And Craft");
            $options_list[] = "Fairs And Festivals";
            $list[] = array("content" => "Fairs And Festivals");
            $options_list[] = "Dances forms";
            $list[] = array("content" => "Dances forms");
            break;


        case 'nagaland':

            $total_return = "Tourist places of Nagaland";

            $options_list[] = "Wildlife of Nagaland";
            $list[] = array("content" => "Wildlife of Nagaland");
            $options_list[] = "Shopping in Nagaland";
            $list[] = array("content" => "Shopping in Nagaland");
            $options_list[] = "Festivals of Nagaland";
            $list[] = array("content" => "Festivals of Nagaland");
            $options_list[] = "Crafts";
            $list[] = array("content" => "Crafts");
            $options_list[] = "Music";
            $list[] = array("content" => "Music");
            $options_list[] = "Dance";
            $list[] = array("content" => "Dance");
            break;
    }

    if ($total_return) {
        $to_logserver['source'] = 'tourist_NE';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
