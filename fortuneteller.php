<?php

echo "<h2>For Thai Fortune: $req</h2>";
if (preg_match("~^\b(fortune|luck) (.+)\b~", $req, $match)) {
echo "<h2>Inside Thai Fortune: $req</h2>";
    $data = explode('@*@', $match[2]);
    var_dump($data);

    $name = strtoupper(trim($data[0]));
    $time = trim($data[1]);
    $date = trim($data[2]);

    $dateparts = explode('/', $date);

    $d = $dateparts[0];
    $m = $dateparts[1];
    $y = $dateparts[2];

    $newresult = newthai($d, $m, $y, $name);
    $total_return = $newresult;

     if (!empty($total_return)) {
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = 'luckyNO';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
}


function newthai($d, $m, $y, $name) {
    $content = file_get_contents("API");
    if (preg_match('~<div class="ruby">(.+)Synastry according to Typical analysis~Usi', $content, $match)) {
//    var_dump($match);

        $data = $match[1];
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = preg_replace('~Gender:<b>(.+)</b>~Usi', "", $data);
        $data = str_replace('</div>', "***", $data);
        $data = str_replace('</h3>', "***", $data);
        $data = strip_tags($data);
        $data = str_replace('***', "\n", $data);
        $result = "Fortune for $name born on $data";
    }
    return $result;
}

?>
