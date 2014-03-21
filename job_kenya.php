<?php

class jobKenya {

    public $return = array();

    function __construct($spell_checked, $req) {
        if ($spell_checked == "job" || $spell_checked == "jobs") {
            $url = "http://www.kenyamoja.com/jobs/";
            $this->job($url);
        } elseif (preg_match("~^jobs? (.+)~", $spell_checked, $matches)) {
            echo $url = "http://www.kenyamoja.com/jobs/?search=" . urlencode(trim($matches[1]));
            $this->job($url);
        } elseif (preg_match("~__kenyajob__(.+)__~", $req, $matches)) {
            echo $url = trim($matches[1]);
            $this->jobdetails($url);
        }
    }

    function job($url) {
        $content = file_get_contents($url);
        if (preg_match_all('~<a href="http://kenyanjobs.blogspot.com/(.+)" target="_blank">(.+)</a>~Usi', $content, $match)) {
            //var_dump($match);

            if (count($match[1]) > 1) {
                $this->return["job"] = "Your query matches more than one result";
                for ($i = 1; $i < count($match[1]); $i++) {
                    $link = trim(strip_tags($match[1][$i]));
                    $title = trim(strip_tags($match[2][$i]));
                    $this->return["options"][] = $title;
                    $this->return["list"][] = array("content" => "__kenyajob__" . $link . "__");
                }
            }
        } else {
            $this->return["job"] = "No data found";
        }
    }

    function jobdetails($url) {
        echo $url = "http://kenyanjobs.blogspot.com/" . trim($url);
        $content = httpGet($url);
        if (preg_match('~<div dir="ltr" style="text-align: left;" trbidi="on">(.+)<div style=\'text-align: center;\'><br/><br/>~Usi', $content, $match)) {
            $data = $match[1];
            $data = preg_replace('~[\s]+~', " ", $data);
            $data = strip_tags($data);
            $this->return["job"] = $data;
        } else {
            $this->return["job"] = "No data found";
        }
    }

}

$obj = new jobKenya($spell_checked, $req);
var_dump($obj->return);

if (!empty($obj->return["job"])) {
    $total_return = $obj->return["job"];
    if (!empty($obj->return["options"])) {
        $options_list = array_merge($options_list, $obj->return["options"]);
        $list = array_merge($list, $obj->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'jobkenya';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
