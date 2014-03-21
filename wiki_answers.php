<?php

function get_wikianswer_result($wikianswer_in) {
//    global $wikianswer_in;

    global $wikians_return;
//$query = $_GET['q'];
////$query='what is the meaning of life';
//$q = urlencode($query);


    $result = $wikianswer_in;
    $pos1 = strpos($result, '<div class="ansTitle">');
    echo "<h3>entering</h3>";
    echo $pos1;
    if ($pos1 != 0) {
        $pos2 = strpos($result, '<div id="answerButtonsBar">');
        $result = substr($result, $pos1, $pos2 - $pos1);
        $result = strip_tags($result);
        $result = html_entity_decode($result);
        $result = preg_replace("~[\s]+~", " ", $result);
        $result = str_replace('Answer:', '', $result);
        $result = str_replace('Improve', '', $result);
        $result = str_replace('Check out the related link for more information.', '', $result);
        $result = str_replace('Note: There are comments associated with this question.', '', $result);
        $result = str_replace('See the discussion page to add to the conversation.', '', $result);
        $result = str_replace('Extra impressions by our users:India actually beat Sri Lanka because of Dhoni. When it was the last ball, Dhoni shot a six.', '', $result);
        $result = str_replace('var mpt = new Date(); var mpts = mpt.getTimezoneOffset() + mpt.getTime(); document.write(""); ', '', $result);
    } 
    else {
        $result = false;
    }
    return $result;
}

$wikians_return = get_wikianswer_result($wikianswer_in);
file_put_contents(DATA_PATH . "/wikianswers/$global_id", $wikians_return);
echo '<br>WikiAnswers<br>';
    echo $wikians_return;
echo '<br>---------------<br>';


//} else if (($pos1 = strpos($result, "Is one of these your question?", 0)) !== false) {
//    $pos2 = strpos($result, "No? Post your question to the community!", $pos1);
//    $sub = substr($result, $pos1, $pos2 - $pos1);
//    $i = 1;
//    preg_match_all("~<a onclick=[^<]+><img class=[^>]+>([^<]+)</a>~", $sub, $matches);
//    foreach ($matches[1] as $key => $match) {
//        echo $i . $match . "\n";
//        $i++;
//    }
//    echo $sub;
// elseif(($pos1 = strpos($result, "Is one of these your question?", 0)) !== false) {
//     $pos2=strpos()
//    
//}
?> 