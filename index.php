
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HMS Home Page</title>
</head>
<body>
<?php 
	include("include/header.php");
?>
<div style="margin-top: 50px"></div>

<div class="container">
	<div class="col-md-12">
		<div class="row">
			<div class= "col-md-3 mx-1 shadow">
				<img src="img/info_1.jpg" style="width: 100%;">
				<h5 class="text-center">additional information</h5>
				<a href="more_info.php">
					<div class="d-flex justify-content-center">
    					<button class="btn btn-success my-3">More info</button>
					</div>
				</a>
				</div>
			<div class= "col-md-3 mx-1 shadow">
				<img src="img/doctor.jpg" style="width: 100%;">
				<h5 class="text-center">Click here for register.</h5>
				<a href="create_account.php">
					<div class="d-flex justify-content-center">
    					<button class="btn btn-success my-3">Create Account</button>
					</div>
				</a>

				</div>
			<div class= "col-md-3 mx-1 shadow">
				<img src="img/patient_1.jpg" style="width: 100%;">
				<h5 class="text-center">We are hiring doctors</h5>
				<a href="apply_doctor.php">
					<div class="d-flex justify-content-center">
    					<button class="btn btn-success my-3">Apply now</button>
					</div>
				</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>