<?php

require_once('../class/class.Negara.php'); 
$objNegara = new Negara();	
$mode = $_POST['mode']; 

if($mode == "loadnegara")
{	
	$arrayResult = $objNegara->SelectAllNegara();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objNegara->nama_negara = $_POST['nama_negara'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objNegara->id = $_POST['id'];
		$objNegara->UpdateNegara();		
	}
	else
	{	
		$objNegara->AddNegara();		
	}
	echo json_encode($objNegara);	
}

else if($mode == "getone")
{		
	$objNegara->id = $_POST['id'];	
	$objData = $objNegara->SelectOneNegara();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objNegara->id = $_POST['id'];	
	$objNegara->DeleteNegara();
	echo json_encode($objNegara);
}
?>