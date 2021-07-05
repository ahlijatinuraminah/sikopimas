<?php

require_once('../class/class.KabupatenKota.php'); 
$objKabupatenKota = new KabupatenKota(); 
$mode = $_POST['mode']; 
if($mode == "loadbyprovinsi"){	
	$id_provinsi ='';
	$id_kabupatenkota ='';
	$id_bidangkerja ='';
	$id_negara ='';
	$tingkat_kerawanan ='';
	
	if(isset($_POST['id_provinsi']) && isset($_POST['id_provinsi']) != "")
		$id_provinsi = $_POST['id_provinsi'];

	if(isset($_POST['id_kabupatenkota']) && isset($_POST['id_kabupatenkota']) != "")
		$id_kabupatenkota = $_POST['id_kabupatenkota'];
	
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
		
    $objKabupatenKota = new KabupatenKota();	
	$arrayResult = $objKabupatenKota->LoadMap($id_provinsi, $id_kabupatenkota, $id_bidangkerja, $id_negara, $tingkat_kerawanan, $id_mitra, $id_statusperizinan, $id_isu, $id_mitralokal, $nama_organisasi);
	echo json_encode($arrayResult);
}
else if($mode == "loadkabupatenkota"){	
	if(isset($_POST['id_provinsi']) && isset($_POST['id_provinsi']) != "")
		$id_provinsi = $_POST['id_provinsi'];
	
	$arrayResult = $objKabupatenKota->SelectAllKabupatenKota($id_provinsi);
	echo json_encode($arrayResult);
}
else if($mode == "loadallkabupatenkota"){		
	$arrayResult = $objKabupatenKota->SelectAllKabupatenKotaWithProvinsi();
	echo json_encode($arrayResult);
}
else if($mode == "save"){		
	$objKabupatenKota->id_provinsi = $_POST['id_provinsi'];	
	$objKabupatenKota->nama_kabupatenkota = $_POST['nama_kabupatenkota'];
	$objKabupatenKota->lati = $_POST['lati'];
	$objKabupatenKota->longi = $_POST['longi'];
			
	if($_POST['id'] != "" && $_POST['id'] != null)
	{
		$objKabupatenKota->id = $_POST['id'];
		$objKabupatenKota->UpdateKabupatenKota();
	}
	else
	{	
		$objKabupatenKota->AddKabupatenKota();
	}
	echo json_encode($objKabupatenKota);	
}
else if($mode == "delete"){			
	$objKabupatenKota->id = $_POST['id'];	
	$objKabupatenKota->DeleteKabupatenKota();
	echo json_encode($objKabupatenKota);	
}

?>