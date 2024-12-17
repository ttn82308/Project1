<?php 
session_start();

if (isset($_SESSION['doctor'])) {

	unset($_SESSION['doctor']);
	
	session_destroy();

	header("Location:../index.php");
	
}
 ?>