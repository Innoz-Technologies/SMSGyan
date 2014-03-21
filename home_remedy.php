<?php
if ($spell_checked == "home remedy" || $spell_checked == "homeremedy") {
    $total_return = "Home Remedy";

    $options_list[] = "Kitchen Cabinet cures for diabetes";
    $list[] = array("content" => "kitchen cabinet cures for diabetes");
    $options_list[] = "8 DIY Pet cleanup solutions";
    $list[] = array("content" => "diy pet cleanup solutions");
    $options_list[] = "10 DIY Floor and Wall Cleaning Tips";
    $list[] = array("content" => "diy floor and wall cleaning tips");
    $options_list[] = "7 Easy ways to stop kitchen oudour";
    $list[] = array("content" => "easy ways to stop kitchen oudour");
    $options_list[] = "10 House cleaning home remedies";
    $list[] = array("content" => "house cleaning home remedies");
    $options_list[] = "10 Bathroom cleaning tips and tricks";
    $list[] = array("content" => "bathroom cleaning tips and tricks");    
    $options_list[] = "5 Things to know about teething";
    $list[] = array("content" => "things to know about teething");
    $options_list[] = "Treatment for oily hair";
    $list[] = array("content" => "treatment for oily hair");
    $options_list[] = "8 Ways to Treat Head Lice";
    $list[] = array("content" => "ways to treat head lice");
    $options_list[] = "7 Ways to Banish Skin Problems";
    $list[] = array("content" => "ways to banish skin problems");
    $options_list[] = "How to Treat Bruises";
    $list[] = array("content" => "how to treat bruises");
/*    $options_list[] = "8 Medical Myths Busted (or not!)";
    $list[] = array("content" => "Medical Myths Busted (or not!)");
    $options_list[] = "Natural Cough Remedies";
    $list[] = array("content" => "Natural Cough Remedies");
    $options_list[] = "How to Get Rid of a Sore Throat";
    $list[] = array("content" => "How to Get Rid of a Sore Throat");
    $options_list[] = "Natural Remedies for Warts";
    $list[] = array("content" => "Natural Remedies for Warts");
    $options_list[] = "How to Get Rid of a Urinary Tract Infection";
    $list[] = array("content" => "How to Get Rid of a Urinary Tract Infection");*/
    $options_list[] = "Home Remedies for Kidney Stones";
    $list[] = array("content" => "home remedies for kidney stones");    

    if ($total_return) {
        $to_logserver['source'] = 'hremedy';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} 
?>
