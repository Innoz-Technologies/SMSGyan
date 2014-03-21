<?php

$reviewapp = TRUE;
$xmlappFlag = FALSE; // to know whether its XML APP
$appStore = false;
$setOpn = TRUE;
$to_cache['l'] = 0;
$apps_date = date("Y-m-d");

echo "REQUEST" . $req;
if ($req == "more" || $req == "more options") {
    $query_in_keyword = $req;
}

$appResponse = array();

if (strpos($req, '__xmlapp__') !== false && strpos($req, '__xmlapp__') == 0) {
//    $free = $isGyanFree;
    if (preg_match("~^__xmlapp__(.+)__(.+)~", $req, $match)) {
        $query = "select * from app_keyword where id = " . $match[1];
        echo "<br>APP REQ QUERY: $query";
        $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $log_count = count($to_logserver['urls']);
            $to_logserver['urls'][$log_count]['app']['url'] = $match[2];
            $to_logserver['urls'][$log_count]['app']['app'] = $row['keyword'];
            $to_logserver['urls'][$log_count]['app']['app_id'] = $row['id'];
            $to_logserver['urls'][$log_count]['app']['status'] = 1;

            if (!$free && $row['msisdn'] != $number) {
                $to_logserver['urls'][$log_count]['app']['is_paid'] = 1;
                $nextfree = 1;
            } else {
                $to_logserver['urls'][$log_count]['app']['is_paid'] = 0;
                $nextfree = 2;
            }
            $url = trim($match[2]);
            $ttime = microtime(true);
            echo $content = utf8_encode(httpGet($url));

            $ttime = microtime(true) - $ttime;
            $to_logserver['urls'][$log_count]['app']['fetch_time'] = $ttime;
            $apResponse = getAppResponse($content, 'xml');

            $xmlappFlag = TRUE; // set as TRUE to know it as XML APP
            $appID = $row['id'];

            unset($lists);
            unset($options_list);
            unset($recom_opns_list);
            unset($recom_list);
            unset($list);
            $apResponse = getAppResponse($content, "xml");

            if (isset($apResponse)) {
                $total_return = $apResponse;

                $source_machine = $machine_id;
                $current_file = "/temp/$numbers";
                file_put_contents(DATA_PATH . $current_file, $total_return);

                $app_name = $xmlApp;
                $keyword = str_replace("xml__", "", $app_name);

                $flagxml = false;
            }

            if (!$total_return) {
                $total_return = "Sorry, the application returned no data";
                $free = true;
                $showSub = false;
                $to_logserver['isresult'] = 0;
                $to_logserver['urls'][$log_count]['app']['status'] = 0;
            } else if ($to_logserver['urls'][$log_count]['app']['is_paid']) {
                $free = false;
                $nextfree = 2;
            } else if ($to_logserver['urls'][$log_count]['app']['is_paid'] == 0) {
                $free = true;
                $nextfree = 1;
            }
        }
    }
    $reviewapp = FALSE;
} elseif (strpos($query_in_keyword, '#') !== false && strpos($query_in_keyword, '#') == 0) {
    echo "<br>Queru in keyword: $query_in_keyword";
    if ((strpos($query_in_keyword, ' ') !== false && strpos($query_in_keyword, ' ') == 1) || $query_in_keyword == "#") {

        $total_return = recomndapp();
        $add_below = '';

        $log_count = count($to_logserver['urls']);
        $to_logserver['urls'][$log_count]['app']['url'] = '#';
        $to_logserver['urls'][$log_count]['app']['app'] = '#';
        $to_logserver['urls'][$log_count]['app']['app_id'] = 0;
        $to_logserver['urls'][$log_count]['app']['status'] = 1;
        $to_logserver['urls'][$log_count]['app']['is_paid'] = 0;
        $to_logserver['urls'][$log_count]['app']['fetch_time'] = 0;

        if (!$free == true) {
            $msisdn = $numbers;
            $apps_id = 0;
            $apps_name = '#';
            $to_logserver['urls'][$log_count]['app']['is_paid'] = 1;
        }
    } elseif (preg_match("~(#[\w\d]{2,20})(.*)?~", $query_in_keyword, $match)) {

        $gyan_keywords = array("#cri", "#ipl", "#love", "#lyrics", "#locate", "#route", "#showtimes", "#bus", "#local", "#train", "#price", "#gc", "#tc", "#weather", "#tv", "#epl", "#news", "#pnr", "#photo", "#video", "#book", "#expand", "#dict", "#jobs", "#joke", "#convert", "#horoscope", "#recipe", "#stock", "#deal", "#unpluggd", "#hackathon", "#ht", "#chicks", "#startupvillage", "#std", "#facts", "#pincode", '#chat', '#namaz', '#goldprice', "#quotes", "#iccrankings", "#bus", "#oly", "#quiz", "#song", "#twenty20", "#whois", '#auto', '#appoftheday', '#aotd', "#friend", "#recipris", "#distance", "#justeat", "#redbus", "#diffbtw", "#food", "#flame", "#truecaller", "#trace", "#fine", "#fines", "#sachin", "#twitter", "#aids", "#dhoom3", "#xmas", "#wishlist", "#resolution", "#salman", "#2014", "#aap", "#marykom", "#jilla", "#veeram", "#yevadu", "#nenokkadine");
        $keyword = strtolower($match[1]);
        if (in_array($keyword, $gyan_keywords)) {
            echo "<br>Gyan Keyword";
            $req = substr($req, 1);
            $spell_checked = substr($spell_checked, 1);
            $nextfree = 2;
            $appStore = true;

            $add_below = "\n--\n" . getAppScript();

            if ($free) {
                $nextfree = 1;
            } else {
                $apps_name = $keyword;

                $apps_id = 0;

                $msisdn = $numbers;
                $log_count = count($to_logserver['urls']);
                $to_logserver['urls'][$log_count]['app']['url'] = '#';
                $to_logserver['urls'][$log_count]['app']['app'] = $keyword;
                $to_logserver['urls'][$log_count]['app']['app_id'] = $apps_id;
                $to_logserver['urls'][$log_count]['app']['status'] = 1;
                $to_logserver['urls'][$log_count]['app']['is_paid'] = 0;
                $to_logserver['urls'][$log_count]['app']['fetch_time'] = 0;
            }
        } else {
            echo "<br>APP KEYWORD: $keyword";
            if (!empty($match[1])) {
                $api_input = trim(substr($query_in_keyword, strlen($match[1])));
            } else {
                $api_input = '';
            }

            echo "<br>APP INPUT: $api_input";
            $query = "select * from app_keyword where `keyword` = '" . $keyword . "' and status != 4";
            echo "<br>APP REQ QUERY: $query";
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

            if (mysql_num_rows($result)) {
                echo "<h3>App status check $app_status</h3>";
                $row = mysql_fetch_array($result);

                if (($row['status'] != 1 && $row['msisdn'] != $number) && $app_status != ' and status < 4') {
                    if ($row['status'] == 3)
                        $total_return = 'Sorry, this app is temporarily down. Please try after some time.';
                    else
                        $total_return = 'App not found, please check the app name and try again.';

                    $free = true;
                    $showsuboption = false;
                }else {
                    echo "<h3>App type html</h3>" . $row['type'];
                    $log_count = count($to_logserver['urls']);
                    $to_logserver['urls'][$log_count]['app']['url'] = 'site';
                    $to_logserver['urls'][$log_count]['app']['app'] = $keyword;
                    $to_logserver['urls'][$log_count]['app']['app_id'] = $row['id'];
                    $to_logserver['urls'][$log_count]['app']['status'] = 1;

                    echo "<h1>" . $row["msisdn"] . " : $number</h1>";
                    if (!$free && $row['msisdn'] != $number) {
                        $to_logserver['urls'][$log_count]['app']['is_paid'] = 1;
                        $nextfree = 1;
                    } else {
                        $to_logserver['urls'][$log_count]['app']['is_paid'] = 0;
                        $nextfree = 2;
                    }

                    switch ($row['type']) {
                        case 'chat':
                            $to_logserver['urls'][$log_count]['app']['url'] = 'chat';

                            mysql_close();
                            include 'lib/configdb2.php';

                            echo $query = "select * from gChat_master where memberNumber='$number' and groupName='$keyword'";
                            $result = mysql_query($query);

                            if (mysql_num_rows($result)) {
                                $row = mysql_fetch_array($result);
                                echo $grpName = $row['groupName'];
                                echo $membrname = $row['memberName'];
                                echo $gid = $row['gid'];

                                if (preg_match("~$keyword (.+)~si", $query_in_keyword, $matched)) {
                                    var_dump($matched);
                                    if (!empty($matched[1])) {
                                        echo $query = "insert into  gChat_message(groupid,memberName,number,message) values ($gid,'$membrname','$number','" . mysql_real_escape_string(trim($matched[1])) . "')";
                                        if (mysql_query($query)) {
                                            echo "updated gChat message";
                                        }
                                    }
                                }
                                echo $q = "select * from gChat_message where groupid=$gid order by timestamp desc limit 10";
                                $res = mysql_query($q);

                                if (mysql_num_rows($res) <= 0) {
                                    $out = "No chat message is there to be displayed";
                                } else {
                                    while ($row = mysql_fetch_array($res)) {
                                        $final_msg.= $row["memberName"] . ": " . $row["message"] . "\n";
                                    }
                                    $out = "$final_msg";
                                }
                            } else {
                                $out = "You are not a member of this chat group";
                            }
                            echo $out;

                            if (!empty($out)) {
                                mysql_close();
                                include 'lib/appconfigdb.php';

                                $total_return = $out;
                                $source_machine = $machine_id;
                                $current_file = "/temp/$numbers";
                                file_put_contents(DATA_PATH . $current_file, $total_return);
                            }
                            break;
                        case 'site':
                            echo "<h3>Response is </h3> $content";

                            $total_return = $row['response'];
                            $current_file = "app_keyword/response/id/" . $row['id'];
                            $source_machine = "db";
                            break;
                        case 'location':
                            $app_key = $row['app_key'];
                            $url = "";
                            $user = md5($number);
                            if ($operator == "airtel" && $row['type'] == 'location') {

                                echo "<h2>LOC BASED APP</h2>";

                                $url .= "?mobile=$user&region=$tele_state";


                                $data = getLocAPI($number, 3600);

                                if (!empty($data["lat"]) && !empty($data["long"])) {
                                    $lat = round($data["lat"], 2);
                                    $long = round($data["long"], 2);


                                    $url.="&lat=$lat&long=$long";
                                }
                                if (!empty($data["city"])) {
                                    $city = strtolower($data["city"]);
                                    $url.="&city=$city";
                                }if (!empty($data["state"])) {
                                    $state = strtolower($data["state"]);
                                    $url.="&state=$state";
                                }if (!empty($data["district"])) {
                                    $district = strtolower($data["district"]);
                                    $url.="&district=$district";
                                }if (!empty($data["street"])) {
                                    $street = strtolower($data["street"]);
                                    $url.="&street=$street";
                                }
                                if (!empty($data["info"])) {
                                    $info = strtolower($data["info"]);
                                    $url.="&info=" . urlencode($info);
                                }if (!empty($data["zip"])) {
                                    $zip = strtolower($data["zip"]);
                                    $url.="&zip=$zip";
                                }

                                $url.="&key=$app_key&message=" . urlencode($api_input);

                                $islbs = TRUE;
                                $charge_per_query = 1;

                                $to_cache['l'] = 1;
                            }
                        case 'html':
                            $app_key = $row['app_key'];
                            $user = md5($number);

                            if (in_array($keyword, array("#float", "#change"))) {
                                if ($keyword == "#change") {
                                    $setOpn = false;
                                }
                                $user = $number;
                            }

                            if (empty($url)) {
                                $url = $row['api'] . "?mobile=$user&region=" . urlencode($tele_state) . "&key=$app_key&message=" . urlencode($api_input);
                            } else {
                                $url = $row['api'] . $url;
                            }


                            if ($user == '755cbf4859e0408e69423bbf48cb2c5e')
                                $url .= "&access_token=" . urlencode($_GET['op']);

                            if ($keyword == "#en" || $keyword == "#goldalwar" || $keyword == "#mard" || $keyword == "#fb") {
                                $url .= "&number=$number&circle=" . urlencode($_GET['circle']) . "&op=" . urlencode($_GET['op']);
                            }


                            echo "<h2>APP URL<h2>:$url";
                            $ttime = microtime(true);
                            echo "<h2>before content</h2>";
                            echo $content = httpGet($url);
                            echo "<h2>after content : </h2>";

                            $ttime = microtime(true) - $ttime;
                            $to_logserver['urls'][$log_count]['app']['url'] = $url;
                            $to_logserver['urls'][$log_count]['app']['fetch_time'] = $ttime;

                            if (stripos($content, '<body>') !== FALSE && stripos($content, '</body>') !== FALSE) {
                                $showSub = false;
                                $app_name = $keyword;
                                $total_return = getAppResponse($content, "html");
                            } elseif (stripos($content, '<response>') !== FALSE && stripos($content, '</response>') !== FALSE) {
                                $xmlappFlag = TRUE; // set as TRUE to know it as XML APP
                                $appID = $row['id'];

                                unset($lists);
                                unset($options_list);
                                unset($recom_opns_list);
                                unset($recom_list);
                                unset($list);
                                $apResponse = getAppResponse($content, "xml");

                                if (isset($apResponse)) {
                                    $total_return = $apResponse;

                                    echo "<h3>Options</h3>";
                                    var_dump($options_list);
                                    $app_name = "xml__" . $keyword; // set for Next Page;
                                    $source_machine = $machine_id;
                                    $current_file = "/temp/$numbers";
                                    file_put_contents(DATA_PATH . $current_file, $total_return);
                                }
                            } else {
                                echo "<h2>HTML w/o body tag content</h2>";
                                $data = preg_replace("~<(br|p)/?>~i", "\n", $content);
                                $total_return = strip_tags($data);
                                $total_return = html_entity_decode($total_return);
                                $total_return = substr($total_return, 0, 400);
                                $total_return = trim($total_return);
                                $app_name = "xml__" . $keyword;
                                $flagxml = false;
                            }
                            break;
                        default:
                            break;
                    }

                    if (empty($total_return)) {
                        $total_return = "Sorry, the application returned no data";
                        $free = true;
                        $showSub = false;
                        $to_logserver['isresult'] = 0;
                        $to_logserver['urls'][$log_count]['app']['status'] = 0;
                    } else if ($to_logserver['urls'][$log_count]['app']['is_paid']) {
                        $free = false;
                        $nextfree = 2;
                    } else if ($to_logserver['urls'][$log_count]['app']['is_paid'] == 0) {
                        $free = true;
                        $nextfree = 1;
                    }
                }
            } else {
                $total_return = 'App not found, please check the app name and try again';
                $free = true;
                $showSub = false;
                $to_logserver['isresult'] = 0;
            }

            if ($total_return) {
                if ($islbs && $row['msisdn'] != $number) {
                    $free = FALSE;
                }

                if (!empty($arCacheData["trans"])) {

                    $lang = ucfirst($arCacheData["trans"]["lang"]);
                    $addtext = "English to $lang Translator : Enter your string to continue translation or";

                    $total_return = $total_return . "\n" . $addtext;

                    var_dump($arCacheData["trans"]);

                    echo "<h2>INSIDE QUIT OPTION APP MAIN</h2>";

                    $options_list[] = "quit";
                    $list[] = array("content" => "__trans__quit__");

                    $options_list[] = "main menu";
                    $list[] = array("content" => "__trans__main__");
                }
            }
        }
    }
}

