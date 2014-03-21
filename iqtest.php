<?php

if ($spell_checked == "iqtest" || $spell_checked == "iq test" || preg_match("~__iq__(.+)__(.+)__(.+)__~", $req, $match)) {
    $count = 0;
    var_dump($match);
    $score = 0;

    echo "<h3>MATCH 1</h3>" . $match[1];
    if (isset($match[1])) {
        echo "<h2>IQTEST</h2>";
        $count = $match[2];
        $value = $match[1];
        $score = $match[3];

        switch ($count) {

            case 1:
                echo "<h2>SWITCH CASE1 INSIDE</h2>";
                $total_return = "Which number should come next in the series?\n1-1-2-3-5-8-13";
                $count++;
                $score += $value;

                echo $score;

                $options_list[] = "8";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "13";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "21";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "26";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "31";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

                break;

            case 2:
                echo "<h2>SWITCH CASE2 INSIDE</h2>";
                $total_return = "Which one of the five choices makes the best comparison?\nPEACH is to HCAEP as 46251 is to:";
                $count++;
                $score = $score + $value;

                echo $score;

                $options_list[] = "25641";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "26451";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "12654";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "51462";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "15264";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");

                break;

            case 3:
                echo "<h2>SWITCH CASE3 INSIDE</h2>" . $count;
                $total_return = "Mary, who is sixteen years old, is four times as old as her brother. How old will Mary be when she is twice as old as her brother?";
                $count++;
                $score = $score + $value;

                echo $score;

                $options_list[] = "20";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "24";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "25";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "26";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "28";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

                break;

            case 4:
                echo "<h2>SWITCH CASE4 INSIDE</h2>";
                $total_return = "Which one of the numbers does not belong in the following series?\n2-3-6-7-8-14-15-30";
                $count++;
                $score = $score + $value;

                echo $score;

                $options_list[] = "THREE";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "SEVEN";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "EIGHT";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "FIFTEEN";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "THIRTY";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

                break;

            case 5:
                echo "<h2>SWITCH CASE5 INSIDE</h2>";
                $total_return = "Which one of the five choices makes the best comparison?\nFinger is to Hand as Leaf is to:";
                $count++;
                $score = $score + $value;

                echo $score;

                $options_list[] = "Twig";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "Tree";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "Branch";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "Blossom";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "Bark";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

                break;
            case 6:
                echo "<h2>SWITCH CASE6 INSIDE</h2>";
                $total_return = "If you rearrange the letters CIFAIPC you would have the name of a(n):";
                $count++;
                $score = $score + $value;

                echo $score;

                $options_list[] = "City";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "Animal";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "Ocean";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "River";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "Country";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

                break;

            case 7:
                echo "<h2>SWITCH CASE7 INSIDE</h2>";
                $total_return = "Choose the number that is 1/4 of 1/2 of 1/5 of 200:";
                $count++;
                $score = $score + $value;

                echo $score;

                $options_list[] = "2";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "5";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "10";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "25";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "50";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

                break;

            case 8:
                echo "<h2>SWITCH CASE8 INSIDE</h2>";
                $total_return = "John needs 13 bottles of water from the store. John can only carry 3 at a time. What's the minimum number of trips John needs to make to the store?";
                $count++;
                $score = $score + $value;

                echo $score;

                $options_list[] = "3";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "4";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "4.5";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "5";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                $options_list[] = "6";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

                break;

            case 9:
                echo "<h2>SWITCH CASE9 INSIDE</h2>";
                $total_return = "If all Bloops are Razzies and all Razzies are Lazzies, then all Bloops are definitely Lazzies?";
                $count++;
                $score = $score + $value;


                echo $score;

                $options_list[] = "True";
                $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
                $options_list[] = "False";
                $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
                break;

            case 10:
                $score = $score + $value;
                $total_return = "You have an IQ of :  $score";



            default:
                break;
        }
    } else {
        $count++;
        $options_list[] = "Dog";
        $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
        $options_list[] = "Mouse";
        $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
        $options_list[] = "Lion";
        $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");
        $options_list[] = "Snake";
        $list[] = array("content" => "__iq__14__" . $count . "__" . $score . "__");
        $options_list[] = "Elephant";
        $list[] = array("content" => "__iq__0__" . $count . "__" . $score . "__");

        $total_return = "IQ Test\n";
        $total_return.="Which one of the five is least like the other four?";


        if ($total_return) {
            $to_logserver['source'] = 'iqtest';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }

    if ($total_return) {
        $to_logserver['source'] = 'iqtest';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
