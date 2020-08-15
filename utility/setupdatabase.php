<?php
require_once "variables.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SHOW TABLES LIKE '{$tablename}'");
if ($result->num_rows == 0) {
    $sql = "CREATE TABLE {$tablename} (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(30) NOT NULL,
	imagesource VARCHAR(200) NOT NULL,
	tags VARCHAR(100),
	day DATE NOT NULL,
	strike INT(6) UNSIGNED NOT NULL
	)";
	if ($conn->query($sql) === FALSE) {
	    echo "Error creating table: " . $conn->error;
	}
}
$result = $conn->query("SHOW TABLES LIKE '{$commentstable}'");
if ($result->num_rows == 0) {
    $sql = "CREATE TABLE {$commentstable} (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(30) NOT NULL,
	comment VARCHAR(2000) NOT NULL,
	postid INT(6) UNSIGNED NOT NULL,
	type INT(2) UNSIGNED NOT NULL
	)";
	if ($conn->query($sql) === FALSE) {
	    echo "Error creating table: " . $conn->error;
	}
}
$result = $conn->query("SHOW TABLES LIKE '{$challengestable}'");
if ($result->num_rows == 0) {
    $sql = "CREATE TABLE {$challengestable} (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	title VARCHAR(30) NOT NULL,
	description VARCHAR(2000) NOT NULL,
	start DATE,
	deadline DATE,
	tag VARCHAR(2000) NOT NULL
	)";
	if ($conn->query($sql) === FALSE) {
	    echo "Error creating table: " . $conn->error;
	}
}
?>