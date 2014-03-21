<?php
$content = $acry_in;
if (strpos($content, "redirected from") === false) {
    $needle = '<th>Definition</th>';
    $pth = stripos($content, $needle);
    if ($pth !== false) {
        $pt = $pth + 14;
        $out = substr("$content", $pt);
        $pa = stripos($out, '</table>');
        $out = left("$out", $pa);
        $x = 0;
        while (($aa = stripos($out, '<td class=acr>')) !== false) {
            if ($x > 500) {
                break;
            }
            $aend = stripos($out, '</td>', $aa);
            $killer = substr($out, $aa, $aend - $aa);
            $out = str_replace($killer, '', $out);
            $x++;
        }
        $word = trim(strip_tags($killer));
        $out = str_replace("</td>", '', $out);
        $out = str_replace("</tr>", " \n", $out);
        $out = strip_tags($out);
        $out = $word . " may refer to :" . $out;
        $acry_return = trim($out);
        $files=DATA_PATH . "/acry/$global_id";
        @unlink($files);
        file_put_contents($files, $acry_return);
    }
} else {
    $acry_return = "";
}

if(!$acry_return && $expand_must){
    $acry_return = "Sorry, no expansion found for " . strtoupper($word);
    $to_logserver['isresult'] = 0;
    $free = true;
}
?>
