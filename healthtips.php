<?php

if (preg_match('~^health tips?$~', $spell_checked)) {
    $flag_enabled = false;
    $total_return = "Health Tips!!!";

    $options_list[] = "Nutritious and Healthy food";
    $list[] = array("content" => "Nutritious and Healthy food");
    $options_list[] = "Seasonal Diet, Body and Skin Care";
    $list[] = array("content" => "seasonal diet");
    $options_list[] = "Fitness and Exercist Tips";
    $list[] = array("content" => "health tips and technics - fitness and exercise tips");
    $options_list[] = "Yoga for good health";
    $list[] = array("content" => "Yoga for good health");


    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'healthtips';
        putOutput($total_return);
        exit();
    }
}
?>
