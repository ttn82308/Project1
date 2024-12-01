	<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-info bg-info">

		<h5 class="text-white"> Hospital Management System</h5>
		
		<div class="mr-auto"></div>

		<ul class="navbar-nav ">    
		<?php 
		if (isset($_SESSION['admin'])) {
			$user = $_SESSION['admin'];
			echo '
			<li class = "nav-item"><a href="user.php" class ="nav-link text-white">'.htmlspecialchars($user) .'</a></li>
			<li class = "nav-item"><a href="logout.php" class ="nav-link text-white">logout</a></li>
			';
		}else if(isset($_SESSION['doctor'])){
			$user = $_SESSION['doctor'];
			echo '
			<li class = "nav-item"><a href="user.php" class ="nav-link text-white">'.htmlspecialchars($user) .'</a></li>
			<li class = "nav-item"><a href="logout.php" class ="nav-link text-white">logout</a></li>
			';
		}else{
			echo '
			<li class = "nav-item"><a href="index.php" class ="nav-link text-white">Home</a></li>
			<li class = "nav-item"><a href="adminlogin.php" class ="nav-link text-white">Admin</a></li>
			<li class = "nav-item"><a href="doctorlogin.php" class ="nav-link text-white">Doctor</a></li>
			<li class = "nav-item"><a href="patientlogin.php" class ="nav-link text-white">Patient</a></li>
			';
		}
		 ?>   
		</ul>
	</nav>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</body>
</html>