<?php

if ($spell_checked == "new year" || $spell_checked == "new year 2013" || $spell_checked == "newyear" || $spell_checked == "2013") {
    $total_return = "New Year 2013 Special\n";

    $options_list[] = "Greeting Cards";
    $list[] = array("content" => "__gc__help__newyear2013___"); //done
    $options_list[] = "Wishing Messages";
    $list[] = array("content" => "new year messages"); //done
    $options_list[] = "Astrology predictions for 2013";
    $list[] = array("content" => "__newyear__start__predict__"); //done
    $options_list[] = "New year parties and Deals";
    $list[] = array("content" => "__newyear__parties__deals__"); //done except KL,KO
    $options_list[] = "Top Incidents of 2012";
    $list[] = array("content" => "top incidents in 2012"); // done
    $options_list[] = "Top Movies of 2012";
    $list[] = array("content" => "__newyear__top__movies__"); // done
    $options_list[] = "Top Songs of 2012";
    $list[] = array("content" => "__newyear__top__songs__"); //done
    if ($operator == "vodafone") {
        $options_list[] = "New year special callertune";
        $list[] = array("content" => "__newyear__top__callertune__");
    }
    $options_list[] = "Predicted and sheduled events in 2013";
    $list[] = array("content" => "predicted and scheduled events in 2013");

    if ($total_return) {
        $to_logserver['source'] = 'newyear13';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__newyear__start__predict__~", $req, $match)) {
    $total_return = "Reply with zodiac sign\n";

    $options_list[] = "Aries";
    $list[] = array("content" => "2013 Yearly Horoscope of Aaries");
    $options_list[] = "Taurus ";
    $list[] = array("content" => "2013 Yearly Horoscope of Taurus");
    $options_list[] = "Gemini ";
    $list[] = array("content" => "2013 Yearly Horoscope of Gemini");
    $options_list[] = "Cancer ";
    $list[] = array("content" => "2013 Yearly Horoscope of Cancer");
    $options_list[] = "Leo";
    $list[] = array("content" => "2013 Yearly Horoscope of Leo");
    $options_list[] = "Virgo";
    $list[] = array("content" => "2013 Yearly Horoscope of Virgo");
    $options_list[] = "Libra";
    $list[] = array("content" => "2013 Yearly Horoscope of Libra");
    $options_list[] = "Scorpio";
    $list[] = array("content" => "2013 Yearly Horoscope of Scorpio");
    $options_list[] = "Sagittarius";
    $list[] = array("content" => "2013 Yearly Horoscope of Sagittarius");
    $options_list[] = "Capricorn";
    $list[] = array("content" => "2013 Yearly Horoscope of Capricorn");
    $options_list[] = "Aquarius";
    $list[] = array("content" => "2013 Yearly Horoscope of Aquarius");
    $options_list[] = "Pisces";
    $list[] = array("content" => "2013 Yearly Horoscope of Pisces");

    if ($total_return) {
        $to_logserver['source'] = 'newyear13';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__newyear__parties__deals__~", $req, $match)) {
    $total_return = "Reply with City Name\n";

    $options_list[] = "Delhi";
    $list[] = array("content" => "new year parties delhi");
    $options_list[] = "Bangalore";
    $list[] = array("content" => "new year parties bangalore");
    $options_list[] = "Mumbai";
    $list[] = array("content" => "new year parties mumbai");
    $options_list[] = "Pune";
    $list[] = array("content" => "new year parties pune");
    /* $options_list[] = "Kolkata";
      $list[] = array("content" => "new year parties kolkata");
      $options_list[] = "Kochi";
      $list[] = array("content" => "new year parties cochin"); */

    if ($total_return) {
        $to_logserver['source'] = 'newyear13';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__gc__help__newyear2013___~", $req)) {
    $total_return = "Wish your loved ones from your " . $operator . " Number.\n";
    $total_return .= "SMS NY <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name) to " . $shortcode . "\n";

    if ($total_return) {
        $to_logserver['source'] = 'newyear13';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__newyear__top__movies__~", $req)) {
    $total_return = "Top Movies Of 2012";
    switch ($circle_short) {
        case 'AP':
            $options_list[] = "Gabbar Singh";
            $list[] = array("content" => "movie Gabbar Singh");
            $options_list[] = "Ishq";
            $list[] = array("content" => "movie Ishq");
            $options_list[] = "Poola Rangadu";
            $list[] = array("content" => "movie Poola Rangadu");
            $options_list[] = "Ee Rojullo";
            $list[] = array("content" => "movie Ee Rojullo");
            $options_list[] = "Businessman";
            $list[] = array("content" => "movie Businessman");
            $options_list[] = "Racha";
            $list[] = array("content" => "movie Racha");
            $options_list[] = "Love Failure";
            $list[] = array("content" => "movie Love Failure");
            $options_list[] = "Dammu";
            $list[] = array("content" => "movie Dammu");
            $options_list[] = "SMS";
            $list[] = array("content" => "movie SMS");

            break;
        case 'AS':
        case 'BH':
            $options_list[] = "Paan Singh Tomar";
            $list[] = array("content" => "movie Paan Singh Tomar");
            $options_list[] = "Kahaani";
            $list[] = array("content" => "movie Kahaani");
            $options_list[] = "Ek Tha Tiger";
            $list[] = array("content" => "movie Ek Tha Tiger");
            $options_list[] = "VICKY DONOR";
            $list[] = array("content" => "movie VICKY DONOR");
            $options_list[] = "Shanghai";
            $list[] = array("content" => "movie Shanghai");
            $options_list[] = "Gangs of Wasseypur";
            $list[] = array("content" => "movie Gangs of Wasseypur");
            $options_list[] = "Jab Tak Hain Jaan";
            $list[] = array("content" => "movie Jab Tak Hai Jaan");
            $options_list[] = "Agneepath";
            $list[] = array("content" => "movie Agneepath");
            $options_list[] = "Talaash";
            $list[] = array("content" => "movie Talaash");
            $options_list[] = "Oh My God";
            $list[] = array("content" => "movie Oh My God");


            break;
        case 'CH':
        case 'TN':

            $options_list[] = "Eega";
            $list[] = array("content" => "movie Eega");
            $options_list[] = "Vazhakku Enn 18/9";
            $list[] = array("content" => "movie Vazhakku Enn 18/9");
            $options_list[] = "Nanban";
            $list[] = array("content" => "movie Nanban");
            $options_list[] = "Dhoni";
            $list[] = array("content" => "movie Dhoni");
            $options_list[] = "Oru Kal Oru Kannadi";
            $list[] = array("content" => "movie Oru Kal Oru Kannadi");
            $options_list[] = "Love Failure";
            $list[] = array("content" => "movie Love Failure");
            $options_list[] = "Kalakalappu";
            $list[] = array("content" => "movie Kalakalappu");
            $options_list[] = "Billa 2";
            $list[] = array("content" => "movie Billa 2");
            $options_list[] = "3";
            $list[] = array("content" => "movie 3");
            $options_list[] = "Kazhugu";
            $list[] = array("content" => "movie kazhugu");


            break;
        case 'DL':
        case 'GJ':
        case 'HP':
        case 'HR':
        case 'JK':
        case 'KA':
        case 'KO':
        case 'MB':
        case 'MH':
        case 'MP':
        case 'NE':
        case 'OR':
        case 'PB':
        case 'RJ':
        case 'UE':
        case 'UW':
        case 'WB':

            $options_list[] = "Paan Singh Tomar";
            $list[] = array("content" => "movie Paan Singh Tomar");
            $options_list[] = "Kahaani";
            $list[] = array("content" => "movie Kahaani");
            $options_list[] = "Ek Tha Tiger";
            $list[] = array("content" => "movie Ek Tha Tiger");
            $options_list[] = "VICKY DONOR";
            $list[] = array("content" => "movie VICKY DONOR");
            $options_list[] = "Shanghai";
            $list[] = array("content" => "movie Shanghai");
            $options_list[] = "Gangs of Wasseypur";
            $list[] = array("content" => "movie Gangs of Wasseypur");
            $options_list[] = "Jab Tak Hain Jaan";
            $list[] = array("content" => "movie Jab Tak Hai Jaan");
            $options_list[] = "Agneepath";
            $list[] = array("content" => "movie Agneepath");
            $options_list[] = "Talaash";
            $list[] = array("content" => "movie Talaash");
            $options_list[] = "Oh My God";
            $list[] = array("content" => "movie Oh My God");
            $options_list[] = "Marvel's The Avengers";
            $list[] = array("content" => "movie Marvel's The Avengers");
            $options_list[] = "The Dark Knight Rises";
            $list[] = array("content" => "movie The Dark Knight Rises");
            $options_list[] = "The Hunger Games";
            $list[] = array("content" => "movie The Hunger Games");
            $options_list[] = "Life of a Pi";
            $list[] = array("content" => "movie Life of a Pi");


            break;
        case 'KL':
            $options_list[] = "Ustad Hotel";
            $list[] = array("content" => "movie Ustad Hotel");
            $options_list[] = "22 Female Kottayam";
            $list[] = array("content" => "movie 22 Female Kottayam");
            $options_list[] = "Diamond Necklace";
            $list[] = array("content" => "movie Diamond Necklace");
            $options_list[] = "Thattathin Marayathu";
            $list[] = array("content" => "movie Thattathin Marayathu");
            $options_list[] = "Spirit";
            $list[] = array("content" => "movie Spirit");
            $options_list[] = "Ee Adutha Kaalath";
            $list[] = array("content" => "movie Ee Adutha Kaalath");
            $options_list[] = "Second Show";
            $list[] = array("content" => "movie Second Show");
            $options_list[] = "Grandmaster";
            $list[] = array("content" => "movie Grandmaster");
            $options_list[] = "Run Baby Run";
            $list[] = array("content" => "movie Run Baby Run");
            break;

        default:
            $options_list[] = "Kahaani";
            $list[] = array("content" => "movie Kahaani");
            $options_list[] = "Ek Tha Tiger";
            $list[] = array("content" => "movie Ek Tha Tiger");
            $options_list[] = "VICKY DONOR";
            $list[] = array("content" => "movie VICKY DONOR");
            $options_list[] = "Shanghai";
            $list[] = array("content" => "movie Shanghai");
            $options_list[] = "Gangs of Wasseypur";
            $list[] = array("content" => "movie Gangs of Wasseypur");
            $options_list[] = "Jab Tak Hain Jaan";
            $list[] = array("content" => "movie Jab Tak Hai Jaan");
            $options_list[] = "Agneepath";
            $list[] = array("content" => "movie Agneepath");
            $options_list[] = "Talaash";
            $list[] = array("content" => "movie Talaash");
            $options_list[] = "Oh My God";
            $list[] = array("content" => "movie Oh My God");
            $options_list[] = "Marvel's The Avengers";
            $list[] = array("content" => "movie Marvel's The Avengers");
            $options_list[] = "The Dark Knight Rises";
            $list[] = array("content" => "movie The Dark Knight Rises");
            $options_list[] = "The Hunger Games";
            $list[] = array("content" => "movie The Hunger Games");
            $options_list[] = "Life of a Pi";
            $list[] = array("content" => "movie Life of a Pi");
            break;
    }
    if ($total_return) {
        $to_logserver['source'] = 'newyear13';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__newyear__top__songs__~", $req)) {
    $total_return = "Top Songs Of 2012";
    switch ($circle_short) {
        case 'AP':
            $options_list[] = "ARERE PASI MANASA - KRISHNAM VANDE JAGADGURUM";
            $list[] = array("content" => "lyrics ARERE PASI MANASA");
            $options_list[] = "Melikal-CAMERAMAN GANGA THO RAMBABU";
            $list[] = array("content" => "lyrics Melikal-CAMERAMAN GANGA THO RAMBABU");
            $options_list[] = "SAKKUBAI- DHAMARUKAM";
            $list[] = array("content" => "lyrics SAKKUBAI");
            $options_list[] = "SYE ANDRI- KRISHNAM VANDE JAGADGURUM";
            $list[] = array("content" => "lyrics SYE ANDRI");
            $options_list[] = "KANYAKUMARI-DHAMARUKAM";
            $list[] = array("content" => "lyrics KANYAKUMARI");
            $options_list[] = "VECHANI VAYASUNDIRA-GUNDELLO GODARI";
            $list[] = array("content" => "lyrics VECHANI VAYASUNDIRA");
            $options_list[] = "YEDHI YEDHI-YETO VELLIPOYINDI MANASU";
            $list[] = array("content" => "lyrics YEDHI YEDHI from YETO VELLIPOYINDI MANASU");
            $options_list[] = "EXTRAORDINARY-CAMERAMAN GANGA THO RAMBABU";
            $list[] = array("content" => "lyrics EXTRAORDINARY");
            break;

        case 'CH':
        case 'TN':

            $options_list[] = "Kannazhaga(3)";
            $list[] = array("content" => "lyrics Kannazhaga");
            $options_list[] = "Po Nee Po";
            $list[] = array("content" => "lyrics Po Nee Po");
            $options_list[] = "Oru Murai (Muppozhudhum Un Karpanaigal)";
            $list[] = array("content" => "lyrics Oru Murai from Muppozhudhum Un Karpanaigal");
            $options_list[] = "Why This Kolaveri? (3)";
            $list[] = array("content" => "lyrics Why This Kolaveri");
            $options_list[] = "Venam Macha (Oru Kal Oru Kannadi)";
            $list[] = array("content" => "lyrics Venam Macha");
            $options_list[] = "Asku Laska (Nanban)";
            $list[] = array("content" => "lyrics Asku Laska");
            $options_list[] = "Pappa Pappa (Vettai)";
            $list[] = array("content" => "lyrics Pappa Pappa");
            $options_list[] = "Azhaipaaya (Kadhalil Sodhapuvadhu Yeppadi)";
            $list[] = array("content" => "lyrics Azhaipaaya");

            break;

        case 'DL':
        case 'GJ':
        case 'HP':
        case 'HR':
        case 'JK':
        case 'KA':
        case 'KO':
        case 'MB':
        case 'MH':
        case 'MP':
        case 'NE':
        case 'OR':
        case 'PB':
        case 'RJ':
        case 'UE':
        case 'UW':
        case 'WB':
        case 'AS':
        case 'BH':

            $options_list[] = "Chikni Chameli";
            $list[] = array("content" => "lyrics Chikni Chameli");
            $options_list[] = "Ek Main Aur Ekk Tu";
            $list[] = array("content" => "lyrics Ek Main Aur Ekk Tu");
            $options_list[] = "Pani Da Rang - Vicky Donor";
            $list[] = array("content" => "lyrics Pani Da Rang");
            $options_list[] = "Pareshaan - Ishaqzaade";
            $list[] = array("content" => "lyrics Pareshaan");
            $options_list[] = "Ooh La La";
            $list[] = array("content" => "lyrics Ooh La La");
            $options_list[] = "Hosanna";
            $list[] = array("content" => "lyrics Hosanna");
            $options_list[] = "Aahatein";
            $list[] = array("content" => "lyrics Aahatein");
            $options_list[] = "Mashallah - Ek Tha Tiger";
            $list[] = array("content" => "lyrics Mashallah");


            break;
        case 'KL':
            $options_list[] = "MUTHUCHIPPI - THATTATHIN MARAYATH";
            $list[] = array("content" => "lyrics Muthuchippi poloru kathinullil");
            $options_list[] = "AZHALINTE AAZHANGHALIL-AYAALUM NJANUM THAMMIL";
            $list[] = array("content" => "lyrics AZHALINTE AAZHANGHALIL");
            $options_list[] = "APPANGHAL EMBAADUM -USTAD HOTEL";
            $list[] = array("content" => "lyrics APPANGHAL EMBAADUM");
            $options_list[] = "VAATHILIL-USTAD HOTEL";
            $list[] = array("content" => "lyrics vaathilil aa vaathilil");
            $options_list[] = "CHERUCHILLALYIL-101 WEDDINGS";
            $list[] = array("content" => "lyrics cheruchillayil");
            $options_list[] = "THATTATHINNMARAYATHE-THATTATHINMARAYATH";
            $list[] = array("content" => "lyrics THATTATHINNMARAYATHE");
            $options_list[] = "KANNINULLIL NEE KANMANI - TRIVANDRUM LODGE";
            $list[] = array("content" => "lyrics KANNINULLIL NEE KANMANI");
            break;

        default:
            $options_list[] = "Chikni Chameli";
            $list[] = array("content" => "lyrics Chikni Chameli");
            $options_list[] = "Ek Main Aur Ekk Tu";
            $list[] = array("content" => "lyrics Ek Main Aur Ekk Tu");
            $options_list[] = "Pani Da Rang - Vicky Donor";
            $list[] = array("content" => "lyrics Pani Da Rang");
            $options_list[] = "Pareshaan - Ishaqzaade";
            $list[] = array("content" => "lyrics Pareshaan");
            $options_list[] = "Ooh La La";
            $list[] = array("content" => "lyrics Ooh La La");
            $options_list[] = "Hosanna";
            $list[] = array("content" => "lyrics Hosanna");
            $options_list[] = "Aahatein";
            $list[] = array("content" => "lyrics Aahatein");
            $options_list[] = "Mashallah - Ek Tha Tiger";
            $list[] = array("content" => "lyrics Mashallah");
            break;
    }
    if ($total_return) {
        $to_logserver['source'] = 'newyear13';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__newyear__top__callertune__~", $req)) {
    $total_return = "NewYear Special Songs!!!\n";

    $options_list[] = "CALLERTUNE HAPPY NEW YEAR RAP WITH FOLK FROM KURUVIS";
    $list[] = array("content" => "__hellotune__13200012__confirm__Happy New Year Rap With Folk from Kuruvi__Rs0__");
    $options_list[] = "CALLERTUNE HAPPY NEW YEAR FROM NEW YEAR SONGS";
    $list[] = array("content" => "__hellotune__2538257__confirm__Happy New Year from New Year Songs__Rs0__");
    $options_list[] = "CALLERTUNE HAPPY NEW YEAR FROM TERI TALASH MEIN";
    $list[] = array("content" => "__hellotune__10012363__confirm__Happy New Year from Teri Talash Mein__Rs0__");
    $options_list[] = "CALLERTUNE PYAR BESHUMAR FROM HAPPY NEW YEAR";
    $list[] = array("content" => "__hellotune__2633883__confirm__Pyar Beshumar from Happy New Year__Rs0__");
    $options_list[] = "CALLERTUNE MERE KARIB AA FROM HAPPY NEW YEAR";
    $list[] = array("content" => "__hellotune__2633922__confirm__Mere Karib Aa from Happy New Year__Rs0__");

    if ($total_return) {
        $to_logserver['source'] = 'newyear13';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
