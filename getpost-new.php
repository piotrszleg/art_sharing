<!DOCTYPE html>
<html>

<head>
  <title>Artwork Sharing - Submission</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet">
  <script>
  $(function() {
    $( "li:contains('Gallery')" ).addClass("active"); 
    $(".posted-image").click(function(){
      $(".fullscreen-container").css("display", "block");
    });
    $(".fullscreen-container").click(function(){
      $(this).css("display", "none");
    });
    $(".image-fullscreen").on('load', function() {
      $(this).height($(".fullscreen-container").height());
      console.log($(this).height());
    });
  });
  </script>
</head>

<?php require "header.php"; ?>

<body>

<?php

require_once "variables.php";
require "utility/htmlescape.php";

if( isset($_GET["id"]) && $_GET["id"]!==false && is_numeric($_GET["id"])) {

//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id=intval($_GET['id']);

$sql = "SELECT username, imagesource, tags, day FROM {$tablename} WHERE id = {$id}";
$result = $conn->query($sql);
//connection

$row = $result->fetch_assoc();

echo imagebox($row["username"], $row["imagesource"], $row["tags"], $row["day"], $id);

echo "<div class='container-fluid'>    
  <div class='row content'>
    <div class='col-sm-3'>
    </div>
    <div class='col-sm-6 text-left'>";

require "commentform.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  getPostedComment($_GET["id"], 0);
}
require "getcomments.php";
if(isset($_GET["id"]) && $_GET["id"]){
  commentForm($_GET["id"]);
  getComments($_GET["id"], 0);
}

}//end of if( isset($_GET["id"]) && $_GET["id"]!==false && is_numeric($_GET["id"])) {

function linktotag($t){
  global $base_url;
  return htmlspecialchars($base_url."tagged.php?tag=".str_replace('#', '', $t));
}

function linkTags($unlinked){
  $tags_reg="@(#\w+ ?)@";
  $linked_tag="%test";
  preg_match_all($tags_reg, $unlinked, $matches);
  $matches=$matches[0];
  for ($m= 0; $m < count($matches); $m++) {
    $unlinked=str_replace($matches[$m], "<a href='".linktotag($matches[$m])."'>".htmlescape($matches[$m])."</a>", $unlinked);
  }
  return $unlinked;
}

function imagebox($username, $imagesource, $tags, $date, $id) {
	$username=htmlescape($username);
	$imagesource=htmlescape($imagesource);
	$tags=linkTags(htmlescape($tags));
	$date=htmlescape($date);
  $id=htmlescape($id);
	return "
      <div class='fullscreen-container'>
        <div class='image-fullscreen-container'>
          <img src='{$imagesource}' class='image-fullscreen' alt='{$imagesource}'>
        </div>
      </div>
      <img src='{$imagesource}' class='img-responsive posted-image' alt='{$imagesource}'>
      <div class='panel panel-default text-center' style='width:100%; margin-top:1em;'>
        <div class='image-header'><h4 class='panel-title'><span class='text-primary'>#{$id}</span> <b>{$username}</b> posted this image on {$date}:</h4><br></div>
        <div class='image-tags'>{$tags}</div>
      </div>";
}

?>

</div>
    <div class="col-sm-3">
    </div>
  </div>
</div>

<div style="height:10em"></div>

<?php require "footer.php"; ?>

</body>
</html>