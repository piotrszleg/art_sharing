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
</head>

<?php require "header.php"; ?>

<body>

<br>

<?php

require_once"variables.php";
require"utility/days.php";
require "utility/htmlescape.php";
require "utility/commentscount.php";
require_once"generategallery.php";

//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//connection
if(isset($_GET["day"]) && $_GET["day"]!==false && is_numeric($_GET["day"]) && in_range($_GET["day"], $days)) {
	$dayindex=intval($_GET['day']);
	$day=$days[$dayindex];
} else {
  $dayindex=0;
  if($dayindex<count($days)){
    $day=$days[$dayindex];
  } else{
    $day=$today;
  }
}
$sql = "SELECT username, imagesource, tags, day, strike, id FROM {$tablename} WHERE day='".$day."'";
$result = $conn->query($sql);

function linktoday($index){
	return htmlspecialchars($_SERVER["PHP_SELF"]."?day=".$index);
}

function buttonActive($day_index){
  global $days;
  if(in_range($day_index, $days)){
    return "";
  } else {
    return "disabled";
  }
}

echo "<div class='container-fluid page-container' >
  <div class='row' style='width:100%;'>
    <div class='col-xs-2 text-left'>
      <a class='btn btn-default ".buttonActive($dayindex+1)."' href='".linktoday($dayindex+1)."' ><span class='glyphicon glyphicon-triangle-left'></span></a>
    </div>
    <div class='col-xs-8 text-center'>
      <h3 style='margin:0;'>".$day."</h3>
    </div>
    <div class='col-xs-2 text-right'>
      <a class='btn btn-default ".buttonActive($dayindex-1)."' href='".linktoday($dayindex-1)."' ><span class='glyphicon glyphicon-triangle-right'></span></a>
    </div>
  </div>";

echo "<hr>"; 

/*//header with date and controls
echo "<p style='float:left; text-align: left; width:10%; display: inline-block;'>";//empty paragraph to keep the center text aligned

if(in_range($dayindex+1, $days)){
	echo "<a class='btn btn-default' href='".linktoday($dayindex+1)."'>
	<span class='glyphicon glyphicon-triangle-left'></span> ".$days[$dayindex+1]."</a>";
}

echo "<h2 style='float:center; text-align: center; width:80%; display: inline-block;'>".$day."</h2>";//center text

echo "<p style='float:right; text-align: right; width:10%; display: inline-block;'>";//empty paragraph to keep the center text aligned
if(in_range($dayindex-1, $days)){
	echo "<a class='btn btn-default' href='".linktoday($dayindex-1)."'>".$days[$dayindex-1]." 
<span class='glyphicon glyphicon-triangle-right'></span></a>";
}

echo "</p>";
//header with date and controls*/

generategallery($result);

echo"</div>";

?>

<?php require "footer.php"; ?>

</body>
</html>
