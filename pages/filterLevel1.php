<?php
	include '../class/inc.koneksi.php';
	$db = new Connection();
	$data_organisasi = $db->connect();

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title></title>
	<meta name=viewport content = "width = device-width, initial-scale=1">
	<link rel = "stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
	<script src = "https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src = "https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

</head>
	
<body>	


	<table id="example" class="cell-border" style="width:25%">
		<thead>
			<tr>
				<th>Nama Organisasi</th>
				<th>Representatsi</th>
				<th>Tahun Beroperasi</th>
				<th>Lokasi Kerja</th>
				<th>Negara</th>	
				<th>Bidang Kerjaan</th>
				<th>Tingkat Kerawanan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$query = "SELECT * FROM organisasi
			INNER JOIN master_negara on organisasi.id_negara_asal = master_negara.id ORDER BY organisasi.id";
			$sql_rm = mysqli_query($data_organisasi, $query)or die (mysqli_error($data_organisasi));
			while($data = mysqli_fetch_array($sql_rm)) { ?>
				<tr>
					<td><?=$data['nama_organisasi']?></td>
					<td><?=$data['representasi']?></td>
					<td><?=$data['tahun_beroperasi']?></td>
					<td><?=$data['alamat']?></td>
					<td><?=$data['nama_negara']?></td>
					<td>
					
						<?php
						$sql_bidang = mysqli_query($data_organisasi, "SELECT * FROM bidangkerjaorganisasi JOIN master_bidangkerja on bidangkerjaorganisasi.id = master_bidangkerja.id WHERE id_organisasi = '$data[id]'") or die (mysqli_error($data_organisasi));
						while($data_bidang = mysqli_fetch_array($sql_bidang)){
							echo $data_bidang['nama_bidang']."</br>";
							
						}
						
						?>
					
					</td>
				
				
				<td></td>
				</tr>
			<?php
			}?>
		</tbody>
		</table>
		
	<script>
	$(document).ready(function() {
    $('#example').DataTable();
	} );
	</script>
	
</body>
