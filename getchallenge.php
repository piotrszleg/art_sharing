<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Artwork Sharing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet">
  <script>
  $(function() {
    $( "li:contains('Challenges')" ).addClass("active"); 
  });
  </script>
  <style>
img{
  max-width:50%;
}
  </style>
</head>

<?php require "header.php"; ?>

<body>

<div class="container-fluid">    
  <div class="row content">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-6 text-left"> 

<?php 
require_once "variables.php";
require_once "utility/htmlescape.php";
require_once "utility/textstyling.php";
require_once "utility/taglinking.php";

if( isset($_GET["id"]) && $_GET["id"]!==false && is_numeric($_GET["id"])) {

$id=intval($_GET['id']);

//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, title, description, start, deadline, tag FROM {$challengestable} WHERE id = {$id}";
$result = $conn->query($sql);
//connection

if ($result!==null && $result->num_rows > 0) {
  $i=0;
  if($row = $result->fetch_assoc()) {
      $tag=$row["tag"];
      $start=$row["start"];
      $deadline=$row["deadline"];
      echo challenge($row["id"], $row["title"], $row["description"], $row["start"], $row["deadline"], $row["tag"]);
  }
} else {
    echo "No challenges yet.";
}

}// end of if( isset($_GET["id"]) && $_GET["id"]!==false && is_numeric($_GET["id"])) {

function challenge($id, $title, $description, $start, $deadline, $tag) {
  $id=htmlescape($id);
  $title=htmlescape($title);
  $description=markdownTransform($description);
  $start=htmlescape($start);
  $deadline=htmlescape($deadline);
  if($deadline!==""){
    $duration = "<b>Started:</b> ".$start.", <b>Deadline:</b> ".$deadline;
    $deadline="deadline: ".$deadline;
  } else {
    $duration = "<b>Started:</b> ".$start;
  }
  return "<div class='panel-group' style='width:100%; margin-top:1em;'>
    <div class='panel panel-default'>
      <div class='panel-heading'>
        <h4 class='panel-title'>
          <b>{$title}</b> challenge:<span style='float:right; text-align: right;'>{$deadline}</span>
        </h4>
      </div>
        <div class='panel-body'>
        {$description}
        <hr>
        {$duration}
        </div>
        <div class='panel-footer'>Post you submissions with tag: "."<a href='".linktotag($tag)."'>".htmlescape($tag)."</a>"."</div>
    </div>
  </div>";
}

echo "<br>";

require "commentform.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  getPostedComment($_GET["id"], 1);
}
require "getcomments.php";
if(isset($_GET["id"]) && $_GET["id"]){
  commentForm($_GET["id"]);
  getComments($_GET["id"], 1);
}


?>

    </div>
    <div class="col-sm-3">
    </div>
  </div>
</div>

<?php 

echo "
<hr>
<div class='container-fluid page-container' >
  <div class='row' style='width:100%;'>
    <div class='col-xs-2 text-left'>

    </div>
    <div class='col-xs-8 text-center'>
      <h4 style='margin:0;'><b>Submissions:</b></h4>
    </div>
    <div class='col-xs-2 text-right'>

    </div>
  </div>
<br>
<br>
";

require "challengesubmissions.php";
challengeSubmissions($tag, $start, $deadline);

echo"</div>";

require "footer.php"; 

?>

</body>
</html>