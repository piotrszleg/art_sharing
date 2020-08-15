<!DOCTYPE html>
<html>

<head>
  <title>Artwork Sharing - Gallery</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet">
  <script>
  $(function() {
    $( "li:contains('Gallery')" ).addClass("active"); 
  });
  </script>
  <style>
.image-header{
  margin-left:8px;
  margin-top:5px;
  margin-bottom:5px;
  line-height:1.2em
}
.image-tags{
  margin-left:8px;
  margin-top:5px;
  margin-bottom:5px;
}
.panel-default{
  margin-top:5px;
  margin-bottom:5px;
  border-radius:0;
}

  </style>
</head>

<?php require "header.php"; ?>

<body>

<br>

<?php

require_once"variables.php";
require "utility/htmlescape.php";
require_once"generategallery.php";

//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//connection

$tag=$conn->real_escape_string($_GET['tag']);
$sql = "SELECT username, imagesource, tags, day, strike, id FROM {$tablename} WHERE tags RLIKE '#{$tag}( |$)'";
$result = $conn->query($sql);

//header with date and controls
echo "<h4>
<p style='float:left; text-align: left; width:10%; display: inline-block;'>";//empty paragraph to keep the center text aligned

echo "</p>
<p style='float:center; text-align: center; width:80%; display: inline-block;'><b>#".htmlescape($tag)."</b></p>";//center text

echo "<p style='float:right; text-align: right; width:10%; display: inline-block;'>";//empty paragraph to keep the center text aligned

echo "</p>
</h4>";
//header with date and controls

generategallery($result);

?>

<?php require "footer.php"; ?>

</body>
</html>
