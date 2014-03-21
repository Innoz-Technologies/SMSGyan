<?php

$body = '';
$first = '';
$second = '';
$from = '';
$to = '';

if (preg_match("~convert (.+) to (.+)~", $spell_checked, $match)) {
    $convert_must = false;
    if (strpos($spell_checked, "convert") == 0) {
        $convert_must = true;
    }
    echo "\n" . $first = trim(preg_replace("~[0-9]~", '', $match[1]));
    echo "\n" . $second = trim(preg_replace("~[0-9]~", '', $match[2]));
    echo "\n" . $amount = trim(preg_replace("~[^0-9]~", '', $spell_checked));
    if (empty($amount)) {
        $amount = 1;
    }

    $url = 'http://bing.com/search?q=' . urlencode($spell_checked) . '&mkt=en-in&go=&qs=n&sk=&form=QBLH&filt=all&cc=in';
    $content = httpGet($url);

    if (preg_match("~Currency Converter</a></div>(.+)<div class=\"cur_ia_row3\">~Usi", $content, $match)) {
        $head = trim(preg_replace("~[0-9]~", "", $spell_checked));
        echo "\n" . ucwords($head) . "\n";

        $body = strip_tags($match[1]);
        $body = str_replace("To", '', $body);

        if (!empty($body)) {
            $head = trim(preg_replace("~[0-9]~", '', $spell_checked));
            $total_return = ucwords($head) . "\n";
            $total_return .=$body;
        }
    } 

    if (empty($body)) {
        if (!empty($first)) {
            echo "<br>" . $query = "SELECT *, MATCH(`cur_val`, `cur_name`) AGAINST('" . $first . "') as score FROM currency WHERE MATCH (`cur_val`, `cur_name`) AGAINST('" . $first . "') ORDER BY score DESC limit 1";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_array($result);
                $from = $row["cur_val"];
                $first = $row["cur_name"];
            } else {
                echo "<br>" . $query = "select * from currency where soundex(cur_val) like soundex('" . $first . "') order by cur_val limit 0,1";
                $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_array($result);
                    $from = $row["cur_val"];
                    $first = $row["cur_name"];
                }
            }
        }

        if (!empty($second)) {
            echo "<br>" . $query = "SELECT *, MATCH(`cur_val`, `cur_name`) AGAINST('" . $second . "') as score FROM currency WHERE MATCH (`cur_val`, `cur_name`) AGAINST('" . $second . "') ORDER BY score DESC limit 1";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_array($result);
                $to = $row["cur_val"];
                $second = $row["cur_name"];
            } else {
                echo "<br>" . $query = "select * from currency where soundex(cur_val) like soundex('" . $second . "') order by cur_val limit 0,1";
                $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_array($result);
                    $to = $row["cur_val"];
                    $second = $row["cur_name"];
                }
            }
        }

        if (!empty($from) && !empty($to)) {
            if (empty($total_return)) {
                echo "<br>" . $url = "http://www.xe.com/ucc/convert/?Amount=" . urlencode(trim($amount)) . "&From=" . urlencode(trim($from)) . "&To=" . urlencode(trim($to));
                $content = file_get_contents($url);

                if (!empty($content)) {
                    preg_match("~<tr class=\"uccRes\">(.+)</table>~Usi", $content, $match);

                    if (!empty($match[1])) {
                        $out = $match[1];
                        $out = html_entity_decode($out);
                        $out = trim(str_replace('<td width="47%" align="right">', "***", $out));
                        $out = preg_replace("~[\s]+~", " ", $out);
                        $out = trim(str_replace('=</td> <td width="47%" align="left">', " = ", $out));
                        $out = trim(str_replace('</a></td> <td width="47%" align="left">', " - ", $out));
                        $out = trim(str_replace('<td width="47%" align="left">', "***", $out));
                        $out = trim(strip_tags($out));
                        $out = trim(str_replace("&nbsp;", " ", $out));
                        $out = trim(str_replace("***", "\n", $out));
                        $out = trim(str_replace("â†”", "", $out));
                        echo $out;
                    }
                }
                if (!empty($out)) {
                    $total_return = $out;
                }
            }
        }
    }

    if ($convert_must && empty($total_return)) {
        $total_return = "Sorry no result found for $spell_checked";
        $to_logserver['isresult'] = 0;
    }
}

if ($total_return) {
    $to_logserver['source'] = 'convert';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
