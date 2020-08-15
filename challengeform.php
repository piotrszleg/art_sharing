<!DOCTYPE html>
<html>
<head>
  <title>Artwork Sharing - Submit</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <link href="style.css" rel="stylesheet">
  <script>
  $(function() {
    $( "li:contains('Challenges')" ).addClass("active");
    $("#deadlineCheck").change(function() {
        if(!$(this).is(":checked")){
          console.log($("#deadlineInput").val());
          $("#deadlineInput").val(null);
        }
    });
  });
  $
  </script>
</head>

<?php require "header.php"; ?>

<body>
<?php
$error="";//message displayed above the form to signal incorrect input.

//connection
require_once "variables.php";
require "utility/days.php";
require "utility/recaptcha.php";
//recaptcha

//recaptcha

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//connection

//post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //getting posted values

  $title=$conn->real_escape_string(stripslashes($_POST["title"]));
  $description=$conn->real_escape_string(stripslashes($_POST["description"]));
  $tag=$conn->real_escape_string(stripslashes($_POST["tag"]));
  //getting posted values

  //incorrect input handling
  $correct=true;
  $tag_reg="@^#\w+$@";

  if($title===""){
    $error.= "<br>You forgot the title.";
    $correct=false;
  }
  if($description===""){
    $error.= "<br>You forgot the description.";
    $correct=false;
  }
  if(!preg_match($tag_reg, $tag)){
    $error.= "<br>Tag is typed incorrectly, eg: #tag";
    $correct=false;
  }
  //incorrect input handling
  //recaptcha check
  if(!reCaptchaCheck($_POST["g-recaptcha-response"])){
    $error.= "<br>You need to solve the captcha.";
    $correct=false;
  }
  //recaptcha check
  if($correct){
    //post to the database
    if($_POST['deadline']!==""){
      $deadline = date('Y-m-d', strtotime($_POST['deadline']));
    }
    $stmt = $conn->prepare("INSERT INTO {$challengestable} (title, description, start, deadline, tag) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $today, $deadline, $tag);
    if ($stmt->execute() === true) {
      echo "<script>window.location.replace('{$base_url}challenges.php');</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    //post to the database
  }
}
//post
?>
<div class="container-fluid page-container">    
<div class="row content">
<div class="col-md-4"></div>
<div class="panel panel-default col-md-4" style="margin-top:5px">
<div class="panel-body">
<div class='col-md-7'>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <h2>
      Create new challenge
    </h2>
    <?php 
      if($error!==""){
        echo "<div class='alert alert-warning'>
        <strong>Error:</strong>{$error}
        </div>";
      }
    ?>
    Title: <br><input type="text" name="title"><br>
    Description: <br><textarea name="description" rows="4" cols="50" maxlength="2000"></textarea><br>

    Deadline: <input type="checkbox" id="deadlineCheck" data-toggle="collapse" data-target="#collapseDeadline" aria-expanded="false" aria-controls="collapseDeadline">
    <br>
    <div id="collapseDeadline" aria-expanded="false" class="collapse">
    Deadline: <br><input type="date" id="deadlineInput" name="deadline"><br>
    </div>

    Tag: <br><input type="text" name="tag"><br>
    <p class="small">*Tag will be used to find submissions to your challenge.</p>
    <div class="g-recaptcha" data-sitekey="6Ld_WSoUAAAAAMbYQTuHc7WgJxGAsm__TL5NQvA4"></div>
    <br>
    <input type="submit" class='btn btn-default'>
</form>
</div>
</div>
</div>
<div class="col-sm-4"></div>
</div>
</div>

<?php require "footer.php"; ?>

</body>
</html>
