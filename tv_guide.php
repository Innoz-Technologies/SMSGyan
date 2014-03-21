<?php

$total_return = '';
$query = "select * from tv_channel where name like '%" . $tv_req . "%' order by length(name) limit 1";
$result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_array($result);
    $link = $row['link'];
    $dname = $row['dname'];
} else {
    $query = "SELECT * from tv_channel where SUBSTRING(SOUNDEX(name),1,4) = SUBSTRING(SOUNDEX('" . $tv_req . "'),1,4)";
    $result = mysql_query($query);
    echo "<br>Soundx Query, Count" . mysql_num_rows($result);
    if (mysql_num_rows($result) == 0) {
        $sub = substr($tv_req, 0, 1);
        $query = "SELECT * from tv_channel where name like '" . $sub . "%'";
        $result = mysql_query($query);
        echo "<br>Like Query, Count" . mysql_num_rows($result);
        if (mysql_num_rows($result) == 0) {
            $query = "SELECT * from tv_channel";
            $result = mysql_query($query);
            echo "<br>Query, Count" . mysql_num_rows($result);
        }
    }
    
    $i = 0;
    $m2 = metaphone($tv_req);
    while ($row = mysql_fetch_array($result)) {
        $tvname[$i] = trim($row['name']);
        $tvdname[$i] = trim($row['dname']);
        $tvlink[$i] = trim($row['link']);
        $m1 = metaphone($tvname[$i]);
        //$lev_arry[$i] = levenshtein($m1, $m2);
        $sim[$i] = similar_text($m1, $m2, $perc);
        $percent[$i] = $perc;
        echo 'similarity: ' . $tvdname[$i] . ' : ' . $sim[$i] . ', ' . $perc . '% <br>';
        $i++;
//            $isfound = true;
    }

    $highest = 85;
    $hkey = -1;
    foreach ($percent as$key => $pr) {
        if ($pr >= $highest) {
            $highest = $pr;
            $hkey = $key;
            echo "<br>Matched at: " . $key;
            echo "<br>Match using SIM :" . $trname[$key] . ' Train count:' . $trCount[$key] . '<br>';
        }
    }
    if ($hkey >= 0) {
        $link = $tvlink[$hkey];
        $dname = $tvdname[$hkey];
        echo "<br>Matched Name :" . $tvname[$hkey];
        echo "<br>Matched link :" . $tvlink[$hkey];
    }
}

//if($link!=''&& $curTime)
//{
//    
//   $result=mysql_query("SELECT * FROM tvchannel_store where channel_id ='$link' && date='" . (date("Y-m-d")) . "' ");
//   if($result)
//   {
//        $row = mysql_fetch_array($result); 
//        $code = json_decode($row['details']);
//   }
//
//
//}
$s= date('g:i A');
echo $s;
echo $code;
$total_return=$code;


if ($link != ''&& $code=='') {
    $url = "http://tv.burrp.com/channel/" . $link . "/";
    $result = $dname;
   if (isset($getdate)) {
       echo $getdate;
        echo "Date set:";
        if ($getdate >= strtotime("today") && $getdate <= strtotime("today + 10 days")) {
            $url .= $getdate . '000';
            $result .= "(" . date('jS M', $getdate) . ")";
            $curTime = false;
        }
    } else {
        $add_below = "\n--\nYou can also get program schedule for next 6 days, Eg: TV $dname ON " . date('jS F', strtotime("today + 3 days"));
    }
    echo $url;
    for ($i = 0; $i < 2; $i++) {
        $data = httpGet($url);
        if (preg_match("~<td class=\"resultTime( resultCurrent| resultPast)?\">(.+)</table>~Us", $data, $match)) {
            $total_return = $result . "\n";
            $r=$result;
            $result = str_replace('</tr>', "**", $match[2]);
            $result = strip_tags($result);
            $result = str_replace("Tomorrow's Full Schedule", "", $result);
            $result = str_replace("Playing Now", "(Playing Now)", $result);
            $result = preg_replace("~[\s]+~", " ", $result);
            $result = str_replace(' ** ', "\n", $result);
            $total_return .= trim($result);
       
            $i = 1;
        } else if (strpos($data, 'Awaiting schedule from channel') > 0) {
            $total_return = $result . "\nAwaiting schedule from channel for this date.";
            $free = true;
            $i = 1;
        }
    }

//    $str=json_encode($total_return);

//    if(isset ($total_return))
//    {
//        if($curTime)
//        {
//        echo "entering in to the loop";
//        $query="insert into tvchannel_store(channel_id,date,details) values ('".mysql_escape_string($link)."','".(date("Y-m-d"))."','".mysql_escape_string($str)."')";
//        $r = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//        
//    }
//    }
    
}
?>