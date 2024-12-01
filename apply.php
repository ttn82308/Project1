<?php 

include("include/connection.php");

	if (isset($_POST['apply'])) {

		$firstname = isset($_POST['fname']) ? $_POST['fname'] : '';
		$surname = isset($_POST['sname']) ? $_POST['sname'] : '';
		$username = isset($_POST['uname']) ? $_POST['uname'] : '';
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$phone = isset($_POST['phone']) ? $_POST['phone'] :'';
		$country = isset($_POST['country']) ? $_POST['country'] : '';
		$password = isset($_POST['pass']) ? $_POST['pass'] : '';
		$confirm_password = isset($_POST['con_pass']) ? $_POST['con_pass'] : '';


		$error = array();

		if (empty($firstname)) {
			$error['apply'] = "Enter firstname";
		}else if (empty($surname)) {
			$error['apply'] ="Enter surname ";
		}else if (empty($username)) {
			$error['apply'] ="Enter username";
		}else if (empty($email)) {
			$error['apply'] ="Enter email";
		}else if (empty($gender == "")) {
			$error['apply'] ="Select your gender";
		}else if (empty($phone)) {
			$error['apply'] ="Enter your phone number ";
		}else if (empty($country =="")) {
			$error['apply'] ="Select your country ";
		}else if (empty($password)) {
			$error['apply'] ="Enter password";
		}else if (empty($confirm_password != $password)) {
			$error['apply'] ="password does not match";
		}

		if (count($error) == 0) {
			$query ="INSERT INTO doctors( firstname, surname, username, Email, gender, phone, country, password, salary, data_reg, status, profile) VALUES(`firstname`, `surname`, `username`, `Email`, `gender`, `phone`, `country`, `password`, '0', NOW(), 'Pending', 'doctor.jpg')";
			$result = mysqli_query($connect,$query);

			if ($result) {
				echo "<script>alert('You have successed Applid')</script>";
				header("Location: doctorlogin.php");
			}else{
				echo "<script>alert('Failed')</script>";
			}
		}



	}

		if (isset($error['apply'])) {
			$s = $error['apply'];

			$show = "<h5 class = 'text-center alert alert-danger'>$s</h5>";
		}else{
			$show = "";
		}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Apply Now</title>
</head>
<body style="background-image: url(img/back.jpg); background-size: cover; background-repeat: no-repeat;">
	<?php 
	include("include/header.php");
	 ?>

	 <div class="container-fluid">
	 	<div class="col-md-12">
	 		<div class="row">
	 			<div class="col-md-3"></div>
	 			<div class="col-md-6 jumbotron my-3">
	 				<h5 class="text-center">Apply Now</h5>
	 				<div>
	 					<?php echo $show; ?>
	 				</div>
	 				<form method="post">
	 				<div class="form-group">
	 					<label>First Name</label>
	 					<input type="text" name="fname" class="form-control" autocomplete="off" placeholder="Enter Firstname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>">
	 				</div>
	 				<div class="form-group">
	 					<label>SurName</label>
	 					<input type="text" name="sname" class="form-control" autocomplete="off" placeholder="Enter Surname"value="<?php if(isset($_POST['sname'])) echo $_POST['sname']; ?>">
	 				</div>
	 				<div class="form-group">
	 					<label>User Name</label>
	 					<input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username"value="<?php if(isset($_POST['uname'])) echo $_POST['uname']; ?>">
	 				</div>
	 				<div class="form-group">
	 					<label>Email</label>
	 					<input type="text" name="email" class="form-control" autocomplete="off" placeholder="Enter Email"value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
	 				</div>
	 				<div class="form-group">
	 					<label>Gender</label>
	 					<select name="Gender">
	 						<option value="">Select Gender</option>
	 						<option value="Male">Male</option>
	 						<option value="Female">Female</option>
	 					</select>
	 				</div> 
	 				<div>
	 					<div class="form-group">
	 					<label>Phone Number</label>
	 					<input type="number" name="phone" class="form-control" autocomplete="off" placeholder="Enter Phone Number"value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
	 				</div>
	 				<div class="form-group">
	 					<label>Country</label>
	 					<select name="Gender" class="form-control">
	 						<option value="">Select Country</option>
	 						<option value="America">America</option>
	 						<option value="Japan">Japan</option>
	 						<option value="China">China</option>
	 						<option value="VietNam">VietNam</option>
	 					</select>
	 				</div>
	 				<div class="form-group">
	 					<label>Password</label>
	 					<input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Enter Password">
	 				</div>
	 				<div class="form-group">
	 					<label>Confirm Password</label>
	 					<input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Confirm password">
	 				</div>
	 				<input type="submit" name="apply" value="Apply Now" class="btn btn-success">
	 				<p>I already have an account <a href="doctorlogin.php">Click here</a></p>
	 				</div>
	 				</form>
	 			</div>
	 			<div class="col-md-3"></div>
	 		</div>
	 	</div>
	 </div>
</body>
</html>