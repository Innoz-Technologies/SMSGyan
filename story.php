<?php

echo '<br>EPISODE STORY<br>';
if (strpos($req, "storyepd") || preg_match("~\b((savitha|savita) (babi|bhabi|bhabbi|bhabhi))\b~", $spell_checked)) {
    include 'episode_story.php';
}

echo "<h3>Sex Story</h3>";
echo $spell_checked;
$isSmust = false;


if (preg_match("~__sexstory_(.+)_(.+)__~", $req, $smatch)) {
    $search_sword = $smatch[1];
    $ss_id = $smatch[2];
} else {
    $search_sword = $spell_checked;
    $ss_id = 0;
}

if (strpos($spell_checked, "sex") !== false) {

    $search_sword = str_replace(",", " ", $search_sword);
    $search_sword = remwords($search_sword);

    $search_sword = preg_replace("~\bstories\b~", "story", $search_sword);
    $search_sword = preg_replace("~\btip\b~", "tips", $search_sword);
    $search_sword = preg_replace("~\bsexy\b~", "sex", $search_sword);
    echo "<h3>story : $search_sword</h3>";
    $s_return = '';

    $arLang = array("malayalam", "english", "hindi", "telugu", "assamese", "tamil", "gujarati", "urdu", "kannada", "bengali", "marathi", "oriya", "punjabi");

    if (preg_match("~(.+) sex (story|tips) (.+)~", $search_sword, $match)) {
        echo "first case";
        $isSmust = true;
        $s_type = $match[2];
        if (str_word_count($match[1]) == 1 && in_array($match[1], $arLang)) {
            $s_lang = $match[1];
            $s_category = $match[3];
        } elseif (str_word_count($match[1]) > 1) {
            $s_ar = explode(" ", $match[1]);
            foreach ($s_ar as $val) {
                if (in_array($val, $arLang)) {
                    $s_lang = $val;
                    $s_category = trim(str_replace($val, "", $match[1]));
                    $s_category2 = $match[3];
                    break;
                }
            }
        }

        if (empty($s_lang)) {
            echo "second cond";
            if (str_word_count($match[3]) == 1 && in_array($match[3], $arLang)) {
                $s_lang = $match[3];
                $s_category = $match[1];
            } elseif (str_word_count($match[3]) > 1) {
                $s_ar = explode(" ", $match[3]);
                foreach ($s_ar as $val) {
                    if (in_array($val, $arLang)) {
                        $s_lang = $val;
                        $s_category = trim(str_replace($val, "", $match[3]));
                        $s_category2 = $match[1];
                        break;
                    }
                }
                if (empty($s_category)) {
                    $s_category = $match[1];
                    $s_category2 = $match[3];
                }
            } else {
                $s_category = $match[1];
                $s_category2 = $match[3];
            }
        }
    } elseif (preg_match("~(.+) sex (story|tips)~", $search_sword, $match)) {
        echo "second case";
        $isSmust = true;
        $s_type = $match[2];
        if (str_word_count($match[1]) == 1 && in_array($match[1], $arLang)) {
            $s_lang = $match[1];
        } elseif (str_word_count($match[1]) > 1) {
            $s_ar = explode(" ", $match[1]);
            foreach ($s_ar as $val) {
                echo "<br>" . $val;
                if (in_array($val, $arLang)) {
                    echo "if";
                    $s_lang = $val;
                    $s_category = trim(str_replace($val, "", $match[1]));
                    break;
                }
            }
            if (empty($s_category)) {
                $s_category = $match[1];
            }
        } else {
            $s_category = $match[1];
        }
    } elseif (preg_match("~sex (story|tips) (.+)~", $search_sword, $match)) {
        echo "Third case";
        $isSmust = true;
        $s_type = $match[1];
        if (str_word_count($match[2]) == 1 && in_array($match[2], $arLang)) {
            $s_lang = $match[2];
        } elseif (str_word_count($match[2]) > 1) {
            $s_ar = explode(" ", $match[2]);
            foreach ($s_ar as $val) {
                if (in_array($val, $arLang)) {
                    $s_lang = $val;
                    $s_category = trim(str_replace($val, "", $match[2]));
                    break;
                }
            }
            if (empty($s_category)) {
                $s_category = $match[2];
            }
        } else {
            $s_category = $match[2];
        }
    } elseif (preg_match("~sex (.+) (story|tips)~", $search_sword, $match)) {
        echo "Third case";
        $isSmust = true;
        $s_type = $match[2];
        if (str_word_count($match[1]) == 1 && in_array($match[1], $arLang)) {
            $s_lang = $match[1];
        } elseif (str_word_count($match[1]) > 1) {
            $s_ar = explode(" ", $match[1]);
            foreach ($s_ar as $val) {
                if (in_array($val, $arLang)) {
                    $s_lang = $val;
                    $s_category = trim(str_replace($val, "", $match[1]));
                    break;
                }
            }
            if (empty($s_category)) {
                $s_category = $match[1];
            }
        } else {
            $s_category = $match[1];
        }
    } elseif (preg_match("~sex (story|tips)~", $search_sword, $match)) {
        echo "Fouth case";
        $isSmust = true;
        $s_type = $match[1];
        $s_lang = "english";
        $s_category = "straight";
    }

    if (isset($s_type) && isset($s_category) && isset($s_lang)) {
        echo "<br>" . $query = "select *  from Knowledge where Language='" . $s_lang . "' and category='" . $s_category . "' and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
    } elseif (isset($s_type) && isset($s_category) && isset($s_lang)) {
        echo "<br>" . $query = "select *  from Knowledge where Language='" . $s_lang . "' and category='" . $s_category . "' and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
    } elseif (isset($s_type) && isset($s_lang)) {
        echo "<br>" . $query = "select *  from Knowledge where Language='" . $s_lang . "' and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
    } elseif (isset($s_type) && isset($s_category)) {
        echo "<br>" . $query = "select *  from Knowledge where category='" . $s_category . "' and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
    }

    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $s_return = $row["Content"];
        $s_id = $row["Id"];
        $s_lang = $row["Language"];
        $s_category = $row["category"];
        $s_type = $row["Type"];
    } else {
        if (isset($s_type) && isset($s_category) && isset($s_lang)) {
            echo "<br>" . $query = "select *  from Knowledge where Language='" . $s_lang . "' and soundex(category)=soundex('" . $s_category . "') and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
        } elseif (isset($s_type) && isset($s_category)) {
            echo "<br>" . $query = "select *  from Knowledge where soundex(category)=soundex('" . $s_category . "') and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
        } elseif (isset($s_type) && isset($s_category2)) {
            echo "<br>" . $query = "select *  from Knowledge where soundex(category)=soundex('" . $s_category2 . "') and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
        }
    }

    if (empty($s_return)) {
        $result = mysql_query($query);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $s_return = $row["Content"];
            $s_id = $row["Id"];
            $s_lang = $row["Language"];
            $s_category = $row["category"];
            $s_type = $row["Type"];
        } else {
            if (isset($s_type) && isset($s_lang)) {
                echo "<br>" . $query = "select *  from Knowledge where Language='" . $s_lang . "' and Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
            } elseif (isset($s_type)) {
                echo "<br>" . $query = "select *  from Knowledge where Type='" . $s_type . "' and session='sex' and id !=$ss_id order by rand()";
            } 
        }
    }

    if (empty($s_return)) {
        $result = mysql_query($query);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $s_return = $row["Content"];
            $s_id = $row["Id"];
            $s_lang = $row["Language"];
            $s_category = $row["category"];
            $s_type = $row["Type"];
        } else {
            if (isset($s_type)) {
                echo "<br>" . $query = "select *  from Knowledge where Type='" . $s_type . "' and session='sex' and id !=$ss_id and Language IN ('english', '$circle_lang') order by rand()";
            }
        }
    }

    if (empty($s_return)) {
        $result = mysql_query($query);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $s_return = $row["Content"];
            $s_id = $row["Id"];
            $s_lang = $row["Language"];
            $s_category = $row["category"];
            $s_type = $row["Type"];
        }
    }

    if ($s_return) {
        $total_return = $s_return;
        if (isset($s_lang)) {
            if (isset($s_category)) {
                echo "<br>" . $query = "select distinct(category) as cat,Language from Knowledge where Language='$s_lang' and category not like '' and category not like '$s_category' and Session='sex' and id !=$ss_id order by rand()";
            } else {
                echo "<br>" . $query = "select distinct(category) as cat,Language from Knowledge where Language='$s_lang' and category not like '' and Session='sex' and id !=$ss_id order by rand()";
            }
            $res = mysql_query($query);
            $cnt = 0;
            while (($row = mysql_fetch_array($res)) && $cnt < 3) {
                if ($row["cat"] != "straight") {
                    $options_list[] = $row["cat"] . " sex story";
                    $list[] = array("content" => $row["Language"] . " " . $row["cat"] . " sex story");

                    $cnt +=1;
                }
            }
        }
        $options_list[] = "read another";
        $list[] = array("content" => "__sexstory_$s_lang $s_category sex " . $s_type . "_" . $s_id . "__");
        $options_list[] = "savitha bhabhi stories";
        $list[] = array("content" => "savitha bhabhi stories");
        var_dump($options_list);
        $source_machine = 'db';
        $current_file = "Knowledge/Content/Id/" . $s_id;
        $to_logserver['source'] = 'sex story';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
