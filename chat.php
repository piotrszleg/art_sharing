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
    $( "li:contains('Chat')" ).addClass("active"); 
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

require "commentform.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  getPostedComment(0, 2);
}
commentForm(0);

require "getcomments.php";
getComments(0, 2);


?>

    </div>
    <div class="col-sm-3">
    </div>
  </div>
</div>

<?php 

require "footer.php"; 

?>

</body>
</html>