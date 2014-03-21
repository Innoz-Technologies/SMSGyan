<?php

//$req = $spell_checked = $_GET["s"];
$obj = new NG_Jobs($req, $spell_checked);

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
    $to_logserver['source'] = 'NGjobs';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class NG_Jobs {

    public $return = array("result" => "");
    Public $jobName = "";

    function __construct($req, $spell_checked) {
        if (preg_match('~\bjobs?\b (.+)~si', $spell_checked, $matches)) {
            $this->findJob($matches[1]);
        } elseif (preg_match('~__NGJOBS__(.+)__(.+)__~si', $spell_checked, $matches)) {
//            var_dump($matches);
            $this->jobName = $matches[2];
            $this->getJobContent($matches[1]);
            
        }
    }

    function findJob($search) {
        $url = "http://www.jobberman.com/jobs-in-nigeria/?keywords=" . urlencode($search) . "&experience=&category=";
        $content = $this->httpGet($url);

        if (preg_match_all('~<div class="clear"></div><h2 style="width:400px;"><a href="(.+)".+>(.+)</a>~Usi', $content, $matches)) {
//            var_dump($matches);
            $this->return["result"] = "Your query matches more yhan one results";
            foreach ($matches[1] as $id => $value) {
                $job = $this->StripTags($matches[2][$id]);
                $this->return["options"][] = $job;
                $this->return["list"][] = array("content" => "__NGJOBS__" . $this->StripTags($value) . "__" . $job . "__");
            }
        }
    }

    function getJobContent($url) {
        $content = $this->httpGet($url);

        if (preg_match('~<div id="job-description".+>(.+)<br/><div class="clearfix">~Usi', $content, $matches)) {
            $out = $matches[1];
            $out = preg_replace('~<div style="display:none;">(.+)</div>~Usi', "", $out);
            $out = str_replace('<font size="2">', "***", $out);
            $out = strip_tags($out);
            $out = str_replace('******', "***", $out);
            $out = str_replace('***', "\n", $out);
            $this->return["result"] = $this->jobName . "\n$out";
        } elseif (preg_match_all('~<div class="clear"></div><h2 style="width:400px;"><a href="(.+)".+>(.+)</a>~Usi', $content, $matches)) {
//            var_dump($matches);
            $this->return["result"] = "Your query matches more yhan one results";
            foreach ($matches[1] as $id => $value) {
                $job = $this->StripTags($matches[2][$id]);
                $this->return["options"][] = $job;
                $this->return["list"][] = array("content" => "__NGJOBS__" . $this->StripTags($value) . "__" . $job . "__");
            }
        }
    }

    function StripTags($out) {

        $out = strip_tags($out);
        $out = trim(preg_replace("~[\s]+~", " ", $out));
        $out = str_ireplace("&#8230;", "", $out);
        $out = str_ireplace("&amp;", "&", $out);
        return $out;
    }

    function httpGet($url) {
        $curl = curl_init();
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: close";
        $header[] = "Accept-Charset: ISO-8859-1;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: ";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);

        $html = curl_exec($curl); // execute the curl command
        if (curl_error($curl)) {
            trigger_error(curl_error($curl), E_USER_WARNING);
        }
        curl_close($curl); // close the connection
        return $html; // and finally, return $html
    }

}

?>