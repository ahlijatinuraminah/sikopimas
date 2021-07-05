<?php
include "inc.koneksi.php";
class Donor extends Connection
{
    public $id = 0;
    public $nama_Donor = '';
    public $hasil = false;
    public $message = '';

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllDonor()
    {
        $sql = "SELECT id, nama_donor FROM master_donor";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();

        if (!empty($baris)) {
            return $baris;
        }
    }
    public function AddDonor()
    {
        $sql = "INSERT INTO master_donor(nama_donor) 
					values ('$this->nama_donor')";

        
        $this->hasil = $this->conn->query($sql);				
        if ($this->hasil) {
            $this->message = "Data berhasil ditambahkan";
          } else {
            $this->message = "Error: " . $this->conn->error;
          }	
    }

    public function UpdateDonor()
    {
        $sql = "UPDATE master_donor 
					SET nama_donor ='$this->nama_donor'
					WHERE id = $this->id";

        
        $this->hasil = $this->conn->query($sql);				
        if ($this->hasil) {
            $this->message = "Data berhasil diubah";
          } else {
            $this->message = "Error: " . $this->conn->error;
          }	
    }

    public function SelectOneDonor()
    {
        $sql = "SELECT * FROM master_donor WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteDonor()
    {
        $sql = "DELETE FROM master_donor WHERE id=$this->id";
        
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
