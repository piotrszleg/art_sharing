<?php
require"utility/days.php";
require_once"generategallery.php";

//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//connection

function challengeSubmissions($tag, $start, $end){
	global $today, $conn, $tablename;

	$tag=$conn->real_escape_string($tag);
	$start=date('Y-m-d', strtotime($start));
	//convert start and end to php date objects
	if($end!==NULL){
		$end=date('Y-m-d', strtotime($end));
		$sql = "SELECT username, imagesource, tags, day, strike, id FROM {$tablename} WHERE tags RLIKE '{$tag}( |$)' AND day >= '{$start}' AND day <= '{$end}'";
	} else {
		$sql = "SELECT username, imagesource, tags, day, strike, id FROM {$tablename}  WHERE tags RLIKE '{$tag}( |$)' AND day >= '{$start}'";
	}
	
	$result = $conn->query($sql);

	if($result){
		generategallery($result);
	} else {
		echo $conn->error;
	}
}
?>