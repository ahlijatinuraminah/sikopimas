<?php
include "inc.koneksi.php";
class DataCollection extends Connection
{
    public $id = 0;
    public $deskripsi = '';
    public $jumlah_organisasi = '';
    public $hasil = false;
    public $message = '';

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllDataCollection()
    {
        $sql = "SELECT * FROM master_datacollection where 1";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();
        if (!empty($baris)) {
            return $baris;
        }
    }

    public function AddDataCollection()
    {
        $sql = "INSERT INTO master_datacollection(deskripsi) 
					values ('$this->deskripsi')";

        
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil ditambahkan";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}	
    }

    public function UpdateDataCollection()
    {
        $sql = "UPDATE master_datacollection 
					SET deskripsi ='$this->deskripsi'
					WHERE id = $this->id";

        $this->hasil = $this->conn->query($sql);				
        if ($this->hasil) {
            $this->message = "Data berhasil diubah";
          } else {
            $this->message = "Error: " . $this->conn->error;
          }	
    }

    public function SelectOneDataCollection()
    {
        $sql = "SELECT * FROM master_datacollection WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteDataCollection()
    {
        $sql = "DELETE FROM master_datacollection WHERE id=$this->id";
        
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
