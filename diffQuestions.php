<?php

if (preg_match("~\b^((difference|diff) between)|diffbtw\b~", $spell_checked)) {

    $diffQuestion = trim(preg_replace("~(The|differences?|diff|between|diffbtw)~", "", $spell_checked));
    echo "<br>" . $query = "SELECT *,MATCH (question) AGAINST('$diffQuestion') as relv FROM diffquestions WHERE MATCH (question) AGAINST('$diffQuestion') having relv >6 order by relv desc limit 1";
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);

        if (empty($row["response"])) {
            $url = $row["url"];
            $content = file_get_contents($url);

            if (preg_match("~<div class=\"entry clearfloat\">(.+)</div>~Usi", $content, $matches)) {
                $out = $matches[1];
                $out = str_replace("</strong>", "***", $out);
                $out = strip_tags($out);
                $out = preg_replace("~[\s]+~", " ", $out);
                $out = str_replace("***", "\n", $out);
                $out = str_replace("\n ", "\n", $out);
                $out = clean($out);
                $out = str_replace("&#8216;", "", $out);
                $out = str_replace("&#8217;", "", $out);
                $total_return = trim($out);

                $q = "Update diffquestions set response='$out' where id=" . $row["id"];
                mysql_query($q);
            }
        } else {
            echo "<br>From Data base<br>";
            $total_return = $row["response"];
        }
    }

    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'diffbtw';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
