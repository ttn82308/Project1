

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Total Patient</title>
</head>
<body>

	<?php
		session_start(); 
		include ("../include/header.php");
		include ("../include/connection.php");
		// Kiểm tra nếu người dùng đã đăng nhập
		if (!isset($_SESSION['doctor'])) {
		    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
		    header("Location: ../doctorlogin.php");
		    exit();
		}
	?>
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-2" style="margin-left:-30px;">
					<?php
					include("sidenav.php");
					?>
				</div>
				<div class="col-md-10">
					<h5 class="text-center my-3">Total Patient</h5>


					<?php
					$query= "SELECT * FROM patient";
					$res = mysqli_query($connect,$query);

					$output = "";
					$output .= "
					<table class='table table-responsive table-bordered'>
								<tr>
								<th>ID</th>
								<th>Họ</th>
								<th>Tên</th>
								<th>Username</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Gender</th>
								<th>Country</th>
								<th>Date Reg</th>
								<th style='width: 10%;''>Action</th>
								<tr>
								";

					if(mysqli_num_rows($res) < 1 ){
									$output .= "<tr><td colspan='3' class='text-center'>No Patient Yet</td></tr>";
								}
					while ($row = mysqli_fetch_array($res)) {
									

									$output .="
									<tr>
									<td>".$row['id']."</td>
									<td>".$row['surname']."</td>									
									<td>".$row['firstname']."</td>
									<td>".$row['username']."</td>
									<td>".$row['email']."</td>
									<td>".$row['phone']."</td>
									<td>".$row['gender']."</td>
									<td>".$row['country']."</td>
									<td>".$row['date_reg']."</td>
									<td>
										<a href='view.php?id=".$row['id']."'>
										<button class'btn btn-info'>View</button>
										</a>
										</td>
										";
									}
									$output .= "
									</tr>
									</table>";
									echo $output;
										?>

				</div>
			</div>
		</div>
	</div>
</body>
</html>