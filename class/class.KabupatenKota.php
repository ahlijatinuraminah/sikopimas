<?php 
	include "inc.koneksi.php";			
	class KabupatenKota extends Connection
	{
		public $id =0;
		public $nama_kabupaten_kota = '';
		public $lati = '';
		public $longi = '';
		public $id_provinsi= 0;
		public $zoom = 10;
		
		public $hasil = false;
		public $message ='';
		private $conn;

		public function __construct(){
			$this->conn = $this->connect();
		}
		
		public function SelectAllKabupatenKota($id_provinsi){
			$sql = "SELECT * from master_kabupatenkota WHERE id_provinsi = ". $id_provinsi;
			$sql .= " ORDER BY nama_kabupatenkota ASC";

			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}

			$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}
		}

		public function SelectAllKabupatenKotaWithProvinsi(){
			$sql = "SELECT a.*, b.nama_provinsi from master_kabupatenkota a join master_provinsi b on a.id_provinsi = b.id WHERE 1";
			$sql .= " ORDER BY b.kode_provinsi, nama_kabupatenkota ASC";

			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}

			$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}
		}

		public function AddKabupatenKota(){			
			$sql = "INSERT INTO master_kabupatenkota(id_provinsi, nama_kabupatenkota, kode_kabupaten, lati, longi, zoom) 
					values ($this->id_provinsi,'$this->nama_kabupatenkota', 0, '$this->lati', '$this->longi', $this->zoom)";	
									
			$this->hasil = $this->conn->query($sql);		
			if ($this->hasil) {
				$this->message = "Data berhasil ditambahkan";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}									
		}


		public function UpdateKabupatenKota(){			
			$sql = "UPDATE master_kabupatenkota
					SET id_provinsi =$this->id_provinsi,
					nama_kabupatenkota ='$this->nama_kabupatenkota',
					lati ='$this->lati',
					longi ='$this->longi',
					zoom = $this->zoom
					WHERE id = $this->id";
									
			$this->hasil = $this->conn->query($sql);											
			if ($this->hasil) {
				$this->message = "Data berhasil diubah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
		}

		public function DeleteKabupatenKota(){			
			$sql = "DELETE FROM master_kabupatenkota WHERE id=$this->id";									
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
		
				
		public function LoadMap($id_provinsi, $id_kabupatenkota, $id_bidangkerja, $id_negara, $tingkat_kerawanan, $id_mitra, $id_statusperizinan, $id_isu, $id_mitralokal, $nama_organisasi){		
			$sql = "select mk.*, ta.jumlah_organisasi FROM
			(select id_kabupaten, COUNT(id_kabupaten) as jumlah_organisasi FROM
				(SELECT distinct o.id, o.id_negara_asal, o.id_mitra, lk.id_kabupaten, fn_GetTingkatKerawanan(o.id) as tingkat_kerawanan
				 FROM organisasi o 
				 JOIN lokasiorganisasikabupaten lk on o.id = lk.id_organisasi
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
			if($id_kabupatenkota != ''){
				$sql .= " AND id_kabupaten  = $id_kabupatenkota ";
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
			
			$sql .= "	 ) t";

			if($tingkat_kerawanan != ''){
				$sql .= " WHERE tingkat_kerawanan  = '$tingkat_kerawanan' ";
			}
			  	 
			$sql .= " GROUP by id_kabupaten) ta join master_kabupatenkota mk on ta.id_kabupaten = mk.id";
		
			//echo $sql;
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
