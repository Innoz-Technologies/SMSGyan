<?php

echo "<h1>News urls</h1>";
$contents = getAllBingNews($word);
if (!empty($contents["url"])) {
    $search_url = $contents["url"];
}
var_dump($search_url);
include 'news_search_1.php';

if (empty($data)) {
    echo "<h1>Google News</h1>";
    $contents = getGoogleNews($word);
    if (!empty($contents["url"])) {
        $search_url = $contents["url"];
    }
    var_dump($search_url);
    include 'news_search_1.php';
}

if (!empty($data)) {
    $total_return = $data;
    $source_machine = $machine_id;
    $current_file = "/news/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
}

//if ($total_return) {
//    $source_machine = $machine_id;
//    $current_file = "/temp/$numbers";
//    file_put_contents(DATA_PATH . $current_file, $total_return);
//    $to_logserver['source'] = 'news';
//    include 'allmanip.php';
//    putOutput($total_return);
//    exit();
//}
?>
