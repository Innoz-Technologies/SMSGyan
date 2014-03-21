<?php

class jobThai {

    public $return = array();

    function __construct($spell_checked, $req) {
        if ($spell_checked == "job" || $spell_checked == "jobs") {
            echo $url = "http://th.tiptopjob.com/search/tiptopresults.asp";
            $field_string = "country=THA&sub_location=&srchtype=0&Keyword=&btnSearch=Search+Jobs";
            $this->job($url, $field_string);
        } elseif (preg_match("~^jobs? (.+)~", $spell_checked, $matches)) {
            echo $url = "http://th.tiptopjob.com/search/tiptopresults.asp";
            $field_string = "country=THA&sub_location=&srchtype=0&Keyword=" . urlencode(trim($matches[1])) . "&btnSearch=Search+Jobs";
            $this->job($url, $field_string);
        } elseif (preg_match("~__thailandjob__(.+)__~", $req, $matches)) {
            echo $url = trim($matches[1]);
            $this->jobdetails($url);
        }
    }

    function job($url, $field_string) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: th.tiptopjob.com", 'Referer: 	http://th.tiptopjob.com/'));
        $result = curl_exec($ch);
        curl_close($ch);

        if (preg_match_all('~<a href="/search/jobs/(.+)" onclick=".+" class=tl>(.+)</a>~Usi', $result, $match)) {
            if (count($match[1]) > 1) {
                $this->return["job"] = "Your query matches more than one result";
                for ($i = 1; $i < count($match[1]); $i++) {
                    $link = trim(strip_tags($match[1][$i]));
                    $title = trim(strip_tags($match[2][$i]));
                    $this->return["options"][] = $title;
                    $this->return["list"][] = array("content" => "__thailandjob__" . $link . "__");
                }
            }
        } else {
            $this->return["job"] = "No data found";
        }
    }

    function jobdetails($url) {
        $url_next = "http://th.tiptopjob.com/search/jobs/" . $url;
        $content = file_get_contents($url_next);

        if (preg_match('~<td class="frmlbl nowrap">(.+)<td class=hs_m colspan=2>~Usi', $content, $match)) {
            $data = $match[1];
            $data = preg_replace('~[\s]+~', " ", $data);
            $data = str_replace('</td></tr>', "***", $data);
            $data = strip_tags($data);
            $data = str_replace('***', "\n", $data);
            $data = str_replace("\n ", "\n", $data);
            $this->return["job"] = $data;
        } else {
            $this->return["job"] = "No data found";
        }
    }

}

$obj = new jobThai($spell_checked, $req);
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
    $to_logserver['source'] = 'jobthai';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
