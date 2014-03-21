<?php

if (strlen($linkedin_url) > 0) {
    if (!preg_match("~\b(define|trace|how|when|what|which|why|route|direction|movie|song|poem|weather|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|expand|pnr|dict|photos?|party|city)\b~i", $req) && !preg_match("~^(friend|love|fc|l0v|luv)~si", $bing_url)) {
        echo '<br> Linkedin Answers<br>';

        $content = file_get_contents($linkedin_url);
        $linkedin_return = '';

//        if ($fromSite) {
//            $query = "insert ignore into linkedin (query,url,isDir) values('" . trim(mysql_real_escape_string($lquery)) . "','" . trim(mysql_real_escape_string($linkedin_url)) . "','$ldir')";
//            if (mysql_query($query)) {
//                echo "<br>Record Insertd";
//            }
//        }

        if ($ldir == true) {
            echo '<br> Linkedin list<br>';
            $flag_enabled = FALSE;
            preg_match_all("~<li class=\"vcard\">(.+)<dt>Demographic~Usi", $content, $matched);

            $data_l = $matched[1];
//        echo serialize($data_l);

            $arLnkd = array();
            $arAir = array();
            $IsAir = false;
            echo '<br>';
            $count = 0;
            foreach ($data_l as $id => $val) {
                $IsAir = false;
                preg_match("~<dd class=\"title\">(.+)</dd>~Usi", $val, $title);
                $title[1] = trim(str_replace('&#8211;', "-", $title[1]));
                $title[1] = trim(str_replace('&#x2013;', "", $title[1]));
                $title[1] = trim(str_replace('&#x2019;', "", $title[1]));
                $title[1] = trim(str_replace('&amp;', "", $title[1]));
                $title[1] = trim(preg_replace("~[\s]+~", " ", $title[1]));
                if (stripos($title[1], "Aircel") !== false) {
                    $arAir[$id]["title"] = $title[1];
                    $IsAir = true;
                } else {
                    $arLnkd[$id]["title"] = $title[1];
                }

                preg_match("~<span class=\"given-name\">(.+)</span></a>~Usi", $val, $name);
                $namel = $name[1];
                $namel = strip_tags($namel);

                $namel = trim(str_replace('&#8211;', "-", $namel));
                $namel = trim(str_replace('&#x2013;', "", $namel));
                $namel = trim(str_replace('&#x2019;', "", $namel));
                $namel = trim(str_replace('&amp;', "", $namel));
                $namel = trim(preg_replace("~[\s]+~", " ", $namel));

                if ($IsAir == true) {
                    $arAir[$id]["name"] = $namel;
                } else {
                    $arLnkd[$id]["name"] = $namel;
                }

                preg_match("~<a href=\"http://.+(linkedin.com/(pub|in)/.+)\".+>~Usi", $val, $UrlL);
                if ($IsAir == true) {
                    $arAir[$id]["url"] = "http://www.$UrlL[1]";
                } else {
                    $arLnkd[$id]["url"] = "http://www.$UrlL[1]";
                }
            }

            $arLnkd = array_merge($arAir, $arLnkd);

            if (count($data_l) > 1) {
                $query = "insert ignore into linkedin (query,url,isDir) values";
                for ($id = 0; $id < count($arLnkd); $id++) {
                    if (!empty($arLnkd[$id]['url'])) {
                        $options_list[] = trim($arLnkd[$id]['name']) . "\n" . trim($arLnkd[$id]['title']);
                        $list[] = array("content" => '__person__detail__' . $arLnkd[$id]['url'] . '__');

                        $query .= "('" . trim(mysql_real_escape_string($arLnkd[$id]['name'])) . "','" . trim(mysql_real_escape_string($arLnkd[$id]['url'])) . "','0'),";
                    }
                }

                echo $query = substr($query, 0, strlen($query) - 1);
//                if ($fromSite && mysql_query($query)) {
//                    echo "<br>Record Insertd";
//                }

                if (count($options_list) > 0) {
                    echo '<br>Return<br>';
                    echo $total_return = ucwords($lquery);
                }
                echo '<br>';
                var_dump($options_list);
                echo '<br>';
                var_dump($list);

                if ($total_return) {
                    $source_machine = $machine_id;
                    $current_file = "/temp/$numbers";
                    file_put_contents(DATA_PATH . $current_file, $total_return);
                    $to_logserver['source'] = 'linkedin';
                    include 'allmanip.php';
                    putOutput($total_return);
                    exit();
                }
            } else {
                if (!empty($arLnkd[0]["url"])) {
                    $content = file_get_contents($arLnkd[0]["url"]);
                    $query = "Replace into linkedin(query,url,isDir) values('" . trim(mysql_real_escape_string($lquery)) . "','" . trim(mysql_real_escape_string($arLnkd[0]["url"])) . "','$ldir')";
//                    if (mysql_query($query)) {
//                        echo "<br>Record Insertd";
//                    }
                }
            }
        }

        if (!empty($content)) {
            $plinkedin_url = "";
            $content = preg_replace("~<div class=\"join-linkedin.+\">(.+)<p class=\"actions\">~Usi", "", $content);

            preg_match("~<div id=\"content\" class=\"resume hresume\">(.+)<div id=\"extra\">~Usi", $content, $match);

            preg_match("~ <img src=\"(.+)\" class=\"photo\" width=\"100\" height=\"100\".+>~Usi", $content, $image);
            if (!empty($image)) {
                echo $plinkedin_url = $image[1];
            }

            preg_match("~<div id=\"member-1\" class=\"masthead vcard contact\">(.+)<h2 class=\"section-title\">~Usi", $match[1], $match_main);

            if (!empty($match_main)) {
                $main = $match_main[1];
                $main = trim(preg_replace('~<dt>|</li>|</h2>|<h2 class="section-title">|<p class="headline-title title" style="display:block">~', "***", $main));
                $main = trim(str_replace('</dt>', ":", $main));
                $main = trim(preg_replace('~\bsee|less|all\b~', "", $main));

                $desc = $main = strip_tags($main);
                $desc = trim(str_replace("***", ",", $desc));
                echo $desc = trim(preg_replace("~[\s]+~", " ", $desc));

                $main = trim(str_replace('View Full Profile', "", $main));
//        echo "<h1> $main</h1>";
                $linkedin_return .= $main . "\n";
            }

            preg_match("~<h2 class=\"section-title\">(.+)<dt id=\"overview-summary-education-title.+>~Usi", $match[1], $match_main);

            if (!empty($match_main)) {
                $main = $match_main[0];
                $main = trim(preg_replace('~<dt>|</li>|</h2>|<h2 class="section-title">|<p class="headline-title title" style="display:block">~', "***", $main));
                $main = trim(str_replace('</dt>', ":", $main));
                $main = trim(preg_replace('~\bsee|less|all\b~', "", $main));

                $main = strip_tags($main);
                $linkedin_return .= $main . "\n";
            }
            preg_match("~<div class=\"section subsection-reorder summary-education.+>(.+)<div class=\"section\" id=\"profile-additional.+>~Us", $match[1], $match_h3);

            if (!empty($match_h3)) {
                $h1 = $match_h3[1];
//        echo serialize($h1);
                $h1 = trim(preg_replace('~<br> <br>|</h2>|<h3>|<\h3>|<h2>|<span class="title">|\*|<em>|<h3 class="summary fn org">~', "***", $h1));
                $h1 = trim(preg_replace('~</h3>~', ":", $h1));
                $h1 = strip_tags($h1) . "\n";

                $linkedin_return.=$h1 . "\n";
            }

            preg_match("~<div class=\"section\" id=\"profile-summary\" style=\"display:block\">(.+)<div class=\"section subsection-reorder\" id=\"profile-experience\" style=\"display:block\">~Usi", $match[1], $match_h1);

            if (!empty($match_h1)) {
                $h1 = $match_h1[1];
                $h1 = trim(preg_replace('~<br> <br>|</h2>|<h3>|<\h3>|<h2>|<span class="title">|\*|<em>|<h3 class="summary fn org">~', "***", $h1));
                $h1 = trim(preg_replace('~</h3>~', ":", $h1));
                $h1 = strip_tags($h1) . "\n";

                $linkedin_return.=$h1 . "\n";
            }

            preg_match("~<div class=\"section subsection-reorder\" id=\"profile-experience\" style=\"display:block\">(.+)<div class=\"section subsection-reorder summary-education\" id=\"profile-education\" style=\"display:block\">~Usi", $match[1], $match_h2);

//    var_dump($match_h2);
            if (!empty($match_h2)) {
                $h1 = $match_h2[1];
                $h1 = trim(preg_replace('~<br> <br>|</h2>|<h3>|<\h3>|<h2>|<span class="title">|\*|<em>|<h3 class="summary fn org">~', "***", $h1));
                $h1 = trim(preg_replace('~</h3>~', ":", $h1));
                $h1 = strip_tags($h1) . "\n";

                $linkedin_return.=$h1 . "\n";
            }

            $linkedin_return = trim(str_replace('&#8211;', "-", $linkedin_return));
            $linkedin_return = trim(str_replace('&#x2013;', "", $linkedin_return));
            $linkedin_return = trim(str_replace('&#x2019;', "", $linkedin_return));
            $linkedin_return = trim(str_replace('&amp;', "", $linkedin_return));
            $linkedin_return = trim(str_replace(';', ",", $linkedin_return));
            $linkedin_return = trim(preg_replace("~[\s]+~", " ", $linkedin_return));
            $linkedin_return = trim(str_replace("***", "\n", $linkedin_return));
            $linkedin_return = str_replace("\n ", "\n", $linkedin_return);
            $total_return = clean($linkedin_return);
        }
        if ($total_return) {
            $link_imageid = 0;
            $arlink = explode(",", $desc);
            var_dump($arlink);

            if (strlen($plinkedin_url) > 0) {
                $query = "SELECT imageid FROM linkedin_photo where query = '" . mysql_real_escape_string($spell_checked) . "'";
                echo "<br>$query<br>";
                $result = mysql_query($query) or print(mysql_error() . "  in $query");

                if (mysql_num_rows($result)) {
                    echo '<h5>image found in db</h5>';
                    $row = mysql_fetch_array($result);
                    $link_imageid = $row["imageid"];
                    $options_list[] = "Photo of $arlink[0]";
                    $list[] = array("content" => "__mwiki__image__" . $link_imageid);
                } else {

                    echo $desc = $arlink[0] . $arlink[1];
                    $desc = trim(str_replace('&#8211;', "-", $desc));
                    $desc = trim(str_replace('&#x2013;', "", $desc));
                    $desc = trim(str_replace('&#x2019;', "", $desc));
                    $desc = trim(str_replace('&amp;', "", $desc));

                    $link_imageid = file_get_contents("http://IPs/gyanmobi/w/link_image.php?imageurl=" . urlencode($plinkedin_url) . "&otherimages=" . urlencode($spell_checked) . "&desc=" . urlencode($desc));
                    if (is_numeric($link_imageid)) {
                        echo "<h3>Image entered: $link_imageid</h3>";
                        $options_list[] = "Photo of $arlink[0]";
                        $list[] = array("content" => "__mwiki__image__" . $link_imageid);

                        $q = "insert into linkedin_photo(query,imageid) values('" . mysql_real_escape_string($spell_checked) . "'," . $link_imageid . ")";
                        if (mysql_query($q)) {
                            echo "<br>Record inserted to image db<br>";
                        }
                    }
                }
            }
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $total_return);
            $to_logserver['source'] = 'linkedin';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
        echo $total_return;
    }
}
?>