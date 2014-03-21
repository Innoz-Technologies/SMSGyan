<?php

echo "<h3>SPELL: $spell_checked</h3>";
if (preg_match('~^\bcompare\b (.+)~', $spell_checked, $matches)) {
    echo "<h3>inside diff </h3>";
    //var_dump($matches);

    $d_str = trim(strtolower($matches[1]));
    $d_str = str_replace(' & ', ' and ', $d_str);
    $d_str = str_replace('&', ' and ', $d_str);
    $arStr = explode(' and ', $d_str);

    if (!isset($arStr[1])) {
        $arStr = array();
        $arStr = explode('and', $d_str);
    }
    //var_dump($arStr);
    if (isset($arStr[1])) {
        $preg_tr = "<tr  class='comparisonRow'.+>(.+)</tr>";
        $preg_td = "<td .+>(.+)</td>";

        $diff1 = ucwords(trim($arStr[0]));
        $diff2 = ucwords(trim($arStr[1]));

        $diff1 = preg_replace("~[\s]+~", ' ', $diff1);
        $diff2 = preg_replace("~[\s]+~", ' ', $diff2);

        $diff_ur11 = str_replace(' ', '_', trim($diff1));
        $diff_ur12 = str_replace(' ', '_', trim($diff2));

        $url = "http://www.diffen.com/difference/" . $diff_ur11 . "_vs_" . $diff_ur12;

        echo "<h4>URL: $url</h4>";

        $content = httpGet($url);

        $out_diff = '';
        //echo "content: $content<br>";
        if ($content) {
            echo "<h3>content fetched</h3>";
            if (preg_match_all("~$preg_tr~Usi", $content, $mRow)) {
                //var_dump($mRow);
                echo "<h3>inside preg 1</h3>";
                foreach ($mRow[1] as $kRow => $vRow) {
                    if (preg_match_all("~$preg_td~Usi", $vRow, $mTD)) {
                        //echo "<h3>inside preg 2</h3>";
                        foreach ($mTD[1] as $kTD => $vTD) {
                            //echo "index: $kTD<br>";
                            if (!($kTD == 0 && stripos($vTD, 'Introduction (from Wikipedia)') !== FALSE)) {
                                //echo "Data<br>";
                                $tval = $vTD;
                                $tval = html_entity_decode($tval);
                                $tval = strip_tags($tval);
                                $tval = preg_replace('~[\s]+~', ' ', $tval);
                                $tval = trim($tval);

                                if ($kTD == 0)
                                    $out_diff .= '(' . ($kRow + 1) . ') ';
                                $out_diff .= "$tval ";
                                if (trim($tval) == '') {
                                    $out_diff .= 'none ';
                                }
                                if ($kTD == 1) {
                                    $out_diff .= '- ';
                                }
                                //if ($kTD == 0)
                                //echo "<h3>$tval</h3>";
                            }
                        }
                    }
                    $out_diff = trim(rtrim($out_diff, ' - '));
                    $out_diff .= "\n";
                }
            }

            if (!empty($out_diff)) {
                $total_return = "Difference between $diff1 and $diff2\n";
                $total_return .= $out_diff;
            }
        }
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'difference';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
