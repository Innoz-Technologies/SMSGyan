<?php

echo "<h1>Operator PAKISTAN</h3>";
$cleared = $spell_checked;
if (preg_match("~\b(costs?|prices?|rates?)\b~", $cleared, $match)) {
    if (preg_match("~^[^\w]*(phone|mobile)? ?(prices?|what is the (price|cost)s?)(.+)~", $cleared, $match)) {
        $cleared = $match[4];
    }

    $cleared = remcity($cleared);
//        $cleared = remwords($cleared);
    $cleared = preg_replace("~\b(phone|mobile)\b~", "", $cleared);
    $arMobBrand = array("Samsung", "Nokia", "Apple iPhone", "Q Mobile", "HTC", "MegaGate", "Sony", "Blackberry", "China Mobile", "Sony ericsson", "Trend", "HP", "imate", "Tablet PCs", "Philips", "T Mobile", "Vodafone", "Dell", "Acer", "Micromax", "Alcatel", "Microsoft", "ASUS", "Toshiba", "Lava", "Club", "Pantech", "ZTE", "NKTel", "China Copy", "Huawei", "Ufone", "Zong", "G Tide", "Nasaki", "O2", "LG", "Motorola", "Golden Numbers", "GFive", "Home", "O7", "Meizu", "xMobiles", "Touchtel", "Lenovo", "AMB", "Gigabyte", "Karbonn", "Sky", "Jolla", "Panasonic", "Voice", "Mobilink", "Plum", "Spice", "Hyundai", "Ainol", "NEC", "Xolo", "Celkon", "BLU"
    );

    foreach ($arMobBrand as $brand) {
        if (preg_match("~\b" . $brand . "\b~si", $cleared)) {
            $cleared = str_replace("price", "", $cleared);
            $isSet = true;
            echo "<h1>Before PAKISTAN</h3>";
            include 'pakistan_mobile.php';
            break;
        }
    }
    $total_return = "Sorry, no prices found for '" . trim($cleared) . "'";
    $to_logserver['isresult'] = 0;
    $to_logserver['source'] = 'pak_mobile';
    $free = true;
    putOutput($total_return);
    exit();
} elseif (preg_match('~price__pakmobile__(.+)__~', $req, $match)) {
    $url = "http://www.mobile2u.com.pk/mobile/" . $match[1];
    $content = file_get_contents($url);

    if (preg_match('~<span id="ctl00_ContentPlaceHolder1_ItemDetail1_lblSummary">(.+)</span>~Usi', $content, $match)) {
        $data = $match[1];
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace('<br/>', "\n", $data);
        $data = strip_tags($data);
        echo $data;
    }
    $total_return = $data;
    if (!empty($total_return)) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'pak_mobile';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
