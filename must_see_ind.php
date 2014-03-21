<?php

//$q = $_GET["q"];
//$url = "http://www.mustseeindia.com/$q";
//$content = file_get_contents($url);

$content = $city_in;
$city_return = '';
$out = '';
if (!empty($content)) {
    preg_match_all("~<td class=\"td-title-sm-pl\">(.+)<div class=\"sep10\"></div>~Usi", $content, $match);
//    echo serialize($match[1]);
//    var_dump($match[1][0]);
    if (!empty($match[1])) {
        $out = $match[1][0];
        $out = preg_replace('~<td class="td-pl">|<br>~', "***", $out);
        $out = strip_tags($out);
        $out = str_replace("More details coming soon. Stay tuned!", "", $out);
        $out = str_replace("Fast Facts", "", $out);
        $out = str_replace("Â", "", $out);
        $out = str_replace("â€™", "'", $out);
        $out = preg_replace("~[\s]+~", " ", $out);
        $out = str_replace("***", "\n", $out);
        $out = str_replace("\n ", "\n", $out);
        $out = str_replace("\n\n", "\n", $out);
    }
    if (!empty($out)) {
        $city_return = ucfirst($city_name) . $out;
        echo $city_return;
    }
    if (!empty($city_return)) {
        $files = DATA_PATH . "/city/$global_id";
        echo file_get_contents("http://" . $private_ip[$machine] . "/storage/write.php?file=" . urlencode("/city/$global_id") . "&content=" . urlencode($city_return));
//        file_put_contents($files, $city_return);
        echo "<br>_####_file is: $files<br>";
    }
}
?>