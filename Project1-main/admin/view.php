<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Patient Details</title>
</head>
<body>
<?php
session_start(); 
include ("../include/header.php");
include ("../include/connection.php");
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['admin'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: ../adminlogin.php");
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
					<h5 class="text-center my-3">View Patient Details</h5>
					<?php 

					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$query = "SELECT * FROM patient WHERE id='$id'";
						$res = mysqli_query($connect,$query);
						$row = mysqli_fetch_array($res);
					}

					 ?>
					 <div class="col-md-12">
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<?php 
								echo "<img src='../patient/img/".$row['profile']."' class='col-md-12 my-2' style='height: 500px;'>" ?>
								<table class='table table-bordered'>
								<tr>
								<th class="text-center" colspan="2">Details</th>
							</tr>
							<tr>
								<td>Họ</td>
								<td><?php echo $row['surname'];?></td>
							</tr>
							<tr>
								<td>Tên</td>
								<td><?php echo $row['firstname'];?></td>
							</tr>

							<tr>
								<td>Tên tài khoản</td>
								<td><?php echo $row['username'];?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?php echo $row['email'];?></td>
							</tr>
							<tr>
								<td>Số điện thoại</td>
								<td><?php echo $row['phone'];?></td>
							</tr>
							<tr>
								<td>Giới tính</td>
								<td><?php echo $row['gender'];?></td>
							</tr>
							<tr>
								<td>Quốc tịch</td>
								<td><?php echo $row['country'];?></td>
							</tr>
							<tr>
								<td>Ngày đăng kí</td>
								<td><?php echo $row['date_reg'];?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</body>
</html>