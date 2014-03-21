<?php

//$spell_checked = $_GET["q"];
//include 'configdb.php';

if (preg_match("~(elections?|results?) ?(.+)?~", $spell_checked)) {

    $election_word = trim(str_replace("elections", " ", $spell_checked));
    $election_word = trim(str_replace("results", " ", $election_word));
    $election_word = trim(str_replace("result", " ", $election_word));
    $election_word = trim(str_replace("election", " ", $election_word));
    $election_word = strtolower($election_word);

    $arElec = array("uttar pradesh", "uttarakhand", "punjab", "manipur", "Goa");

    if (in_array($election_word, $arElec)) {
        $fetched = apc_fetch($election_word, $success);
        if (!empty($fetched)) {
            echo "from cache\n";
            echo $val = $fetched;
        } else {
            echo "from db\n";
            $url = 'http://www.indian-elections.com/';
            $content = file_get_contents($url);

            if (!empty($content)) {
                preg_match_all("~<A HREF=\"/assembly-elections/.+\" STYLE=\"color:#fffc00;font-size:13px;\">(.+)</TABLE></DIV>~Usi", $content, $match);

                foreach ($match[1] as $id => $val) {
//            echo $val;
                    if ($id == 0) {
                        $state = "Uttar Pradesh";
                    } elseif ($id == 1) {
                        $state = "Uttarakhand";
                        ;
                    } elseif ($id == 2) {
                        $state = "Punjab";
                    } elseif ($id == 3) {
                        $state = "Manipur";
                    } elseif ($id == 4) {
                        $state = "Goa";
                    }

                    $start = strpos($val, "<TABLE");
                    $val = trim(substr($val, $start - 6));

                    $out = '';
                    $val = str_replace("</TD>", "***", $val);
                    $val = str_replace("</TR>", "+++", $val);
                    $val = strip_tags($val);
                    $val = preg_replace("~[\s]+~", " ", $val);
                    $val = str_replace("+++", "\n", $val);
                    $val = trim(str_replace("***", " ", $val));
                    $out = ucfirst($state) . "\n" . $val;

                    if (strtolower($state) == $election_word) {
                        echo $out;
                    }

                    if ($val) {
                        $query = "Update electionresult set data='$out' where state='$state'";
                        if (mysql_query($query)) {
                            echo 'record insertd';
                            apc_store(strtolower($state), $out, 20);
                        }
                    } else {
                        $query = "select * from electionresult where state='$state'";
                        $result = mysql_query($query);

                        if (mysql_num_rows($result)) {
                            $row = mysql_fetch_array($result);
                            $data = $row["data"];
                        }
                    }
                }
            }
        }
    }
}
?>