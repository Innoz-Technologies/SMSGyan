<?php

$return = "";
$log_source="su_";  //changed on 03-10-2012 before source 'sulekha'
if (preg_match("~\b__free__test_drive__\b~", $req)) {  //User opts to get free test drive
        
    //sending data to sulekha site
    $code=2706;
    $datetime=urlencode(date('Y/m/d H:i:s'));
    $log_source.="tatanano";
    
    //API
    $success=file_get_contents($url);
    echo "Result: $success code: $code<br>";
    $return.="Thank you for contacting for a Free Test Drive in your city. Our partner Sulekha.com will call you in the next 24 hours to get your details and help you get a FREE test drive.";
} elseif (preg_match("~\b__buy__health_insurance__\b~", $req)) {  //User opts to buy health insurance
        
        //sending data to sulekha site
    $code=1413;
    $datetime=urlencode(date('Y/m/d H:i:s'));
    $log_source.="health";
    
    //API
    $success=file_get_contents($url);
    echo "Result: $success code: $code<br>";
    $return.="Thank you for contacting for a health insurance quote. Our partner Sulekha.com will call you in the next 24 hours to get your details and help you get FREE health insurance quotes.";
}elseif (preg_match("~\b__online__courses__\b~", $req)) {  //User opts for online computer courses
       
        //sending data to sulekha site
    $code="3195";
    $datetime=urlencode(date('Y/m/d H:i:s'));
    $log_source.="degree";
    
    //API
    $success=file_get_contents($url);
    echo "Result: $success code: $code<br>";
    $return.="Thank you for contacting for a Educational Courses. Our partner Sulekha.com will call you in the next 24 hours to get your details and help you get FREE online BBA/MBA/MCA";
} else {    //checks for tata nano or health insurance keyword
//
    //excluding common keywords
    if (!preg_match("~\b(define|trace|route|direction|movie|song|poem|weather|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|expand|pnr|dict|photos?|party|city)\b~i", $req)) {
        if (preg_match("~\b(tatanano|nano|1 lakh car|people car|small car|tatahatchback|tatananocar)\b~i", $req)) {
            echo $query="SELECT id from matching_keys where key_type = 'tata' and keyword = '".$req."'";
            $result=mysql_query($query) or trigger_error(mysql_error());
            if(mysql_num_rows($result)>0){
                $return.="The Tata Nano is the cheapest car in the world, as of now. After launching it for Rs 1 lakh in 2009, Tata Nano is now priced between Rs 1.50 lakh (Base version), 1.81 lakh (2012 CX version) and 2.1 lakh (2012 LX version). All models are of 624 cc, petrol-based and have manual transmission. They give an estimated 20.6 kpl in mileage. The Nano is sold in 250+  cities through nearly 500+ dealers including most of the major cities and towns of India.It is possible to get a FREE test drive of Tata Nano in several parts of the country.";

                $options_list[] = "To get a FREE Test Drive";
                $list[] = array("content" => "__free__test_drive__");
                $log_source.="tatanano";
            }
        }elseif (preg_match("~\b(health|insurance|policy|policies|blue cross blue shield|cashless|medi ?claims?|ins)\b~i", $req)) {
            echo $query="SELECT id from matching_keys where key_type = 'health' and keyword = '".$req."'";
            $result=mysql_query($query) or trigger_error(mysql_error());
            if(mysql_num_rows($result)>0){
                $return.="Mediclaim (also known as Health Insurance) covers medical treatment in case of illness or accident. This insurance covers diseases, injuries, surgery or any medical are that is needed by families or individuals. This helps users to pay a small premium and get a large insurance cover by paying different insurance companies.  IRDA has approved 16 companies to sell insurance - and has authorized more than 250,000+ insurance as IRDA certified professionals. Why is health insurance required? Medical expenses have increased tremendously in last 5 years. Common man has to stretch to uncomfortable financial limits to get proper treatment for himself and his family. Health insurance is important for you as well as your loved ones so, that they do not compromise on good medical treatment in times of Medical emergencies. ";
                echo "Keyword $req found in DB<br/>";
                $options_list[] = "To buy health insurance";
                $list[] = array("content" => "__buy__health_insurance__");
                $log_source.="health";
            }            
        }elseif (preg_match("~\b(bca|mca|bba|mba|about|on ?line|accredited|universit[ty|ies]|bachelor|best|business|computer|correspondence|exams?|internet|executive|emba|diploma|masters?|courses?|degrees?|distance|entrance|graduate|school|msc|collages?|mock|e learning|it classes?|it programs?)\b~i", $req)) {
            echo $query="SELECT id from matching_keys where key_type = 'online' and keyword = '".$req."'";
            $result=mysql_query($query) or trigger_error(mysql_error());
            if(mysql_num_rows($result)>0){
                $return.="Online BBA/MBA/MCA are degrees that contribute to the career development of working professionals or career entrants. Online BBA/MBA/MCA allows users to access a 100% online education platform, completely online exams, online study material, convenient admission, e-Library and multiple payment modes. Placement support, Academic support and Student care are also offered by several Online distance education service providers in India.  e-Campus blackboard, video tutorials and community based shared learning are making several thousand Indians opt for online programs for BBA, MBA, MCA and several types of PGDBA programs.";
                echo "Keyword $req found in DB<br/>";
                $options_list[] = "To get more details of Online BBA/MBA/MCA";
                $list[] = array("content" => "__online__courses__");
                $log_source.="degree";
            }            
        }
    }
}

if($return!=""){
    $total_return=$return;
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = $log_source;
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
