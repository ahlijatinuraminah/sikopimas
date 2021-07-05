<?php
include "inc.koneksi.php";
class BidangKerja extends Connection
{
    public $id = 0;
    public $nama_bidang = '';
    public $hasil = false;
    public $message = '';

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllBidangKerja()
    {
        $sql = "SELECT id, nama_bidang FROM master_bidangkerja";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();

        if (!empty($baris)) {
            return $baris;
        }
    }

    public function AddBidangKerja()
    {
        $sql = "INSERT INTO master_bidangkerja(nama_bidang) 
					values ('$this->nama_bidang')";

        
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil ditambahkan";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}	
    }

    public function UpdateBidangKerja()
    {
        $sql = "UPDATE master_bidangkerja 
					SET nama_bidang ='$this->nama_bidang'
					WHERE id = $this->id";

        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil diubah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}	
    }

    public function SelectOneBidangKerja()
    {
        $sql = "SELECT * FROM master_bidangkerja WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteBidangKerja()
    {
        $sql = "DELETE FROM master_bidangkerja WHERE id=$this->id";
        
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
}
?>
