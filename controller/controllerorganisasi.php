<?php

require_once('../class/class.Organisasi.php'); 
$objOrganisasi = new Organisasi(); 
$mode = $_POST['mode']; 


if($mode == "save"){		
	$objOrganisasi->nama_organisasi = $_POST['nama_organisasi'];	
	$objOrganisasi->id_negara_asal = $_POST['id_negara_asal'];
	$objOrganisasi->representasi = $_POST['representasi'];
	$objOrganisasi->alamat = $_POST['alamat'];
	$objOrganisasi->id_mitra = $_POST['id_mitra'];
	$objOrganisasi->id_datacollection = $_POST['id_datacollection'];
	$objOrganisasi->tahun_berdiri = $_POST['tahun_berdiri'];
	$objOrganisasi->tahun_beroperasi = $_POST['tahun_beroperasi'];
	$objOrganisasi->id_statusperizinan = $_POST['id_statusperizinan'];
	$objOrganisasi->anggaran = $_POST['anggaran'];	
	$objOrganisasi->mitralokalorganisasi = json_decode($_POST['mitralokalorganisasi']);	
	$objOrganisasi->lokasiprovinsiorganisasi = json_decode($_POST['lokasiprovinsiorganisasi']);	
	$objOrganisasi->bidangkerjaorganisasi = json_decode($_POST['bidangkerjaorganisasi']);	
	$objOrganisasi->isuorganisasi = json_decode($_POST['isuorganisasi']);	
	$objOrganisasi->donororganisasi = json_decode($_POST['donororganisasi']);	
	$objOrganisasi->lokasikabupatenorganisasi = json_decode($_POST['lokasikabupatenorganisasi']);	
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objOrganisasi->id= $_POST['id'];
		$objOrganisasi->UpdateOrganisasi();		
	}
	else
	{	
		$objOrganisasi->AddOrganisasi();		
	}		
	echo json_encode($objOrganisasi);
}
else if($mode == "getone"){		
	
	$objOrganisasi->id = $_POST['id'];	
	$objData = $objOrganisasi->SelectOneOrganisasi();
	echo json_encode($objData);	
}
else if($mode == "delete"){			
	$objOrganisasi->id = $_POST['id'];	
	$objOrganisasi->DeleteOrganisasi();
	echo json_encode($objOrganisasi);
}		
else if($mode == "read"){
	// Design initial table header 
	$arrayResult = $objOrganisasi->SelectAllOrganisasi();
	echo json_encode($arrayResult);
}

else if($mode == "reads"){
	// Design initial table header 
	$arrayResult = $objOrganisasi->SelectAllOrganisasiSimple();
	echo json_encode($arrayResult);
}



?>