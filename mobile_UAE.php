<?php


//}
//
//if (empty($result["match"])) {
//    $result["match"] = $cleared;
//}
//if (!empty($result["match"])) {
$cleared = trim($cleared);
if ($cleared) {
    $urlStr = str_replace(" ", "-", $cleared);
    echo $url = "http://uae.souq.com/ae-en/$urlStr/s/";
    $content = httpGet($url);
    $out = "";
//    if (preg_match_all('~<b class="txt14">(.+)</b>.+</strong>.+starting from(.+)</span></div>~Usi', $content, $matches)) {
//        foreach ($matches[1] as $id => $value) {
//            $product = trim(strip_tags($value));
//
//            $price = trim(strip_tags($matches[2][$id]));
//
//            $out .= "$product - $price\n";
//        }
//    }
//    echo "<br>$out<br>";

    if (preg_match_all('~<div class="single-item-browse  fl .+>(.+)<a class="linkButton linkButton-send-small.+>~Usi', $content, $matches)) {

        foreach ($matches[1] as $id => $value) {
            if (preg_match('~<a href=".+title="(.+)".+>.+<div class="small-price position-relative.+>(.+)</div>~Usi', $value, $match)) {
                foreach ($match as $key => $val) {
                    $val = preg_replace("~[\s]+~", " ", $val);
                    if ($key == 2) {
                        $val = preg_replace("~<span class='striked.+>(.+)</span></span>~Usi", "", $val);
                    }
                    $val = trim(strip_tags($val));
                    $match[$key] = $val;
                }

                $out .= $match[1] . " " . $match[2] . "\n";
            }
        }
    }
}

if (!empty($out)) {
    $total_return = "Price " . ucfirst($cleared) . "\n" . $out;
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'price_mobile';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function getMetaphoneM($first, $second, $result) {
    $arFirst = explode(" ", $first);
    $arSecond = explode(" ", $second);
    $m1 = $m2 = "";

    foreach ($arFirst as $val) {
        $m1 .= metaphone($val);
    }

    foreach ($arSecond as $val2) {
        $m2 .= metaphone($val2);
    }

    $metaphone['levenshtein'] = levenshtein($m1, $m2);
    $metaphone['similarity'] = similar_text($m1, $m2, $perc);
    $metaphone['percentage'] = $perc;

    if ($result['levenshtein'] > $metaphone['levenshtein'] && $result['percentage'] <= $metaphone['percentage']) {
        $result["levenshtein"] = $metaphone['levenshtein'];
        $result["percentage"] = $metaphone['percentage'];
        $result["match"] = $second;
    }

    return $result;
}

?>