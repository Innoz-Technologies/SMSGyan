<?php

//$spell_checked = $req = $_GET["s"];
$obj = new KE_gossip($spell_checked, $req);
var_dump($obj->return);

if (!empty($obj->return["result"])) {
    $total_return = $obj->return["result"];
    if (!empty($obj->return["options"])) {
        $options_list = array_merge($options_list, $obj->return["options"]);
        $list = array_merge($list, $obj->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'KEgossip';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class KE_gossip {

    public $return = array("result" => "");

    function __construct($spell_checked, $req) {
        if ($spell_checked == "gossip") {
            $url = "http://www.kenyacelebrities.com/";
            $this->getTop5($url);
        } elseif (preg_match("~gossip (.+)~", $spell_checked, $matches)) {
            echo $url = "http://www.kenyacelebrities.com/?s=" . urlencode(trim($matches[1]));
            $this->getGossipBrief($url);
        } elseif (preg_match("~__KEGOSSIP__(.+)__~", $req, $matches)) {
            echo $url = trim($matches[1]);
            $this->getGossipDetailed($url);
        }
//        $url = "http://www.kenyacelebrities.com/?s=Sanaipei+Tande";
//        $url = "http://www.kenyacelebrities.com/2012/04/sanaipei-tande/";
//        $url = "http://www.kenyacelebrities.com/";
//        $this->getTop5($url);
    }

    function getGossipBrief($url) {
        $content = file_get_contents($url);
        if (preg_match('~<div id="post-.+" class="news_i">.+<a href="(.+)".+>(.+)</a></h2>.+</div>(.+)</div>(.+)</div>~Usi', $content, $matches)) {
//            var_dump($matches);
            $out = $this->StripTags($matches[2]) . "\n";
            $out .= $this->StripTags($matches[3]);
            $this->return["result"] = $out;
            $this->return["options"][] = "Read Full Article";
            $this->return["list"][] = array("content" => "__KEGOSSIP__" . $this->StripTags($matches[1]) . "__");
        }
    }

    function getGossipDetailed($url) {
        $content = file_get_contents($url);
        if (preg_match('~<div class="area">(.+)<span class=.+>.+</h1>.+</script>(.+)</div>~Usi', $content, $matches)) {
//            var_dump($matches);
            $out = $this->StripTags($matches[1]) . "\n";
            $out .= $this->StripTags($matches[2]);
            $this->return["result"] = $out;
        }
    }

    function getTop5($url) {
        $content = file_get_contents($url);
        if (preg_match_all('~</a></div><div><h6><a href="(.+)".+>(.+)</a></h6><span>~Usi', $content, $matches)) {
//            var_dump($matches);
            foreach ($matches[1] as $id => $val) {
                $this->return["options"][] = $matches[2][$id];
                $this->return["list"][] = array("content" => "__KEGOSSIP__" . $this->StripTags($val) . "__");
            }

            if (!empty($this->return["options"])) {
                $this->return["result"] = "Top five Gossip articles:";
            }
        }
    }

    function StripTags($out) {
        $out = strip_tags($out);
        $out = trim(preg_replace("~[\s]+~", " ", $out));
        $out = str_ireplace("&#8230;", "", $out);
        return $out;
    }

}

?>