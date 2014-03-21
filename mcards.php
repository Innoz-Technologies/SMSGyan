<?php

mysql_close();
include 'lib/configdb_up.php';

$query = "select * from gc_group WHERE gcshow=1 AND (operator='all' OR operator='$operator' OR circle='$circle_short') AND script!='' order by timestamp desc";
$result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);

while ($row = mysql_fetch_array($result)) {
    $script.= $row['script'] . "\n";
}

if (!empty($script)) {
    mysql_close();
    include 'lib/appconfigdb.php';

    $total_return = $script;

    $to_logserver['source'] = 'mcards';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
