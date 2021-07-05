<?php
if (!isset($_SESSION)) {
    session_start();
}

include "inc.koneksi.php";
class User extends Connection
{
    public $id = 0;
    public $nama = '';
    public $email = '';
    public $role_id = '';
    public $password = '';
    public $new_password = '';
    public $message = '';
    public $hasil = false;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function SelectAllUser()
    {
        $sql = "SELECT u.*, r.name as role_name FROM user u join role r on u.role_id = r.id where 1";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();
        if (!empty($baris)) {
            return $baris;
        }
    }

    public function SelectAllRole()
    {
        $sql = "SELECT * FROM role where 1";

        $bind = $this->conn->query($sql);

        while ($obj = $bind->fetch_object()) {
            $baris[] = $obj;
        }
        $this->conn->close();
        if (!empty($baris)) {
            return $baris;
        }
    }

    public function LoadProfile()
    {
        $id = $_SESSION['user'];
        $sql = "SELECT * FROM user where id = '$id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function AddUser()
    {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(nama, email, password, role_id) 
                    values ('$this->nama','$this->email','$hashed_password','$this->role_id')";

        
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil ditambahkan";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function UpdateUser()
    {
        $sql = "UPDATE user 
					SET nama = '$this->nama',
					email = '$this->email',
					role_id = '$this->role_id'
					WHERE id = $this->id";

        
        $this->hasil = $this->conn->query($sql);				
			if ($this->hasil) {
				$this->message = "Data berhasil diubah";
		  	} else {
				$this->message = "Error: " . $this->conn->error;
		  	}
    }

    public function UpdatePassword()
    {
        $temp = $this->password;
        $sql = "SELECT * FROM user WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }

        if (password_verify($this->password, $baris->password)) {
            $hashed_password = password_hash($this->new_password, PASSWORD_DEFAULT);
            $sql2 = "UPDATE user
                    SET password = '$hashed_password'
                    WHERE id = $this->id";

            $this->conn->query($sql2);
            $this->message = "Password berhasil diubah";
        } else {
            $this->message = "";
        }
    }

    public function SelectOneUser()
    {
        $sql = "SELECT * FROM user WHERE id='$this->id'";

        $bind = $this->conn->query($sql);
        while ($obj = $bind->fetch_object()) {
            $baris = $obj;
        }
        return $baris;
    }

    public function DeleteUser()
    {
        //$sql = "DELETE FROM user WHERE id=$this->id";        
       // $this->hasil = $this->conn->query($sql);			
                
        $sql= 'DELETE FROM user where id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $this->hasil = $stmt->execute();
        $stmt->close();

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
