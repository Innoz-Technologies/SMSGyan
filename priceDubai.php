<?php

echo "<h1>Operator DU</h3>";
$cleared = $spell_checked;
if (preg_match("~\b(costs?|prices?|rates?)\b~", $cleared, $match)) {
    if (preg_match("~^[^\w]*(car|mobile|bike|vegetable|veg|grocery)? ?(prices?|what is the (price|cost)s?)(.+)~", $cleared, $match)) {
        $cleared = $match[4];
    }

    $cleared = remcity($cleared);
//        $cleared = remwords($cleared);
    $cleared = preg_replace("~\b(india|mobile|cars?|bikes?|vegetables?|grocery|veg)\b~", "", $cleared);
//        $arMobBrand = array("Nokia", "Samsung", "Micromax", "Blackberry", "LG", "Sony", "Motorola", "HTC", "Acer", "Apple", "Videocon", "Spice", "Karbonn",
//            "Lemon", "Lava", "Fly", "Olive", "Intex", "Wynncom", "Dell", "MVL", "Onida", "T Series", "Wespro");
    include 'mobile_UAE.php';
//        foreach ($arMobBrand as $brand) {
//            if (preg_match("~\b" . $brand . "\b~si", $cleared)) {
//                $cleared = str_replace("price", "", $cleared);
//                
//                break;
//            }
//        }

    include 'bikecar_UAE.php';
    $total_return = "Sorry, no prices found for '$cleared'";
    $to_logserver['isresult'] = 0;
    $to_logserver['source'] = 'price';
    $free = true;
    putOutput($total_return);
    exit();
}
?>
