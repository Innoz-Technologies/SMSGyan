<?php

if (($spell_checked == 'women' || $spell_checked == "womens day special" || $spell_checked == "women's day special" || $spell_checked == "international womens day" || $spell_checked == "womens day" || $spell_checked == "women's day" || $spell_checked == "women day" || $spell_checked == "mothers day" || $spell_checked == "mother's day" || $spell_checked == "international women's day") && ($operator == 'aircel' || $operator == 'airtel')) {
//    if ($spell_checked == 'women' || $spell_checked == "womens day special" || $spell_checked == "women's day special" || $spell_checked == "international womens day" || $spell_checked == "womens day" || $spell_checked == "women day" || $spell_checked == "women's day" || $spell_checked == "womensday" || $spell_checked == "mothers day") {
    $flag_enabled = false;
    $total_return = "Women's Day Special..!";
    $options_list[] = "Significance Of Women's Day";
    $list[] = array("content" => "womens_day_significance");
    $options_list[] = "Facts Of Women's Day";
    $list[] = array("content" => "womens_day_facts");
    $options_list[] = "Women's Day Greeting Cards";
    $list[] = array("content" => "__gc__womens_day__");
//    }
}
if (preg_match("~__gc__womens_day__~", $req, $match)) {
    $total_return = "Wish your loved ones from your " . ucfirst($operator) . " Number.\n";
    $total_return .= "For Mother SMS GCM <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name) to  " . $shortcode . ",\n";
    $total_return .= "For Sister SMS GCS <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name) to " . $shortcode . ",\n";
    $total_return .= "For Wife SMS GCW <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name) to " . $shortcode . ",\n";
    $total_return .= "For Friend SMS GCF <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name) to " . $shortcode . ",\n";
    $total_return .= "For Girl Friend SMS GCG <space>name1 (Sender’s Name) <space>name2 (Receiver’s Name) to " . $shortcode . "\n";
}
if ($total_return) {
    $current_file = "/temp/$numbers";
    $source_machine = $machine_id;
    file_put_contents(DATA_PATH . $current_file, $total_return);
    include 'allmanip.php';
    $to_logserver['source'] = 'womens_day';
    putOutput($total_return);
    exit();
}
?>
