<?php

require "variables.php";
require "utility/htmlescape.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, imagesource, tags, day, strike FROM {$tablename} ORDER BY id DESC";
$result = $conn->query($sql);

$delimeter="<br>";

echo "Block starts with index in square brackets and its data is enclosed in curly brackets.<br>";
echo "In each in block lines represent following: username, imagesource, tags, day, strike.<br>";
echo "If you want to backup this site, just copy it to your notepad and save it.<br><br>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$id=htmlescape($row["id"]);
    	$username=htmlescape($row["username"]);
		$imagesource=htmlescape($row["imagesource"]);
		$tags=htmlescape($row["tags"]);
		$day=htmlescape($row["day"]);
		$strike=htmlescape($row["strike"]);
        echo "</br>[{$id}] {</br>".$username.$delimeter.$imagesource.$delimeter.$tags.$delimeter.$day.$delimeter.$strike.$delimeter."}</br></br>";
    }
}
?>