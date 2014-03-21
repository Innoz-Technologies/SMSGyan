<?php

class GhanaNews {

    public $return = array();

    function __construct($spell_checked, $req) {
        if ($spell_checked == "news") {
            $url = "http://www.dailyguideghana.com";
            $this->news($url);
        } elseif (preg_match("~news (.+)~", $spell_checked, $matches)) {
            echo $url = "http://www.dailyguideghana.com/?s=" . urlencode(trim($matches[1]));
            $this->breifNews($url);
        } elseif (preg_match("~__ghanaswen__(.+)__~", $req, $matches)) {
            echo $url = trim($matches[1]);
            $this->fullNews($url);
        }
    }

    function breifNews($url) {
        $content = file_get_contents($url);

        if (preg_match('~<div class="entry-summary">(.+)<a href="(.+)">.+</div>~Usi', $content, $matches)) {
            $this->return["news"] = trim($this->getNews($matches[1]));
            $this->return["options"][] = "Read full news";
            $this->return["list"][] = array("content" => "__ghanaswen__" . trim($matches[2]) . "__");
        }
    }

    function fullNews($url) {
        $content = file_get_contents($url);

        if (preg_match('~<h1 class="entry-title">(.+)</h1>~Usi', $content, $matches)) {
            $this->return["news"] = trim($this->getNews($matches[1])) . "\n";
        }

        if (preg_match('~<div class="entry-content">(.+)<strong>~Usi', $content, $matches)) {
            $this->return["news"] .= trim($this->getNews($matches[1]));
        } else {
            $this->return["news"] = '';
        }
    }

    function news($url) {

        $content = file_get_contents($url);

        if (preg_match('~<div id="section">General News</div>(.+)<div id="section">Audio</div>~Usi', $content, $matches)) {

            if (preg_match_all('~<h2><a href="(.+)".+>(.+)</a></h2>~Usi', $matches[1], $match)) {
                foreach ($match[1] as $id => $val) {
                    $this->return["options"][] = $this->getNews($match[2][$id]);
                    $this->return["list"][] = array("content" => "__ghanaswen__" . trim($val) . "__");
                }
            }
            if (count($this->return["options"]) > 0) {
                $this->return["news"] = "Your query matches more than one result";
            }
        }
    }

    function getNews($out) {
        $out = strip_tags($out);
        $out = html_entity_decode($out);
        $out = str_replace("â€™", "'", $out);
        $out = str_replace("â€“", "", $out);
        $out = str_replace("â€¦", "", $out);
        $out = str_replace("&#038;", "", $out);
        $out = str_replace("&#8211;", "–", $out);
        $out = str_replace("&#8230;", "", $out);
        $out = preg_replace("~[\s]+~", " ", $out);
        return $out;
    }

}

$obj = new GhanaNews($spell_checked, $req);
var_dump($obj->return);

if (!empty($obj->return["news"])) {
    $total_return = $obj->return["news"];
    if (!empty($obj->return["options"])) {
        $options_list = array_merge($options_list, $obj->return["options"]);
        $list = array_merge($list, $obj->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'ghananews';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>