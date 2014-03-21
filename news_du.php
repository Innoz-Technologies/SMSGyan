<?php

if (preg_match("~\b^(news|siasat)\b(.+)?~si", $spell_checked, $match)) {
    $search = $match[2];
    $url = "http://gulfnews.com/advanced-search/search-results?action=search&submitted=true&freeText=" . urlencode($search) . "&site=gulfnews&search=Search";
    $content = httpGetDU($url, $search);

    if (preg_match('~<ul class="overview">(.+)</ul>~Usi', $content, $matches)) {

//    var_dump($matches);
        if (preg_match_all('~<li>.+<a title=.+href="(.+)">(.+)</h3>.+</li>~Usi', $matches[1], $match)) {

            foreach ($match[1] as $id => $value) {
                $fst = trim(strip_tags($match[2][$id]));
                if (!empty($fst)) {
                    $options_list[] = $fst;
                    $list[] = array("content" => "__duNews__" . trim(strip_tags($value)) . "__" . $fst . "__");
                }
                echo trim(strip_tags($match[2][$id])) . " " . trim(strip_tags($value)) . "\n";
            }
            if (!empty($fst)) {
                $total_return = "Your query matches more than one result";
            }
        }
    }
} elseif (preg_match("~__duNews__(.+)__(.+)__~Usi", $req, $match)) {
//    var_dump($match);
    echo $url = $match[1];
    echo $search = $match[2];
    $content = httpGetDU($url, $search);

    if (preg_match_all('~<div class="articleBody">(.+)</div>~Usi', $content, $matches)) {
        var_dump($matches);
        foreach ($matches[1] as $value) {
            $total_return .= trim(strip_tags($value));
        }
    } elseif (preg_match_all('~<div class="leadContainer".+>(.+)</div>~Usi', $content, $matches)) {
        foreach ($matches[1] as $value) {
            $total_return .= trim(strip_tags($value));
        }
    }
    if (!empty($total_return)) {
        $total_return = $search . "\n" . $total_return;
    }
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'dunews';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

function httpGetDU($url, $search) {
    $curl = curl_init();

    $header[] = "Accept:*/*";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: close";
    $header[] = "Content-Type:text/plain; charset=UTF-8";
    $header[] = "Accept-Charset: ISO-8859-1;q=0.7,*;q=0.7";    //ISO-8859-1
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // browsers keep this blank.
    $header[] = "X-Requested-With:XMLHttpRequest";
    $header[] = "Cookie:sifrFetch=true; __utma=156143789.1111815642.1379400584.1379400584.1379400584.1; __utmb=156143789.1.10.1379400584; __utmc=156143789; __utmz=156143789.1379400584.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)";

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_REFERER, 'http://gulfnews.com/advanced-search/search-results?action=search&submitted=true&freeText=' . urlencode($search) . '&site=gulfnews&search=Search');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);

    $html = curl_exec($curl); // execute the curl command
    if (curl_error($curl)) {
        trigger_error(curl_error($curl), E_USER_WARNING);
    }
    curl_close($curl); // close the connection
    return $html; // and finally, return $html
}

?>
