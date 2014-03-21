<?php

if ($spell_checked == "nigeria league") {
    $url = "http://www.completesportsnigeria.com/league/fixtures/1";
    $content = file_get_contents($url);
    if (preg_match_all('~<td>(.+)</td>~Usi', $content, $match)) {
        //var_dump($match[1]);
        $data = "Nigeria league Table\n";
        for ($i = 8; $i < count($match[1]);) {
            $team = $match[1][$i];
            $played = $match[1][$i + 1];
            $won = $match[1][$i + 2];
            $draw = $match[1][$i + 3];
            $lost = $match[1][$i + 4];
            $gf = $match[1][$i + 5];
            $ga = $match[1][$i + 6];
            $gd = $match[1][$i + 7];
            $points = $match[1][$i + 8];
            $data.="Team: $team Played: $played Won: $won Draw: $draw Lost: $lost GF: $gf GA: $ga GD: $gd Points: $points\n";
            $i = $i + 9;
        }
        $data = str_replace('&nbsp; ', '', $data);
        $total_return = $data;

        echo $data;
    }
    if (!empty($total_return)) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'NGleague';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
