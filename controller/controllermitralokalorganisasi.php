<?php

require_once('../class/class.MitraLokalOrganisasi.php'); 

$objMitraLokalOrganisasi = new MitraLokalOrganisasi(); 
$mode = $_POST['mode']; 

if($mode == "load"){
	// Design initial table header 
	if(isset($_POST['id_organisasi']) && isset($_POST['id_organisasi']) != "")
		$id_organisasi = $_POST['id_organisasi'];

	$arrayResult = $objMitraLokalOrganisasi->SelectAllMitraLokalOrganisasi($id_organisasi);
	echo json_encode($arrayResult);
}
?>