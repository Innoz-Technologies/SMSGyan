<?php
$stime = microtime(true);
function get_between($string, $start, $end){
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
function multihttpget($urls) {
    $mh = curl_multi_init();
    foreach ($urls as $i => $oneurl) {
        $ch[$i] = curl_init();
        curl_setopt($ch[$i], CURLOPT_URL, $oneurl);
        curl_setopt($ch[$i], CURLOPT_HEADER, 0);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch[$i], CURLOPT_TIMEOUT, 100);
        $useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
        curl_setopt($ch[$i], CURLOPT_USERAGENT, $useragent);
        curl_multi_add_handle($mh, $ch[$i]);
    }

    $active = null;
    do {
        $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);

    while ($active && $mrc == CURLM_OK) {
        if (curl_multi_select($mh) != -1) {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
    }
    $response = array();
    foreach ($ch as $k => $h) {
        $response[] = curl_multi_getcontent($h);
    }

    foreach ($ch as $h)
        curl_multi_remove_handle($mh, $h);

    curl_multi_close($mh);
    return ($response);
}

function get_result($query) {
    $search = trim($query);
    $url = array();
    $url[0] = "http://yellowpages.webindia123.com/search_pro.aspx?opt=product&q=" . urlencode($search) . "&city=Indore&street=&Submit=Go+%3E%3E";
    $url[1] = "http://yellowpages.webindia123.com/search_pro.aspx?opt=company&q=" . urlencode($search) . "&city=Indore&street=&Submit=Go+%3E%3E";
    $ttime = microtime(true);
    return $response = multihttpget($url);
    // $ttime = microtime(true) - $ttime;
}
$reqin = $req;
$ar_kw = array("indore", " in ", " at ", " on "," address ","number","contact"," of ",",");
foreach ($ar_kw as $pk) {
    $reqin = str_ireplace($pk, "", $reqin);
}
$arr = array();
$loc = '';
$cont = get_result($reqin);
preg_match_all("~<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">(.+)</table></td></tr></table>~Us",$cont[0], $matches, PREG_SET_ORDER);
//print_r($matches);
foreach($matches as $mat){
        $temp = $mat[1];
        preg_match_all("~<a id=basic href=\"(.+)\">~Us",$temp, $matc, PREG_SET_ORDER);
        foreach($matc as $ma){
             $ul = "http://yellowpages.webindia123.com".$ma[1];
             $arr[] = $ul;
        }
    }
if(count($arr) == 0){
    //echo "\n<br><br>\n";
    preg_match_all("~<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">(.+)</table></td></tr></table>~Us",$cont[1], $matches, PREG_SET_ORDER);
   // print_r($matches);
    foreach($matches as $mat){
        $temp = $mat[1];
        preg_match_all("~<a id=basic href=\"(.+)\">~Us",$temp, $matc, PREG_SET_ORDER);
        foreach($matc as $ma){
             $ul = "http://yellowpages.webindia123.com".$ma[1];
             $arr[] = $ul;
        }
    }
}


//print_r($arr);

if(count($arr) != 0){
  // print_r ($arr);
   $resultt = multihttpget($arr);
   //file_put_contents("loc.htm",$resultt[0]);
   $imgs = array('<img src="/common_files/images/address.jpg" width="22" height="18">','<img src="/common_files/images/person.jpg" width="17" height="25">',
'<img src="/common_files/images/mobile.jpg" width="14" height="22">','<img src="/common_files/images/phone.jpg" width="20" height="14">','N/A','Get Mobile',
           'X Close','Save To Mobile | Rate it','Rate it');
   $start = '<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">';
   $end = '<img src="/common_files/images/fax.jpg" width="21" height="18">';
   $re = array();
   foreach($resultt as $result){
        $temp = get_between($result,$start,$end);
        $tem = get_between($temp,'<script type="text/javascript">','</script>');
        $temp = str_ireplace($tem,"",$temp);
        $r = '<img src="/common_files/images/phone.jpg" width="20" height="14">';
        $temp = str_ireplace($r, "`", $temp);
        $temp = strip_tags($temp);
        $temp = str_ireplace("&nbsp;"," ",$temp);
        foreach ($imgs as $pk) {
         $temp = str_ireplace($pk, "\n", $temp);
        }
        while (stripos($temp, "\t") !== false) {
            $temp = str_replace("\t", "", $temp);
        }
            $temp = str_replace("\r\n", "", $temp);
        while (stripos($temp, "  ") !== false) {
            $temp = str_replace("  ", "", $temp);
        }
            $temp = str_replace("\n", "", $temp);

        $re[] = $temp;

   }
   //print_r($re);
   foreach ($re as $key => $val) {
        $no = $key + 1;
        $loc = $loc . "\n$no: $val";
    }
    $loc = str_ireplace("`", ",PH:", $loc);
    $loc = trim($loc);
}

//print_r($arr);F

if (count($re) != 0) {
    $files = DATA_PATH . "/loc/$global_id";
    @unlink($files);
    file_put_contents($files, $loc);
    //echo "\n<br>location: $loc<br>\n";
    $location_return = $loc;
}
$stime = microtime(true) - $stime;
echo "<br>mplocal: $stime<br>";
?>