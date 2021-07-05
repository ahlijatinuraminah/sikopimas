<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once('../class/class.Auth.php'); 
$mode = $_POST['mode'];

if($mode == "login") {
	if((isset($_POST['email']) && isset($_POST['email']) != "") &&
		isset($_POST['password']) && isset($_POST['password']) != "") {
    		$objAuth = new Auth();
    		$result = $objAuth->Login($_POST['email'], $_POST['password']);
    		
    		if($result->hasil) {
    			$_SESSION['role_id'] = $result->role_id;
				$_SESSION['user'] = $result->id;												
    		}
	}
	echo json_encode($result->message);
		
}

else if ($mode == "logout") {
	$objAuth = new Auth();
	$result = $objAuth->Logout();
	return $result;
}

else if ($mode == "forgotpassword") {
	if((isset($_POST['email']) && isset($_POST['email']) != "")) {
    	$objAuth = new Auth();
    	$result = $objAuth->ForgotPassword($_POST['email']);
	}
	echo json_encode($result);
}

?>