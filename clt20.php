<?php

if ($spell_checked == "clt20" || $spell_checked == "champions league t20" || $spell_checked == "champions league twenty 20"||$spell_checked == "t20") {

    $total_return = "Champions league t20 special";

    $options_list[] = "fixtures";
    $list[] = array("content" => "__clt20__fixture__");
    $options_list[] = "teams";
    $list[] = array("content" => "__clt20__teams__");
    $options_list[] = "team photos";
    $list[] = array("content" => "photo clt20");

    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'clt20';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__clt20__(.+)__~", $req, $match)) {

    switch ($match[1]) {
        case 'fixture':
            echo $query = "select * from clt20 where date >= CURDATE()";

            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                $i = 1;
                while ($row = mysql_fetch_array($result)) {
                    $clt20_fixture.= "$i. " . $row['team1'] . " Vs " . $row['team2'] . " on " . date('F j', strtotime($row['date'])) . "," . $row['time'] . " " . " at " . $row['venue'] . "\n";
                    $i++;
                }
            }

            if (!empty($clt20_fixture)) {

                $total_return = $clt20_fixture;
                $source_machine = $machine_id;
                $current_file = "/temp/$numbers";
                file_put_contents(DATA_PATH . $current_file, $total_return);
                include 'allmanip.php';
                $to_logserver['source'] = 'clt20';
                putOutput($total_return);
                exit();
            }

            break;

        case 'teams':
            $total_return = "Champions League T20 Teams";

            $options_list[] = "Auckland";
            $list[] = array("content" => "__clt20team__Auckland__");
            $options_list[] = "Chennai Super Kings";
            $list[] = array("content" => "__clt20team__Chennai Super Kings__");
            $options_list[] = "Delhi Daredevils";
            $list[] = array("content" => "__clt20team__Delhi Daredevils__");
            $options_list[] = "Hampshire";
            $list[] = array("content" => "__clt20team__Hampshire__");
            $options_list[] = "Kolkata Knight Riders";
            $list[] = array("content" => "__clt20team__Kolkata Knight Riders__");
            $options_list[] = "Lions";
            $list[] = array("content" => "__clt20team__Lions__");
            $options_list[] = "Mumbai Indians";
            $list[] = array("content" => "__clt20team__Mumbai Indians__");
            $options_list[] = "Perth Scorchers";
            $list[] = array("content" => "__clt20team__Perth Scorchers__");
            $options_list[] = "Sialkot Stallions";
            $list[] = array("content" => "__clt20team__Sialkot Stallions__");
            $options_list[] = "Sydney Sixers";
            $list[] = array("content" => "__clt20team__Sydney Sixers__");
            $options_list[] = "Titans";
            $list[] = array("content" => "__clt20team__Titans__");
            $options_list[] = "Trinidad & Tobago";
            $list[] = array("content" => "__clt20team__Trinidad & Tobago__");
            $options_list[] = "Uva Next";
            $list[] = array("content" => "__clt20team__Uva Next__");
            $options_list[] = "Yorkshire";
            $list[] = array("content" => "__clt20team__Yorkshire__");


            if ($total_return) {
                include 'allmanip.php';
                $to_logserver['source'] = 'clt20';
                putOutput($total_return);
                exit();
            }

            break;

        default:
            break;
    }
} elseif (preg_match("~__clt20team__(.+)__~", $req, $match)) {
    $team = $match[1];
    echo $query = "select * from clt20_team where team='$team'";
    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $squad = $row["member"];
    }

    if (!empty($squad)) {
        $total_return = $squad;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'clt20';
        putOutput($total_return);
        exit();
    }
}
?>
