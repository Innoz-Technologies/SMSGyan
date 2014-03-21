<?php

if (preg_match("~__ileague__(.+)__~", $req, $match)) {
    echo $spell_checked = "ileague " . $match[1];
}


if (preg_match("~\b(ileague|i-league|indian league|i league)\b~", $spell_checked)) {
    $total_return = '';

    $content = file_get_contents("http://fussball.wettpoint.com/en/league/i-league-india.html");

    if (strpos($spell_checked, 'fixture') !== false) {
        preg_match("~<table summary=\"I-League Schedules India\">(.+)</table>~Usi", $content, $match);

        $out = '';

        if (!empty($match[1])) {
            $out = $match[1];
            $out = preg_replace("~<td width=\"120px\">~", "***", $out);
            $out = preg_replace("~<td class=\"sps1\">~", "***", $out);
            $out = preg_replace("~<a href=\"http://fussball.wettpoint.com/en/goals.+>(.+)</a>~Usi", "", $out);
            $out = preg_replace("~<a href=\"http://fussball.wettpoint.com/en/h2hstats.+>(.+)</a>~Usi", "", $out);
            $out = preg_replace("~<a href=\"http://fussball.wettpoint.com/en/h2h/.+>(.+)</a>~Usi", "", $out);
            $out = trim(strip_tags($out));
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = trim(str_replace("***", "\n", $out));
            $out = str_replace("\n ", "\n", $out);
            $out = clean($out);
        }
        
        if (!empty($out)) {
            echo $total_return = "I-League Fixtures \n$out";
            $options_list[] = "ileague results";
            $list[] = array("content" => "__ileague__results__");
        }
    }

    if ((strpos($spell_checked, 'result') !== false) || empty($total_return)) {
        preg_match("~<table summary=\"I-League Results India\">(.+)</table>~Usi", $content, $match);

//        echo serialize($match[1]);
        if (!empty($match[1])) {
            $out = $match[1][0];
            $out = $match[1];
            $out = preg_replace("~<td width=\"120px\">~", "***", $out);
            $out = preg_replace("~</td><td class=\"sps1\">~", " ", $out);
            $out = preg_replace("~</b>&nbsp;(.+)</tr>~Usi", "", $out);
            $out = trim(strip_tags($out));
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = trim(str_replace("***", "\n", $out));
            $out = str_replace("\n ", "\n", $out);
            $out = clean($out);
        }
        if (!empty($out)) {
            echo $total_return .= "I-League Results \n$out";
            $options_list[] = "ileague fixtures";
            $list[] = array("content" => "__ileague__fixtures__");
        }
    }
}
if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    include 'allmanip.php';
    $to_logserver['source'] = 'ileague';
    putOutput($total_return);
    exit();
}
?>
