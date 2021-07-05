<?php 
	include "inc.koneksi.php";			
	class Organisasi extends Connection
	{
		public $mysqli;
		
		public $id =0;
		public $nama_organisasi = '';
		public $nama_negara = '';
		public $representasi = '';
		public $alamat = '';
		public $tingkat_kerawanan = '';
		public $id_mitra = '';
		public $id_datacollection= '';
		public $tahun_beroperasi = 0;
		public $id_statusperizinan='';
		public $anggaran = '';
		public $jejaring_mitra = '';
		public $tahun_berdiri = 0;	
		public $mitralokalorganisasi = array();
		public $isuorganisasi = array();
		public $lokasiprovinsiorganisasi = array();
		public $lokasikabupatenorganisasi = array();
		public $bidangkerjaorganisasi = array();
		public $donororganisasi = array();
		public $hasil = false;
		public $message ='';
	
		public function __construct(){
			$this->conn = $this->connect();
		} 
		
	
	public function AddOrganisasi(){			

			$sql = "INSERT INTO organisasi(nama_organisasi, id_negara_asal, representasi, alamat, id_mitra, id_datacollection, tahun_berdiri, tahun_beroperasi, id_statusperizinan, anggaran) 
					values ('$this->nama_organisasi',$this->id_negara_asal,'$this->representasi','$this->alamat',$this->id_mitra, $this->id_datacollection,$this->tahun_berdiri, $this->tahun_beroperasi,$this->id_statusperizinan,$this->anggaran)";	
            
            $this->conn->begin_transaction();
            
            try {
					$this->conn->query($sql);											
					//$this->conn->error;
			        $this->id = $this->conn->insert_id;		
			        $this->InsertDetailOrganisasi();			
			
			        $this->conn->commit();
			        $this->hasil = true;
			        $this->message = "Data berhasil ditambahkan";//. $this->id;
            } catch (Exception $e) {
                    $this->hasil = false;
                    $this->message = "Data gagal ditambahkan";// . $e->getMessage();
                    $this->conn->rollback();
                    //throw $e;
            }

			
			
			  
			//if ($this->hasil) {
			//	$this->message = "Data berhasil ditambahkan";
		  	//} else {
			//	$this->message = "Data gagal ditambahkan" .$sql . $this->conn->error;
		  	//}
			
		}

	private function InsertDetailOrganisasi(){
		$sql ='';
		if(count($this->mitralokalorganisasi) > 0){
			$sql = "INSERT INTO mitralokalorganisasi(id_organisasi, id_mitralokal) values"; 
					
			for ($i = 0; $i < count($this->mitralokalorganisasi); $i++) {
				$dataMitraLokalOrg = $this->mitralokalorganisasi[$i];				
				$sql .= "($this->id, $dataMitraLokalOrg->id_mitralokal),";
			}						
			$sql = substr($sql, 0, -1);

            $this->conn->query($sql);			
			
		}
			
		if(count($this->lokasiprovinsiorganisasi) > 0){
			$sql = "INSERT INTO lokasiorganisasiprovinsi(id_organisasi, id_provinsi) values"; 
					
			for ($i = 0; $i < count($this->lokasiprovinsiorganisasi); $i++) {
				$dataLokasiOrg = $this->lokasiprovinsiorganisasi[$i];				
				$sql .= "($this->id, $dataLokasiOrg->id_provinsi),";
			}						
			$sql = substr($sql, 0, -1);
			$this->conn->query($sql);
		}

		if(count($this->lokasikabupatenorganisasi) > 0){
			$sql = "INSERT INTO lokasiorganisasikabupaten(id_organisasi, id_provinsi, id_kabupaten) values"; 
					
			for ($i = 0; $i < count($this->lokasikabupatenorganisasi); $i++) {
				$dataLokasiKabOrg = $this->lokasikabupatenorganisasi[$i];				
				$sql .= "($this->id, $dataLokasiKabOrg->id_provinsi, $dataLokasiKabOrg->id_kabupaten),";
			}						
			$sql = substr($sql, 0, -1);
			$this->conn->query($sql);
		}
			
		if(count($this->bidangkerjaorganisasi) > 0){
			$sql = "INSERT INTO bidangkerjaorganisasi(id_organisasi, id_bidangkerja) values"; 
					
			for ($i = 0; $i < count($this->bidangkerjaorganisasi); $i++) {
				$dataBidangKerjaOrg = $this->bidangkerjaorganisasi[$i];				
				$sql .= "($this->id, $dataBidangKerjaOrg->id_bidangkerja),";
			}						
			$sql = substr($sql, 0, -1);
		    $this->conn->query($sql);
		}

		if(count($this->isuorganisasi) > 0){
			$sql = "INSERT INTO isuorganisasi(id_organisasi, id_isu, keterangan) values"; 
					
			for ($i = 0; $i < count($this->isuorganisasi); $i++) {
				$dataIsuOrg = $this->isuorganisasi[$i];				
				$sql .= "($this->id, $dataIsuOrg->id_isu, '$dataIsuOrg->keterangan'),";
			}						
			$sql = substr($sql, 0, -1);

			$this->conn->query($sql);
		}

		if(count($this->donororganisasi) > 0){
			$sql = "INSERT INTO donororganisasi(id_organisasi, id_donor, jumlah) values"; 
					
			for ($i = 0; $i < count($this->donororganisasi); $i++) {
				$dataDonorOrg = $this->donororganisasi[$i];				
				$sql .= "($this->id, $dataDonorOrg->id_donor, $dataDonorOrg->jumlah),";
			}						
			$sql = substr($sql, 0, -1);

			$this->conn->query($sql);
		}
			
	}

	private function DeleteDetailOrganisasi(){
		$sql = "DELETE FROM lokasiorganisasiprovinsi
				WHERE id_organisasi = $this->id";
		$this->conn->query($sql);

		$sql = "DELETE FROM lokasiorganisasikabupaten
				WHERE id_organisasi = $this->id";
		$this->conn->query($sql);

		$sql = "DELETE FROM bidangkerjaorganisasi
				 WHERE id_organisasi = $this->id";
		$this->conn->query($sql);

		$sql = "DELETE FROM isuorganisasi
				 WHERE id_organisasi = $this->id";
		$this->conn->query($sql);

		$sql = "DELETE FROM mitralokalorganisasi
				 WHERE id_organisasi = $this->id;";
		$this->conn->query($sql);

		$sql = "DELETE FROM donororganisasi
				WHERE id_organisasi = $this->id";
		$this->conn->query($sql);

	}
	
	public function UpdateOrganisasi(){			
			$sql = "UPDATE organisasi 
					SET nama_organisasi ='$this->nama_organisasi',
					id_negara_asal = $this->id_negara_asal,
					representasi ='$this->representasi',
					alamat ='$this->alamat',
					id_mitra = $this->id_mitra,
					id_datacollection =$this->id_datacollection,
					tahun_beroperasi = $this->tahun_beroperasi,
					tahun_berdiri = $this->tahun_berdiri,
					id_statusperizinan = $this->id_statusperizinan,
					anggaran =$this->anggaran					
					WHERE id = $this->id";
					
			$this->conn->begin_transaction();
            
            try {
                    $this->conn->query($sql);	
			        $this->DeleteDetailOrganisasi();
			        $this->InsertDetailOrganisasi();			
			
			        $this->conn->commit();
			        $this->hasil = true;
			        $this->message = "Data berhasil diubah";
            } catch (Exception $e) {
                    $this->hasil = false;
                    $this->message = "Data gagal diubah" ;//. $e->getMessage();
                    $this->conn->rollback();
            }
		}

		public function DeleteOrganisasi(){			
			$sql = "DELETE FROM organisasi WHERE id=$this->id";									
				
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

		
		
		public function SelectAllOrganisasi(){
			$sql = "SELECT * from v_organisasi where 1";
			$sql .= " ORDER BY id ASC";
			
			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}

		public function SelectAllOrganisasiSimple(){
			$sql = "SELECT a.id, a.nama_organisasi, a.alamat, b.nama_negara, fn_GetTingkatKerawanan(a.id) as tingkat_kerawanan from organisasi a join master_negara b on a.id_negara_asal = b.id where 1";
			$sql .= " ORDER BY id ASC";
			
			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}
		
		public function SelectOneOrganisasi(){			
			$sql = "SELECT * FROM v_organisasi WHERE id='$this->id'";				
			$bind = $this->conn->query($sql);
			while ($obj = $bind->fetch_object()) {
				$baris = $obj;
			}
			$baris->mitralokalorganisasi = $this->SelectAllMitraLokalOrganisasi($this->id);
			$baris->isuorganisasi = $this->SelectAllIsuOrganisasi($this->id);
			$baris->lokasiprovinsiorganisasi = $this->SelectAllLokasiProvinsiOrganisasi($this->id);
			$baris->lokasikabupatenorganisasi = $this->SelectAllLokasiKabupatenOrganisasi($this->id);
			$baris->bidangkerjaorganisasi = $this->SelectAllBidangKerjaOrganisasi($this->id);
			$baris->donororganisasi = $this->SelectAllDonorOrganisasi($this->id);

			return $baris;								
		}

		public function SelectAllMitraLokalOrganisasi($id_organisasi){
			$sql = "SELECT a.id, a.id_mitralokal, b.nama_mitralokal from mitralokalorganisasi a join master_mitralokal b on a.id_mitralokal = b.id where a.id_organisasi = ". $id_organisasi;
			
			$sql .= " ORDER BY a.id ASC";
			$bind = $this->conn->query($sql);
			//echo $sql;
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			//$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}

		public function SelectAllLokasiKabupatenOrganisasi($id_organisasi){
			$sql = "SELECT a.id, a.id_provinsi, a.id_kabupaten, b.nama_kabupatenkota from lokasiorganisasikabupaten a join master_kabupatenkota b on a.id_kabupaten = b.id where a.id_organisasi = ". $id_organisasi;
			
			$sql .= " ORDER BY a.id ASC";
			$bind = $this->conn->query($sql);
			//echo $sql;
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			//$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}
		public function SelectAllBidangKerjaOrganisasi($id_organisasi){
			$sql = "SELECT a.id, a.id_bidangkerja, b.nama_bidang from bidangkerjaorganisasi a join master_bidangkerja b on a.id_bidangkerja = b.id where a.id_organisasi = ". $id_organisasi;
			
			$sql .= " ORDER BY a.id ASC";
			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			//$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}
		

		public function SelectAllLokasiProvinsiOrganisasi($id_organisasi){
			//$sql = "SELECT a.id, a.id_provinsi, b.nama_provinsi from lokasiorganisasiprovinsi a join master_provinsi b on a.id_provinsi = b.id where a.id_organisasi = ". $id_organisasi;

			$sql = "select lok.id, mp.nama_provinsi, lok.id_provinsi, group_concat(lok.id_kabupaten separator ',') as id_kabupaten, group_concat(mk.nama_kabupatenkota separator '<br> ') as nama_kabupaten
			from lokasiorganisasikabupaten lok
			join master_kabupatenkota mk
			on lok.id_kabupaten = mk.id
            JOIN master_provinsi mp
            on lok.id_provinsi = mp.id
            where lok.id_organisasi = $id_organisasi
			group by lok.id_organisasi, lok.id_provinsi
            order by lok.id";
			
			//$sql .= " ORDER BY a.id ASC";
			$bind = $this->conn->query($sql);
			//echo $sql;
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			//$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}


		public function SelectAllIsuOrganisasi($id_organisasi){
			$sql = "SELECT a.id, a.id_isu, b.nama_isu, a.keterangan from isuorganisasi a join master_isu b on a.id_isu = b.id where a.id_organisasi = ". $id_organisasi;
			
			$sql .= " ORDER BY a.id ASC";
			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
			//$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}

		public function SelectAllDonorOrganisasi($id_organisasi){
			$sql = "SELECT a.id, a.id_donor, b.nama_donor, a.jumlah from donororganisasi a join master_donor b on a.id_donor = b.id where a.id_organisasi = ". $id_organisasi;
			
			$sql .= " ORDER BY a.id ASC";
			$bind = $this->conn->query($sql);
			
			while ($obj = $bind->fetch_object()) {
				$baris[] = $obj;
			}
	//		$this->conn->close();
				if(!empty($baris)){
					return $baris;
			}					
		}
		
}	
	