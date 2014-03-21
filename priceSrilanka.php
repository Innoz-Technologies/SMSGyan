<?php

echo "<h1>Operator DIALOG</h3>";
$cleared = $spell_checked;
if (preg_match("~\b(costs?|prices?|rates?)\b~", $cleared, $match)) {
    if (preg_match("~^[^\w]*(car|mobile|bike|vegetable|veg|grocery)? ?(prices?|what is the (price|cost)s?)(.+)~", $cleared, $match)) {
        $cleared = $match[4];
    }

    $cleared = remcity($cleared);
//        $cleared = remwords($cleared);
    $cleared = preg_replace("~\b(india|mobile|cars?|bikes?|vegetables?|grocery|veg)\b~", "", $cleared);

    echo "<h3>CLEARED: $cleared</h3>";

    $arMobBrand = array("Nokia", "Samsung", "Micromax", "Blackberry", "Sony Ericson");

    foreach ($arMobBrand as $brand) {
        if (preg_match("~\b" . $brand . "\b~si", $cleared)) {
            $cleared = str_replace("price", "", $cleared);
            include 'srilanka_MobPrice.php';
            break;
        }
    }

    $total_return = "Sorry, no prices found for " . trim($cleared);
    $to_logserver['isresult'] = 0;
    $to_logserver['source'] = 'SLMobPrice';
    $free = true;
    putOutput($total_return);
    exit();
} else if (preg_match("~\b(___slmobid(.+))\b~", $cleared, $match)) {
    include 'srilanka_MobPrice.php';
}
?>
