<?php
require_once "variables.php";
require_once "recaptchalib.php";
$response = null;
if($captchaKey!==""){
	$reCaptcha = new ReCaptcha($captchaKey);
}
if(session_id() == '') {
    session_start();
}
if (!isset($_SESSION['nocaptcha-posts'])||$_SESSION['nocaptcha-posts']>=5) {
  $captcha=true;
} else {
  $captcha=false;
}

function recaptchaCheck($response){
	global $captchaKey, $reCaptcha, $captcha;
	if(!$captcha){
		if (!isset($_SESSION['nocaptcha-posts'])) {
			$_SESSION['nocaptcha-posts']=1;
		} else {
			$_SESSION['nocaptcha-posts']++;
		}
		return true;
	}
	if($captchaKey===""){
		//When recaptcha key is empty captcha is always correct
		$_SESSION["nocaptcha-posts"]=0;
		return true;
	}
	if ($response) {
		//verify
		$response = $reCaptcha->verifyResponse(
		$_SERVER["REMOTE_ADDR"],
		$response
		);
		//verify
		if ($response == null || !$response->success) {
			echo $response;
			return false;
		}
		$_SESSION["nocaptcha-posts"]=0;
	  return true;
  } else {
	//no response
	return false;
  }
}

?>