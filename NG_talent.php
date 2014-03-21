<?php

$obj = new Talent($spell_checked,$req);

var_dump($obj->return);

if (!empty($obj->return["response"])) {
    $total_return = $obj->return["response"];
    if (!empty($obj->return["options"])) {
        $options_list = array_merge($options_list, $obj->return["options"]);
        $list = array_merge($list, $obj->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'NGtalent';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class Talent {

    public $return;

    function __construct($spell_checked, $req) {
        $return = array();
        if ($spell_checked == "talent") {
            $url = "http://www.nigeriasgottalent.com/news.php";
            $this->getUpdates($url);
        } elseif (preg_match('~__NGtalent__(.+)__~', $req, $match)) {
            $link = "http://www.nigeriasgottalent.com/news_detail.php?" . trim($match[1]);
            $this->getContents($link);
        }
    }

    function getUpdates($url) {
        $content = file_get_contents($url);
        if (preg_match_all('~<a href="news_detail.php\?(.+)".+style="font-family:GOTHICB.+".+>(.+)</a>~Usi', $content, $match)) {
            if (count($match[1]) > 1) {
                $this->return["response"] = "Nigeria's got Talent.Live Updates";
                for ($i = 0; $i < count($match[1]); $i++) {
                    $link = trim($match[1][$i]);
                    $title = trim($match[2][$i]);
                    $title = preg_replace('~[\s]+~', " ", $title);

                    $this->return["options"][] = $title;
                    $this->return["list"][] = array("content" => "__NGtalent__" . $link . "__");
                }
            }
        }
    }

    function getContents($link) {
        $content = file_get_contents($link);
        if (preg_match('~<div style="margin-top:-15px;">(.+)</div>~Usi', $content, $match)) {
            $data = trim($match[1]);

            $data = preg_replace('~[\s]+~', " ", $data);
            $data = strip_tags($data);
            $data = html_entity_decode($data);
            $this->return["response"] = $data;
        }
    }

}

?>
