<?php

$score = 0;
$count = 0;

if (preg_match("~__quiz__(.+)__(.+)__(.+)__(.+)__(.+)__~", $req, $match)) {

    $show_charge_per_query = false;

    $ans = $match[1];
    $score = $match[2];
    $corctOpt = $match[3];
    echo $id = $match[4];
    echo "count:" . $count = $match[5];

    $id = $id + 1;

    mysql_close();
    include 'lib/configdb2.php';

    echo $query1 = "select count(*) as count from quiz where quizType='nepal'";
    $result1 = mysql_query($query1);

    if (mysql_num_rows($result1)) {
        $row = mysql_fetch_array($result1);
        echo "<h1>Row Count : </h1>" . $row_count = $row["count"];
    }


    if ($count < $row_count && ($id - 89) == $row_count + 1) {
        $id = 90;
    }

    if ($ans == $corctOpt) {
        $score = $score + 1;
        $total_return.= "Correct answer\nYour Score Is : $score/$count\n";
    } else {
        $score = $score + 0;
        $total_return.= "Wrong answer\nYour Score Is : $score/$count\n";
    }
    if ($count < $row_count) {


        echo $query = "select * from quiz where id='$id'";
        $result = mysql_query($query);

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $question = $row["question"];
            $opt1 = $row["clue1"];
            $opt2 = $row["clue2"];
            $opt3 = $row["clue3"];
            $id = $row["id"];

            $corctOpt = $row["answer"];

            $total_return.= "Next Question : ";
            $total_return.=$question;

            $count = $count + 1;

            $options_list[] = $opt1;
            $list[] = array("content" => "__quiz__1__" . $score . "__" . $corctOpt . "__" . $id . "__" . $count . "__");
            $options_list[] = $opt2;
            $list[] = array("content" => "__quiz__2__" . $score . "__" . $corctOpt . "__" . $id . "__" . $count . "__");
            $options_list[] = $opt3;
            $list[] = array("content" => "__quiz__3__" . $score . "__" . $corctOpt . "__" . $id . "__" . $count . "__");
        }
    }

    mysql_close();
    include 'lib/appconfigdb.php';

    if (!empty($total_return)) {
        $to_logserver['source'] = 'nepalquiz';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}

if ($spell_checked == "quiz") {


    echo "<h2>NEPAL QUIZ</h2>";
    $show_charge_per_query = false;
    //connection to app db2
    mysql_close();
    include 'lib/configdb2.php';
    echo $query = "select * from quiz where quizType='nepal' order by rand() limit 1";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $question = $row["question"];
        $opt1 = $row["clue1"];
        $opt2 = $row["clue2"];
        $opt3 = $row["clue3"];
        $id = $row["id"];

        $corctOpt = $row["answer"];

        $total_return = "Welcome to Quiz\n";
        $total_return.=$question;

        $count = 1;

        $options_list[] = $opt1;
        $list[] = array("content" => "__quiz__1__0__" . $corctOpt . "__" . $id . "__" . $count . "__");
        $options_list[] = $opt2;
        $list[] = array("content" => "__quiz__2__0__" . $corctOpt . "__" . $id . "__" . $count . "__");
        $options_list[] = $opt3;
        $list[] = array("content" => "__quiz__3__0__" . $corctOpt . "__" . $id . "__" . $count . "__");
    }

    mysql_close();
    include 'lib/appconfigdb.php';

    if (!empty($total_return)) {
        $to_logserver['source'] = 'nepalquiz';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
