<?php

if (preg_match("~__showtime__(.+)_(.+)__~Usi", $req, $matches)) {
    $url = "http://www.nowrunning.com" . $matches[1];
    $content = file_get_contents($url);
    $total_return = $matches[2] . "\n";
    $total_return .= showtimes($content);

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'showtime';
        putOutput($total_return);
        exit();
    }
}

function showtimes($contents) {
    preg_match("~<div id=\"ctl00_ContentPlaceHolder_Middle_ShowtimesPanel\" class=\"Showtime\">(.+)</div><br />~Usi", $contents, $match_cin);
    $match_cin[0] = preg_replace("~<td style=\"width:90px;text-align:center;vertical-align:top;\">(.+)<span id=\"ctl00_ContentPlaceHolder_Middle_.+_showtimeDate.+>~Usi", "", $match_cin[0]);
    $match_cin[0] = trim(preg_replace("~[\s]+~", " ", $match_cin[0]));
    $match_cin[0] = trim(str_replace("</td> </tr>", "***", $match_cin[0]));
    $match_cin[0] = trim(strip_tags($match_cin[0]));
    $match_cin[0] = trim(preg_replace("~[\s]+~", " ", $match_cin[0]));
    $match_cin[0] = trim(str_replace("***", "\n", $match_cin[0]));
    $match_cin[0] = trim(str_replace("&nbsp;", "", $match_cin[0]));
    $match_cin[0] = trim(str_replace("\n ", "\n", $match_cin[0]));
    $match_cin[0] = trim(str_replace("\n\n", "\n", $match_cin[0]));
    return $match_cin[0];
}

?>
