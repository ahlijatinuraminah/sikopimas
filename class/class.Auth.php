<?php
include "inc.koneksi.php";
require_once('../assets/PHPMailer/class.SentMail.php'); 

class Auth extends Connection
{
    public $hasil = false;
    public $message = '';
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function Login($email, $password)
    {
        $role_id = 0;
        //$sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $sql = "SELECT * FROM user WHERE email='$email'";
        $baris = new Auth();

        $bind = $this->conn->query($sql);
        if($bind->num_rows > 0){
            while ($obj = $bind->fetch_object()) {                
                $baris->role_id = $obj->role_id;
                $baris->password = $obj->password;
                $baris->id = $obj->id;                
            }
            
            if (password_verify($password, $baris->password)) {
                $baris->hasil = true;            
            } else {
                $baris->hasil = false;
                $baris->message = "Invalid username and pasword";                        
            }
        }
        else{
            $baris->hasil = false;
            $baris->message = "User doesn't exists";                        
        }
        return $baris;
        
    }

    public function Logout()
    {
        session_destroy();
        header("Location:../index.php");
    }

    public function ForgotPassword($email)
    {
        $sql = "SELECT * FROM user WHERE email='$email'";
        $baris = new Auth();
        $mailer = new SentMail();

        $bind = $this->conn->query($sql);
        if($bind->num_rows > 0) {
            while ($obj = $bind->fetch_object()) {                
                $baris->nama = $obj->nama;  
                $baris->id = $obj->id;      
            }

            $newPassword = $this->generatePassword();
            if($mailer->SentNewPassword($email, $baris->nama, $newPassword)) {
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql2 = "UPDATE user SET password = '$hashed_password' WHERE id = $baris->id";
                $this->conn->query($sql2);

                $baris->hasil = true;
                $baris->message = "Email Sent";
            }
            else {
                $baris->hasil = false;
                $baris->message = "Failed to Send Email";
            }
        }
        else{
            $baris->hasil = false;
            $baris->message = "User doesn't exists";                        
        }
        return $baris;   
    }

    private function generatePassword()
    {
        $listAlpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $listNonAlpha = ',;:!?.$/*-+&@_+;./*&?$-!,';
        return str_shuffle(
            substr(str_shuffle($listAlpha), 0, 6) .
            substr(str_shuffle($listNonAlpha), 0, 2)
        );
    }
}
?>
