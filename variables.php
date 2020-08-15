<?php
//Server related variables:

$base_url="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';

//mysql database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art_sharing";
$tablename = "posts";
$commentstable = "comments";
$challengestable = "challenges";
$captchaKey = "";
//mysql database
?>