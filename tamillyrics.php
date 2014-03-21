<?php
function string1_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return false;
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    if(strpos($string,$end))
    {
       return substr($string,$ini,$len);
    }
    else
    {
       return false;
    }
}
function get1_link($query) {
    $search = "site:www.tamillyrics.net " . $query;
    $bing_results = bing_search($search);
    return $bing_results['urls'][0];
//    //$url = "http://www.google.co.in/search?hl=en&q=" . urlencode($search) . "&btnG=Search&meta=";
//    //$url = "http://www.google.co.in/search?hl=en&source=hp&q=" . urlencode($search) . "&aq=f&aqi=&aql=&oq=&gs_rfai=";
//
//    $ttime = microtime(true);
//    $response = rawurldecode(httpGet($url));
//    $ttime = microtime(true) - $ttime;
//    //file_put_contents("wikihowgle.htm",$response);
//    echo "<br>Google Search: $ttime<br>";
//    preg_match_all('~<a href="http://www.tamillyrics.net/([^":]+)"~', $response, $matches);
//    //print_r($matches);
//    echo "Google search results:\n";
//    $google_search_results = $matches[1];
//    $google_search_results = array_values($google_search_results);
//    print_r($google_search_results);
//    echo "<br>\n------------------<br>\n";
//    if (isset($matches[1][0])) {
//        echo "<br>Google search result: $google_search_results[0]<br>";
//        return urldecode($google_search_results[0]);
//    } else
//        return '';
}

 $mp = get1_link($word);
 $lyurl = "http://www.tamillyrics.net/".$mp;
 echo "Result: $lyurl";
 echo "<br>\n------------------<br>\n";
 $ttime = microtime(true);
 $response = httpGet($lyurl);
 $ttime = microtime(true) - $ttime;
 $out = string1_between($response, '<table  border="0" cellspacing="0" cellpadding="0" align="center" style="padding:10px;">', '</table>');
 //$out = str_ireplace("Song Lyrics @ Http://Www.indiankalakar.Com","",$out);
 while(string1_between($out, "[", "]")){
     $temp="[".string1_between($out, "[", "]")."]";
     echo $temp."<br>";
     $out = str_ireplace($temp,"",$out);
 }
 $out = strip_tags($out);
 $out = str_ireplace("&nbsp;"," ",$out);
if($out){
    //echo "\n<br>-------------LYRICS-------------------<br>\n";
   // echo "<b>".str_ireplace("\n","<br>",$out)."</b>";
   // echo "\n<br>-------------LYRICS-------------------<br>\n";
    $lyrics_return = $out;
    //file_put_contents(DATA_PATH . "/lyrics/$global_id", $lyrics_return);
}else{
     echo "search failed from tamillyrics.<br>";
}

//echo $out;



?>