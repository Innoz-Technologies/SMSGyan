<?php

$content = file_get_contents('http://www.tennis.com/livescores/index.aspx');
$wimfinal = array();
$menout = '';
$womenout = '';
$menfinished = "";
$mennotstarted = "";
$wommennotstarted = "";
$womenfinished = "";
if (preg_match("~<span class=\"cup\">Wimbledon \(Men's\)(.+)<div class=\"results\">~Usi", $content, $resultmen)) {
    if (preg_match_all("~<td class=\"status\">In progress</td>(.+)</div>~Usi", $resultmen[1], $progress)) {
        foreach ($progress[1] as $prog) {
            $out = $prog;
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('<td class="scores">', "***", $out);
            $out = str_replace('<td class="icons">', "***", $out);
            $out = str_replace('</tr>', "***", $out);
            $out = preg_replace('~<td class="standing">(.+)<td class="player">~Usi', "", $out);
            $out = preg_replace('~<sup>.+</sup>~Usi', "", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('***', "\n", $out);
            $out = str_replace('+++', "", $out);
            $out = str_replace("\n ", "\n", $out);
            $out = str_replace("\n\n", "\n", $out);
            $out = str_replace("\n\r", "\n", $out);
            $menout.=$out;
        }
//        "Mens In Progress:" . $menout;
    }
    if (preg_match_all("~<td class=\"status\">Has not started</td>(.+)</div>~Usi", $resultmen[1], $progress)) {
        foreach ($progress[1] as $prog) {
            $out = $prog;
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('</tr>', "***", $out);
            $out = preg_replace('~<sup>.+</sup>~Usi', "", $out);
            $out = preg_replace('~<td class="score">(.+)</td>~Usi', "", $out);
            $out = str_replace('<td class="scores">', "-----------", $out);
            $out = preg_replace('~<td class="standing">(.+)<td class="player">~Usi', "", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('***', "\n", $out);
            $out = str_replace('+++', "", $out);
            $out = str_replace("\n ", "\n", $out);
            $out = str_replace("\n\n", "\n", $out);
            $mennotstarted.=$out;
        }
//        "Mens Not Started:" . $mennotstarted;
    }
    if (preg_match_all("~<td class=\"status\">Finished</td>(.+)</div>~Usi", $resultmen[1], $progress)) {
        foreach ($progress[1] as $prog) {
            $out = $prog;
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('<td class="scores">', "***", $out);
            $out = str_replace('<td class="icons">', "***", $out);
            $out = str_replace('</tr>', "***", $out);
            $out = preg_replace('~<td class="standing">(.+)<td class="player">~Usi', "", $out);
            $out = preg_replace('~<sup>.+</sup>~Usi', "", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('***', "\n", $out);
            $out = str_replace('+++', "", $out);
            $out = str_replace("\n ", "\n", $out);
            $out = str_replace("\n\n", "\n", $out);
            $out = str_replace("\n\r", "\n", $out);
            $menfinished.=$out;
        }
//        "Mens Finished:" . $menfinished;
    }
    $wimfinal[] = $menout . $mennotstarted . $menfinished;
}

if (preg_match("~<span class=\"cup\">Wimbledon WTA \(Women's\)(.+)<div class=\"results\">~Usi", $content, $resultwomen)) {
    if (preg_match_all("~<td class=\"status\">In progress</td>(.+)</div>~Usi", $resultwomen[1], $progress)) {
        foreach ($progress[1] as $prog) {
            $out_women = $prog;
            $out_women = trim(preg_replace("~[\s]+~", " ", $out_women));
            $out_women = str_replace('<td class="scores">', "***", $out_women);
            $out_women = str_replace('<td class="icons">', "***", $out_women);
            $out_women = str_replace('</tr>', "***", $out_women);
            $out_women = preg_replace('~<td class="standing">(.+)<td class="player">~Usi', "", $out_women);
            $out_women = preg_replace('~<sup>.+</sup>~Usi', "", $out_women);
            $out_women = strip_tags($out_women);
            $out_women = trim(preg_replace("~[\s]+~", " ", $out_women));
            $out_women = str_replace('***', "\n", $out_women);
            $out_women = str_replace('+++', "", $out_women);
            $out_women = str_replace("\n ", "\n", $out_women);
            $out_women = str_replace("\n\n", "\n", $out_women);
            $out_women = str_replace("\n\r", "\n", $out_women);
            $womenout.=$out_women;
        }
        "Womens In Progress:" . $womenout;
    }
    if (preg_match_all("~<td class=\"status\">Has not started</td>(.+)</div>~Usi", $resultwomen[1], $progress)) {
        foreach ($progress[1] as $prog) {
            $out = $prog;
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('</tr>', "***", $out);
            $out = str_replace('<td class="scores">', "\n-----------", $out);
            $out = preg_replace('~<td class="score">(.+)</td>~Usi', "", $out);
            $out = preg_replace('~<td class="standing">(.+)<td class="player">~Usi', "", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('***', "\n", $out);
            $out = str_replace('+++', "", $out);
            $out = str_replace("\n ", "\n", $out);
            $out = str_replace("\n\n", "\n", $out);
            $wommennotstarted.=$out;
        }
        "Womens Not Started:" . $wommennotstarted;
    }

    if (preg_match_all("~<td class=\"status\">Finished</td>(.+)</div>~Usi", $resultwomen[1], $progress)) {
        foreach ($progress[1] as $prog) {
            $out = $prog;
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('<td class="scores">', "***", $out);
            $out = str_replace('<td class="icons">', "***", $out);
            $out = str_replace('</tr>', "***", $out);
            $out = preg_replace('~<td class="standing">(.+)<td class="player">~Usi', "", $out);
            $out = preg_replace('~<sup>.+</sup>~Usi', "", $out);
            $out = strip_tags($out);
            $out = trim(preg_replace("~[\s]+~", " ", $out));
            $out = str_replace('***', "\n", $out);
            $out = str_replace('+++', "", $out);
            $out = str_replace("\n ", "\n", $out);
            $out = str_replace("\n\n", "\n", $out);
            $out = str_replace("\n\r", "\n", $out);
            $womenfinished.=$out;
        }
        "Womens Finished:" . $womenfinished;
    }
    $wimfinal[] = $womenout . $wommennotstarted . $womenfinished;
}
if (!empty($wimfinal)) {
    echo serialize($wimfinal);
}
?>