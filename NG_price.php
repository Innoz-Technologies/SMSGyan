<?php

$object = new Price($spell_checked, $req);
var_dump($object);

if (!empty($object->return["price"])) {
    $total_return = $object->return["price"];
    if (!empty($object->return["options"])) {
        $options_list = array_merge($options_list, $object->return["options"]);
        $list = array_merge($list, $object->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'NGprice';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class Price {

    public $return = array();

    function __construct($spell_checked, $req) {
        if ($spell_checked == "price") {
            $this->return['price'] = "SMS Price <item>";
        } elseif (preg_match('~price (.+)~', $spell_checked, $match)) {
            $searchedQuery = trim($match[1]);
            $url = "http://www.jumia.com.ng/catalog/?q=" . urlencode($searchedQuery);
            $this->parseData($url);
        } elseif (preg_match('~__nigeriaprice__(.+)__~', $req, $match)) {
            echo $url = trim($match[1]);
            $this->getData($url);
        }
    }

    function parseData($url) {
        $contents = file_get_contents($url);
        if (preg_match_all('~<a id=".+" class="itm-link" href="(.+)" title="(.+)">~Usi', $contents, $match)) {
            if (count($match[1] > 1)) {
                $this->return['price'] = "Your query matches more than one result";
                for ($i = 0; $i < count($match[1]); $i++) {
                    $title = trim($match[2][$i]);
                    $link = trim($match[1][$i]);
                    $this->return["options"][] = $title;
                    $this->return["list"][] = array("content" => "__nigeriaprice__" . $link . "__");
                }
            }
        }else{
            $this->return['price'] = "Sorry no data found matching your query";
        }
    }

    function getData($url) {
        $contents = file_get_contents($url);
        if (preg_match('~<span class="prd-title ltr-content" itemprop="name">(.+)</span>~Usi', $contents, $match)) {
            $item = trim($match[1]);
            $item = strip_tags($item);
        }
        if (preg_match('~<meta itemprop="price" content="(.+)">~Usi', $contents, $match)) {
            $price = trim($match[1]);
            $price = "NGN $price";
        }
        if (preg_match('~<div class="ltr-content txtLeft">(.+)</div>~Usi', $contents, $match)) {
            $features = trim($match[1]);
            $features = strip_tags($features);
        }

        $data = "$item\n$price\n$features";

        $this->return['price'] = $data;
    }

}

?>
