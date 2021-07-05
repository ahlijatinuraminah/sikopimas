<?php

class Connection{
	/*
	private $host = "65.19.141.67";
	private $struser = "sikopima_root";
	private $strpassword = "Esqbs165*";
	private $strdbname = "sikopima_db";      
	*/
	private $host = "localhost";
   	private $struser = "root";
   	private $strpassword = "";
   	private $strdbname = "sikopimas";  
      
    /*  
	function __construct() {
	   $this->connect();
	}
	*/
	
	function connect()
	{	    
		$connection = mysqli_connect($this->host, $this->struser, $this->strpassword,$this->strdbname);
		if (mysqli_connect_errno()){
			echo "Koneksi database gagal : " . mysqli_connect_error();
		}
    	return $connection;
		 
	}

	

}
?>




 