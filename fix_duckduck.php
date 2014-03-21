<?php

$duck_url = "API";
$duck_in = file_get_contents($duck_url);
$json = json_decode($duck_in, true);
$duck_retrurn = '';
$duck_or_wolf = 'duck';
echo '<br>---------------------------------------------<br>';
var_dump($json);
echo '<br>---------------------------------------------<br>';
$is_wolf = false;

if ($json['AbstractText'] && $json['AbstractSource'] == 'Wikipedia') {  //FULL WIKI ARTICLE
    if (preg_match('~https?://en.wikipedia.org/wiki/(.+)~', $json['AbstractURL'], $matches)) {
        $sr = $matches[1];
        if (!(strpos($sr, ':') > 0 || strpos($sr, '"') > 0 || substr($sr, 0, 7) == 'List_of' || $sr == "Main_Page" || $sr == "Wikipedia")) {
            $return = fetch_mediawiki($sr, true);
            if ($return) {
                echo "FROM DUCKWIKI";
                $total_return = $return['article'];
                $to_logserver['source'] = 'wiki';
                if ($return['media']) {
                    $suggestions[$sugg_index]['option'] = "photo of " . str_replace('_', ' ', $return['title']);
                    $suggestions[$sugg_index]['list'] = array("content" => "__mwiki__image__" . $return['media'], "type" => "photo");
                    $sugg_index++;
                }
            }
        }
    }
} else {
    if ($json['AbstractText']) {
        $duck_retrurn .= $json['AbstractText'] . "\n";
    } elseif ($json['Definition'] && !empty($json["DefinitionSource"])) {
        $duck_retrurn .= $json['Definition'] . "\n";
    }

    if ($json['Answer']) {
        $duck_retrurn .= "Answer: " . $json['Answer'] . "\n";
    }

    if (!$duck_retrurn) {

        $url = '';
        if ($json['Calls']['abstract']) {
            $url = 'API';
            $duck_or_wolf = 'duc2';
        } elseif ($json['Calls']['wa']) {
            $is_wolf = true;
            $duck_or_wolf = 'wolf';
            $url = 'API';
            $query = "update duckduck_count set cnt = cnt + 1 where id =1";
            mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        }
        if ($url) {
            echo "<br>DuckDuckURL:$url";
            $log_count = count($to_logserver['urls']);
            if ($is_wolf) {
                $log_tablr = 'api_wolf';
            } else {
                $log_tablr = 'api_duck';
            }
            $to_logserver['urls'][$log_count][$log_tablr]['url'] = $url;

            $ttime = microtime(true);
//            $duck_in = file_get_contents($url);
            echo "<h3>DUCK data : $duck_in</h3>";
            $ttime = microtime(true) - $ttime;
            $to_logserver['urls'][$log_count][$log_tablr]['fetch_time'] = $ttime;
            if (trim($duck_in)) {
                $to_logserver['urls'][$log_count][$log_tablr]['status'] = 1;
            } else {
                $to_logserver['urls'][$log_count][$log_tablr]['status'] = 0;
            }
            $json = json_decode($duck_in, true);
            var_dump($json);
            echo '<br>---------------------------------------------<br>';
            if ($json[0]['h']) {
                $duck_retrurn .= strtoupper($json[0]['h']) . "\n";
            }
            if ($json[0]['a']) {
                $duck_retrurn .= $json[0]['a'];
            }
            if ($is_wolf) {
                if ($duck_retrurn) {
                    $duck_retrurn .= "\n--\nSrc: WolframAlpha";
                }
                $to_log = date("Y-m-d H:i:s") . " $query_in $duck_in";
                if (filesize("log/wolfduck.log") > 5000000) {
                    $new_name = "log/wolfduck.log." . time();
                    $ren = rename("log/wolfduck.log", $new_name);
                }
                file_put_contents("log/wolfduck.log", "$to_log\n", FILE_APPEND);
            }
        }
    }

    echo "<h3>DUCK result is : $duck_retrurn</h3>";

    if ($duck_retrurn) {
        $duck_retrurn = str_replace('<sup>', '^', $duck_retrurn);
        $duck_retrurn = trim(strip_tags($duck_retrurn));
    }

    if ($duck_retrurn) {
        if ($is_wolf) {
            $source = "wolf";
        } else {
            $source = "duck";
        }
        $wiki_sugg = get_wiki_title($spell_keywords);
        if ($wiki_sugg) {
            $suggestions[$sugg_index]['option'] = $options_list[] = "Article: $wiki_sugg";
            $suggestions[$sugg_index]['list'] = $list[] = array("content" => $wiki_sugg, "type" => "Also read");
            $sugg_index++;
        }
        if ($savetodata) {
            $query = "insert into data_new(query,source,source_id,suggestion) values('" . mysql_real_escape_string($spell_checked) . "','$source',$machine_id,'" . mysql_real_escape_string(json_encode($suggestions)) . "')";
            mysql_query($query) or trigger_error(mysql_error() . " in $query", E_USER_ERROR);
            $id = mysql_insert_id();
            file_put_contents(DATA_PATH . "/$source/$id", $duck_retrurn);
            $current_file = "/$source/$id";
        } else {
            file_put_contents(DATA_PATH . "/temp/$numbers", $duck_retrurn);
            $current_file = "/temp/$numbers";
        }
        $source_machine = $machine_id;
        $to_logserver['source'] = $source;
        $total_return = $duck_retrurn;
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>