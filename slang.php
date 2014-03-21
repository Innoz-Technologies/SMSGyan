<?php

echo "<h1>Slang</h1>";
echo $srch_slang = strtolower(trim($query_in));

$out = '';
if (strpos($spell_checked, "slang") !== false && strpos($spell_checked, "slang") == 0) {
    if ($srch_slang) {
//        if (!is_numeric($srch_slang) || $srch_slang > 15) {
//        if (str_word_count($srch_slang) <= 2 && (!is_numeric($srch_slang) || $srch_slang > 20)) {
//            if (!in_array($srch_slang, array('ccl', 'mi', 'rr', 'dc', 'uk', 'loop', 'gold', 'goa', 'cloud', 'dvd', 'japan', 'man', 'hiv', 'std', 'dna', 'gsm', 'aids', 'lips', 'eat', 'sim', 'brain', 'rash', 'bad', 'ias', 'pon', 'case', '3g', 'dth', 'wifi', 'tea', 'icc', 'car', 'bus', 'hbo', 'chicken', 'sbi', 'class', 'map', 'dog', 'snake', 'book', 'orkut', 'ram', 'espn', 'kiss', 'tree')) || strpos($srch_slang, 'slang') !== false) {
//                if (!preg_match("~\b(tv|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|price|expand|pnr|dict|recipe|horoscope|photos?|party|city|greetings?|[0-9])\b~", $req)) {
//if (preg_match('~slang (.+)~', $srch_slang)) {
        $srch_slang = trim(str_ireplace('slang', '', $srch_slang));
        $out = '';

        $query = "SELECT * FROM slang where scode like '" . mysql_real_escape_string($srch_slang) . "' limit 0,1";
        echo "<br>$query<br>";
        $result = mysql_query($query) or print(mysql_error() . "  in $query");
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $out = $row["smean"];
        }

        if (!empty($out)) {
            echo $total_return = "Internet Slang: " . $srch_slang . "\n" . $out;
        }

        if ($total_return) {
            $to_logserver['source'] = 'slang';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
//            }
//        }
//    }
}
?>
