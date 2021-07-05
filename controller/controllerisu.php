<?php

require_once('../class/class.Isu.php'); 

$objIsu = new Isu();	
$mode = $_POST['mode']; 

if($mode == "loadisu")
{	
	$arrayResult = $objIsu->SelectAllIsu();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objIsu->nama_isu = $_POST['nama_isu'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objIsu->id = $_POST['id'];
		$objIsu->UpdateIsu();
		
	}
	else
	{	
		$objIsu->AddIsu();
		
	}
	echo json_encode($objIsu);	
}

else if($mode == "getone")
{		
	$objIsu->id = $_POST['id'];	
	$objData = $objIsu->SelectOneIsu();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objIsu->id = $_POST['id'];	
	$objIsu->DeleteIsu();
	echo json_encode($objIsu);	
}
?>