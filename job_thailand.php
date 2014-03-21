<?php

if (preg_match("~___job___thailand___(.+)___~Usi", $req, $match)) {
    echo $url_about = "http://th.jobsdb.com/TH/EN/Search/JobAdSingleDetail?jobsIdList=" . trim($match[1]) . "&sr=1";

    $data = getthaijob($url_about);


    if (!empty($data)) {
        $total_return = $data;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'jobsthai';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~^(find |show |get )?(some )?(jobs?\b.*)~", $req, $match) && !preg_match("~^\b(job tips|job tip)\b~", $spell_checked)) {
    var_dump($match);


    echo $srch = trim($match[3]);
    $srch = urlencode($match[3]);

    if ($srch != "job" || $srch != "jobs") {
        $srch = trim(preg_replace("~\b(jobs?)\b~", "", $srch));
    }



    echo $url = "http://th.jobsdb.com/TH/EN/Search/FindJobs?KeyOpt=COMPLEX&JSRV=1&RLRSF=1&JobCat=1&SearchFields=Positions,Companies&Key=$srch&Locations=1";
    $content = file_get_contents($url);

    if (preg_match_all('~<a class="posLink" href=".+jobsIdList=(.+)&sr=1" >(.+)</a>~Usi', $content, $match)) {
//    var_dump($match);

        if (count($match[1]) > 1) {
            $total_return = "Your query matches more than one result";
            for ($i = 0; $i < count($match[1]); $i++) {

                $options_list[] = trim(strip_tags(html_entity_decode($match[2][$i])));
                $list[] = array("content" => "___job___thailand___" . trim($match[1][$i]) . "___");
            }

            var_dump($options_list);
            var_dump($list);
        } else {
            $url_about = "http://th.jobsdb.com/TH/EN/Search/JobAdSingleDetail?jobsIdList=" . trim($match[1][0]) . "&sr=1";

            $data = getthaijob($url_about);

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
        $to_logserver['source'] = 'jobthai';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

function getthaijob($url) {
    echo $url;
    $content = file_get_contents($url);

    if (preg_match('~<td class="position">(.+)</td>~Usi', $content, $match)) {
        $pos = trim($match[1]);
    }
    if (preg_match('~<table width="100%" border="0" cellspacing="0" cellpadding="5".+>(.+)</font></td>~Usi', $content, $match)) {
        $details = trim($match[1]);
        $details = preg_replace('~[\s]+~', " ", $details);
        $details = str_replace('</strong></p>', "***", $details);
        $details = str_replace('</li>', "***", $details);
        $details = strip_tags($details);
        $details = preg_replace('~[\s]+~', " ", $details);
        $details = str_replace('***', "\n", $details);
    }
    if (preg_match('~<td class="Qualification">(.+)</table></td>~Usi', $content, $match)) {
        $qual = trim($match[1]);
        $qual = preg_replace('~[\s]+~', " ", $qual);
        $qual = strip_tags($qual);
    }
    echo $pos;
    if (!empty($pos) && !empty($details))
        return "$pos\n$details\n$qual";
    elseif (preg_match('~<div class="job-ad-job-title posName">(.+)<article class="job-ad-data jobSumWrap">~Usi', $content, $match)) {
        $details = trim($match[1]);
        if (strpos($content, '<span lang="TH">') !== FALSE)
            $details = "No details found";
        else {
            $details = preg_replace('~[\s]+~', " ", $details);
            $details = str_replace('</strong></p>', "***", $details);
            $details = str_replace('</li>', "***", $details);
            $details = strip_tags($details);
            $details = preg_replace('~[\s]+~', " ", $details);
            $details = str_replace('***', "\n", $details);
        }
        return $details;
    }else
        return "No details found";
}

?>