$script = array();

function getAppResponse($content, $type) {
    global $appID;
    global $options_list, $list;
    $return = "";

    switch ($type) {
        case 'html':
            echo "<h3>App type html</h3>";

            $start = stripos($content, '<body>');
            $end = stripos($content, '</body>');
            if ($start != 0 && $end != 0) {
                $data = substr($content, $start + 6, $end - ($start + 6));
                $data = preg_replace("~<(br|p)/?>~i", "\n", $data);
                $data = html_entity_decode($data);
                $return = strip_tags($data);
                $return = html_entity_decode($return);
                $return = substr($return, 0, 400);
            }
            break;
        case 'xml':
            echo "<h3>App type xml</h3>";
            if (preg_match('~<content>(.+)</content>~si', $content, $match)) {
                $match[1] = html_entity_decode($match[1]);
                $return = trim($match[1]);
            }

            if (preg_match_all('~<option name="(.+)" url="(.+)"(.*)/>~Usi', $content, $matches)) {
                foreach ($matches[1] as $i => $value) {
                    $options_list[] = substr(html_entity_decode(trim($value)), 0, 100);
                    $list[] = array("content" => "__xmlapp__" . $appID . "__" . html_entity_decode(trim($matches[2][$i])));
                }
            }
            break;
    }
    return $return;
}

function getXmlValue($response, $tag1, $tag2) {
    $str = "";
    $p1 = strpos($response, $tag1);
    if ($p1 !== false) {
        $p1 = $p1 + strlen($tag1);
        $p2 = strpos($response, $tag2, $p1);
        $str = substr($response, $p1, $p2 - $p1);
    }
    return $str;
}

?>