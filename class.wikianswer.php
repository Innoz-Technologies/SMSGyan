<?php

class wikianswer {

    private $url;
    public $output;

    function __construct($url) {
        $this->url = $url;
    }

    function getAnswer() {
        $content = httpGet($this->url);
        if (preg_match("~<div class=\"answer_text\" id=\"editorText\">(.+)</div>~Usi", $content, $match)) {
            $WikiAns = trim(strip_tags($match[1]));
            $WikiAns = html_entity_decode($WikiAns);
        }
        if (!empty($WikiAns)) {
            $this->output = $WikiAns;
            return $this->output;
        }
    }

}

?>