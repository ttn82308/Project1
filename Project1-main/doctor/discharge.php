<?php 
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>

	<title>Check Patient Discharge</title>
</head>
<body>
<?php 
	include("../include/header.php");
	include("../include/connection.php");
 ?>
<style>
    .table {
        width: 80%; /* Làm bảng rộng hơn */
        font-size: 1.2rem; /* Tăng kích thước chữ */
        line-height: 2rem; /* Tăng khoảng cách giữa các hàng */
    }

    .table td {
        padding: 15px; /* Tăng khoảng cách bên trong ô */
                text-align: left; /* Căn trái nội dung trong ô */
    }
</style>
 <div class="container-fluid">
 	<div class="col-md-12">
 		<div class="row">
 			<div class="col-md-2" style="margin-left: -30px;">
 				<?php 
 				include("sidenav.php");
 				 ?>
 			</div>
 			<div class="col-md-10">
 				<h5 class="text-center my-2">Thông tin lịch hẹn</h5>
 				<?php 	
 				if (isset($_GET['id'])) {
 					
 					$id = $_GET['id'];

 					$query = "SELECT * FROM appointment WHERE id ='$id'";

 					$res = mysqli_query($connect,$query);

 					$row = mysqli_fetch_array($res);
 				}
 				 ?>
<div class="table-container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered text-center">
                <tr>
                    <td colspan="2" class="text-center"><strong>Thông tin</strong></td>
                </tr>

                <tr>
                    <td><strong>Tên</strong></td>
                    <td><?php echo $row['firstname']; ?></td>
                </tr>

                <tr>
                    <td><strong>Họ</strong></td>
                    <td><?php echo $row['surname']; ?></td>
                </tr>

                <tr>
                    <td><strong>Giới tính</strong></td>
                    <td><?php echo $row['gender']; ?></td>
                </tr>

                <tr>
                    <td><strong>Số điện thoại</strong></td>
                    <td><?php echo $row['phone']; ?></td>
                </tr>

                <tr>
                    <td><strong>Ngày hẹn gặp</strong></td>
                    <td><?php echo $row['appointment_date']; ?></td>
                </tr>

                <tr>
                    <td><strong>Triệu chứng</strong></td>
                    <td><?php echo $row['symptoms']; ?></td>
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