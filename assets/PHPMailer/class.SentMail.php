<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "library/PHPMailer.php";
require_once "library/Exception.php";
require_once "library/OAuth.php";
require_once "library/POP3.php";
require_once "library/SMTP.php";

class SentMail
{
    private $username = "companyebs2020@gmail.com";
    private $password = "P@ssw0rd.123";
    private $name = "Project Sikopimas";
    private $subject = "Reset Password";

    public function SentNewPassword($email, $name, $new_password)
    {
    	$mail = new PHPMailer;

		$mail->isSMTP();                             
		$mail->Host = "tls://smtp.gmail.com";

		$mail->SMTPAuth = true;

		$mail->Username = $this->username;          
		$mail->Password = $this->password;

		$mail->SMTPSecure = "tls";
		$mail->Port = 587;                                   
	 
		$mail->From = $this->username;
		$mail->FromName = $this->name;
	 
		$mail->addAddress($email, $name);
		$mail->isHTML(true);
	 
		$mail->Subject = $this->subject;
	    $mail->Body    = "Password baru anda adalah <h4><b>" . $new_password . "</b></h4><br>Segera ganti password anda dengan password yang mudah diingat!";
	    $mail->AltBody = "PHP mailer";
	 
		if(!$mail->send()) 
		{
		    //message = "Mailer Error: " . $mail->ErrorInfo;
		    return false;
		} 
		else 
		{
			return true;
		}
    }
}
?>