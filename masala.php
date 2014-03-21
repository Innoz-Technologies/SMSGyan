<?php

if (preg_match("~__gossip__(.+)__~", $spell_checked, $match)) {
    $g_id = $match[1];
}
if (strpos($spell_checked, 'gossip') !== false) {
    $out = '';
    $g_id = 0;
    $head = '';
    $url = "http://www.masala.com/celebrities/news";
//$spell_checked = $_GET['q'];
    echo "from gossip site";
    $spell_checked = preg_replace("~gossip~", " ", $spell_checked);
    echo $spell_checked;
    $spell_checked = trim($spell_checked);
    if (!empty($spell_checked)) {
        echo $query = "select data,id from masala where dated = '" . date("Y-m-d") . "'  AND id!=$g_id AND (MATCH (head ,data) AGAINST('" . $spell_checked . "')) ";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        $set = mysql_num_rows($result);
        if ($set) {
            echo "<br>From DB" . date("Y-m-d") . "<br>";
            $row = mysql_fetch_array($result);
            $result = $row['data'];
            $g_id = $row["id"];
            $total_return = $result;
            $from = 'db';
            echo $result;
        }
    }

    if (empty($set)) {
        echo $query = "select data,id from masala where dated = '" . date("Y-m-d") . "' AND id!=$g_id ORDER BY rand() limit 0,1";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        $set1 = mysql_num_rows($result);
        if ($set1) {
            echo "<br>From DB" . date("Y-m-d") . "<br>";
            $row = mysql_fetch_array($result);
            $result = $row['data'];
            $g_id = $row["id"];
            $total_return = $result;
            $from = 'db';
            echo $result;
        }
    }
    if (empty($set1) && empty($set)) {
        $contents = file_get_contents($url);
        echo $url;
        if (!empty($contents)) {
            if (preg_match_all('~<div class="field-item even" property="dc:title">(.+)</div>~Usi', $contents, $match)) {
                echo "<h2>Inside Gossip Site</h2>";
                for ($i = 0; $i < count($match[1]); $i++) {
                    if (preg_match_all('~<a href="(.+)">~Usi', $match[1][$i], $match1)) {
                        $out[].=$match1[1][0];
                    }
                    if (preg_match_all('~<h(2|1)><a href=".+">(.+)</a></h(2|1)>~Usi', $match[1][$i], $match2)) {
                        $head[].=$match2[2][0];
                    }
                }
            }
        }
        $i = 0;
        $count = count($out);
//        $surl = $out[$i];
        foreach ($out as $a) {
            $data = file_get_contents("http://www.masala.com" . $a);
            if (!empty($data)) {
                $head[$i] . "\n";
                if (preg_match('~<div class="body-content">(.+)</div>~Usi', $data, $match3)) {
                    $story = $match3[1];
                    $story = preg_replace("~[\s]+~", " ", $story);
                    $story = html_entity_decode($story);
                    $story = strtoupper($head[$i]) . "\n" . strip_tags($story);
                    $total_return = $story;
                }
                if (!empty($story)) {
                    echo $query = "insert into masala (data,dated,url,head) values( '" . mysql_real_escape_string($story) . "' ,'" . date("Y-m-d") . "','" . mysql_real_escape_string($out[$i]) . "','" . mysql_real_escape_string($head[$i]) . "')";
                    if (mysql_query($query)) {
                        echo "<br>Record Updated<br>";
//                        $url = $out[$i];
                    }
                }
                $i++;
            }
        }
    }
    if (!empty($total_return)) {
        $options_list[] = "Read Another";
        $list[] = array("content" => "__gossip__" . $g_id . "__");
//    echo $options_list[0];
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'masala_gossip';
        putOutput($total_return);
        exit();
    }
}

//} elseif (!empty($total_return) && $from == 'db') {
//    $options_list[] = "Read Another";
//    $list[] = array("content" => "$url");
//    echo $url;
//}
?>