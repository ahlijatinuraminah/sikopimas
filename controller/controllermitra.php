<?php

require_once('../class/class.Mitra.php'); 
$objMitra = new Mitra();	
$mode = $_POST['mode']; 

if($mode == "loadmitra")
{	
	$arrayResult = $objMitra->SelectAllMitra();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objMitra->nama_mitra = $_POST['nama_mitra'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objMitra->id = $_POST['id'];
		$objMitra->UpdateMitra();
		
	}
	else
	{	
		$objMitra->AddMitra();		
	}
	echo json_encode($objMitra);	
}

else if($mode == "getone")
{		
	$objMitra->id = $_POST['id'];	
	$objData = $objMitra->SelectOneMitra();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objMitra->id = $_POST['id'];	
	$objMitra->DeleteMitra();
	echo json_encode($objMitra);	
}
?>