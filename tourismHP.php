<?php

if ($spell_checked == "tourism" || $spell_checked == "tourist place") {
    
    $total_return = "Tourist places of $circle_state";

    switch ($circle_short) {
        case 'HP':

            $options_list[] = "hamirpur";
            $list[] = array("content" => "tourist place hamirpur");
            $options_list[] = "pragpur";
            $list[] = array("content" => "tourist place pragpur");
            $options_list[] = "chail";
            $list[] = array("content" => "tourist place chail");
            $options_list[] = "maharana pratap sagar";
            $list[] = array("content" => "tourist place maharana pratap sagar");
            $options_list[] = "kangra fort";
            $list[] = array("content" => "tourist place kangra fort");
            $options_list[] = "manali";
            $list[] = array("content" => "tourist place manali");

            $to_logserver['source'] = 'tourism' . $circle_short;
            break;

        case 'OR':

            $options_list[] = "rourkela";
            $list[] = array("content" => "tourist place rourkela");
            $options_list[] = "baripada";
            $list[] = array("content" => "tourist place baripada");
            $options_list[] = "puri";
            $list[] = array("content" => "tourist place puri");
            $options_list[] = "sambalpur";
            $list[] = array("content" => "tourist place sambalpur");
            $options_list[] = "konark";
            $list[] = array("content" => "tourist place konark");
            $options_list[] = "phulbani";
            $list[] = array("content" => "tourist place phulbani");
            $options_list[] = "cuttack";
            $list[] = array("content" => "tourist place cuttack");

            break;
        default:
            break;
    }

    if ($total_return) {

        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
