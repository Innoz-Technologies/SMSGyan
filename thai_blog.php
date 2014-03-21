<?php

if ($spell_checked == "blog") {
    $content = file_get_contents('http://www.thai-blogs.com/');

    if (preg_match('~<li id="recent-posts-3".+>(.+)<li id="meta-5" class="widget-container widget_meta"><h3 class="widget-title">~Usi', $content, $match)) {

        var_dump($match);

        if (preg_match_all('~<a href="(.+)" title=".+">(.+)</a>~Usi', $match[1], $matches)) {
            var_dump($matches);

            $total_return = "Recent Posts";
            for ($i = 0; $i < count($matches[1]); $i++) {

                $link = trim($matches[1][$i]);
                $head = trim(html_entity_decode($matches[2][$i]));

                $options_list[] = $head;
                $list[] = array("content" => "__blog__next__" . $link . "__");
            }
        } else {
            $total_return = "Sorry we coudn't find any post";
        }
    } else {
        $total_return = "Sorry we coudn't find any post";
    }
} elseif (preg_match('~__blog__next__(.+)__~', $req, $match)) {

    echo "<h2>Inside thai Blog</h2>";
    echo $url = trim($match[1]);

    $content = file_get_contents($url);

    if (preg_match('~<div class="entry-content">(.+)</div>~Usi', $content, $match)) {
        echo "<h2>Blog Next 1</h2>";
        $data = trim($match[1]);
        $data = preg_replace('~[\s]+~', " ", $data);
        $data = str_replace("<br />", "+++", $data);
        echo $data = strip_tags($data);
        $data = str_replace("+++", "\n", $data);
        $total_return = $data;
    }
    if (empty($total_return)) {
        if (preg_match('~<div class="entry-content">(.+)<p>Related posts:</p>~Usi', $content, $match)) {
            echo "<h2>Blog Next 2</h2>";
            $data = trim($match[1]);
            $data = preg_replace('~[\s]+~', " ", $data);
            $data = str_replace("<br />", "+++", $data);
            $data = strip_tags($data);
            $data = str_replace("+++", "\n", $data);
            $total_return = $data;
        }
    }
    if (empty($total_return)) {
        $total_return = "No details found";
    }
}

if (!empty($total_return)) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'blog_thai';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>