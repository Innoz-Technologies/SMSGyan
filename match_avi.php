<?php

echo "<h2>Masala </h2>";
include 'masala.php';

echo "<h3>Difference</h3>";
include 'diffQuestions.php';

echo "<h3></h3>";
//exam parsers;

echo "<h3>champions trophy</h3>";
include 'fixture_championstrophy.php';

include 'fifacup2013.php';

echo "<h3>LUCKY NUMBER</h3>";

include 'luckynumber.php';
include 'namemean.php';

echo"<br>BCALC<br>";
echo $req;
include 'bcalc.php';

include 'ipl_stats.php';

echo"<br>Traffic Rules<br>";
include 'trafficRules.php';
echo "<br><h2>TIME after traffic :" . (microtime(TRUE) - $time_start) . "</h2><br>";

echo"<br>Bid Number<br>";
include 'bidNumber.php';

echo"<br>DIFFEREENCE<br>";
include 'difference.php';

echo"<br>Befor 143<br>";
include '143.php';

echo "<br>WOMEN SELF DEFENSE<br>";
include'women_helpline.php';

echo "<br>LUCKY NO<br>";
include 'lucky_no.php';

echo"<br>OP CUST CARE No<br>"; // added on 23/112012
include 'operator_cust_care.php';

echo"<br>CELEBRITY INFO<br>";
include 'celebrity_info.php';

echo"<br>VISA INFO<br>";
include 'visa_info.php';

echo"<br>DENGUE<br>";
include 'dengue.php';

echo"<br>BLOOD DONOR<br>";
include 'blood_menu.php';

echo"<br>FOOTBALL TIPS<br>";
include 'football_tricks.php';

echo"<br>GUITAR TIPS<br>";
include 'guitar_tips.php';

echo"<br>PHOTO TIPS<br>";
include 'photography_tips.php';

echo"<br>LOVEMSG<br>";
include 'love_menu.php';

echo"<br>JOB TIPS<br>";
include 'job_tips.php';

echo"<br>Mukhwaak<br>";
include 'hukamnama.php';

echo"<br>Monsoon special<br>";
include 'monsoon_spcl.php';

echo"<br>chickipedia<br>";
include 'chickipedia.php';

echo'<br>AYURVEDA TIPS SPECIAL<br>';
include 'ayurvedatips_spcl.php';

echo '<br>Pincode<br>';
include 'pincodeNew.php';

echo '<br>Health Tips<br>';
include 'healthtips.php';

echo'<br>read story<br>';
include 'read_story.php';

echo '<br>SnapDeal<br>';
include "snapDeal.php";

echo '<br>Devotional<br>';
include 'devotional.php';

echo '<br>STD Codes<br>';
include 'stdcodes.php';

echo '<br>Leap Year<br>';
include 'leap_year.php';

echo '<br>MowrunSplCase<br>';
include 'nowrun_spl.php';

include 'moviequiz.php';

echo '<br>ISD Codes<br>';
include 'isdcodes.php';

echo"<br> ifsc_code<br>";
include 'ifsccodeNew.php';

$srch_item = '';
$srch_place = '';
$isBing = false;

if (preg_match("~(locate|find|location) (.+) (near|in|at|on) (.+)~", $spell_checked, $match)) {

    echo "search item is " . $srch_item = trim($match[2]);
    echo "search palce is " . $srch_place = trim($match[4]);
    echo 'Result is must';
    $ismust = true;
}


echo '<br>JustEat<br>';
include 'justeat.php';

echo '<br>Getit<br>';
include 'getit.php';

echo '<br>Zomato<br>';
include 'restu_det.php';
echo "<br><h2>TIME after zomato :" . (microtime(TRUE) - $time_start) . "</h2><br>";


if (preg_match("~__getitRes__(.+)__~si", $req, $match)) {
    echo "Match spl";
    $total_return = $match[1];
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'getit';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

?>