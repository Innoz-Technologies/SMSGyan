<?php

if (preg_match("~__readmorechick__(.+)__~Usi", $req, $match)) {
    $url = $match[1];
    $content = file_get_contents($url);
    if (preg_match("~<div class = \"article\">(.+)</div>~Usi", $content, $match)) {
        $article = $match[1];
        $article = trim(preg_replace("~[\s]+~", " ", $article));
        $article = strip_tags($article);
        $article = html_entity_decode($article);
        $article = trim(str_replace("â€™", "'", $article));
        $article = trim(str_replace("â€œ", "\"", $article));
        $article = trim(str_replace("â€", "\"", $article));
        echo $article;
        $total_return = $article;
    }
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'chicks';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~__chicks__(.+)__(.+)__~", $req, $match)) {
    $url = $match[1];
    $chckname = $match[2];
    $content = file_get_contents($url);

// Image chick
    if (preg_match("~<img id = \"avatar\" src = \"(.+)\" alt .+>~Usi", $content, $match)) {
        echo $image_url = $match[1];
        $image_url = file_get_contents("http://IP/services/goo.php?url=" . urlencode($image_url));
    }
    if (preg_match("~<h1 class = \"left\">(.+)</h1>~", $content, $match)) {
        $name = $match[1];
    }
    // About the chick
    if (preg_match("~ <!-- start the attributes -->(.+) <!-- end the attributes -->~Usi", $content, $match)) {
        $about = $match[1];
        $about = trim(preg_replace("~[\s]+~", " ", $about));
        $about = trim(str_replace("</dt>", ":", $about));
        $about = trim(str_replace("</dd>", "\n", $about));
        $about = strip_tags($about);
        $about = html_entity_decode($about);
        $about = trim(str_replace("Add", "Nill", $about));
        $about = trim(str_replace("\n ", "\n", $about));
        $about = trim(str_replace("\n ", "\n", $about));
        echo $about . "\n";
        $total_return = $name . "\n" . $about . "\nImage: " . $image_url;
        $q = "replace into chickpedia(name,about,image) values('" . mysql_real_escape_string($chckname) . "','" . mysql_real_escape_string($about) . "','" . mysql_real_escape_string($image_url) . "')";
        $res = mysql_query($q);
        if ($res) {
            echo "inserted";
        }
        $options_list[] = "Read More";
        $list[] = array("content" => "__readmorechick__" . $url . "__");
    } elseif (preg_match("~<h1 class = \"left\">(.+)</h1>~", $content, $match)) {
        $total_return = $match[1] . "\nNo more details available";
    }
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'chicks';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~^chicks? (.+)~", $spell_checked, $match)) {
    $name = $match[1];
    $name = trim(str_replace(" ", "-", $name));
    $url = trim("http://www.mademan.com/chickipedia/$name");
    $contents = file_get_contents($url);
    if (preg_match("~<img id = \"avatar\" src = \"(.+)\" alt .+>~Usi", $contents, $match)) {
        echo $image_url = $match[1];
        $image_url = file_get_contents("http://IP/services/goo.php?url=" . urlencode($image_url));
    }

    // About the chick
    if (preg_match("~ <!-- start the attributes -->(.+) <!-- end the attributes -->~Usi", $contents, $match)) {
        $about = $match[1];
        $about = trim(preg_replace("~[\s]+~", " ", $about));
        $about = trim(str_replace("</dt>", ":", $about));
        $about = trim(str_replace("</dd>", "\n", $about));
        $about = strip_tags($about);
        $about = html_entity_decode($about);
        $about = trim(str_replace("Add", "Nill", $about));
        $about = trim(str_replace("\n ", "\n", $about));
        $about = trim(str_replace("\n ", "\n", $about));
        echo $about . "\n";
        $total_return = $about . "\nImage: " . $image_url;
        $q = "replace into chickpedia(name,about,image) values('" . mysql_real_escape_string($name) . "','" . mysql_real_escape_string($about) . "','" . mysql_real_escape_string($image_url) . "')";
        $res = mysql_query($q);
        if ($res) {
            echo "inserted";
        }
        $options_list[] = "Read More";
        $list[] = array("content" => "__readmorechick__" . $url . "__");
    } else {
        echo $url = trim("http://www.mademan.com/chickipedia/q/$name");
        $contents = file_get_contents($url);
        if (preg_match("~<p>Matches:</p>(.+)<!-- Previous page Link -->~Usi", $contents, $match)) {
            if (preg_match_all("~<p><a href = \"/chickipedia/(.+)/\">(.+)</a></p>~", $match[1], $matches)) {
                var_dump($matches);
                echo "COUNT:" . count($matches[1]);
                $total_return = "Chicks";
                for ($i = 0; $i < count($matches[1]); $i++) {
                    $url = "http://www.mademan.com/chickipedia/" . trim($matches[1][$i]);
                    $options_list[] = $matches[2][$i];
                    $list[] = array("content" => "__chicks__" . $url . "__" . trim($matches[2][$i]) . "__");
                }
            }
        } else {
            $total_return = "No Chicks Found";
        }
    }
    if ($total_return) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        include 'allmanip.php';
        $to_logserver['source'] = 'chicks';
        putOutput($total_return);
        exit();
    }
} elseif (preg_match("~\b^(chick|chicks)\b~", $spell_checked)) {
    $url = "http://www.mademan.com/chickipedia/";
    $content = file_get_contents($url);
// chick of the day,week,and month
    if (preg_match_all("~Chick of the .+</a>.+<p class = \"chick-name\"><a href = \"/chickipedia/(.+)/\">(.+)</a>~Usi", $content, $match)) {
        echo $name_day = $match[2][0] . "\n";
        echo $name_week = $match[2][1] . "\n";
        echo $name_month = $match[2][2] . "\n";

        echo $url_day = "http://www.mademan.com/chickipedia/" . trim($match[1][0]) . "\n";
        echo $url_week = "http://www.mademan.com/chickipedia/" . trim($match[1][1]) . "\n";
        echo $url_month = "http://www.mademan.com/chickipedia/" . trim($match[1][2]) . "\n";

        $total_return = "Chicks Of The Day,Week,Month!!!";
        $options_list[] = "Chick Of The Day:- $name_day";
        $list[] = array("content" => "__chicks__" . trim($url_day) . "__" . trim($name_day) . "__");
        $options_list[] = "Chick Of The Week:- $name_week";
        $list[] = array("content" => "__chicks__" . trim($url_week) . "__" . trim($name_week) . "__");
        $options_list[] = "Chick Of The Month:- $name_month";
        $list[] = array("content" => "__chicks__" . trim($url_month) . "__" . trim($name_month) . "__");
    }
    if ($total_return) {
        include 'allmanip.php';
        $to_logserver['source'] = 'chicks';
        putOutput($total_return);
        exit();
    }
}
?>