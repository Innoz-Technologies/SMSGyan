<?php

$data = getmobilepricepak($cleared);

var_dump($data);

if (isset($data['options_list'])) {
    echo $total_return = "Your query matches more than one result";
    $options_list = $data['options_list'];
    $list = $data['list'];
} elseif (isset($data['data'])) {
    $total_return = $data['data'];
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'pak_mobile';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function getmobilepricepak($cleared) {
    $return = array();
    $url = "http://www.mobile2u.com.pk/Search.aspx?oid=0&cid=0&pf=0&pt=0&s=" . urlencode($cleared) . "&pNo=0&cc=pak";
    $content = file_get_contents($url);

    if (preg_match_all('~<a class="prd_nme" href=\'http://www.mobile2u.com.pk/mobile/(.+)\' title=\'(.+)Mobile price in pakistan\'>~', $content, $match)) {
        //var_dump($match);
        if (preg_match_all('~<p>(.+)<span class="itm_prc_cur">~', $content, $matches)) {
            //var_dump($matches);
            if (count($match[2]) > 1) {
                for ($i = 0; $i < count($match[2]); $i++) {
                    $price = trim($matches[1][$i]);
                    $price = str_replace('&nbsp;', '', $price);
                    $options_list[] = trim($match[2][$i]) . "(" . $price . " PKR)";
                    $list[] = array("content" => "price__pakmobile__" . trim($match[1][$i]) . "__");
                }
                $return['options_list'] = $options_list;
                $return['list'] = $list;
            } else {
                $title = $match[2][0];
                $price = $matches[1][0];
                echo $url = "http://www.mobile2u.com.pk/mobile/" . trim($match[1][0]);
                $data = getmobilespecpak($url);
                var_dump($data);
                $return['data'] = $title . "(" . $price . " PKR)\n" . $data;
            }
        }
        var_dump($options_list);
        var_dump($list);
    }
    return $return;
}

function getmobilespecpak($url) {
    //$url = "http://www.mobile2u.com.pk/mobile/nokia-asha-501.aspx";
    $content = file_get_contents($url);

    if (preg_match('~<span id="ctl00_ContentPlaceHolder1_ItemDetail1_lblSummary">(.+)</span>~Usi', $content, $match)) {
        echo "<h2>inside pakistan mobile </h2>";
        $data = $match[1];
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace('<br/>', "\n", $data);
        $data = strip_tags($data);
        echo $data;
    }
    return $data;
}

//if (!empty($total_return)) {
//    include 'allmanip.php';
//    $to_logserver['source'] = 'price_nepal';
//    putOutput($total_return);
//    exit();
//}
?>