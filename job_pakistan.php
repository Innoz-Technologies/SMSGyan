<?php

if (preg_match("~^(find |show |get )?(some )?(jobs?\b.*)~", $req, $match) && !preg_match("~^\b(job tips|job tip)\b~", $spell_checked)) {
    var_dump($match);


    echo $srch = trim($match[3]);
    $srch = urlencode($match[3]);

    if ($srch != "job" || $srch != "jobs") {
        $srch = trim(preg_replace("~\b(jobs?)\b~", "", $srch));
    }

    $result = getjoblinkpak($srch);
    if (!empty($result)) {
        if (preg_match_all('~<a href="/job/(.+)/">(.+)</a>~', $result, $match)) {
            if (count($match[1]) > 1) {
                $total_return = "You query matches more than one result";
                for ($i = 0; $i < count($match[1]); $i++) {
                    $options_list[] = trim($match[2][$i]);
                    $list[] = array("content" => "__job__pak__" . trim($match[1][$i]) . "__");
                }
            } else {
                $link = "http://www.mustakbil.com/job/" . trim($match[1][0]);
                $details = getjobdetailspak($link);
                if (!empty($details)) {
                    $total_return = $details;
                }
            }
        }
    }
} elseif (preg_match('~__job__pak__(.+)__~', $req, $match)) {
    $link = "http://www.mustakbil.com/job/" . trim($match[1]);
    $details = getjobdetailspak($link);
    if (!empty($details)) {
        $total_return = $details;
    } else {
        $total_return = "No jobs found";
        $to_logserver['isresult'] = 0;
    }
}
if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'pak_job';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function getjoblinkpak($srch) {
    $url = "http://www.mustakbil.com/jobs/search";
    $fields_string = "Keywords=$srch&Location=";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.mustakbil.com", 'Referer: http://www.mustakbil.com/jobs/search'));
    $result = curl_exec($ch);
    curl_close($ch);

    //echo $result;
    return $result;
}

function getjobdetailspak($link) {
    //$url = "http://www.mustakbil.com/job/86549/";
    $content = file_get_contents($link);

    if (preg_match('~<h2 class="JobDetailsLabel">(.+)<div class="Footer">~Usi', $content, $match)) {
        $data = $match[1];
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = preg_replace('~<script type="text/javascript">(.+)</script>~Usi', "", $data);
        $data = preg_replace('~<script type="text/javascript"(.+)</script>~Usi', "", $data);
        $data = preg_replace("~<script type='text/javascript'>(.+)</script>~Usi", "", $data);
        $data = str_replace('</h2>', '***', $data);
        $data = str_replace('</li>', '***', $data);
        $data = str_replace('</span>', '+++', $data);
        $data = strip_tags($data);
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace('+++', ' ', $data);
        $data = str_replace('***', "\n", $data);
        $data = str_replace(' (read more) ', "", $data);
        echo $data;
    }
    return $data;
}

?>
