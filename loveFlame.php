<?php

if (preg_match("~^((calculate|calc)? ?(l[o0]ve?|luve?|lve|loue?))~", $req) && count($query_words) >= 3) {
    echo '<br>IN LOVE<br>';
    $flag_enabled = false;
    $islove = true;
    echo print_r($query_words);
    $love_in = implode(' ', $query_words);
    echo "<br>Joined String : $love_in";
    if (preg_match("~^((calculate|calc)? ?(l[o0]ve?|luve?|lve|loue?|ilu)) (\w+) (\w+)$~", $love_in, $matches)) {
        echo '<br>----------<bR>';
        print_r($matches);
        echo '<br>---------<br>';
        $first_name = $matches[4];
        $second_name = $matches[5];
    } else if (preg_match("~^((calculate|calc)? ?(l[o0]ve?|luve?|lve|loue?|ilu)) ([\w\s]+)(and|\+|\||x|,|\*|\.|%|-|=)([\w\s]+)~", $love_in, $matches)) {
        echo '<br>_________<br>';
        print_r($matches);
        echo '<br>_________<br>';
        $first_name = $matches[4];
        $second_name = $matches[6];
    } else {
        $first_name = $query_words[1];
        $second_name = $query_words[count($query_words) - 1];
        echo "<br>first : $first_name,  $second_name<br>";
    }
    include 'lovecalculator.php';
} else if (in_array($query_words[0], array("flames", "flame", "flams")) && count($query_words) >= 3) {
    echo '<br>IN FLAME<br>';
    echo print_r($query_words);
    $flag_enabled = false;
    $flames_in = implode(' ', $query_words);
    if (preg_match("~^(flames|flame|f1ames|flams|f1ame) (\w+) (\w+)$~", $flames_in, $matches)) {
        echo '<br>----------<bR>';
        print_r($matches);
        echo '<br>---------<br>';
        $first_name = $matches[2];
        $second_name = $matches[3];
    } else if (preg_match("~^(flames|flame|f1ames|flams|f1ame) ([\w\s]+) (and|\+|\||x|,|\*|\.|%|-|=) ([\w\s]+)~", $flames_in, $matches)) {
        echo '<br>_________<br>';
        print_r($matches);
        echo '<br>_________<br>';
        $first_name = $matches[2];
        $second_name = $matches[3];
    } else {
        $first_name = $query_words[1];
        $second_name = $query_words[count($query_words) - 1];
        echo "<br>first : $first_name, $second_name<br>";
    }
    include 'flames.php';
} else if (preg_match("~^((calculate|calc)? ?(fri?e?nd[sz]?|frand[sz]?|fri?e?ndship|frn[sz]))~", $req) && count($query_words) >= 3 && count($query_words) <= 8) {
    echo '<br>IN FRIENDSHIP CALC<br>';
    $islove = false;
    $isfs = true;
    echo print_r($query_words);
    $love_in = implode(' ', $query_words);
    if (preg_match("~^((calculate|calc)? ?(fri?e?nd[sz]?|frand[sz]?|fri?e?ndship|frn[sz])) (\w+) (\w+)$~", $love_in, $matches)) {
        echo '<br>----------<bR>';
        print_r($matches);
        echo '<br>---------<br>';
        $first_name = $matches[4];
        $second_name = $matches[5];
    } else if (preg_match("~^((calculate|calc)? ?(fri?e?nd[sz]?|frand[sz]?|fri?e?ndship|frn[sz])) ([\w\s]+)(and|\+|\||x|,|\*|\.|%|-|=)([\w\s]+)~", $love_in, $matches)) {
        echo '<br>_________<br>';
        print_r($matches);
        echo '<br>_________<br>';
        $first_name = $matches[4];
        $second_name = $matches [6];
    } else {
        $first_name = $query_words[1];
        $second_name = $query_words[count($query_words) - 1];
        echo " <br>first :  $first_name, $second_name<br>";
    } include 'lovecalculator.php';
    if ($isfs && ( $circle == 'UW' || $circle == 'UE'))
        $charge_per_query = 3;
    $to_logserver['source'] = 'fc';
    putOutput($love_result);
    exit();
}
?>
