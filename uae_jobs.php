<?php

//JOB search for UAE
$time_start = microtime(true);
if (preg_match("~^(find |show |get )?(some )?(jobs?\b.*)~", $req, $match) && !preg_match("~^\b(job tips|job tip)\b~", $spell_checked)) {
//    if (is_numeric($numbers)) {
        $UAElocs['Dubai'] = array("dubai", "dbai", "dubia");
        $UAElocs['Abu-Dhabi'] = array("abudhabi", "abu dhabi", "abubhabi", "abu bhabi");
        $UAElocs['Ajman'] = array("ajman", "ajmn");
        $UAElocs['Al-Ain'] = array("alain", "al ain");
        $UAElocs['Fujairah'] = array("fujairah", "fujaira", "fujeira", "fujeirah");
        $UAElocs['Ras-Al-Khaimah'] = array("ras al khaimah", "rasalkhaimah", "ras al khaima", "rasalkhaima");
        $UAElocs['Sharjah'] = array("sharjah", "sharja", "sherjah", "sherja");
        $UAElocs['Umm-Al-Quwain'] = array("umm al quwain", "ummalquwain", "umm al quwin", "ummalquwin");

        $job_title = "-";
        $job_loc = "";

        $req_job = $match[3];
        //echo "REQUEST $req_job<br>";
        if (preg_match("~jobs? (.*) (in|at|near) (.+)~", $req_job, $matches)) {
            $job_title = $matches[1];
            $job_loc.="$matches[3]";

            $job_head = "$job_title at $job_loc";
        } elseif (preg_match("~jobs? (.*)~", $req_job, $matches)) {
            $job_title = $matches[1];
            $job_head = $job_title;
        }
        $job_title = str_replace(" ", "-", $job_title);

        //echo "JOB $job_title at $job_loc<br>";
        foreach ($UAElocs as $key => $value) {

            $tmp = in_array($job_loc, $UAElocs[$key]);
            //echo "KEY $key TMP $tmp<br>";
            if ($tmp === true) {
                //echo "FOUND<br>";
                $job_loc = $key;
                break;
            }
            //var_dump($value);
            //echo "<br>$job_loc<br>";
        }
        if ($job_loc == "") {
            $job_loc = "UAE";
        } else {
            $job_loc = "UAE-" . $job_loc;
        }
        //var_dump($UAElocs);


        $root_site = "http://gnads4u.com/";
        $ext_site = "jobs/-/$job_loc/$job_title/Available/-/50000";

        //echo "<h2>URL $ext_site</h2>";
        //echo "SITE: $root_site$ext_site<br>";

        $url = "$root_site$ext_site";

        $content = file_get_contents($url);

        if ($content) {
            if (preg_match_all('~<span class="orange-title-sr">(.+)</span>~Usi', $content, $match)) {
                foreach ($match[1] as $value) {
                    //var_dump($value);
                    //echo "****************<br>";

                    if (preg_match('~<a style="text-decoration:none" href="/(.+)" onclick="(.+)">(.+)</a>~Usi', $value, $matches)) {
                        //var_dump($matches);
                        $total_return = "Vacancies found for $job_head";
                        $options_list[] = $matches[3];
                        $list[] = array("content" => "__uae__" . trim($root_site . $matches[1]) . "__jobs__");
                    }
                }
            }
        }

        /* foreach ($options_list as $key => $value) {
          echo ($key + 1) . "$value => " . $list[$key]['content'] . "<br>";
          } */
//    } else {
//        $to_logserver['isresult'] = 0;
//        $total_return = "This service is available only through SMS.";
//    }
    if (!$total_return) {
        $to_logserver['isresult'] = 0;
        $total_return = "Sorry.. No job found for your query. Please try later..";
    }
    if ($total_return) {
        $to_logserver['source'] = 'uaejob';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__uae__(.+)__jobs__~", $req, $match)) {
    $ext_site = $match[1];
    $root_site = "";

    echo $url = "$root_site$ext_site";

    $content = file_get_contents($url);

    if (preg_match('~<span class="company-listings-but">(.+)</table>~Usi', $content, $match)) {
//    var_dump($match);
        $out = $match[1];
        $out = preg_replace("~[\s]+~", " ", $out);
        $out = str_replace("<p>", "\n", $out);
        $out = str_replace("<div>", "\n", $out);
        $out = trim(strip_tags($out));
        $out = str_replace("\n ", "\n", $out);
        $total_return = $out;
    }
//    if (preg_match('~<div class="jobs-results-content"><p>(.+)</table>~Usi', $content, $match)) {
////        var_dump($match);
//        $found = $match[1];
//        //var_dump($match);
//        //echo "match found<br>";
//        $found = str_replace(array('</p>', '<div>'), "***", $found);
//        $found = strip_tags($found);
//
//        $found = preg_replace("~[\s]+~", " ", $found);
//        $found = str_replace("***", "\n", $found);
//        $found = str_replace("\n\n", "\n", $found);
//        $found = str_replace("\n ", "\n", $found);
//        $pos = stripos($found, 'published');
//
//        $found = substr($found, 0, $pos);
//        $total_return = $found;
//    }
    else {
        $to_logserver['isresult'] = 0;
        $total_return = "Sorry.. No job found for your query. Please try later..";
    }
    if ($total_return) {
        $to_logserver['source'] = 'uaejob';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
