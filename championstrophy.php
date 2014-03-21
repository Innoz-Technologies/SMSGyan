<?php 

//if($spell_checked=="champions trophy fixture"){
getmatches_data();
function getmatches_data(){	
	$db_connect= connect_db();	
	$query = "select * from matchfixture WHERE match_date >= CURDATE()";
	$result = mysql_query($query, $db_connect) or die(mysql_error());	
	$i=1;
	$ipl_result = '';
	while($row = mysql_fetch_array($result)){
	/*echo '<br>';
	echo '<br> id =' .$row['id'];
	echo '<br>match date='.$row['match_date'];
	echo '<br>match timing='.$row['match_time'];
	echo '<br>team1 name='.$row['team1'];
	echo '<br>team2 name='.$row['team2'];
	echo '<br>match venue='.$row['venue'];*/
		
		$ipl_result.= $i. ". " .$row['team1'] . " Vs " . $row['team2'] . " on " . date('F j', strtotime($row['match_date'])) . ", " . $row['match_time'] . " at " . $row['venue'] . "\n";
		$i++;
	}
	echo $ipl_result;
	
	if ($ipl_result != "") {
		$total_return = $ipl_result;
		$source_machine = $machine_id;
		$current_file = "/temp/$numbers";
		file_put_contents(DATA_PATH . $current_file, $total_return);
		include 'allmanip.php';
		$to_logserver['source'] = 'championsTrophy';
		putOutput($total_return);
		exit();
	}
	
}

function connect_db(){	
	$dbhost='localhost';
	$username='root';
	$password='';
	$database='gyantest';
	$dbconnect = mysql_connect($dbhost, $username, $password) or die('Error connecting to mysql: ' . mysql_error());
	mysql_select_db($database) or trigger_error('Error selecting databae: ' . mysql_error(), E_USER_ERROR);
	return $dbconnect;
}
//}

?>