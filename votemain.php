<?php

require_once 'voteClass.php';

if ($spell_checked == "vote") {

    $vote = new vote();
    $output = $vote->getQues();

    var_dump($output);

    $total_return = $output['ques'];
    $id = $output['id'];

    for ($i = 1; $i < 5; $i++) {
        if ($output['opt' . $i] != "") {
            $options_list[] = $output['opt' . $i];
            $list[] = array("content" => "__vote__" . $id . "__" . $output['opt' . $i] . "__");
        }
    }

    var_dump($options);
    var_dump($list);
} elseif (preg_match("~__vote__(.+)__(.+)__~", $req, $match)) {

    $id = $match[1];
    $optname = $match[2];

    $vote = new Vote();
    $out = $vote->getCount($id);

    $out = $out['count'];
    $out = json_decode($out, TRUE);

    foreach ($out as $opt->$count) {
        if ($optname == $opt) {
            $count++;
            break;
        }
    }
    
    var_dump($out);

    $total_return = "Your vote has been updated";
}


if (!empty($total_return)) {

    $to_logserver['source'] = 'vote';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
