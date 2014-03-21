<?php

echo '<h1>bing</h1>';
if ($isSearch) {

    $cur_city = $circle_city;
    include 'local_citycheck.php';

    echo $search = urlencode($search_it);
    $cplace = urlencode($cur_city);
    if (!empty($search)) {
        $url = "http://www.bing.com/local/default.aspx?what=$search&where=$cplace&ac=False&start=0&mkt=en-IN&FORM=LLSV";
        echo "<br><h2>TIME after bing local:" . (microtime(TRUE) - $time_start) . "</h2><br>";
        $local_cir_in = file_get_contents($url);
    }
}

//echo $local_cir_in;
//echo "<h1>bing result is : </h1>" . $local_cir_in;
if (!empty($local_cir_in)) {
    if (strpos($local_cir_in, "sritem_ec2_lblPin")) {
        if (preg_match("~sritem_ec2_nameControl\" class=\"ecHeaderLink\" href=\"/local/details.aspx\?lid=.+\">(.*)</a>~Usi", $local_cir_in, $match)) {

            $search_item = $match[1];
            echo $search_item = trim(strip_tags($search_item));

            echo '<br> seaching in bing';
            $options_list[] = "locate $search_item near $cur_city";
            $list[] = array("content" => "__local__srch__" . $search_it . "_" . $cur_city . "__");
            var_dump($options_list);
        }
    }
}
?>
