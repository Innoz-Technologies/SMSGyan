<?php

set_time_limit(0);

//db connecton

//db connection

$query = "Select image_id,id from articles where image_id>0";
$result = mysql_query($query, $con);

//while ($row = mysql_fetch_array($result)) {
//    $q = "Select image_url from `image_tab` where image_id=" . $row["image_id"];
//    $res = mysql_query($q, $con2);
//
//    if (mysql_num_rows($res)) {
//        $r = mysql_fetch_array($res);
//        if (empty($r["image_url"])) {
//            $q_del = "delete from image_tab where image_id=" . $row["image_id"];
//            if (mysql_query($q_del, $con2)) {
//
//                $q_del = "update articles set image_id=0 where id=" . $row["id"];
//                mysql_query($q_del, $con);
//            } else {
//                echo '<br>failed' . $row["image_id"];
//            }
//        }
//    } else {
//        $q_del = "update articles set image_id=0 where id=" . $row["id"];
//        mysql_query($q_del, $con);
//    }
//}

while ($row = mysql_fetch_array($result)) {
    $q = "Select image_url from `image_tab` where image_id=" . $row["image_id"];
    $res = mysql_query($q, $con2);

    if (mysql_num_rows($res)) {
        $r = mysql_fetch_array($res);
        $image_url = $r["image_url"];
        if (empty($image_url) || !(stripos($image_url, ".jpg") !== false || stripos($image_url, ".jpeg") !== false)) {
            $q_del = "delete from image_tab where image_id=" . $row["image_id"];
            echo '<br>' . $image_url;
            echo '<br>' . $row["image_id"];
            if (mysql_query($q_del, $con2)) {
                $q_del = "update articles set image_id=0 where id=" . $row["id"];
                mysql_query($q_del, $con);
            } else {
                echo '<br>failed' . $row["image_id"];
            }
        }
    } else {
        $q_del = "update articles set image_id=0 where id=" . $row["id"];
        mysql_query($q_del, $con);
    }
}
?>
