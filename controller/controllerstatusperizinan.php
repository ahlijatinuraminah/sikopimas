<?php

require_once('../class/class.StatusPerizinan.php'); 

$objStatusPerizinan = new StatusPerizinan();	
$mode = $_POST['mode']; 

if($mode == "loadstatusperizinan")
{	
	$arrayResult = $objStatusPerizinan->SelectAllStatusPerizinan();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objStatusPerizinan->deskripsi = $_POST['deskripsi'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objStatusPerizinan->id = $_POST['id'];
		$objStatusPerizinan->UpdateStatusPerizinan();		
	}
	else
	{	
		$objStatusPerizinan->AddStatusPerizinan();
	}
	echo json_encode($objStatusPerizinan);
}

else if($mode == "getone")
{		
	$objStatusPerizinan->id = $_POST['id'];	
	$objData = $objStatusPerizinan->SelectOneStatusPerizinan();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objStatusPerizinan->id = $_POST['id'];	
	$objStatusPerizinan->DeleteStatusPerizinan();
	echo json_encode($objStatusPerizinan);
}
?>