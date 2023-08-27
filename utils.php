<?php
$host = 'localhost';
$username = 'root';
$pass = '';
$db = 'metric_conversion';

$conn = mysqli_connect($host, $username, $pass, $db);
function sqlExecute($sql, $types, ...$values) {
	global $conn;
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, $types, ...$values);
	return mysqli_stmt_execute($stmt);
}

function sqlGetAll($sql, $types = '', ...$values) {
	global $conn;
	$result = null;
	if ($types) {
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, $types, ...$values);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);		
	} else {
		$result = mysqli_query($conn, $sql);
	}
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function redirect($url) {
	header("Location: $url");
	exit;	
}

?>