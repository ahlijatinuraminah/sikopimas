
<?php

require_once('../class/class.MitraLokal.php'); 

$objMitraLokal = new MitraLokal();	
$mode = $_POST['mode']; 

if($mode == "loadmitralokal")
{	
	$arrayResult = $objMitraLokal->SelectAllMitraLokal();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objMitraLokal->nama_mitralokal = $_POST['nama_mitralokal'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objMitraLokal->id = $_POST['id'];
		$objMitraLokal->UpdateMitraLokal();
	}
	else
	{	
		$objMitraLokal->AddMitraLokal();		
	}
	echo json_encode($objMitraLokal);	
}

else if($mode == "getone")
{		
	$objMitraLokal->id = $_POST['id'];	
	$objData = $objMitraLokal->SelectOneMitraLokal();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objMitraLokal->id = $_POST['id'];	
	$objMitraLokal->DeleteMitraLokal();
	echo json_encode($objMitraLokal);	
}
?>