<?php    
    function get_region($region_in) {
        $return_key = '';
        $return_val = array();
        $return = array();
        $temp = 0;
        $kl=0;
        $ret='';
        $fi=0;
        $xml_parser = xml_parser_create("UTF-8");
        xml_parse_into_struct($xml_parser, $region_in, $values);
        // print_r($values);
        if(count($values) > 1){
            foreach($values as $val){
                foreach($val as $ky => $v){
                    //echo $v."<br>";
                    if($ky == "tag"){
                        if($v == "SEARCH_API" || $v == "RESULT" || $v == "POPULATION" || $v == "WEATHERURL"){
                        break;
                        }
                        if($v == "AREANAME" && $temp != 0){
                        //echo "<br><br>";
                        $return[]=$return_val;
                        $return_val=array();                    
                        }                    
                        //echo "$v ->";
                        $return_key=$v;                
                    }
                    if($ky == "value"){
                    //echo "$v | ";
                    $temp++;
                    $return_val[$return_key]=$v;                
                    }
                }
            }
            $return[]=$return_val;
            reset($return);
            foreach($return as $val){
                if(isset($val["REGION"])){
                    if($val["REGION"] == "Kerala"){
                        $ret = $val["AREANAME"].",".$val["REGION"];
                        $kl=1;
                    }
                }
                if($kl == 0 && $fi == 0){
                    $ret = $val["AREANAME"].",".$val["COUNTRY"];
                    //echo $ret."<br>";
                    $fi=1;
                }
            }
        }
        return $ret;   
    }
    
    function get_weather($region_in){
        global $weather_area;
        $return_key = '';
        $return_val = array();
        $return = array();
        $temp = 0;
        $t=0;
        $ret='';
        $fi=0;
        $tmax='';
        $xml_parser = xml_parser_create("UTF-8");
        xml_parse_into_struct($xml_parser, $region_in, $values);
        //print_r($values);
        if(count($values) > 5){
            foreach($values as $val){
                foreach($val as $ky => $v){
                    //echo $v."<br>";
                    if($ky == "tag"){
                        if($v == "QUERY"){
                            
                            $weather_area = $val["value"];
                            //echo $val["value"]."<br>";
                            $ret=$val["value"]."\n";
                            
                        }
                        else if($v == "TEMP_C" && $t == 0){
                            //echo "Temperature: ".$val["value"]." C<br>";
                            $ret=$ret."Temperature: ".$val["value"]." C"."\n";
                            $t++;
                        }
                         else if($v == "WEATHERDESC" && $t == 1){
                            //echo "Weather: ".$val["value"]."<br>";
                            $ret=$ret."Weather: ".$val["value"]."\n";
                            $t++;
                        }
                        else if($v == "HUMIDITY" && $t == 2){
                            //echo "Humidity: ".$val["value"]."%<br>";
                            $ret=$ret."Humidity: ".$val["value"]."%\n";
                            $t++;
                        }
                        else if($v == "PRESSURE" && $t == 3){
                            //echo "Pressure: ".$val["value"]." mb<br>Tomorrow's Forecast<br>";
                            $ret=$ret."Pressure: ".$val["value"]." mb\nTomorrow's Forecast\n";
                            $t++;
                        }
                        else if($v == "TEMPMAXC" && $t == 4){
                            $t++;
                        }
                         else if($v == "TEMPMAXC" && $t == 5){
                            $t++;
                            $tmax=$val["value"];
                        }
                        else if($v == "TEMPMINC" && $t == 6){
                            //echo "Temperature: ".$val["value"]." C to $tmax C<br>";
                            $ret=$ret."Temperature: ".$val["value"]." C to $tmax C\n";
                            $t++;
                        }
                        else if($v == "WEATHERDESC" && $t == 7){
                            //echo "Weather: ".$val["value"]."<br>";
                            $ret=$ret."Weather: ".$val["value"]."\n";
                            $t++;
                        }
                        
                        
                    }
                    
         
                }
            }
        }
        return $ret;  
    }
    //TEMPMAXC
    
    $out='';
	$weather_req=urlencode($word);
    $url='API';
    $content=httpGet($url);
    $weather=get_weather($content);
    if($weather == ''){
    $url='API';
    $content=httpGet($url);
    $out=get_region($content);
    if($out != '' ){
        $weather_req=urlencode($out);
        $url='API';
        $content=httpGet($url);
        $weather=get_weather($content);
    }
    }
    $weather_return=$weather;   //out put will get in $weather;
?>