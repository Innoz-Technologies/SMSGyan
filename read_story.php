<?php

if (preg_match("~_next(.+)~", $req, $match)) {
    echo $id = $match[1];
    echo $id++;
    echo $query = "select id,chapter_title,data from story where id='$id'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $story_data = $row['data'];
        $chapter_title = $row['chapter_title'];
        $id = $row['id'];
        $story_data = $chapter_title . "\n" . $story_data;
    }
    echo $total_return = $story_data;
}
if (strpos($spell_checked, "read") !== false && strpos($spell_checked, "read") == 0) {
    if (preg_match("~read(.+)~", $spell_checked, $smatch)) {
        $search_sword = remwords($smatch[1]);
        echo $search_sword;
        $count = str_word_count($search_sword);
        $search_sword1 = explode(" ", trim($search_sword));
        var_dump($search_sword1);
        $fst_word = $search_sword1[0];
        $secnd_word = trim($search_sword1[1]);
        $trd_word = $search_sword1[2];
        $search_sword = str_replace("ramayana", "", $search_sword);
        $search_sword = preg_replace("~chapter~", "", $search_sword);
        $search_sword = trim($search_sword);
        if (is_numeric($trd_word)) {
            $secnd_word = $secnd_word . " " . $trd_word;
        }
        $secnd_word = str_replace("bhagavad", "bhagavad gita", $secnd_word);

        echo $count;
        if ($count <= 1) {
            echo $query = "select chapter_title,id,data from story where story_title like '%$fst_word%' and chapter_name like'%%'";
            $result = mysql_query($query);
            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);
                $story_data = $row['data'];
                $id = $row['id'];
                $title = $row['chapter_title'];
            }
        } elseif ($count <= 3) {
            echo $query = "select chapter_title,data,id from story where story_title like '%$fst_word%' and chapter_name like '%$secnd_word%'";
            $result = mysql_query($query);
            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);
                $story_data = $row['data'];
                $id = $row['id'];
                $title = $row['chapter_title'];
            } else {
                echo $query = "select chapter_title,id,data from story where story_title like '%$fst_word%' and chapter_title like'%$secnd_word%'";
                $result = mysql_query($query);
                if (mysql_num_rows($result)) {
                    $row = mysql_fetch_array($result);
                    $story_data = $row['data'];
                    $id = $row['id'];
                    $title = $row['chapter_title'];
                }
            }
        } else {
            echo $query = "select chapter_title,data,id from story where story_title like '%$fst_word%' and chapter_title like '%$search_sword%'";
            $result = mysql_query($query);
            if (mysql_num_rows($result)) {
                echo "its here";
                $row = mysql_fetch_array($result);
                $story_data = $row['data'];
                echo $story_data;
                $id = $row['id'];
                $title = $row['chapter_title'];
            }
        }

        $story_data = $title . "\n" . $story_data;
        $total_return = $story_data;
    }
}
if ($total_return) {

    $options_list[] = "Next Chapter";
    $list[] = array("content" => "_next $id");

    $current_file = "/temp/$numbers";
    $source_machine = $machine_id;
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'read_story';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
