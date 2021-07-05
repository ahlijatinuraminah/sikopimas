<?php
include "inc.koneksi.php";
class Mitra extends Connection
{
    public $id = 0;
    public $nama_mitra = '';
    public $hasil = false;
    public $message = '';

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllMitra()
    {
        $sql = "SELECT * FROM master_mitra where 1";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();

        if (!empty($baris)) {
            return $baris;
        }
    }

    public function AddMitra()
    {
        $sql = "INSERT INTO master_mitra(nama_mitra) 
						values ('$this->nama_mitra')";
        
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil ditambahkan";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function UpdateMitra()
    {
        $sql = "UPDATE master_mitra 
						SET nama_mitra ='$this->nama_mitra'
						WHERE id = $this->id";

        
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil diubah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function SelectOneMitra()
    {
        $sql = "SELECT * FROM master_mitra WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteMitra()
    {
        $sql = "DELETE FROM master_mitra WHERE id=$this->id";
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
