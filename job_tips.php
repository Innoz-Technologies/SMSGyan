<?php

if (preg_match("~^y (.+)~", $spell_checked, $match) && $spell_checked != "y pathan") {

    echo "COUNT" . $count = str_word_count($match[1]) . "\n";
    if ($count >= 1 && $count <= 4) {
        echo $name = $match[1];

        $total_return = "EduKart.com is India’s leading online education portal. You can learn anywhere and anytime.";

        $options_list[] = "Online MBA";
        $list[] = array("content" => "__edukart__mba__");
        $options_list[] = "Online MCA";
        $list[] = array("content" => "__edukart__mca__");
        $options_list[] = "Online BBA";
        $list[] = array("content" => "__edukart__bba__");
        $options_list[] = "Retail Courses";
        $list[] = array("content" => "__edukart__retail courses__");
        $options_list[] = "Digital Marketing Courses";
        $list[] = array("content" => "__edukart__digital marketing__");
        $options_list[] = "Finance Courses";
        $list[] = array("content" => "__edukart__finance__");

        $q = "select * from educart where msisdn='$number'";
        $reslt = mysql_query($q);

        if (mysql_num_rows($reslt)) {
            echo $query = "update educart set name='$name' where msisdn='$number'";
            $result = mysql_query($query);
            if ($result) {
                echo "Name Updated";
            }
        } else {
            $query = "insert into educart(name,msisdn) value ('" . $name . "','" . $number . "')";
            $result = mysql_query($query);

            if ($result) {
                echo "Name Inserted";
            }
        }
    }
    include 'allmanip.php';
    $to_logserver['source'] = 'jobtip';
    putOutput($total_return);
    exit();
}

if (preg_match("~__edukart__(.+)__~", $req, $match)) {
    $cname = $match[1];

    $query = "update educart set course='$cname' where msisdn='$number'";
    $result = mysql_query($query);

    if ($result) {
        echo "course name updated";
    }

    $total_return = "Thanks for your making your choice.  Please reply with E space <your E-mail>\ne.g. E mba@edukart.com";

    include 'allmanip.php';
    $to_logserver['source'] = 'jobtip';
    putOutput($total_return);
    exit();
}

if (preg_match("~^e (.+)~", $spell_checked, $match)) {
    $ename = $match[1];

    echo "COUNT" . $count = str_word_count($ename) . "\n";

    if ($count == 3 && preg_match("~\b(@)\b~", $ename)) {
        $total_return = "One more step before we call you! Please reply with H <City>,<State>\ne.g. H Gurgaon,Haryana";

        $q = "select * from educart where msisdn='$number'";
        $reslt = mysql_query($q);

        if (mysql_num_rows($reslt)) {
            echo $query = "update educart set emailid='$ename' where msisdn='$number'";
            $result = mysql_query($query);

            if ($result) {
                echo "E mail Updated";
            }
        } else {
            echo $query = "insert into educart(msisdn,emailid) values ('$number','$ename')";
            $res = mysql_query($query);
            if ($res) {
                echo "Email Id Inserted";
            }
        }
    }

    include 'allmanip.php';
    $to_logserver['source'] = 'jobtip';
    putOutput($total_return);
    exit();
}
if (preg_match("~^h (.+),(.+)~", $spell_checked, $match)) {

    var_dump($match);
    echo "COUNT" . $count = str_word_count($spell_checked) . "\n";

    $area = preg_replace("~\b(h)\b~", "", $match[0]);

    if ($count >= 3 && $count <= 7) {
        $q = "select * from educart where msisdn='$number'";
        $reslt = mysql_query($q);

        if (mysql_num_rows($reslt)) {

            echo $query = "update educart set city='$area' where msisdn='$number'";
            $result = mysql_query($query);

            if ($result) {
                echo "City, State Updated";
            }
        } else {
            echo $query = "insert into educart(msisdn,city) values ('$number','$area')";
            $res = mysql_query($query);
            if ($res) {
                echo "City, State Inserted";
            }
        }


        $total_return = "Thank you for showing your interest in online degree and certificate courses by EduKart.com. We will call you shortly!";
    }

    include 'allmanip.php';
    $to_logserver['source'] = 'jobtip';
    putOutput($total_return);
    exit();
}

if (preg_match("~__add__jobtip__~", $req)) {
    $total_return = "Educart Project Management Certification @ Rs.4500/-.\nGood job guaranteed.Please give a missed call @ +919741931588 to know more";
    include 'allmanip.php';
    $to_logserver['source'] = 'jobtip';
    putOutput($total_return);
    exit();
}

if (preg_match("~__jobtip__(.+)__~", $req, $match)) {
    $dbid = $match[1];
    $id = $dbid + 1;
    if ($id == 18) {
        $id = 1;
    }
    $q = "select * from job_tips where id=$id";
    $res = mysql_query($q);
    if (mysql_num_rows($res)) {
        $row = mysql_fetch_array($res);
        $tips = $row["content"];
        $dbid = $row["id"];
    }
    if (!empty($tips)) {
        $total_return = $tips;
        if (($number == '8826382201' || $number == '9741931588') && $id <= 2) {
//            $add_below = "\n--\nYou can avail certification course to enhance your degree.\nEducart provides certification courses";
            $options_list[] = "Read next tip";
            $list[] = array("content" => "__jobtip__" . $dbid . "__");
            $options_list[] = "get educart details";
            $list[] = array("content" => "__add__jobtip__");
        } else {
            $options_list[] = "Read next tip";
            $list[] = array("content" => "__jobtip__" . $dbid . "__");
//            $add_below = "\n--\nGet your MBA, MCA, BBA online (UCG Certified) or Enrol for Industry Endorsed Certifications at EduKart.com.\nReply with Y <name> to know more about the course.\nEg: Y jitender";
        }
        $current_file = "job_tips/content/id/$dbid";
        $source_machine = "db";
        include 'allmanip.php';
        $to_logserver['source'] = 'jobtip';
        putOutput($total_return);
        exit();
    }
}
if (preg_match("~^\b(job tips|job tip|jobtip|jobtips)\b~", $spell_checked)) {
    $q = "select * from job_tips where id=1";
    $res = mysql_query($q);
    if (mysql_num_rows($res)) {
        $row = mysql_fetch_array($res);
        $tips = $row["content"];
        $dbid = $row["id"];
    }
    if (!empty($tips)) {
        $total_return = $tips;
        if ($number == '8826382201') {
//            $add_below = "\n--\nYou can avail certification course to enhance your degree.\nEducart provides certification courses";
            $options_list[] = "Read next tip";
            $list[] = array("content" => "__jobtip__" . $dbid . "__");
            $options_list[] = "get educart details";
            $list[] = array("content" => "__add__jobtip__");
        } else {
            $options_list[] = "Read next tip";
            $list[] = array("content" => "__jobtip__" . $dbid . "__");
//            $add_below = "\n--\nGet your MBA, MCA, BBA online (UCG Certified) or Enrol for Industry Endorsed Certifications at EduKart.com.\nReply with Y <name> to know more about the course.\nEg: Y jitender";
        }
        $current_file = "job_tips/content/id/$dbid";
        $source_machine = "db";
        include 'allmanip.php';
        $to_logserver['source'] = 'jobtip';
        putOutput($total_return);
        exit();
    }
}
?>
