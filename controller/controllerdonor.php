<?php

require_once('../class/class.Donor.php'); 

$objDonor = new Donor();	
$mode = $_POST['mode']; 

if($mode == "loaddonor")
{	
	$arrayResult = $objDonor->SelectAllDonor();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objDonor->nama_donor = $_POST['nama_donor'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objDonor->id = $_POST['id'];
		$objDonor->UpdateDonor();		
	}
	else
	{	
		$objDonor->AddDonor();
	}
	echo json_encode($objDonor);	
}

else if($mode == "getone")
{		
	$objDonor->id = $_POST['id'];	
	$objData = $objDonor->SelectOneDonor();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objDonor->id = $_POST['id'];	
	$objDonor->DeleteDonor();
	echo json_encode($objDonor);	
}
?>