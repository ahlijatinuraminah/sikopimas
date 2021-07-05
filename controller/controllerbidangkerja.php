<?php

require_once('../class/class.BidangKerja.php'); 

$objBidangKerja = new BidangKerja();	
$mode = $_POST['mode']; 

if($mode == "loadbidangkerja")
{	
	$arrayResult = $objBidangKerja->SelectAllBidangKerja();
	echo json_encode($arrayResult);
}

else if($mode == "save")
{		
	$objBidangKerja->nama_bidang = $_POST['nama_bidang'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objBidangKerja->id = $_POST['id'];
		$objBidangKerja->UpdateBidangKerja();		
	}
	else
	{	
		$objBidangKerja->AddBidangKerja();		
	}
	echo json_encode($objBidangKerja);	
}

else if($mode == "getone")
{		
	$objBidangKerja->id = $_POST['id'];	
	$objData = $objBidangKerja->SelectOneBidangKerja();
	echo json_encode($objData);	
}

else if($mode == "delete")
{			
	$objBidangKerja->id = $_POST['id'];	
	$objBidangKerja->DeleteBidangKerja();
	echo json_encode($objBidangKerja);	
}
?>