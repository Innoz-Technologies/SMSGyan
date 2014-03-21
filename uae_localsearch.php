<?php

//include 'uae_restaurant.php';
//JOB search for UAE
$time_start = microtime(true);
if (preg_match("~^(suppliers?|contractors?|hotels?|restaurants?) ?(.+)?~", $req, $match)) {
    echo "MATCHED QUERY $req<br>";

    //var_dump($match);

    $rest_keyword = "";
    $sup_key_word = $match[1];
    if (isset($match[2]))
        $rest_keyword = $match[2];

    if (trim($rest_keyword) == "help") {
        $total_return = "To use this service SMS contractor/supplier/restaurant <name> in <place> to $shortcode\n";
        $total_return.= "Example restaurant aden in sharjah\n";
    } else {
        $sup_name = trim($rest_keyword);
        $sup_place = "uae";
        $sup_name = "";
        if (preg_match("~(.*) (in|at|near) (.+)~", $rest_keyword, $matches)) {
            $sup_name = $matches[1];
            $sup_place = $matches[3];
        }

        if ($sup_name == "") {
            $sup_name = $sup_key_word;
        }

        $sup_place = str_replace(" ", "-", $sup_place);
        $sup_name = str_replace(" ", "-", $sup_name);

        echo "KEYWORD $sup_key_word SUPNAME $sup_name SUPLOC $sup_place <br>";
        $root_site = "http://www.yellowpages-uae.com/";
        $ext_site = "search/$sup_place/$sup_name";

        echo "url<br>" . $url = "$root_site$ext_site";

        $content = file_get_contents($url);

        $arrResult = array();
        if ($content) {
            if (preg_match_all('~<a Class="head"(.+)>(.+)</a>~Usi', $content, $match1)) {
                foreach ($match1[2] as $valueT) {
                    $arrResult['title'][] = $valueT;
                }
            }

            if (preg_match_all('~<div class="other_info">(.+)</ul></div>~Usi', $content, $match2)) {
                foreach ($match2[1] as $valueO) {
                    $arrResult['other'][] = strip_tags(str_replace("</li>", "\n", str_replace("</span>", " ", $valueO)));
                }
            }
        }

        var_dump($arrResult);
        if (!empty($arrResult)) {
            $total_return = "Your query found following results\n";
            foreach ($arrResult['title'] as $key => $value) {
                $total_return.= $arrResult['title'][$key] . "\n";
                $total_return.= $arrResult['other'][$key] . "\n";
            }
        }
    }
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'uaesup';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
