<?php 

include("include/connection.php");

session_start();

if (isset($_POST['login'])) {

	// Lấy và làm sạch dữ liệu nhập vào
	$username = isset($_POST['uname']) ? trim($_POST['uname']) : '';
	$password = isset($_POST['pass']) ? trim($_POST['pass']) : '';

	$error = array();

	// Kiểm tra dữ liệu nhập
	if (empty($username)) {
		$error['admin'] = "Nhập tên tài khoản.";
	} else if (empty($password)) {
		$error['admin'] = "Nhập mật khẩu.";
	}

	if (count($error) == 0) {
		// Truy vấn với prepared statement để tránh SQL Injection
		$query = "SELECT * FROM admin WHERE username = ?";
		$stmt = mysqli_prepare($connect, $query);
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			
			// Kiểm tra mật khẩu với password_verify
			if (password_verify($password, $row['password'])) {
				echo "<script>alert('Bạn đã đăng nhập với tư cách admin.')</script>";

				$_SESSION['admin'] = $username;

				header("Location: admin/index.php");
				exit();
			} else {
				echo "<script>alert('Tên tài khoản hoặc mật khẩu không đúng.')</script>";
			}
		} else {
			echo "<script>alert('Tên tài khoản hoặc mật khẩu không đúng.')</script>";
		}

		mysqli_stmt_close($stmt);
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

						<div >
							<?php
							if (isset($error['admin'])) {
								  $sh = $error['admin'];	
								  $show = "<h4 class='alert alert-danger'> ' $sh' </h4>";
							}else {	
								$show = "";
							} 
							 echo $show;
							
							 ?>  
						</div>	

						<div class="form-group">
							<label>Tên tài khoản</label>
							<input type="text" name="uname" class="form-control"
							autocomplete="off" placeholder="Nhập tài khoản">
						</div>
						<div class="form-group">
							<label>Mật khẩu</label>
							<input type="password" name="pass" class="form-control" placeholder="Nhập mật khẩu">
						</div>
						<input type="submit" name="login" class="btn btn-success" value="Đăng nhập">
					</form>
					</div class="col-md-3"></div>
				</div>
			</div>

</body>
</html>