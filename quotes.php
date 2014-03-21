<?php

$content = '';
$total_return = '';

if (preg_match("~__quotes__(.+)__(.+)__~si", $req, $match)) {
    $q_id = $match[1];
    $qu_word = trim($match[2]);
    echo $q_quotes = "Select * from quotes_data where typed like '%" . $qu_word . "%' and id!=$q_id AND length( typed ) <= length( '$qu_word' ) order by rand() limit 2";
    $r_quotes = mysql_query($q_quotes);

    if (mysql_num_rows($r_quotes) > 0) {
        $r = mysql_fetch_array($r_quotes);
        $total_return = $r["quotes"];
        $quotes_id = $r["id"];
        if (mysql_num_rows($r_quotes) > 1) {
            $options_list[] = "Read another";
            $list[] = array("content" => "__quotes__" . $quotes_id . "__" . $qu_word . "__");
        }
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'quote';
        putOutput($total_return);
        exit();
    }
}

if (preg_match("~^quotes? (.+)~", $spell_checked, $match)) {
    echo "first case";
    echo $quotes_word = $match[1];
} elseif (preg_match("~(.+) quotes?$~", $spell_checked, $match)) {
    echo "second case";
    echo $quotes_word = $match[1];
}

if (!empty($quotes_word)) {
    echo $q_qoutes = "Select * from quotes_data where typed like '%" . $quotes_word . "%' AND length( typed ) <= length('$quotes_word') order by rand() limit 2";
    $r_quotes = mysql_query($q_qoutes);
    if (mysql_num_rows($r_quotes) == 0) {
        $query = "Select * from quotes where quote like '%" . $quotes_word . "%' limit 0,1";
        $result = mysql_query($query);

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $url = "http://www.brainyquote.com" . $row["url"];
            $content = file_get_contents($url);

            echo "<h2>VAR DUMP</h2>" . var_dump($content);
        }

        if (!empty($content)) {

            echo "<h2>INSIDE CONTENT <h2>";
            $content = preg_replace("~<script type=\"text/javascript\">(.+)</script>~Usi", "", $content);
            preg_match_all("~<span class=\"huge bqQuoteLink\">(.+)<div class='pw_widget pw_post_false' pw:twitter-via=\"BrainyQuote\">~Usi", $content, $match);

            if (!empty($match[1])) {
                echo "<h2>INSIDE PREG MATCH <h2>";
                $q = "insert into quotes_data(typed,quotes) values";
                foreach ($match[1] as $val) {
                    $out = $val;
                    $out = str_replace("</span>", "***", $out);
                    $out = strip_tags($out);
                    $out = preg_replace("~[\s]+~", " ", $out);
                    $out = trim(str_replace("***", "\n", $out));
                    $out = trim(str_replace("\n ", "\n", $out));
                    $q .="('" . mysql_real_escape_string($quotes_word) . "','" . mysql_real_escape_string($out) . "'),";
                }
            }
            $q = substr($q, 0, strlen($q) - 1);
            if (mysql_query($q)) {
                echo "<br>Record Inserted";
            }
        }
        $q_qoutes = "Select * from quotes_data where typed like '%" . $quotes_word . "%' order by rand() limit 2";
        $r_quotes = mysql_query($q_qoutes);
    }
    if ($quotes_word == "friendship") {
        $options_list[] = "gift ideas";
        $list[] = array("content" => "friendship idea_gift");
        $options_list[] = "celebration ideas";
        $list[] = array("content" => "friendship celb idea");
        $options_list[] = "Send Mobile Greeting card";
        $list[] = array("content" => "__gc__frndshpday__help__");
    }
    if (mysql_num_rows($r_quotes) > 0) {
        $r = mysql_fetch_array($r_quotes);
        $total_return = $r["quotes"];
        $quotes_id = $r["id"];
        if (mysql_num_rows($r_quotes) > 1) {
            $options_list[] = "Read another";
            $list[] = array("content" => "__quotes__" . $quotes_id . "__" . $quotes_word . "__");
        }
    }
    echo $total_return;

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'quote';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>