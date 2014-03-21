<?php

if ($spell_checked == "youth") {
    $total_return = "You think you are a raw diamon and country should see your talent?
                    Colors of Youth offers you a national platform to rock the stage.Grab this opportunity of a lifetime to get judged by none other than
                    Mugdha Godse and Nikhil Chinapa.
                    Guwahati City Round Auditions on 28TH NOVEMBER at Don Bosco Institute of Management.
                    Register now & stand a chance to win \"MARUTI SUZUKI SWIFT\" as a Grand Prize.
                    Online registration is now open at : http://colorsofyouth.com";

    $options_list[] = "event flow";
    $list[] = array("content" => "youth event flow");

    $options_list[] = "schedule";
    $list[] = array("content" => "youth schedule");
} elseif ($spell_checked == "youth event flow") {
    $total_return = "Event Flow:-
                    9:00 AM - 11:15 AM Registrations 
                    11:45 AM - 11:55 AM Corporate AV 
                    11:55 AM - 12:05 PM Welcome Address Followed By Performances 
                    12:05 PM - 2:00 PM Auditions 
                    2:00 PM - 2:45 PM Lunch Break
                    2:45 PM - 6:00 PM Auditions 
                    6:00 PM - 6:30 PM Judges Session with Winners
                    6:30 PM - 7:00 PM Written Quiz";
    
    $options_list[] = "Main Menu";
    $list[] = array("content" => "youth");
    
} elseif ($spell_checked == "youth schedule") {
    $total_return = "Schedule:-
                    EAST
                    28th Nov. Thursday Don Bosco Institute of Management, Guwahati 
                    6th Dec. Friday Kolkata
                    7th Dec. Satarday Kolkata (Zonal)
                    NORTH 
                    12th Dec. Thursday Chandigarh
                    13 Dec. Friday Lucknow
                    15 Dec. Sunday Delhi
                    16 Dec. Monday Delhi (Zonal)
                    WEST
                    10 Jan. Friday Pune
                    15 Jan. Wednesday Mumbai
                    16 Jan. Thursday Mumbai (Zonal)
                    SOUTH
                    20th Jan. Monday Hyderabad
                    22nd Jan. Wednesday Chennai
                    23rd Jan. Thursday Bangalore
                    24th Jan. Friday Bangalore (Zonal)";
    $options_list[] = "Main Menu";
    $list[] = array("content" => "youth");
}

if (!empty($total_return)) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'youthnesa';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
