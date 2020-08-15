<?php

require_once "variables.php";

//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//connection

function commentscount($id, $type){
	global $conn, $commentstable;

	$id=intval($id);
	$type=intval($type);

	$sql = "SELECT DISTINCT comment FROM {$commentstable} WHERE postid = {$id} AND type={$type}";
	$result = $conn->query($sql);
	if($result){
		return $result->num_rows;
	}else{
		return 0;
	}
}

?>