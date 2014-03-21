<?php
if (preg_match("~__stdcode__(.+)__~si", $req, $matches)) {

    $query = "SELECT * FROM `stdcodes` WHERE id=" . $matches[1];
    $result = mysql_query($query);

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $total_return .= "STD " . ucfirst($isdWord) . "\n";
        $total_return .= "State : " . $row["state"] . "\n";
        $total_return .= "City : " . $row["city"] . "\n";
        $total_return .= "STD Code : " . $row["code"] . "\n";
    }
}elseif (preg_match("~\b((std) ?(codes?)?)\b (.+)~", $spell_checked, $match)) { //elseif (preg_match("~^std (.+)~", $spell_checked)) {
    //$isdWord = trim(str_replace("std", "", $spell_checked));
    
    if (strpos($spell_checked, 'std') === 0) {
        $first_STD = true;
    } else {
        $first_STD = false;
    }
    echo "std query: $spell_checked [$first_STD]<br>";
    
    $isdWord =$match[4];    //getting rest of keyword
    $isdWord=trim(remwords($isdWord));    //removing unnecessary wordss
    
    /*foreach ($match as $key => $value) {
        echo "$key => $value<br>";
    }*/
    //checking whether enter std code and find corr details
    if(is_numeric($isdWord)){
        echo $query = "SELECT * FROM stdcodes where code = " . $isdWord ;
        $result = mysql_query($query);

        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_array($result);
            //$total_return .= "STD " . ucfirst($isdWord) . "\n";
            $total_return .= "State : " . $row["state"] . "\n";
            $total_return .= "City : " . $row["city"] . "\n";
            $total_return .= "STD Code : " . $row["code"] . "\n";
        }
        if (empty($total_return) && $first_STD) {
            $total_return = "Sorry no data found for std code $isdWord";
            $to_logserver['isresult'] = 0;
        }
    }else{
        echo $query = "SELECT * FROM stdcodes where city like '%" . $isdWord . "%' limit 0,30";
        $result = mysql_query($query);
        
        if (mysql_num_rows($result) == 0) {
            echo $query = "SELECT * FROM stdcodes where soundex(city) like soundex('" . $isdWord . "') limit 0,30";
            $result = mysql_query($query);
        }
        if (mysql_num_rows($result) == 1) {
            $row = mysql_fetch_array($result);
            $total_return .= "STD " . ucfirst($isdWord) . "\n";
            $total_return .= "State : " . $row["state"] . "\n";
            $total_return .= "City : " . $row["city"] . "\n";
            $total_return .= "STD Code : " . $row["code"] . "\n";
        }elseif(mysql_num_rows($result) > 1){
            $len = 0;
            while ($row = mysql_fetch_array($result)) {
                
                $city = $row["city"];

                $state = $row["state"];
                $options_list[] = $state . " " . $city;
                $list[] = array("content" => "__stdcode__" . $row["id"] . "__");
            }
            $total_return = "SELECTION AN OPTION FOR STD ".$isdWord;
        }
        
        if (empty($total_return) && $first_STD) {
            $total_return = "Sorry no std code found for $isdWord";
            $to_logserver['isresult'] = 0;
        }
    }   //is_numeric else close
} elseif ($spell_checked == "std") {
    $total_return = "To get std code of a particular place SMS STD <space> plcae name to $shortcode \nTo get details of a particular std code, SMS STD <space> std code to $shortcode";
}
if ($total_return) {
    $source_machine = 'db';
    include 'allmanip.php';
    $to_logserver['source'] = 'std';
    putOutput($total_return);
    exit();
}
?>
