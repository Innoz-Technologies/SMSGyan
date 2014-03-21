<?php

if (preg_match("~__city__(.+)__~", $req, $match)) {
    echo $spell_checked = "city " . $match[1];
}

if (!preg_match("~^city (.+)~", $spell_checked, $match)) {
    $city_word = remwords($spell_checked);
//$hasResult=false;
    $city_word = trim(str_ireplace("'", '', $city_word));
    echo $city_word = trim(str_ireplace('city', '', $city_word));

    require_once 'binary_search.php';
    echo "<h4>CITY SEARCH</h4>";
    $tree = new BinarySearch('msi_cities', 'city', 3);
    $btime = microtime(true);
    echo $city_name = $tree->search($city_word, 1);

//    $query = "select * from msi_cities where city like '%" . $city_word . "%' order by length(city) limit 1";
//    $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
//    echo "<br>MUST SEE INDIA : $query";
//    if (mysql_num_rows($result) > 0) {
    if (!empty($city_name)) {
//        echo 'record in db';
//        $row = mysql_fetch_array($result);
//        $city_name = $row['city'];
//    $hasResult=true;
        $options_list[] = "city $city_name";
        $list[] = array("content" => "__city__" . $city_name . "__");
    }
}
?>
