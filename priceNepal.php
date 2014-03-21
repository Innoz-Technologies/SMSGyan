<?php

echo "<h1>Operator NEPAL</h3>";
$cleared = $spell_checked;
if (preg_match("~\b(costs?|prices?|rates?)\b~", $cleared, $match)) {
    if (preg_match("~^[^\w]*(car|mobile|bike|vegetable|veg|grocery)? ?(prices?|what is the (price|cost)s?)(.+)~", $cleared, $match)) {
        $cleared = $match[4];
    }

    $cleared = remcity($cleared);
//        $cleared = remwords($cleared);
    $cleared = preg_replace("~\b(india|mobile|cars?|bikes?|vegetables?|grocery|veg)\b~", "", $cleared);
    $arMobBrand = array("Chevrolet", "Daihatsu", "Ford", "Great Wall Motors", "Honda", "Hyundai", "Jonway", "Kia motors", "Mahindra", "Maruti Suzuki",
        "Mazda", "Nissan", "Perodua", "Proton", "Skoda", "Ssangyong", "Tata", "Toyota", "Volkswagen", "Alcatel", "Apple", "Beetel", "Bird", "BlackBerry",
        "Colors Mobile", "Gadgets Mobile", "GFIVE", "HTC", "Intex", "Karbonn Mobile", "Lava Mobiles", "LG", "Micromax", "Motorola", "Nokia", "Oxygen Mobile",
        "Samsung", "Sony Ericsson", "Spice Mobile", "Anna Lifan", "Bajaj", "Daelim", "Hartford", "Hero Moto Corp", "Hyosung", "KTM", "Mahindra",
        "Royal Enfield", "Suzuki", "TVS", "Yamaha");

    foreach ($arMobBrand as $brand) {
        if (preg_match("~\b" . $brand . "\b~si", $cleared)) {
            $cleared = str_replace("price", "", $cleared);
            include 'nepal_price.php';
            break;
        }
    }

    $total_return = "Sorry, no prices found for '" . trim($cleared) . "'";
    $to_logserver['isresult'] = 0;
    $to_logserver['source'] = 'price_nepal';
    $free = true;
    putOutput($total_return);
    exit();
}

if (preg_match('~__nepalprice__(.+)__~', $req, $matched)) {

    echo '<h3>Inside Nepal Price </h3>';

    $pdt_url = trim($matched[1]);
    $details = getdetails($pdt_url);
    if (!empty($details)) {
        $total_return = $details;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'price_nepal';
        putOutput($total_return);
        exit();
    }
}
?>
