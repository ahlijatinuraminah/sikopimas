<?php
if(!isset($_SESSION)){
 session_start();
}

if(!isset($_SESSION["role_id"])){
	echo '<script> window.location="index.php"; </script>';
}
?>