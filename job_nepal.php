<?php

if (preg_match("~___job___nepal___(.+)___~Usi", $req, $match)) {

    echo "<h2>Inside job nepal</h2>";

    echo $url = "http://www.jobsnepal.com/jobs.php?" . trim($match[1]);
    $output = getContents($url);

    if (!empty($output)) {
        $total_return = $jobtitle . "\n" . $output;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'nepaljob';
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

    echo $url = "http://www.jobsnepal.com/index.php?method=SimpleJobSearch";
    echo $fields_string = "Keywords=$srch";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.jobsnepal.com", 'Referer: http://www.jobsnepal.com/index.php?method=SimpleJobSearch', "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2",
        "Content-Length: " . strlen($fields_string),
        "Cookie: PHPSESSID=vlbj408usmmd0047bhslapqnk2"));
    $result = curl_exec($ch);
    curl_close($ch);

    if (!empty($result)) {
        if (preg_match("~<b>Deadline</b></a></font>.+</td>(.+)</table>~Usi", $result, $match)) {

            if (preg_match_all("~<td.+>(.+)</td>~Usi", $match[1], $matches)) {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    $out[$i] = $matches[1][$i];
                    if (preg_match("~<a href=\"jobs.php\?(.+)\" class=\"joblist\">~Usi", $out[$i], $url)) {
                        $joburl[$i] = $url[1];
                    }
                    $out[$i] = trim(preg_replace("~[\s]+~", " ", $out[$i]));
                    $out[$i] = strip_tags($out[$i]);
                }
            }
        } else {
            $total_return = "No jobs found";
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
        if (!empty($out)) {
            $k = 0;
            for ($j = 0; $j < count($out); $j = $j + 6) {

                $job[$k] = $out[$j] . "," . $joburl[$j] . "\n";

                $k++;
            }
            if (count($job) == 1) {
                $jobs = explode(",", $job[0]);
                echo $jobtitle = $jobs[0] . "\n";
                echo $url_next = "http://www.jobsnepal.com/jobs.php?" . trim($jobs[1]);

                $output = getContents($url_next);

                if (!empty($output)) {
                    $total_return = $jobtitle . "\n" . $output;
                    $source_machine = $machine_id;
                    $current_file = "/temp/$numbers";
                    file_put_contents(DATA_PATH . $current_file, $total_return);
                    $to_logserver['source'] = 'nepaljob';
                    include 'allmanip.php';
                    putOutput($total_return);
                    exit();
                }
            } else {
                foreach ($job as $outopt) {
                    $outopt = explode(',', $outopt);
                    $options_list[] = trim($outopt[0]);
                    $list[] = array("content" => "___job___nepal___" . trim($outopt[1]) . "___");
                }

                var_dump($opt);
                var_dump($cont);

                $total_return = "Your query matches more than one result";

                if (!empty($total_return)) {
                    include 'allmanip.php';
                    putOutput($total_return);
                    exit();
                }
            }
        }
    } else {
        $total_return = "No jobs found";
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function getContents($url) {
    $contents = file_get_contents($url);

    if (preg_match("~<font face=\"Verdana\" size=\"2\"><b>Back</b></font></a></center>(.+)<!--start of right-->~Usi", $contents, $matches)) {
        $output = $matches[1];
        $output = trim(preg_replace("~[\s]+~", " ", $output));
        $output = trim(str_replace("</table>", "***", $output));
        $output = strip_tags($output);
        $output = trim(preg_replace("~[\s]+~", " ", $output));
        $output = trim(str_replace("***", "\n", $output));
        $output = html_entity_decode($output);
        echo $output;
    }
    return $output;
}

?>
