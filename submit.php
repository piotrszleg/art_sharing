<!DOCTYPE html>
<html>
<head>
	<title>Artwork Sharing - Submit</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="js/js.cookie.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link href="style.css" rel="stylesheet">
	<script>
	$(function() {
		$( "li:contains('Submit')" ).addClass("active"); 
		$("input[name='name']").keyup(function(){
				$( ".username" ).text( $(this).val() );
		});
		$("input[name='image']").on("keyup paste mouseup", function(){
				$( ".gallery-image" ).attr("img", $(this).val() );
				$( ".gallery-image" ).css("background-image", "url("+$(this).val()+")" );
				resizeImages();//function declared in generategallery.php
		});
		$("form").submit(function(e){
				Cookies.set("name", $("input[name=name]").val());
		});
		$("input[name=name]").val(Cookies.get("name"));
		/*$("input[name='tags']").keyup(function(){
				$( ".tags-container" ).text( $(this).val() ); 
		});*/
	});
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

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
}
//connection

function getstrike($username){
	global $tablename, $previousday, $conn;
	$sql = "SELECT strike FROM {$tablename} WHERE username='{$username}' AND day='{$previousday}'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		return $result->fetch_assoc()["strike"];
	} else {
		return 0;
	}
}

//post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	//getting posted values

	$user=$conn->real_escape_string(stripslashes($_POST["name"]));
	$image=$conn->real_escape_string(stripslashes($_POST["image"]));
	$tags=$conn->real_escape_string(stripslashes($_POST["tags"]));
	$strike=getstrike($user)+1;
	//getting posted values

	//incorrect input handling
	$correct=true;
	$img_reg="#^.+\.(jpg|jpeg|png|bmp|gif)$#";
	$tags_reg="@^(#\w+ )*(#\w+ ?)?$@";

	if($user===""){
		$error.= "<br>You forgot the user name.";
		$correct=false;
	} 
	if($image===""){
		$error.= "<br>You forgot the image link.";
		$correct=false;
	}
	if(!preg_match($img_reg, $image)){
		$error.= "<br>Your image link must end with image file extension.";
		$correct=false;
	}
	if(!preg_match($tags_reg, $tags)){
		$error.= "<br>Tags are typed incorrectly, eg: #tag #tag2";
		$correct=false;
	}
	//incorrect input handling
	//recaptcha check
	if(isset($_POST["g-recaptcha-response"])){
		$captcha_response=$_POST["g-recaptcha-response"];
	} else{
		$captcha_response="";
	}
	if(!reCaptchaCheck($captcha_response)){
		$error.= "<br>You need to solve the captcha.";
		$correct=false;
	}
	//recaptcha check
	if($correct){
		//post to the database
		$stmt = $conn->prepare("INSERT INTO {$tablename} (username, imagesource, tags, day, strike) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $user, $image, $tags, $today, $strike);
		if ($stmt->execute() === true) {
			echo "<script>window.location.replace('{$base_url}gallery.php');</script>";
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
<div class='col-md-7 container'>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-horizontal">
		<h2>
			Submit your artwork
		</h2>
		<?php 
			if($error!==""){
				echo "<div class='alert alert-warning'>
				<strong>Error:</strong>{$error}
				</div>";
			}
		?>
		<div class="form-group">
			<label class="control-label col-sm-2" for="name">Name:</label>
			<div class="col-sm-10">
				<input type="text" name="name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="image">Image*:</label>
			<div class="col-sm-10">
				<input type="text" name="image" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="tags">Tags:</label>
			<div class="col-sm-10">
				<input type="text" name="tags" class="form-control">
			</div>
		</div>
		<div class="col-sm-12">
		<p class="small">*Your image link should end with image file extension, like ".jpeg" or ".png". <br>
		First upload it somewhere (tumblr, imgur, mixtape.moe), then right click on your image and select "Copy image adress".<br>
		Then paste it in the image field.</p>
		<?php 
		if($captcha){
			echo "<div class='g-recaptcha' data-sitekey='6Ld_WSoUAAAAAMbYQTuHc7WgJxGAsm__TL5NQvA4'></div>";
		}else if(isset($_SESSION["nocaptcha-posts"])){
			echo "<p class='small'>Posts without captcha: ".$_SESSION["nocaptcha-posts"]."/5</p>";
		}
		?>
		</div>
		<div class="form-group"> 
			<div class="col-sm-10">
			<input type="submit" value="Submit" class='btn btn-default'>
			</div>
		</div>
</form>
</div>
<div class='col-md-5'>
<?php 
require "generategallery.php"; 
echo imagebox("", "", "", "?", 0, 0, false);
?>
</div>
</div>
<div class="col-sm-4"></div>
</div>
</div>

<?php require "footer.php"; ?>

</body>
</html>
