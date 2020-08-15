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

<div class="container-fluid page-container">    
  <div class="row content">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-6 text-left"> 

<?php 
require_once "variables.php";
require_once 'Michelf/MarkdownExtra.inc.php';
require_once "utility/htmlescape.php";

echo "<br><a href='{$base_url}challengeform.php' class='btn btn-default' role='button'>New Challenge</a><hr>";

function getBreakText($t) {
    $t= strtr($t, array('\\r\\n' => '<br>', '\\r' => '<br>', '\\n' => '<br>'));
    return explode('<br>', $t);
}

function linktotag($t){
  global $base_url;
  return htmlescape($base_url."tagged.php?tag=".str_replace('#', '', $t));
}


//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, title, description, deadline, tag FROM {$challengestable} ORDER BY id DESC";
$result = $conn->query($sql);
//connection

if ($result!==null && $result->num_rows > 0) {
  $i=0;
  while($row = $result->fetch_assoc()) {
      echo challenge($row["id"], $row["title"], $row["description"], $row["deadline"], $row["tag"]);
  }
} else {
    echo "No challenges yet.";
}

function challenge($id, $title, $description, $deadline, $tag) {
  $id=htmlescape($id);
  $title=htmlescape($title);
  $lines=getBreakText($description);
  array_splice($lines, 2);
  if($deadline!==null){
    $deadline="deadline: ".$deadline;
  }
  $deadline=htmlescape($deadline);
  $description="";
  foreach ($lines as &$l){
     $description.=\Michelf\MarkdownExtra::defaultTransform(htmlescape($l));
   }
   global $base_url;
  return "<div class='panel-group'>
    <div class='panel panel-default'>
      <div class='panel-heading'>
        <h4 class='panel-title'>
          <b>{$title}</b> challenge:<span style='float:right; text-align: right;'>{$deadline}</span>
        </h4>
      </div>
      <div>
        <div class='panel-body'>
        {$description}
        <a href=".$base_url."getchallenge.php?id=".$id.">more</a>
        </div>
      </div>
    </div>
  </div>";
}

?>

    </div>
    <div class="col-sm-3">
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

</body>
</html>