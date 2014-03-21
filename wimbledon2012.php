<?php

if (preg_match("~\b^(wimbledon|tennis|womens singles)\b~", $spell_checked)) {

    echo "wimbledon";
    if (empty($cache_mens) || empty($cache_women)) {
        echo $content = file_get_contents('API');
        $arWimb = unserialize($content);
//    var_dump($arWimb);

        $menout = $arWimb[0];
        $womenout = $arWimb[1];

        $cache_mens = apc_store('wimbcache', $menout, 600);
        $cache_women = apc_store('wimbcachewomen', $womenout, 600);

        echo "CACHE:" . $cache_mens;
        echo "CACHE:" . $cache_women;
    } else {
        $menout = apc_fetch('wimbcache', $success);
        $womenout = apc_fetch('wimbcachewomen', $success);
    }
    if ($spell_checked == "womens singles") {
        $total_return = $womenout;
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'wimbledon';
        putOutput($total_return);
        exit();
    }
    if (!empty($menout)) {
        $total_return = "Men's Singles :\n" . $menout;
        $options_list[] = "Womens Singles";
        $list[] = array("content" => "womens singles");
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'wimbledon';
        putOutput($total_return);
        exit();
    }
}
?>