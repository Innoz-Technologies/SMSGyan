<?php

function read_news($url) {// = 'http://www.thehindu.com/news/states/tamil-nadu/article1590731.ece'
    $news = false;
    $html = file_get_contents($url);
    $pos = strpos($html, '<div class="articleLead">');
    if ($pos !== false) {
        $pos = strpos($html, '</div>', $pos) + strlen('</div>');
        $pos2 = strpos($html, '<script ', $pos);
        $part = substr($html, $pos, $pos2 - $pos);

        $no_tags = strip_tags($part);

        while (strpos($no_tags, "\n\n") !== false) {
            $no_tags = str_replace("\n\n", "\n", $no_tags);
        }

        $no_tags = str_replace("&#8220;", '"', $no_tags);
        $no_tags = str_replace("&#8221;", '"', $no_tags);
        $no_tags = str_replace("&#8216;", '"', $no_tags);
        $no_tags = str_replace("&#8217;", '"', $no_tags);

        $news = trim(html_entity_decode($no_tags));
    }

    return $news;
}

$resu = read_news($word);
$current_file = "/news/$global_id";
$files = DATA_PATH . "/news/$global_id";
@unlink($files);
file_put_contents($files, $resu);
$news_return = $resu;
//$total_return = substr($resu,0,478);
//putOutput($total_return);
?>
