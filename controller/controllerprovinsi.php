<?php

require_once('../class/class.Provinsi.php'); 
$objProvinsi = new Provinsi(); 

$mode = $_POST['mode']; 
if($mode == "loadmap"){		
	$id_provinsi ='';
	$id_bidangkerja ='';
	$id_negara ='';
	$tingkat_kerawanan ='';
	$id_mitra ='';
	$id_statusperizinan ='';
	$nama_organisasi ='';
	
	if(isset($_POST['id_provinsi']) && isset($_POST['id_provinsi']) != "")
		$id_provinsi = $_POST['id_provinsi'];
	
	if(isset($_POST['id_bidangkerja']) && isset($_POST['id_bidangkerja']) != "")
		$id_bidangkerja = $_POST['id_bidangkerja'];
	
	if(isset($_POST['id_negara']) && isset($_POST['id_negara']) != "")
		$id_negara = $_POST['id_negara'];

	if(isset($_POST['tingkat_kerawanan']) && isset($_POST['tingkat_kerawanan']) != "")
		$tingkat_kerawanan = $_POST['tingkat_kerawanan'];

	if(isset($_POST['id_mitra']) && isset($_POST['id_mitra']) != "")
		$id_mitra = $_POST['id_mitra'];

	if(isset($_POST['id_statusperizinan']) && isset($_POST['id_statusperizinan']) != "")
		$id_statusperizinan = $_POST['id_statusperizinan'];

	if(isset($_POST['id_isu']) && isset($_POST['id_isu']) != "")
		$id_isu = $_POST['id_isu'];

	if(isset($_POST['id_mitralokal']) && isset($_POST['id_mitralokal']) != "")
		$id_mitralokal = $_POST['id_mitralokal'];

	if(isset($_POST['nama_organisasi']) && isset($_POST['nama_organisasi']) != "")
		$nama_organisasi = $_POST['nama_organisasi'];

	$arrayResult = $objProvinsi->LoadMap($id_provinsi, $id_bidangkerja, $id_negara, $tingkat_kerawanan, $id_mitra, $id_statusperizinan, $id_isu, $id_mitralokal, $nama_organisasi);
	echo json_encode($arrayResult);
}
else if($mode == "loadprovinsi"){		
	$arrayResult = $objProvinsi->SelectAllProvinsi();
	echo json_encode($arrayResult);
}
else if($mode == "save"){		
	$objProvinsi->kode_provinsi = $_POST['kode_provinsi'];	
	$objProvinsi->nama_provinsi = $_POST['nama_provinsi'];
	$objProvinsi->lati = $_POST['lati'];
	$objProvinsi->longi = $_POST['longi'];
		
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objProvinsi->id = $_POST['id'];
		$objProvinsi->UpdateProvinsi();
	}
	else
	{	
		$objProvinsi->AddProvinsi();
	}
	echo json_encode($objProvinsi);	
}

else if($mode == "savewithkabupaten"){		
	$objProvinsi->kode_provinsi = $_POST['kode_provinsi'];	
	$objProvinsi->nama_provinsi = $_POST['nama_provinsi'];
	$objProvinsi->kabupaten = json_decode($_POST['kabupaten']);	

	
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objProvinsi->id = $_POST['id'];
		$objProvinsi->UpdateProvinsiWithKabupaten();
		echo "Data berhasil diubah";
	}
	else
	{	
		$objProvinsi->AddProvinsiWithKabupaten();
		echo "Data berhasil ditambahkan";
	}
		

}
else if($mode == "getone"){		
	
	$objProvinsi->id = $_POST['id'];	
	$objData = $objProvinsi->SelectOneProvinsi();
	echo json_encode($objData);	
}
else if($mode == "delete"){			
	$objProvinsi->id = $_POST['id'];	
	$objProvinsi->DeleteProvinsi();
	//echo $objProvinsi->message;
	echo json_encode($objProvinsi);	
}
?>