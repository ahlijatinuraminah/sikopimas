<?php

require_once('../class/class.DataCollection.php'); 
$objDataCollection = new DataCollection();	
$mode = $_POST['mode']; 

if($mode == "loaddatacollection")
{	
	
	$arrayResult = $objDataCollection->SelectAllDataCollection();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objDataCollection->deskripsi = $_POST['deskripsi'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objDataCollection->id = $_POST['id'];
		$objDataCollection->UpdateDataCollection();
	}
	else
	{	
		$objDataCollection->AddDataCollection();
	}
	echo json_encode($objDataCollection);	
}

else if($mode == "getone")
{		
	$objDataCollection->id = $_POST['id'];	
	$objData = $objDataCollection->SelectOneDataCollection();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objDataCollection->id = $_POST['id'];	
	$objDataCollection->DeleteDataCollection();
	echo json_encode($objDataCollection);	
}
?>