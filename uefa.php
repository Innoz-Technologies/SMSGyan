<?php

if (preg_match("~__uefa__(.+)__~", $req, $match)) {
    echo $spell_checked = "uefa " . $match[1];
}

if (strpos($spell_checked, "uefa") !== false) {

    $url = "http://www.uefa.com/uefachampionsleague/season=2012/matches/round=2000266/index.html";
    $content = file_get_contents($url);
    $uefa_result = '';
    $uefa_fixture = '';
    $uefa_return = '';

    preg_match_all("~<div class=\"sup-left l\"><span class=\"b dateT\">(.+)</td></tr><tr class=\"hide\">~Usi", $content, $match);
//var_dump($match);
//serialize($match[0]);
    $uefa_return = '';

    if (!empty($match[0])) {
        foreach ($match[0] as $val) {
            $out = preg_replace("~</span><span class=\"sep\">-(.+)</a></span></div></td></tr>~", "", $val);
            $out = preg_replace("~<caption>(.+)</caption>~", "", $out);
            $out = preg_replace("~<span class=\"hide\">(.+)</span>~Usi", "", $out);
            $out = preg_replace("~<tr class=\"referee_stadium\" id=\"rs.+>~Usi", "***", $out);
            $out = str_replace("&#8211;", "***", $out);
            $out = str_replace("</span>", " ", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace("***", "\n", $out);
            $out = str_replace("- UEFA Champions League, Round of 16 More &raquo;", "", $out);
            $out = str_replace("More", "\n", $out);
            $out = str_replace("Aggregate:", "\nAggregate:", $out);
            if (strpos($out, "Referee: TBD")) {
                $out = str_replace("\nReferee: TBD", "", $out);
                $uefa_fixture .= str_replace("\n ", "\n", $out) . "\n";
            } else {
                $uefa_result .= str_replace("\n ", "\n", $out) . "\n";
            }
        }
    }
    
    $url = "http://www.uefa.com/uefachampionsleague/season=2012/matches/round=2000267/index.html";
    $content = file_get_contents($url);

    preg_match_all("~<div class=\"sup-left l\"><span class=\"b dateT\">(.+)</td></tr><tr class=\"hide\">~Usi", $content, $match);

    if (!empty($match[0])) {
        foreach ($match[0] as $val) {
            $out = preg_replace("~</span><span class=\"sep\">-(.+)</a></span></div></td></tr>~", "", $val);
            $out = preg_replace("~<caption>(.+)</caption>~", "", $out);
            $out = preg_replace("~<span class=\"hide\">(.+)</span>~Usi", "", $out);
            $out = preg_replace("~<tr class=\"referee_stadium\" id=\"rs.+>~Usi", "***", $out);
            $out = str_replace("&#8211;", "***", $out);
            $out = str_replace("</span>", " ", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace("***", "\n", $out);
            $out = str_replace("- UEFA Champions League, Round of 16 More &raquo;", "", $out);
            $out = str_replace("More", "\n", $out);
            if (strpos($out, "Referee: TBD")) {
                $out = str_replace("\nReferee: TBD", "", $out);
                $uefa_fixture .= str_replace("\n ", "\n", $out) . "\n";
            } else {
                $uefa_result .= str_replace("\n ", "\n", $out) . "\n";
            }
        }

//        if (strpos($spell_checked, "result") !== false) {
//            $uefa_return = "UEFA Champions League Result\n" . $uefa_result;
//            $options_list[] = "uefa fixtures";
//            $list[] = array("content" => "__uefa__fixtures__");
//        } elseif (strpos($spell_checked, "fixture") !== false) {
//            $uefa_return = "UEFA Champions League Fixture\n" . $uefa_fixture;
//            $options_list[] = "uefa result";
//            $list[] = array("content" => "__uefa__result__");
//        } else {
        $uefa_return = "UEFA Champions League Result and Fixture\n" . $uefa_result . $uefa_fixture;
//            $options_list[] = "uefa fixtures";
//            $list[] = array("content" => "__uefa__fixture__");
//            $options_list[] = "uefa result";
//            $list[] = array("content" => "__uefa__result__");
//        }
    }

    if ($uefa_return) {
        $total_return = $uefa_return;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'uefa';
        putOutput($total_return);
        exit();
    }
}
?>