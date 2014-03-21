<?php

if ($spell_checked == "player") {
    $total_return = "To know the statistics of your favorite player.\nSend Player player name\nEg:Player Lionel Messi";
} elseif (preg_match('~^\bplayer\b (.+)~', $req, $match)) {
    $player = trim($match[1]);

    $url = "http://www.whoscored.com/Search/?t=" . urlencode($player);
    $content = file_get_contents($url);

    if (preg_match_all('~<td><a href="(.+)" class="iconize iconize-icon-left"><span class=".+"></span>(.+)</a></td>~', $content, $match)) {

        if (count($match[2]) > 1) {
            $total_return = "Your query matches more than one result";
            for ($i = 0; $i < count($match[2]); $i++) {
                $options_list[] = trim($match[2][$i]);
                $list[] = array("content" => "__fplayer__next__" . trim($match[1][$i]) . "__");
            }
        } else {
            $link = "http://www.whoscored.com/" . trim($match[1][0]);
            $data = getfplayer($link);

            if ($data)
                $total_return = $data;
            else
                $total_return = "No details found";
        }
    }else {
        $total_return = "No players matched.Try again with another palyer name. Eg:Player Lionel Messi";
    }
} elseif (preg_match('~__fplayer__next__(.+)__~', $req, $match)) {
    echo "<h2>inside next fplayer</h2>";
    $link = "http://www.whoscored.com" . trim($match[1]);

    $data = getfplayer($link);

    if ($data)
        $total_return = $data;
    else
        $total_return = "No details found";
}

if (!empty($total_return)) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'fplayer_thai';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function getfplayer($url) {
    $content = file_get_contents($url);

    if (preg_match('~<table class="grid hover stat-table with-centered-columns">(.+)</table>~Usi', $content, $match)) {
        $data = trim($match[1]);
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace('</th>', " ", $data);
        $data = str_replace('</td>', " ", $data);
        $data = str_replace('</tr>', "***", $data);
        $data = strip_tags($data);
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace('***', "\n", $data);
        echo $data . "<br>";
    }

    if (preg_match('~<div class="player-info">(.+)<script type="text/javascript">~Usi', $content, $match)) {
        $profile = trim($match[1]);
        $profile = preg_replace('~[\s]+~', " ", $profile);
        $profile = str_replace('</dl>', "***", $profile);
        $profile = strip_tags($profile);
        $profile = preg_replace('~[\s]+~', " ", $profile);
        $profile = str_replace('***', "\n", $profile);
        echo $profile . "<br>";
    }

    if (preg_match('~<div class="character-card singular">(.+)<div class="clear">~Usi', $content, $match)) {
        $char = trim($match[1]);
        $char = preg_replace('~[\s]+~', " ", $char);
        $char = str_replace('<span class="level55">', ":", $char);
        $char = str_replace('<span class="level25">', ":", $char);
        $char = str_replace('</tr>', "***", $char);
        $char = str_replace('</h3>', "***", $char);
        $char = strip_tags($char);
        $char = preg_replace('~[\s]+~', " ", $char);
        $char = str_replace('***', "\n", $char);
        echo $char;
    }
    if (!empty($profile))
        return $data = $profile . "\n" . $data . "\n" . $char;
    else
        return $data = FALSE;
}

?>
