<?php



include 'configdb.php';
echo $query = "select * from tvnow_channel";
$result = mysql_query($query);

$num_array1[] = "0";
$num_array1[] = "1";
$num_array1[] = "2";
$num_array1[] = "3";
$num_array1[] = "4";
$num_array1[] = "5";
$num_array1[] = "6";
$num_array1[] = "7";
$num_array1[] = "8";
$num_array1[] = "9";

$num_array[] = " Zero";
$num_array[] = " One";
$num_array[] = " Two";
$num_array[] = " Three";
$num_array[] = " Four";
$num_array[] = " Five";
$num_array[] = " Six";
$num_array[] = " Seven";
$num_array[] = " Eight";
$num_array[] = " Nine";

//$arNum = array("1" => "one", "2" => "two", "3" => "three", "4" => "four", "5" => "five", "6" => "six", "7" => "seven", "8" => "eight", "9" => "nine");
while ($row = mysql_fetch_array($result)) {
    $movieName = $row["name"];

    echo "Original Movie: " . $movieName . " <br>";
    $movieName = preg_replace("~[\W\s]~Usi", " ", $movieName);
    $movieName = str_replace("_", " ", $movieName);
    $movieName = str_replace($num_array1, $num_array, $movieName);
    $movieName = preg_replace("~[\s]+~", "", $movieName);

    echo "Replaced Movie: " . $movieName . " <br><br>";

    $q = "update tvnow_channel set search='" . $movieName . "'where id=" . $row["id"] . "";
    $res = mysql_query($q);
    if ($res) {
        echo "<br>updated";
    }

}

