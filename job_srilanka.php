<?php

if (preg_match("~___job___srilanka___(.+)___~Usi", $req, $match)) {
    echo $url_about = "http://www.bayt.com/" . trim($match[1]);

    $data = getsrilankajob($url_about);


    if (!empty($data)) {
        $total_return = $data;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'jobsrilanka';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~^(find |show |get )?(some )?(jobs?\b.*)~", $req, $match) && !preg_match("~^\b(job tips|job tip)\b~", $spell_checked)) {
    var_dump($match);


    echo $srch = trim($match[3]);
    $srch = urlencode($match[3]);

    if ($srch != "job" || $srch != "jobs") {
        $srch = trim(preg_replace("~\b(jobs?)\b~", "", $srch));
    }

    echo $url = "http://www.bayt.com/en/job-search-results/?composite_search=1&jb_loc_list=lk%2C0%2C0&keyword=$srch";
    $content = file_get_contents($url);

    if (preg_match_all('~<h4 class="jb-row-title"><a href="(.+)" onmousedown=".+">(.+)</a>.+</h4>~Usi', $content, $match)) {
//    var_dump($match);

        if (count($match[1]) > 1) {
            $total_return = "Your query matches more than one result";
            for ($i = 0; $i < count($match[1]); $i++) {
                $options_list[] = trim(strip_tags($match[2][$i]));
//                $list[] = $match[1][$i];

                $list[] = array("content" => "___job___srilanka___" . trim($match[1][$i]) . "___");
            }

            var_dump($options_list);
            var_dump($list);
        } else {
            $url_about = "http://www.bayt.com/" . trim($match[1][0]);

            $data = getsrilankajob($url_about);

            if (!empty($data)) {
                $total_return = $data;
                $source_machine = $machine_id;
                $current_file = "/temp/$numbers";
                file_put_contents(DATA_PATH . $current_file, $total_return);
                include 'allmanip.php';
                $to_logserver['source'] = 'jobsrilanka';
                putOutput($total_return);
                exit();
            }
        }
    } else {
        $total_return = "Sorry, we found no jobs matching your search criteria";
        $to_logserver['isresult'] = 0;
    }

    if (!empty($total_return)) {
        $to_logserver['source'] = 'jobsrilanka';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function getsrilankajob($url) {

    echo "<h2> inside job sri lanks</h2>";
    $content = httpGet($url);

    if (preg_match('~<div class="head">(.+)</div>~Usi', $content, $matched)) {
        $title = $matched[1];
        $title = trim(preg_replace("~[\s]+~", " ", $title));
        $title = trim(str_replace("</h1>", "***", $title));
        $title = trim(str_replace("</h2>", "***", $title));
        $title = strip_tags($title);
        $title = trim(preg_replace("~[\s]+~", " ", $title));
        $title = trim(str_replace("***", "\n", $title));
        $title = trim(str_replace("\n ", "\n", $title));
    }


    if (preg_match('~<div style="padding: 15px;" class="lightgrey_box">(.+)<span class="clear">~Usi', $content, $matches)) {
        $out = $matches[1];
        $out = trim(preg_replace("~[\s]+~", " ", $out));
        $out = trim(str_replace("</dd>", "***", $out));
        $out = strip_tags($out);
        $out = trim(preg_replace("~[\s]+~", " ", $out));
        $out = trim(str_replace("***", "\n", $out));
        $out = trim(str_replace("\n ", "\n", $out));
    }
    if (!empty($title))
        return $title . "\n" . $out;
    else
        return $out;
}

?>
