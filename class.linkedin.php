<?php

class linkedin {

    private $url;
    public $about;

    function __construct($url) {
        $this->url = $url;
    }

    function getabout() {

        echo "<h2>LINKEDIN PROFILE</h2>";
        $linkedin_return = "";
        $content = file_get_contents($this->url);
        $content = preg_replace("~<a href=\"https://www.linkedin.com/reg/join-pprofile?.+rel=\"nofollow\">(.+)</a>~Usi", "", $content);

        
        $content = preg_replace("~<div class=\"content\">(.+)</div>~Usi", "", $content);
        
       $content = preg_replace('~<p id="show-expanded" class="actions ">(.+)</p>~Usi', "", $content);
//        $content = preg_replace("~<div class=\"join-linkedin\">(.+)<p class=\"actions\">~Usi", "", $content);
        $content = preg_replace("~<div id=\"nprofile-overview\" class=\"join-linkedin name-button\">(.+)<p id=\"show-expanded\" class=\"actions.+\">~Usi", "", $content);
        $content = preg_replace("~<script id=\".+\" type=\"linkedin/control\" class=\"li-control\">(.+)</script>~Usi", "", $content);

//        $content = preg_replace("~<p id=\"show-expanded\" class=\"actions.+\">(.+)</p>~Usi", "", $content);

//        $content = preg_replace("~<a class=\"btn-action\" id=\"regform-show\" href=\"https://www.linkedin.com/reg/join-pprofile?.+rel=\"nofollow\">(.+)</a>~Usi", "", $content);

        preg_match("~<div id=\"content\" class=\"resume hresume\">(.+)<div id=\"extra\">~Usi", $content, $match);
        preg_match("~ <img src=\"(.+)\" class=\"photo\" width=\"100\" height=\"100\".+>~Usi", $content, $image);
        if (!empty($image)) {
            $plinkedin_url = $image[1];
        }

        preg_match("~<div id=\"member-1\" class=\"masthead vcard contact\">(.+)<h2 class=\"section-title\">~Usi", $match[1], $match_main);

        if (!empty($match_main)) {
            $main = $match_main[1];
            $main = trim(preg_replace('~<dt>|</li>|</h2>|<h2 class="section-title">|<p class="headline-title title" style="display:block">~', "***", $main));
            $main = trim(str_replace('</dt>', ":", $main));
            $main = trim(preg_replace('~\bsee|less|all\b~', "", $main));

            $desc = $main = strip_tags($main);
            $desc = trim(str_replace("***", ",", $desc));
            $desc = trim(preg_replace("~[\s]+~", " ", $desc));

            $main = trim(str_replace('View Full Profile', "", $main));
//        echo "<h1> $main</h1>";
            $linkedin_return .= $main . "\n";
        }

        preg_match("~<h2 class=\"section-title\">(.+)<dt id=\"overview-summary-education-title.+>~Usi", $match[1], $match_main);

        if (!empty($match_main)) {
            $main = $match_main[0];
            $main = trim(preg_replace('~<dt>|</li>|</h2>|<h2 class="section-title">|<p class="headline-title title" style="display:block">~', "***", $main));
            $main = trim(str_replace('</dt>', ":", $main));
            $main = trim(preg_replace('~\bsee|less|all\b~', "", $main));

            $main = strip_tags($main);
            $linkedin_return .= $main . "\n";
        }
        preg_match("~<div class=\"section subsection-reorder summary-education.+>(.+)<div class=\"section\" id=\"profile-additional.+>~Us", $match[1], $match_h3);

        if (!empty($match_h3)) {
            $h1 = $match_h3[1];
//        echo serialize($h1);
            $h1 = trim(preg_replace('~<br> <br>|</h2>|<h3>|<\h3>|<h2>|<span class="title">|\*|<em>|<h3 class="summary fn org">~', "***", $h1));
            $h1 = trim(preg_replace('~</h3>~', ":", $h1));
            $h1 = strip_tags($h1) . "\n";

            $linkedin_return.=$h1 . "\n";
        }

        preg_match("~<div class=\"section\" id=\"profile-summary\" style=\"display:block\">(.+)<div class=\"section subsection-reorder\" id=\"profile-experience\" style=\"display:block\">~Usi", $match[1], $match_h1);

        if (!empty($match_h1)) {
            $h1 = $match_h1[1];
            $h1 = trim(preg_replace('~<br> <br>|</h2>|<h3>|<\h3>|<h2>|<span class="title">|\*|<em>|<h3 class="summary fn org">~', "***", $h1));
            $h1 = trim(preg_replace('~</h3>~', ":", $h1));
            $h1 = strip_tags($h1) . "\n";

            $linkedin_return.=$h1 . "\n";
        }

        preg_match("~<div class=\"section subsection-reorder\" id=\"profile-experience\" style=\"display:block\">(.+)<div class=\"section subsection-reorder summary-education\" id=\"profile-education\" style=\"display:block\">~Usi", $match[1], $match_h2);

//    var_dump($match_h2);
        if (!empty($match_h2)) {
            $h1 = $match_h2[1];
            $h1 = trim(preg_replace('~<br> <br>|</h2>|<h3>|<\h3>|<h2>|<span class="title">|\*|<em>|<h3 class="summary fn org">~', "***", $h1));
            $h1 = trim(preg_replace('~</h3>~', ":", $h1));
            $h1 = strip_tags($h1) . "\n";

            $linkedin_return.=$h1 . "\n";
        }

        $linkedin_return = trim(str_replace('&#8211;', "-", $linkedin_return));
        $linkedin_return = trim(str_replace('&#x2013;', "", $linkedin_return));
        $linkedin_return = trim(str_replace('&#x2019;', "", $linkedin_return));
        $linkedin_return = trim(str_replace('&amp;', "", $linkedin_return));
        $linkedin_return = trim(str_replace(';', ",", $linkedin_return));
        $linkedin_return = trim(preg_replace("~[\s]+~", " ", $linkedin_return));
        $linkedin_return = trim(str_replace("***", "\n", $linkedin_return));
        $linkedin_return = str_replace("View full profile", "", $linkedin_return);
        $linkedin_return = str_replace("\n ", "\n", $linkedin_return);

        $this->about = $linkedin_return;
        return $this->about;
    }

}

?>