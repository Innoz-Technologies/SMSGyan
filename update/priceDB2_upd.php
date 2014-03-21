<?php

include 'configdb.php';
$query = "select * from bikedekho";
$result = mysql_query($query);

echo "<br>BIKE DATA<br>";
while ($row = mysql_fetch_array($result)) {
    $q = "insert into solr_Car_Bike_test(make_id,model_id,make,model,srch,category,price) values ('" . $row["make_id"] . "','" . $row["model_id"] . "','" . $row["make"] . "','" . $row["model"] . "','" . $row["srch"] . "','bike','0')";
    $query .= " ON DUPLICATE KEY UPDATE make=VALUES(make_id),model=VALUES(model_id),make=VALUES(make),model=VALUES(model),srch=VALUES(srch)";
    if (mysql_query($q)) {
        echo "Record inserted<br>";
    }
}
$q = "";
echo "<br>CAR DATA<br>";
$query = "select * from carwale";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {
    $q = "insert into solr_Car_Bike_test(make_id,model_id,make,model,srch,category,price) values ('" . $row["make_id"] . "','" . $row["model_id"] . "','" . $row["make"] . "','" . $row["model"] . "','" . $row["srch"] . "','car','0')";
    $query .= " ON DUPLICATE KEY UPDATE make=VALUES(make_id),model=VALUES(model_id),make=VALUES(make),model=VALUES(model),srch=VALUES(srch)";
    if (mysql_query($q)) {
        echo "Record inserted<br>";
    }
}
?>