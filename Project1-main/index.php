
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
				<h5 class="text-center">Thông tin thêm</h5>
				<br>
				<a href="#">
					<div class="d-flex justify-content-center">
    					<button class="btn btn-success my-3">thông tin chi tiết</button>
					</div>
				</a>
				</div>
			<div class= "col-md-3 mx-1 shadow">
				<img src="img/patient_1.jpg" style="width: 100%;">
				<h5 class="text-center">Click vào nút bên dưới để tạo tài khoản.</h5>
				<a href="register.php">
					<div class="d-flex justify-content-center">
    					<button class="btn btn-success my-3">Tạo tài khoản</button>
					</div>
				</a>

				</div>
			<div class= "col-md-3 mx-1 shadow">
				<img src="img/doctor.jpg" style="width: 100%;">
				<h5 class="text-center">Bạn muốn đăng ký làm bác sĩ ở chỗ chúng tôi ?</h5>
				<a href="apply.php">
					<div class="d-flex justify-content-center">
    					<button class="btn btn-success my-3">Đăng ký ngay</button>
					</div>
				</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>