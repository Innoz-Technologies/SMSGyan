<?php

class answers {

    private $url;
    public $answer;

    function __construct($url) {
        $this->url = $url;
    }

    function getdata() {
        $content = file_get_contents($this->url);


        if (preg_match_all("~<div class=\"dstitle\">(.+)<script language=\"javascript\">~Usi", $content, $match)) {
            $i = 0;
            foreach ($match[1] as $data) {
                if (preg_match("~<a href=\"http://www.answers.com/library/.+\">(.+)</a> <h2>~Usi", $data, $head)) {
                    $topic = $head[1];
                }
                if (preg_match("~<div class=\"contents\">.+<div>(.+)</div>~Usi", $data, $matches)) {
                    $data_ans = $matches[1];
                    $data_ans = strip_tags($data_ans);
                }
                if (preg_match("~<div class=\"contents\">.+<li>(.+)</li>~Usi", $data, $matches)) {
                    $data_ans = $matches[1];
                    $data_ans = strip_tags($data_ans);
                }
                if (preg_match("~<div class=\"contents\">.+<p>(.+)</p>~Usi", $data, $matches)) {
                    $data_ans = $matches[1];
                    $data_ans = strip_tags($data_ans);
                }
                if (preg_match("~<div id=\"ency_0\">(.+)</div>~Usi", $data, $matches)) {
                    $data_ans = $matches[1];
                    $data_ans = preg_replace("~<span class=\"shw\">(.+)</p>~", "", $data_ans);
                    $data_ans = strip_tags($data_ans);
                }
                if ($topic == "Featured Videos:" || $topic == "Wikipedia on Answers.com:" || $topic == "Rhymes:" || $topic == "Translations:") {
                    $data_ans = "";
                    $i = $i - 1;
                }

                if (!empty($data_ans)) {
                    $ans[$i] = $topic . $data_ans . "\n";
                }
                $i++;
            }
        }
        $this->answer = '';
        foreach ($ans as $data_put) {
            $this->answer.= "$data_put";
        }
        return $this->answer;
    }

}

//$url = "http://www.answers.com/topic/norse";
//$out = new answers($url);
//$out->getdata();
//var_dump($out->answer);
?>