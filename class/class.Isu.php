<?php
include "inc.koneksi.php";
class Isu extends Connection
{
    public $id = 0;
    public $nama_isu = '';
    public $hasil = false;
    public $message = '';

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllIsu()
    {
        $sql = "SELECT id, nama_isu FROM master_isu";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();

        if (!empty($baris)) {
            return $baris;
        }
    }

    public function AddIsu()
    {
        $sql = "INSERT INTO master_isu(nama_isu) 
					values ('$this->nama_isu')";
        
        $this->hasil = $this->conn->query($sql);				
        if ($this->hasil) {
            $this->message = "Data berhasil ditambahkan";
          } else {
            $this->message = "Error: " . $this->conn->error;
          }	
    }

    public function UpdateIsu()
    {
        $sql = "UPDATE master_isu 
					SET nama_isu ='$this->nama_isu'
					WHERE id = $this->id";

        
        $this->hasil = $this->conn->query($sql);				
        if ($this->hasil) {
            $this->message = "Data berhasil diubah";
          } else {
            $this->message = "Error: " . $this->conn->error;
          }	
    }

    public function SelectOneIsu()
    {
        $sql = "SELECT * FROM master_isu WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteIsu()
    {
        $sql = "DELETE FROM master_isu WHERE id=$this->id";
        
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
