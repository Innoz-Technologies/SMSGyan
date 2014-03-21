<?php

$private_ip = array("IPs");

function set_machine_id() {
	return "2";
}

function get_file_contents( $path, $machine ) {
	global $machine_id;
	global $private_ip;
	if ($machine_id == $machine) {
		return file_get_contents("/data".$path);
	} else {
		$host = "http://".$private_ip[$machine];
		if ( $machine == '1' ) $host .= ":7000";
		return file_get_contents( $host."/storage/read.php?file=$path" );
	}
}

function does_file_exist( $path, $machine ) {
	global $machine_id;
	global $private_ip;
	if ( $machine_id == $machine ) {
		return file_exists( "/data".$path );
	} else {
		$host = "http://".$private_ip[$machine];
		if ( $machine == '1' ) $host .= ":7000";
		return file_get_contents(  $host."/storage/check.php?file=$path" );
	}
}
?>