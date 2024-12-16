<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Doctor Dashboard</title>
</head>
<body>

	<?php 
	include("../include/header.php");
	 ?>

	 <div class="container-fluid">
	 	<div class="col-md-12">
	 		<div class="row">
	 			<div class="col-md-2" style="margin-left: -30px;">
	 				<?php 
	 				include("sidenav.php");
	 				 ?>
	 			</div>
	 			<div class="col-md-10">
	 			<div class="container-fluid">
	 				<h5>Doctor Dashboard</h5>
	 				<div class="col-md-12">
	 					<div class="row">
	 						
	 						<div class="col-md-3 my-2 bg-info my-2" style="height: 150px;">
	 							<div class="col-md-12">
	 								<div class="row">
	 									<div class="col-md-8">
	 										<h5 class="text-white my-4">My Profile</h5>
	 									</div>
	 									<div class="col-md-4">
	 										<a href="profile.php"><i class="fa fa-user-circle fa-3x my-4" style="color: white;"></i></a>
	 									</div>
	 								</div>
	 							</div>
	 						</div>

	 						<div class="col-md-3 my-2 bg-warning mx-2" style="height: 150px;">
	 							<div class="col-md-12">
	 								<div class="row">
	 									<div class="col-md-8">
	 										<h5 class="text-white my-2" style="font-size: 30px;">0</h5>
	 										<h5 class="text-white">Total</h5>
	 										<h5 class="text-white">Patient</h5>
	 									</div>
	 									<div class="col-md-4">
	 										<a href="#"><i class="fa fa-procedures fa-3x my-4" style="color: white;"></i></a>
	 									</div>
	 								</div>
	 							</div>
	 						</div>

	 						<div class="col-md-3 my-2 bg-success mx-2" style="height: 150px;">
	 							<div class="col-md-12">
	 								<div class="row">
	 									<div class="col-md-8">
	 										<h5 class="text-white my-2" style="font-size: 30px;">0</h5>
	 										<h5 class="text-white">Total</h5>
	 										<h5 class="text-white">Appointment</h5>
	 									</div>
	 									<div class="col-md-4">
	 										<a href="#"><i class="fa fa-calendar fa-3x my-4" style="color: white;"></i></a>
	 									</div>
	 								</div>
	 							</div>
	 						</div>


	 					</div>
	 				</div>
	 			</div>
	 			</div>
	 		</div>
	 	</div>
	 </div>
</body>
</html>