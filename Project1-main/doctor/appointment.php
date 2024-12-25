
<!DOCTYPE html>
<html>
<head>

	<title>Danh sách lịch hẹn</title>
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
	 			<div class="col-md-2" style="margin-left: -30px;">
	 				<?php 
	 				include("sidenav.php");
	 				 ?>
	 			</div>
	 			<div class="col-md-10">
	 				<h5 class="text-center my-2">Danh sách lịch hẹn</h5>
	 				<?php 

	 				$query = "SELECT * FROM appointment";
	 				$res = mysqli_query($connect,$query);

	 				$output ="";

	 				$output .="
	 				<table class ='table table-bodered'>
	 				<tr>
	 				<td>ID</td>
	 				<td>Tên</td>
	 				<td>Họ</td>	 				
	 				<td>Giới tính</td>
	 				<td>Số điện thoại</td>
	 				<td>Ngày hẹn khám</td>
	 				<td>Triệu chứng gặp</td>
	 				<td>Ngày đặt lịch</td>	 				
	 				<td>Chi tiết</td>
	 				<td>Bác sĩ phụ trách</td>
	 				<td>Trạng Thái</td>
	 				</tr>
	 				";

	 				if (mysqli_num_rows($res) < 1) {
	 					$output .="
	 					<tr>
	 					<td class='text-center' colspan ='10'>Không có lịch hẹn.</td>
	 					</tr>
	 					";
	 				}
							while ($row = mysqli_fetch_array($res)) {
						    $status = $row['status'];
						    $doctorAssigned = !empty($row['doctor_id']) ? $row['doctor_id'] : "Chưa chỉ định";

						    $output .= "
						    <tr>
						        <td>".$row['id']."</td>
						        <td>".$row['firstname']."</td>
						        <td>".$row['surname']."</td>
						        <td>".$row['gender']."</td>
						        <td>".$row['phone']."</td>
						        <td>".$row['appointment_date']."</td>
						        <td>".$row['symptoms']."</td>
						        <td>".$row['date_booked']."</td>
						        <td>
						            ".($status === 'Approved' 
						                ? "<button class='btn btn-secondary' disabled>Chi tiết</button>"
						                : "<a href='discharge.php?id=".$row['id']."'>
						                    <button class='btn btn-info'>Chi tiết</button>
						                  </a>")."
						        </td>
						        <td>$doctorAssigned</td>
						        <td>
						            ".($status === 'Approved'
						                ? "<button class='btn btn-secondary' disabled>Xác nhận</button>"
						                : "<a href='approve.php?id=".$row['id']."'>
						                    <button class='btn btn-info'>Xác nhận</button>
						                  </a>")."
						        </td>
						    </tr>
						    ";
						}



	 				echo $output;

	 				 ?>
	 			</div>
	 		</div>
	 	</div>
	 </div>

</body>
</html>