<?php

$return_msg = '';

//$msg_array = array('story','stories','tips','tip','quotes','quote');
//if(in_array(trim($que), $msg_array)) {
$requried = trim($que);
$requried = preg_replace("~qu?ote?s?~", "quotes", $requried);
$requried = preg_replace("~(songs?|bh?ajan[ea]?|qaww?all?i|paa?tt?[ue]?)~", "lyrics", $requried);
$requried = preg_replace("~(m[ea]ss?ages?|greetings?)~", "message", $requried);
$requried = preg_replace("~(movie?s?)~", "movie", $requried);
$requried = preg_replace("~(movie?s?)~", "movie", $requried);
if ($requried == "stories" || $requried == "history") {
    $requried = "story";
} elseif ($requried == "tip") {
    $requried = "tips";
} 
//elseif ($requried == "shayari") {
//    $requried = "poem";
//} 
elseif ($requried == "recipe") {
    $requried = "recipes";
} elseif ($requried == "pickup line") {
    $requried = "pickup lines";
} elseif ($requried == "mukhvakh") {
    $requried = "mukhwaak";
} elseif ($requried == "mukvak") {
    $requried = "mukhwaak";
} elseif ($requried == "mukhvak") {
    $requried = "mukhwaak";
} elseif ($requried == "mukvaak") {
    $requried = "mukhwaak";
} elseif ($requried == "mukhvaak") {
    $requried = "mukhwaak";
} elseif ($requried == "celb idea") {
    $options_list[] = "gift ideas";
    $list[] = array("content" => "friendship idea_gift");
} elseif ($requried == "idea_gift") {
    $options_list[] = "celebration ideas";
    $list[] = array("content" => "friendship celb idea");
} elseif ($requried == "rakhi message") {
    $options_list[] = "gift for brother";
    $list[] = array("content" => "rakhi gift brother");
    $options_list[] = "gift for brother";
    $list[] = array("content" => "rakhi gift brother");
} elseif ($requried == "gift brother") {
    $options_list[] = "send m-greeting card";
    $list[] = array("content" => "__gc__rakhi__help__");
} elseif ($requried == "gift sister") {
    $options_list[] = "send m-greeting card";
    $list[] = array("content" => "__gc__rakhi__help__");
}

echo "<br>MATCHED : $requried<br>";
$query = "SELECT Content,id FROM Knowledge WHERE session like '" . mysql_real_escape_string($sesn) . "' and Type like '" . mysql_real_escape_string($requried) . "' and Subject like '%" . mysql_real_escape_string(str_replace(' ', '%', $searchstr)) . "%' and id <> $notmsgid order by rand() limit 1";
echo "<br>QUERY : " . $query;
$result = mysql_query($query);
if (!(mysql_num_rows($result))) {
    $query = "SELECT Content,id FROM Knowledge WHERE session like '" . mysql_real_escape_string($sesn) . "' and Type like '" . mysql_real_escape_string($requried) . "' and id <> $notmsgid $mylang_handle order by rand() limit 1";
    echo "<br>QUERY2 : " . $query;
    $result = mysql_query($query);
}
if (mysql_num_rows($result)) {
    while ($row = mysql_fetch_array($result)) {
        $msg = $row['Content'];
        $dbid = $row['id'];
    }
}
//}

if (isset($msg)) {
    $return_msg = $msg;
}
if ($requried == 'quotes' || $requried == 'message') {
    $add_below = '';
} else {
    $add_below = "\n--\nINTERNET SEARCH ON SMS! SMS HELP TO $shortcode TO FIND OUT MORE.$tollfree";
}
$total_return = $return_msg;

$current_file = "Knowledge/Content/id/$dbid";
$source_machine = "db";
if ($sesn == 'rakhi' && $requried == 'message') {
    $options_list[] = "gift for sister";
    $list[] = array("content" => "rakhi gift sister");
    $options_list[] = "gift for brother";
    $list[] = array("content" => "rakhi gift brother");
}
if ($sesn == 'rakhi' && $requried == 'type') {
    $options_list[] = "send m-greeting card";
    $list[] = array("content" => "__gc__rakhi__help__");
}if ($sesn == 'friend' && $requried == 'gift') {
    $options_list[] = "celebration ideas";
    $list[] = array("content" => "friendship celb idea");
}if ($sesn == 'id' && $requried == 'message') {
    $options_list[] = "main menu";
    $list[] = array("content" => "azadi");
}
if ($sesn == 'eid' && $requried == 'message') {
    $options_list[] = "main menu";
    $list[] = array("content" => "eid");
}

if ($sesn == 'monsoon' && $requried == 'movie') {
    $options_list[] = "READ ANOTHER";
    $list[] = array("content" => $questr . "_not_" . $dbid);
} elseif (!($requried == 'movie' || ($sesn == 'krishna' && $requried == 'story'))) {
    $options_list[] = "READ ANOTHER";
    $list[] = array("content" => $questr . "_not_" . $dbid);
}
include 'allmanip.php';
if ($sesn == 'rakhi' && ($requried == 'gift brother' || $requried == 'gift sister')) {
    $total_return = str_replace("READ ANOTHER", "NEXT GIFT IDEA", $total_return);
}if ($sesn == 'rakhi' && $requried == 'message') {
    $total_return = str_replace("READ ANOTHER", "NEXT MESSAGE", $total_return);
}if ($sesn == 'rakhi' && $requried == 'type') {
    $total_return = str_replace("READ ANOTHER", "NEXT RAKHI", $total_return);
}if ($sesn == 'friend' && $requried == 'gift') {
    $total_return = str_replace("READ ANOTHER", "NEXT GIFT IDEA", $total_return);
}if ($sesn == 'friend' && $requried == 'gift') {
    $total_return = str_replace("READ ANOTHER", "NEXT GIFT IDEA", $total_return);
}if ($sesn == 'friendship' && $requried == 'idea_gift') {
    $total_return = str_replace("READ ANOTHER", "NEXT GIFT IDEA", $total_return);
}
?>