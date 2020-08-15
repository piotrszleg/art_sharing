<head>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="js/js.cookie.js"></script>
	<script>
	$(function() {
		$("form").submit(function(e){
				Cookies.set("name", $("input[name=name]").val());
		});
		$("input[name=name]").val(Cookies.get("name"));
	});
	</script>
</head>

<?php
$error="";//message displayed above the form to signal incorrect input.

//connection
require_once "variables.php";

//recaptcha
require "utility/recaptcha.php";

//recaptcha

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
}
//connection

//post
function getPostedComment($id, $type){
	global $conn, $commentstable, $error, $captcha;

	//getting posted values
	$user=$conn->real_escape_string(stripslashes($_POST["name"]));
	$comment=$conn->real_escape_string(stripslashes($_POST["comment"]));
	$id=$postid=intval($id);
	//getting posted values

	//incorrect input handling
	$correct=true;

	if($user===""){
		$error.= "<br>You forgot the user name.";
		$correct=false;
	} 
	if($comment===""){
		$error.= "<br>You need to write something in the comment box.";
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
		$stmt = $conn->prepare("INSERT INTO {$commentstable} (username, comment, postid, type) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssii", $user, $comment, $postid, $type);
		if ($stmt->execute() === true) {
			echo "<script>window.location.replace('".htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$id)."');</script>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		//post to the database
	}
}
//post

function commentForm($id){
	global $error, $captcha;
	$id=intval($id);
	echo "
<div class='panel panel-default' style='width:100%;padding:1%;'>
<h3 class='text-center'>Comment</h3>
<form action='";
	echo htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$id)."' method='post'>";
	if($error!==""){
			echo "<div class='alert alert-warning'>
			<strong>Error:</strong>{$error}
			</div>";
	}
	echo "
	<input type='text' name='name' placeholder='Name' class='form-control'><br>
	<textarea name='comment' rows='10' cols='50' maxlength='2000' class='form-control'></textarea>";
	if($captcha){
		echo "<div class='g-recaptcha' data-sitekey='6Ld_WSoUAAAAAMbYQTuHc7WgJxGAsm__TL5NQvA4'></div>";
	}else if(isset($_SESSION["nocaptcha-posts"])){
		echo "<p class='small'>Posts without captcha: ".$_SESSION["nocaptcha-posts"]."/5</p>";
	}
	echo "<input type='submit' value='Submit' class='btn btn-default'>
</form>
</div>";
}

?>

