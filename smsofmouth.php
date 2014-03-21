<?php


$obj = new SmsMouth($spell_checked, $req);
if (!empty($obj->return["result"])) {
    $total_return = $obj->return["result"];

    $to_logserver['source'] = 'smsmouth';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class SmsMouth {

    function __construct($spell_checked, $req) {
        if ($spell_checked == "twitter") {
            $this->return["result"] = "Invalid format SMS twitter <your name> <message to be tweeted>";
        } elseif (preg_match("~^twitter (.+) (.+)~", $req, $match)) {
            var_dump($match);
            $data = explode(" ", $match[0]);

            var_dump($data);

            $name = trim($data[1]);
            $tweet = str_replace("twitter", "", $match[0]);
            $tweet = str_replace($name, "", $tweet);

            $this->postTweet($name, $tweet);
        }
    }

    function postTweet($name, $tweet) {

        $status_msg = $tweet . " from " . $name;
        require_once('twitteroauth/twitteroauth.php');
        require_once('twitteroauth/config_smsMouth.php');

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
        $tweetPost = $connection->post('statuses/update', array('status' => $status_msg));

        if (!empty($tweetPost->created_at))
            $this->return["result"] = "Your tweet :$tweetPost->text has been posted";
        else
            $this->return["result"] = "Some error occured";
    }

}

?>
