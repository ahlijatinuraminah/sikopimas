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
				<th>Anggaran</th>
				<th>Jejaring Mitra</th>
				<th>Kemitraan</th>
				<th>Status Perizinan</th>
				<th>Bidang Kerjaan</th>
				<th>Donor</th>
				<th>Tingkat Kerawanan</th>	
				
			</tr>
		</thead>
		<tbody>
			<?php
			$query = "SELECT * FROM organisasi
			INNER JOIN master_negara on organisasi.id_negara_asal = master_negara.id
			INNER JOIN master_statusperizinan on organisasi.id_statusperizinan = master_statusperizinan.id 
			INNER JOIN master_mitra on organisasi.id_mitra = master_mitra.id ORDER BY organisasi.id";
			
			$sql_rm = mysqli_query($data_organisasi, $query)or die (mysqli_error($data_organisasi));
			while($data = mysqli_fetch_array($sql_rm)) { ?>
				<tr>
					<td><?=$data['nama_organisasi']?></td>
					<td><?=$data['representasi']?></td>
					<td><?=$data['tahun_beroperasi']?></td>
					<td><?=$data['alamat']?></td>
					<td><?=$data['nama_negara']?></td>
					<td><?=$data['anggaran']?></td>
					<td><?=$data['jejaring_mitra']?></td>
					<td><?=$data['nama_mitra']?></td>
					<td><?=$data['deskripsi']?></td>
					
					<td> 
					
						<?php
						$sql_bidang = mysqli_query($data_organisasi, "SELECT * FROM bidangkerjaorganisasi JOIN master_bidangkerja on bidangkerjaorganisasi.id = master_bidangkerja.id WHERE id_organisasi = '$data[id]'") or die (mysqli_error($data_organisasi));
						while($data_bidang = mysqli_fetch_array($sql_bidang)){
							echo $data_bidang['nama_bidang']."</br>";
							
						}
						
						?>
					
					</td>
				
					<td> 
						
							<?php
							$sql_donor = mysqli_query($data_organisasi, "SELECT * FROM donororganisasi JOIN master_donor on donororganisasi.id = master_donor.id WHERE id_organisasi = '$data[id]'") or die (mysqli_error($data_organisasi));
							while($data_donor = mysqli_fetch_array($sql_donor )){
								echo $data_donor ['nama_donor']."</br>";
								
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
