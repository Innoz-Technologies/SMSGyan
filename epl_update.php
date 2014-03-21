<?php
include 'lib/appconfigdb.php';
$query = "SELECT DISTINCT home_team FROM epl_fixture";
$result = mysql_query($query) or die(mysql_error() . " in $query");
$teams = array();
while ($row = mysql_fetch_array($result)) {
    $teams[] = $row[0];
}
?>
<html>
    <body>
        <form name="form1" method="POST" action="matches-by-date.php">
        Date: <input type="text" name="matchDate" />&nbsp;<input type="submit" value="List Matches" name="submitBtn" />
        </form>
    </body>

</html>
