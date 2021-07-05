<?php
include "inc.koneksi.php";
class MitraLokal extends Connection
{
    public $id = 0;
    public $nama_mitralokal = '';
    public $hasil = false;
    public $message = '';

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllMitraLokal()
    {
        $sql = "SELECT * FROM master_mitralokal where 1 order by nama_mitralokal";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();

        if (!empty($baris)) {
            return $baris;
        }
    }

    public function AddMitraLokal()
    {
        $sql = "INSERT INTO master_mitralokal(nama_mitralokal) 
					values ('$this->nama_mitralokal')";

                  
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil ditambah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function UpdateMitraLokal()
    {
        $sql = "UPDATE master_mitralokal 
					SET nama_mitralokal ='$this->nama_mitralokal'
					WHERE id = $this->id";

        
          
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil diubah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function SelectOneMitraLokal()
    {
        $sql = "SELECT * FROM master_mitralokal WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteMitraLokal()
    {
        $sql = "DELETE FROM master_mitralokal WHERE id=$this->id";
                  
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
