<?php

if (preg_match("~^city (.+)~", $spell_checked, $match)) {

    $city = trim(str_ireplace('city', '', $spell_checked));
    require_once 'binary_search.php';
    echo "<h4>CITY SEARCH</h4>";
    $tree = new BinarySearch('msi_cities', 'city', 3);
    echo $city_name = $tree->search($city, 1);

    if (!empty($city_name)) {
        echo $query = "select * from  msi_cities where city='$city_name'";
        $result = mysql_query($query);
        if (mysql_num_fields($result) > 0) {
            $row = mysql_fetch_array($result);

            $flag = $row['flag'];
            $mid = $row['machineID'];
            $id = $row['id'];

            if ($flag != 0 && $mid != 0) {
                echo "<h2>Inside DB</h2>";
                $current_file = "/city/$id";
                $source_machine = $mid;
                $total_return = get_file_contents($current_file, $mid);

                echo $total_return;
                $to_logserver['source'] = 'city';
                include 'allmanip.php';
                putOutput($total_return);
                exit();
            } else {
                echo $url = "http://www.mustseeindia.com/" . ucfirst($city_name);
                $content = httpGet($url);

                if (!empty($content)) {
                    preg_match_all("~<td class=\"td-title-sm-pl\">(.+)<div class=\"sep10\"></div>~Usi", $content, $match);

                    if (!empty($match[1])) {
                        $out = $match[1][0];
                        $out = preg_replace('~<td class="td-pl">|<br>~', "***", $out);
                        $out = strip_tags($out);
                        $out = str_replace("More details coming soon. Stay tuned!", "", $out);
                        $out = str_replace("Fast Facts", "", $out);
                        $out = str_replace("Â", "", $out);
                        $out = str_replace("â€™", "'", $out);
                        $out = preg_replace("~[\s]+~", " ", $out);
                        $out = str_replace("***", "\n", $out);
                        $out = str_replace("\n ", "\n", $out);
                        $out = str_replace("\n\n", "\n", $out);
                    }
                    if (!empty($out)) {

                        $query = "update msi_cities set flag=1,machineID=$machine_id where id=$id";
                        $result = mysql_query($query);
                        if ($result) {
                            echo "Updated City !!!";
                        }

                        $total_return = $out;
                        $current_file = "/city/$id";
                        $source_machine = $machine_id;

                        file_put_contents(DATA_PATH . $current_file, $total_return);
                        $to_logserver['source'] = 'city';
                        include 'allmanip.php';
                        putOutput($total_return);
                        exit();
                    }
                }
            }
        }
    }
}
?>
