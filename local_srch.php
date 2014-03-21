<?php

$out = '';
$index = 1;

$data = $local_in;
if (preg_match_all("~sritem_ec2_lblPin\">(.+)</li>~Usi", $data, $matches)) {

    foreach ($matches as $k => $loc) {
        foreach ($loc as $k => $loc1) {
            if (preg_match("~sritem_ec2_nameControl\" class=\"ecHeaderLink\" href=\"/local/details.aspx\?lid=.+\">(.*)</a>~Usi", $loc1, $match)) {
//                echo 'entered loop<br>';

                $out .= "$index. " . strip_tags($match[1]);
                $index++;

                if (preg_match("~lblAddressLine\">(.+)</span>~Usi", $loc1, $match)) {
                    $out .= "\n$match[1]";
                }

                if (preg_match("~lblPhone.+\">(.+)</span>~Usi", $loc1, $match)) {
                    $out .= "\nPh: $match[1]";
                }
                if (preg_match("~ohlWeb.+href=\"(.+)\" target=\"_self\"><span>Website</span>~Usi", $loc1, $match)) {
                    $out .= "\nWebsite: $match[1]";
                }
                $out .= "\n";
            }
        }
        break;
    }

    echo $out;
}
if (!empty($out)) {
    $location_return = "LOCAL SEARCH RESULT\n" . $out;
}

if ($location_return) {

    if ($isBing) {
        $total_return = $location_return;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'loc';
        putOutput($total_return);
        exit();
    } else {
        $files = DATA_PATH . "/loc/$global_id";
        file_put_contents($files, $location_return);
        echo "<br>_####_file is: $files<br>";
    }
}
?>
