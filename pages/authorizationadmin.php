<?php
if(!isset($_SESSION)){
 session_start();
}

if(!isset($_SESSION["role_id"])){
	echo '<script> window.location="index.php"; </script>';
}
else
{
	if($_SESSION["role_id"] != 1 ){
		//echo "<script> alert('Hanya admin yang dapat mengakses halaman ini'); </script>";
		echo '<script> window.location="index.php"; </script>';
	}
}
?>