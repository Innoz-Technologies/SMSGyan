<?php

$apps = array("#en"
);

foreach ($apps as $app) {
    include 'configdb.php';

    $query = "select * from app_keyword where keyword='$app' and status =1";
    $result = mysql_query($query) or die("Could not perform select query - " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        $row = mysql_fetch_array($result);
        $id = $row['id'];
        $app_name = $row['keyword'];


        $url = "APi";
        $content = file_get_contents($url);


        echo $content;

        if ($content) {
            $tmbc = $content;
            $tmbc = preg_replace('~[\s]+~', " ", $tmbc);
            echo $tmbc;
            if (preg_match('~<id>(.+)</id>~', $content, $matchid))
                echo $id = trim($matchid[1]);
//            if (preg_match('~<name>(.+)</name>~', $content, $matchid))
//                echo $name = trim($matchname[1]);
            if (preg_match('~<shortdesc>(.+)</shortdesc>~', $content, $matchsd))
                echo $shrtdesc = trim($matchsd[1]);
            if (preg_match('~<desc>(.+)</desc>~', $tmbc, $matchdesc))
//        var_dump($matchdesc);
                echo $desc = trim($matchdesc[1]);
            if (preg_match('~<format>(.+)</format>~', $content, $matchformt)) {
                echo $format = trim($matchformt[1]);
            }
            if (preg_match('~<imgurl>(.+)</imgurl>~', $content, $matchimg))
                echo $imgurl = trim($matchimg[1]);
        }


        echo $query_upd = "insert into app_andriod(id,name,shortdesc,`desc`,format,imgUrl,status) values($id,'" . mysql_real_escape_string($app_name) . "','" . mysql_real_escape_string($shrtdesc) . "','" . mysql_real_escape_string($desc) . "','" . mysql_real_escape_string($format) . "','" . mysql_real_escape_string($imgurl) . "',1)";
        $result_upd = mysql_query($query_upd) or mysql_error();

        if ($result_upd) {
            echo "Updated";
        }
    }
}
?>
