<?php 

include("include/connection.php");

session_start();

if (isset($_POST['login'])) {

	$username = isset($_POST['uname']) ? $_POST['uname'] : '';
	$password = isset($_POST['pass']) ? $_POST['pass'] : '';
 	//$username = $_POST['uname'];
 	//$password = $_POST['pass'];

	$error = array();

	if (empty($username)) {
		$error['admin'] = "Enter username";
	}else if (empty($password)){
		$error['admin'] = "Enter password";
 	}
 if (count($error)==0) {

 	$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

 	$result = mysqli_query($connect, $query);

 	if (mysqli_num_rows($result) ==1) {
 		echo "<script>alert('You have login As an admin')</script>";

 		$_SESSION['admin'] = $username;

 		//header("Location:")
 	}else{
 		echo "<script>alert('Invaild Username or Password')</script>";
 		}
	}
}	

?>  

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login Page</title>
</head>
<body style="background-image: url(img/back.jpg); background-repeat: no-repeat; background-size: cover;">
	<?php
	include("include/header.php");
	?>
	<div style="margin-top:20px;"></div>
	<div class="container"> 
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3"></div>
					<div class="col-md-6 jumbotron">
						<img src="img/admin.jfif" class="col-md-12">
					<form method="post" class="my-2">

						<div class="alert alert-danger">
							<?php
							if (isset($error['admin'])) {
								  $show = $error['admin'];								
							}else {
								$show = "";
							} 
							 echo $show;
							
							 ?>  
						</div>	

						<div class="form-group">
							<label>Username</label>
							<input type="text" name="uname" class="form-control"
							autocomplete="off" placeholder="Enter Username">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="pass" class="form-control">
						</div>
						<input type="submit" name="login" class="btn btn-success" value="Login">
					</form>
					</div class="col-md-3"></div>
				</div>
			</div>

</body>
</html>