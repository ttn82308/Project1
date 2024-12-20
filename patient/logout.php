<?php 
session_start();

if (isset($_SESSION['patient'])) {

	unset($_SESSION['patient']);
	
	session_destroy();

	header("Location:../index.php");
	
}
 ?>