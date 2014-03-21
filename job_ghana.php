<?php

if (preg_match("~^(find |show |get )?(some )?(jobs?\b.*)~", $req, $match) && !preg_match("~^\b(job tips|job tip)\b~", $spell_checked)) {

    echo $srch = trim($match[3]);
    $srch = urlencode($match[3]);

    if ($srch != "job" || $srch != "jobs") {
        $srch = trim(preg_replace("~\b(jobs?)\b~", "", $srch));
    }

    $url = "http://www.jobberman.com.gh/jobs-in-ghana/?keywords=" . urlencode($srch);
    $content = httpGet($url);

    if (preg_match_all('~<a href="http://www.jobberman.com.gh/job/(.+)/".+title="(.+)".+>~Usi', $content, $match)) {

        if (count($match[1]) > 1) {
            $total_return = "Your query matches more than one result";
            for ($i = 0; $i < count($match[1]); $i++) {
                $link = trim(strip_tags($match[1][$i]));

                $jobname = trim(strip_tags($match[2][$i]));
                $jobname = str_replace("job in Ghana", "", $jobname);

                $options_list[] = $jobname;
                $list[] = array("content" => "___job___ghana___" . $link . "___");
            }
        }
    } else {
        $total_return = "No matches found for your query";
    }
} elseif (preg_match('~___job___ghana___(.+)___~', $req, $match)) {

    $url_next = "http://www.jobberman.com.gh/job/" . trim($match[1]);
    $content = httpGet($url_next);


    if (preg_match('~<!-- #apply-online -->(.+)</div><br/>~Usi', $content, $match)) {
//    var_dump($match);

        $data = $match[1];
        $data = preg_replace("~[\s]+~", " ", $data);
        $data = preg_replace("~<div style=\"display:none;\">(.+)</div>~Usi", "", $data);
        $data = str_replace("<span class=\"span2\">", "***", $data);
        $data = str_replace("</strong>", ": ", $data);
        $data = str_replace("&nbsp;", "", $data);
        $data = str_replace("<span style=\"font-size: 1.2em; line-height: 1.5;\">", ".", $data);
        $data = str_replace("cmVtb3RlX2FkZHJlc3MgPSAxNzMuMjU1LjIxNC4xNjE=", ".", $data);
        $data = strip_tags($data);
        $data = str_replace("***", "\n", $data);
        echo $data;

        $total_return = $data;
    } else {
        $total_return = "No additional info found";
    }
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'jobghana';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
