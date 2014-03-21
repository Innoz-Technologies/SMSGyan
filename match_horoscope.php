<?php

echo "<br>Before HOROSCOPE";
if (preg_match("~\b(horo?scope?|zodiac|astrology|star sign|sun sign|forecast|kismat)\b~", $spell_checked)) {
    echo "<br>HOROSCOPE<br>";
    if ($spell_checked == "kismat" && $userid == "51ee3ad6f2009") {

        $zodiac = array('aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'scorpio', 'sagittarius', 'aquarius', 'pisces', 'libra', 'capricorn');
        echo "<br>HOROSCOPE PAKISTAN<br>";


        $total_return = "Please select your zodiac sign";
        foreach ($zodiac as $key => $ti) {
            $options_list[] = strtoupper($ti);
            $list[] = array('content' => "horoscope $ti");
        }
        
        $to_logserver['source'] = 'horoscope';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    } elseif (preg_match("~^[^\w]*(horoscope|kismat)~", $spell_checked)) {
        $horo_must = true;
    }

    if (!preg_match("~\b(who|where|route|direction|poem|climate|cri|score|review|train)\b~", $spell_checked) || $horo_must) {
        $hor_req = remwords($spell_checked);
        $splited = matchdate($hor_req);
        if (isset($splited[2])) {
            $hor_req = $splited[0];
            $getdate = $splited[2];
        }

        $hor_req = preg_replace("~[^\w\d]~", " ", $hor_req);
        $hor_req = preg_replace("~\b(horo?scope?|zodiac|astrology|star sign|sun sign|kismat)\b~i", "", $hor_req);
        $hor_req = trim(preg_replace("~[\s]+~", " ", $hor_req));

        echo "<br>$hor_req<br>";
        if (strlen($hor_req) > 0) {
            include 'horoscope.php';
            if ($return_zodiac) {
                $total_return = $return_zodiac;
                $source_machine = $machine_id;
                $current_file = "/temp/$numbers";
                file_put_contents(DATA_PATH . $current_file, $total_return);
                $to_logserver['source'] = 'horoscope';
                include 'allmanip.php';
                if ($fromHi == true) {
                    $total_return = str_replace("OPTIONS", "ALSO TRY", $total_return);
                    $total_return = str_replace("Reply with", "Try with", $total_return);
                }
                putOutput($total_return);
                exit();
            }
        }
    }
    if ($appQueryFrom == "thai")
        $add_below = "\n--\nSEND HOROSCOPE <ZODIAC SIGN> to get your astrology predictions. Eg, HOROSCOPE RAT.";
    else
        $add_below = "\n--\nSms HOROSCOPE <ZODIAC SIGN> to 55444 to get your astrology predictions. Eg, HOROSCOPE LIBRA.";
}
?>