<?php

$spell = $_GET["s"];

include 'functions.php';
include 'lib/appconfigdb.php';

echo "<br>After spell checking : " . $afterSpell = checkSpelling($spell);
?>
