<?php

if ($spell_checked == "indian") {
    $total_return = "How Indian are you!?\n";

    echo $query = "select * from how_indian order by rand() limit 1";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $q = $row["question"];
        $id = $row["id"];
    }

    $total_return.=$q;
    $count = 1;
    $score = 0;

    $options_list[] = "yes";
    $list[] = array("content" => "__indian__1__" . $id . "__" . $count . "__" . $score . "__");
    $options_list[] = "no";
    $list[] = array("content" => "__indian__0__" . $id . "__" . $count . "__" . $score . "__");

    if ($total_return) {
        $to_logserver['source'] = 'indian';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__indian__(.+)__(.+)__(.+)__(.+)__~", $req, $match)) {



    $answer = $match[1];
    $id = $match[2];
    $count = $match[3];
    $score = $match[4];

    $score +=$answer;
    $id = $id + 1;

    $count++;


    echo $query = "select count(*) as count from how_indian";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        echo "<h1>Row Count : </h1>" . $row_count = $row["count"];
    }

    if ($count < $row_count && $id == $row_count + 1) {
        $id = 1;
    }

    if ($count <= $row_count) {
        echo $query = "select * from how_indian where id=$id";
        $result = mysql_query($query);

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $q = $row["question"];
            $id = $row["id"];

            $total_return.=$q;

            $options_list[] = "yes";
            $list[] = array("content" => "__indian__1__" . $id . "__" . $count . "__" . $score . "__");
            $options_list[] = "no";
            $list[] = array("content" => "__indian__0__" . $id . "__" . $count . "__" . $score . "__");
        }
    } else {
        $final_percentage = sprintf("%d", ($score / $row_count) * 100);

        $total_return = "You are $final_percentage% indian";
    }

    if ($total_return) {
        $to_logserver['source'] = 'indian';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
