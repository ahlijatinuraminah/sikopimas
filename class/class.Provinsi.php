<?php 
	include "inc.koneksi.php";			
	class Provinsi extends Connection
	{
		public $id =0;
		public $nama_provinsi = '';
		public $lati = '';
		public $longi = '';
		public $zoom = 7;
		public $jumlah_ormas= '';
		public $kabupaten;
		
		public $hasil = false;
		public $message ='';
		private $conn;


		public function __construct(){
			$this->conn = $this->connect();
		}

		public function AddProvinsi(){			
			$sql = "INSERT INTO master_provinsi(kode_provinsi, nama_provinsi, lati, longi, zoom) 
					values ('$this->kode_provinsi','$this->nama_provinsi', '$this->lati', '$this->longi', '$this->zoom')";	
									
			$this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil ditambahkan";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}							
		}


		public function AddProvinsiWithKabupaten(){			
			$sql = "INSERT INTO master_provinsi(kode_provinsi, nama_provinsi) 
					values ('$this->kode_provinsi','$this->nama_provinsi')";	
									
			$this->conn->query($sql);
			$id_provinsi = $this->conn->insert_id;		
			
			$sql = "INSERT INTO master_kabupatenkota(id_provinsi, nama_kabupatenkota, kode_kabupaten, lati, longi, zoom) values"; 
			
			for ($i = 0; $i < count($this->kabupaten); $i++) {
				$dataKab = $this->kabupaten[$i];
				$nama_kabupatenkota = $dataKab->nama_kabupatenkota;
				$sql .= "($id_provinsi, '$nama_kabupatenkota', 0, 0, 0, 0),";
			}						
			$sql = substr($sql, 0, -1);

			$this->conn->query($sql);
		}

		public function UpdateProvinsiWithKabupaten(){			
			$sql = "UPDATE master_provinsi 
					SET kode_provinsi ='$this->kode_provinsi',
					nama_provinsi ='$this->nama_provinsi'
					WHERE id = $this->id";
								
			$this->conn->query($sql);				

			$sql = "DELETE FROM master_kabupatenkota
					WHERE id_provinsi = $this->id";
			
			$this->conn->query($sql);			
			
			$sql = "INSERT INTO master_kabupatenkota(id_provinsi, nama_kabupatenkota, kode_kabupaten, lati, longi, zoom) values"; 
			
			for ($i = 0; $i < count($this->kabupaten); $i++) {
				$dataKab = $this->kabupaten[$i];
				$nama_kabupatenkota = $dataKab->nama_kabupatenkota;
				$sql .= "($this->id, '$nama_kabupatenkota', 0, 0, 0, 0),";
			}						
			$sql = substr($sql, 0, -1);

			$this->conn->query($sql);
		}



		public function UpdateProvinsi(){			
			$sql = "UPDATE master_provinsi 
					SET kode_provinsi ='$this->kode_provinsi',
					nama_provinsi ='$this->nama_provinsi',
					lati = '$this->lati',
					longi = '$this->longi'
					WHERE id = $this->id";
									
			$this->hasil = $this->conn->query($sql);		
			if ($this->hasil) {
				$this->message = "Data berhasil diubah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
												
		}

		public function DeleteProvinsi(){			
			$sql = "DELETE FROM master_provinsi WHERE id=$this->id";	


			$this->hasil = $this->conn->query($sql);											

			if ($this->hasil) {
				$this->message = "Data berhasil dihapus";
		  	} else {
				if($this->conn->errno == 1451)
					$this->message = "Data ini tidak dapat dihapus karena ada data lain yang menggunakannya";
				else
					$this->message = "Error: " . $this->conn->error;
		  	}
			
		}

		public function SelectOneProvinsi(){			
			$sql = "SELECT * FROM master_provinsi WHERE id='$this->id'";				
			
			$bind = $this->conn->query($sql);
			while ($obj = $bind->fetch_object()) {
				$baris = $obj;
			}
			return $baris;								
		}
    	
		public function SelectAllProvinsi(){
			$sql = "SELECT * from master_provinsi";			
			$sql .= " ORDER BY nama_provinsi ASC";	
			
			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}

			$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}				
			
			
		}
		
				
		public function LoadMap($id_provinsi, $id_bidangkerja, $id_negara, $tingkat_kerawanan, $id_mitra, $id_statusperizinan, $id_isu, $id_mitralokal, $nama_organisasi){
			//echo $tingkat_kerawanan;
			
			$sql = "select mp.*, ta.jumlah_organisasi FROM
			(select id_provinsi, COUNT(id_provinsi) as jumlah_organisasi FROM
				(SELECT distinct o.id, o.id_negara_asal, o.id_mitra, lp.id_provinsi, fn_GetTingkatKerawanan(o.id) as tingkat_kerawanan
				FROM organisasi o 
				JOIN lokasiorganisasiprovinsi lp on o.id = lp.id_organisasi
				JOIN bidangkerjaorganisasi bk on o.id = bk.id_organisasi
				JOIN  isuorganisasi iu on o.id = iu.id_organisasi
                JOIN  mitralokalorganisasi do on o.id = do.id_organisasi
				WHERE 1 ";
			
			if($id_provinsi != ''){
					$sql .= " AND id_provinsi = $id_provinsi ";
			}
			
			if($id_bidangkerja != ''){
					$sql .= " AND id_bidangkerja = $id_bidangkerja ";
			}
			
			if($id_negara != ''){
					$sql .= " AND id_negara_asal  = $id_negara ";
			}	
			
			if($id_mitra != ''){
				$sql .= " AND id_mitra  = $id_mitra ";
			}	

			if($id_statusperizinan != ''){
				$sql .= " AND id_statusperizinan  = $id_statusperizinan ";
			}

			if($id_isu != ''){
				$sql .= " AND id_isu  = $id_isu ";
			}

			if($id_mitralokal != ''){
				$sql .= " AND id_mitralokal  = $id_mitralokal ";
			}

			if($nama_organisasi != ''){
				$sql .= " AND nama_organisasi  LIKE '%$nama_organisasi%' ";
			}
			
			$sql .= "	) t";

			if($tingkat_kerawanan != ''){
				$sql .= " WHERE tingkat_kerawanan  = '$tingkat_kerawanan' ";
			}	
			
			$sql .= " GROUP by id_provinsi) ta join master_provinsi mp on ta.id_provinsi = mp.id";
			
			
			$bind = $this->conn->query($sql);			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}		
			
		}		
		
 	}	 
?>
