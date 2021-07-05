<?php

require_once('../class/class.User.php'); 
$objUser = new User(); 

$mode = $_POST['mode']; 
if($mode == "loaduser")
{	
	$arrayResult = $objUser->SelectAllUser();
	echo json_encode($arrayResult);
}

else if($mode == "loadrole")
{	
	$arrayResult = $objUser->SelectAllRole();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objUser->nama = $_POST['nama'];	
	$objUser->email = $_POST['email'];
	$objUser->password = $_POST['password'];
	$objUser->role_id = $_POST['role_id'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objUser->id = $_POST['id'];
		$objUser->UpdateUser();
	}
	else
	{	
		$objUser->AddUser();
	}
	echo json_encode($objUser);
}

else if($mode == "updatepassword")
{		
	$objUser->id = $_POST['id'];
	$objUser->password = $_POST['old_password'];	
	$objUser->new_password = $_POST['new_password'];
	$result = $objUser->UpdatePassword();
	echo $objUser->message;
}	

else if($mode == "delete")
{			
	$objUser->id = $_POST['id'];	
	$objUser->DeleteUser();
	echo json_encode($objUser);
}

else if($mode == "getone")
{		
	$objUser->id = $_POST['id'];	
	$objData = $objUser->SelectOneUser();
	echo json_encode($objData);	
}

else if($mode == "loadprofile")
{	
	$result = $objUser->LoadProfile();
	echo json_encode($result);
}
?>