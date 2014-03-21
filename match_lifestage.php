<?php

if ((strpos($req, 'life stage') !== false || strpos($req, 'lifestage') !== false) && (strpos($req, 'photo') !== false || strpos($req, 'picture') !== false || strpos($req, 'image') !== false)) {
    $req = 'life stage photos';
    $spell_checked = 'photo life stage';
} else {
    if ((strpos($req, 'life stage plays') !== false || strpos($req, 'lifestage plays') !== false) && strlen($req) < 25) {
        echo "<br>LIFESTAGE PLAYS";
        $total_return = 'LIST OF PLAYS';
        $options_list[] = "CHASING MY MAMET DUCK - Evam";
        $list[] = array("content" => "CHASING MY MAMET DUCK");
        $options_list[] = "ANUVAB PAL";
        $list[] = array("content" => "Stand-up Comedy");
        $options_list[] = "CHAOS THEORY - Rage Productions";
        $list[] = array("content" => "CHAOS THEORY");
        $options_list[] = "TOPI - Storyteller";
        $list[] = array("content" => "TOPI");
        $options_list[] = "RAFTA RAFTA - Akvarious Productions";
        $list[] = array("content" => "RAFTA RAFTA");
        include 'allmanip.php';
        $to_logserver['source'] = 'menu_lifestage';
        putOutput($total_return);
        exit();
    }

    if ((strpos($req, 'life stage') !== false || strpos($req, 'lifestage') !== false) && strlen($req) < 25) {
        echo "<br>LIFESTAGE";
        $query = "SELECT answer FROM canned_responses WHERE id=121";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        $row = mysql_fetch_array($result);
        $total_return = $row['answer'];
        $current_file = "canned_responses/answer/id/121";
        $source_machine = "db";

        $options_list[] = "PLAYS";
        $list[] = array("content" => "life stage plays");
        $options_list[] = "SCHEDULE";
        $list[] = array("content" => "life stage schedule");
        $options_list[] = "PHOTOS";
        $list[] = array("content" => "photo life stage");
        $to_logserver['source'] = 'menu_lifestage';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>