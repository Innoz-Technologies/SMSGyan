<?php

if ($req == 'adda') {
    echo "<br>ADDA";
    $query = "SELECT answer FROM canned_responses WHERE id=98";
    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
    $row = mysql_fetch_array($result);
    $total_return = $row['answer'];
    $current_file = "canned_responses/answer/id/98";
    $source_machine = "db";

    $options_list[] = "Images of Adda";
    $list[] = array("content" => "photo Adda", "count" => 1);
    $options_list[] = "Hotspots";
    $list[] = array("content" => "__hotspots__", "count" => 2);
    $options_list[] = "Top Pujas in Kolkata";
    $list[] = array("content" => "Top Pujas in Kolkata", "count" => 3);

    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if ($req == '__hotspots__') {
    $total_return = "Hotspots in Kolkata:";
    $options_list[] = "Pizza Hut";
    $list[] = array("content" => "Pizza Hut Kolkata", "count" => 1);
    $options_list[] = "Dominos";
    $list[] = array("content" => "Dominos Kolkata", "count" => 2);
    $options_list[] = "Cafe Coffee Day";
    $list[] = array("content" => "Cafe Coffee Day Kolkata", "count" => 3);
    $options_list[] = "KFC";
    $list[] = array("content" => "kfc Kolkata", "count" => 4);

    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if ($spell_checked == 'puja') {
    echo "<br>PUJO";
    $spell_checked = 'durga puja';
    $req = 'durga puja';

//    $options_list[] = "Images of Adda";
//    $list[] = array("content" => "photo Adda", "count" => 1);
    $options_list[] = "FOOD";
    $list[] = array("content" => "puja food");
    $options_list[] = "TOP PUJAS IN KOLKATA";
    $list[] = array("content" => "Top Pujas in Kolkata");
}
?>