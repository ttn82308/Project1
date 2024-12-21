<?php   
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Book Appointment</title>
</head>
<body>
	<?php 
		include("../include/header.php");
		include("../include/connection.php");
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
	 				<h5 class="text-center my-2">Book Appointment</h5>

	 				<?php 
	 				$pat = $_SESSION['patient'];
	 				$sel = mysqli_query($connect, "SELECT * FROM patient WHERE username ='$pat'");
	 				$row = mysqli_fetch_array($sel);
	 				$firstname = $row['firstname'];
	 				$surname = $row['surname'];
	 				$gender = $row['gender'];
	 				$phone = $row['phone'];

	 				if (isset($_POST['book'])) {
	 					$date = $_POST['date'];
	 					$sym = $_POST['sym'];

	 					// Kiểm tra dữ liệu đầu vào
	 					if (empty($sym)) {
	 						echo "<script>alert('Please enter your symptoms.')</script>";
	 					} elseif (empty($date)) {
	 						echo "<script>alert('Please select an appointment date.')</script>";
	 					} elseif ($date < date('Y-m-d')) {
	 						echo "<script>alert('Appointment date cannot be in the past.')</script>";
	 					} else {
	 						// Kiểm tra số lượng lịch hẹn tối đa trong ngày
	 						$check_limit_query = "SELECT limit_count FROM appointment_limits WHERE appointment_date = '$date'";
	 						$limit_res = mysqli_query($connect, $check_limit_query);
	 						$limit_row = mysqli_fetch_assoc($limit_res);

	 						$max_limit = isset($limit_row['limit_count']) ? $limit_row['limit_count'] : 3; // Mặc định là 3 nếu không có giới hạn.

	 						// Kiểm tra số lượng lịch hẹn hiện tại
	 						$query_check = "SELECT COUNT(*) as total FROM appointment WHERE appointment_date = '$date'";
	 						$res_check = mysqli_query($connect, $query_check);
	 						$row_check = mysqli_fetch_assoc($res_check);

	 						if ($row_check['total'] >= $max_limit) {
	 							echo "<script>alert('Appointment slots for this date are full. Please select another date.')</script>";
	 						} else {
	 							// Thêm lịch hẹn mới
	 							$query = "INSERT INTO appointment(firstname, surname, gender, phone, appointment_date, symptoms, status, date_booked) 
	 							          VALUES('$firstname', '$surname', '$gender', '$phone', '$date', '$sym', 'Pending', NOW())";

	 							$res = mysqli_query($connect, $query);

	 							if ($res) {
	 								echo "<script>alert('You have successfully booked an appointment.')</script>";
	 							} else {
	 								echo "<script>alert('Failed to book appointment. Please try again.')</script>";
	 							}
	 						}
	 					}
	 				}
	 				?>

	 				<div class="col-md-12">
	 					<div class="row">
	 						<div class="col-md-3"></div>
	 						<div class="col-md-6 jumbotron">
	 							<form method="post">
	 								<label>Appointment Date</label>
	 								<input type="date" name="date" class="form-control" required>

	 								<label>Symptoms</label>
	 								<input type="text" name="sym" class="form-control" autocomplete="off" placeholder="Enter Symptoms" required>
	 								<input type="submit" name="book" class="btn btn-info my-2" value="Book Appointment">
	 							</form>
	 						</div>
	 						<div class="col-md-3"></div>
	 					</div>
	 				</div>
	 			</div>
	 		</div>
	 	</div>
	</div>
</body>
</html>
