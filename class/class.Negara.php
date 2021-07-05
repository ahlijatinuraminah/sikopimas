<?php
include "inc.koneksi.php";
class Negara extends Connection
{
    public $id = 0;
    public $nama_negara = '';
    public $jumlah_organisasi = '';
    public $hasil = false;
    public $message = '';

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllNegara()
    {
        $sql = "SELECT * FROM master_negara where 1";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();
        if (!empty($baris)) {
            return $baris;
        }
    }

    public function AddNegara()
    {
        $sql = "INSERT INTO master_negara(nama_negara) 
					values ('$this->nama_negara')";

                  
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil ditambah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function UpdateNegara()
    {
        $sql = "UPDATE master_negara 
					SET nama_negara ='$this->nama_negara'
					WHERE id = $this->id";

        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil diubah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function SelectOneNegara()
    {
        $sql = "SELECT * FROM master_negara WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteNegara()
    {
        $sql = "DELETE FROM master_negara WHERE id=$this->id";
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
