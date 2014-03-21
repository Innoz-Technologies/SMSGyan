<?php

//$spell_checked = $req = $_GET["s"];
$objStock = new GhanaStock($spell_checked, $req);
var_dump($objStock->return);

if (!empty($objStock->return["result"])) {
    $total_return = $objStock->return["result"];
    if (!empty($objStock->return["options"])) {
        $options_list = array_merge($options_list, $objStock->return["options"]);
        $list = array_merge($list, $objStock->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'ghanastock';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class GhanaStock {

    public $return = array("result" => "");

    function __construct($spell_checked, $req) {
        if ($spell_checked == "stock") {
            $this->stock();
        } elseif (preg_match("~^stock (.+)~", $spell_checked, $matches)) {
            var_dump($matches);
            $this->stock(trim($matches[1]));
        } else if (preg_match("~__ghanaStock__(.+)__~", $req, $matches)) {
            $this->getResult(trim($matches[1]));
        }
    }

    function stock($search = '') {
        $url = "http://www.gse.com.gh/index1.php?linkid=5&sublinkid=12";
        $content = file_get_contents($url);

        if (preg_match_all('~<td class="ortab">.+</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>(.+)</td>~Usi', $content, $matches)) {
//            var_dump($matches);
            if (!empty($search)) {
                foreach ($matches[3] as $id => $val) {
                    echo $ShareCode = $this->StripTags($val);
                    if (stripos($ShareCode, $search) !== false) {
                        $out = $this->getString($matches, $id, $ShareCode);
                        $this->getResult($out);
                        break;
                    }
                }
            } else {
                foreach ($matches[3] as $id => $val) {
                    if ($id > 0) {
                        $ShareCode = $this->StripTags($val);
                        $out = $this->getString($matches, $id, $ShareCode);
                        $this->return["options"][] = $ShareCode;
                        $this->return["list"][] = array("content" => "__ghanaStock__" . $out . "__");
                    }
                }

                if (!empty($this->return["options"])) {
                    $this->return["result"] = "Query matches more than one result:";
                }
            }
        }
    }

    function getString($matches, $id, $ShareCode) {
        $out = "$ShareCode:" . $this->StripTags($matches[4][$id]);
        $out .= ":" . $this->StripTags($matches[5][$id]);
        $out .= ":" . $this->StripTags($matches[6][$id]);
        $out .= ":" . $this->StripTags($matches[7][$id]);
        $out .= ":" . $this->StripTags($matches[8][$id]);
        $out .= ":" . $this->StripTags($matches[9][$id]);
        $out .= ":" . $this->StripTags($matches[10][$id]);
        $out .= ":" . $this->StripTags($matches[11][$id]);
        $out .= ":" . $this->StripTags($matches[12][$id]);
        $out .= ":" . $this->StripTags($matches[13][$id]);
        return $out;
    }

    function StripTags($out) {
        $out = strip_tags($out);
        $out = trim(preg_replace("~[\s]+~", " ", $out));
        if ($out == '') {
            $out = "-";
        }
        return $out;
    }

    function getResult($input) {
        $ar = explode(":", $input);
        $out = "Share Code: " . $ar[0];
        $out .= "\nYear High (GHS): " . $ar[1];
        $out .= "\nYear Low (GHS): " . $ar[2];
        $out .= "\nPrevious Closing Price VWAP (GHS): " . $ar[3];
        $out .= "\nOpening Price (GHS): " . $ar[4];
        $out .= "\nClosing Price VWAP (GHS): " . $ar[5];
        $out .= "\nPrice Change (GHS): " . $ar[6];
        $out .= "\nClosing Bid Price (GHS): " . $ar[7];
        $out .= "\nClosing Offer Price (GHS): " . $ar[8];
        $out .= "\nTotal Shares Traded: " . $ar[9];
        $out .= "\nLast Transaction Price (GHS): " . $ar[10];
        $this->return["result"] = $out;
    }

}

?>