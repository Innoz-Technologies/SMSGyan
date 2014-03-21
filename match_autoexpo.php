<?php

echo '<h1>chennai open</h1>';
if (strpos($spell_checked, 'autoexpo') !== false || strpos($spell_checked, 'auto expo') !== false || strpos($spell_checked, 'auto-expo') !== false) {
    if (strpos($spell_checked, 'photo') !== false || strpos($spell_checked, 'image') !== false || strpos($spell_checked, 'wallpaper') !== false) {
        $spell_checked = "photo auto expo";
    } else if (strpos($spell_checked, 'about') !== false) {
        $spell_checked = "about auto expo 2012";
    } else if (strpos($spell_checked, 'showtimes') !== false) {
        $spell_checked = "showtimes of auto expo";
    } else if (strpos($spell_checked, 'brand') !== false) {
        $spell_checked = "participating brands in auto expo";
    } else if (strpos($spell_checked, 'model') !== false) {
        $spell_checked = "new models in auto expo";
    } else {
        $total_return = "Auto Expo 2012";
        $options_list[] = "About auto expo 2012";
        $list[] = array("content" => "about auto expo 2012");
        $options_list[] = "Showtimes";
        $list[] = array("content" => "showtimes of auto expo");
        $options_list[] = "Participating Brands";
        $list[] = array("content" => "participating brands in auto expo");
        $options_list[] = "New Models";
        $list[] = array("content" => "new models in auto expo");
        $options_list[] = "Photos";
        $list[] = array("content" => "photo auto expo");
        $flag_enabled = false;
        include 'allmanip.php';
        $to_logserver['source'] = 'menu_autoexpo';
        putOutput($total_return);
        exit();
    }
}
?>
