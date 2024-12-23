<?php
	session_start();
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<?php 
	include ("../include/header.php");
	include ("../include/connection.php");

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
					<h5 class="text-center my-3">Danh sách khiếu nại</h5>
					<?php 
					$query = "SELECT *FROM report";
					$res = mysqli_query($connect,$query);

					$output= "";
					$output .= "
					<table class='table table-responsive table-bordered'>
						<tr>
						<td>Tiêu đề</td>
						<td>Nội dung</td>
						<td>Tên tài khoản</td>
						<td>Ngày gửi</td>
						
						</tr>
						";
					if(mysqli_num_rows($res) < 1 ){
						$output .= "<tr><td colspan='3' class='text-center'>Không có khiếu nại</td></tr>";
								}
					while ($row = mysqli_fetch_array($res)) {
									

									$output .="
									<tr>
									<td>".$row['title']."</td>
									<td>".$row['message']."</td>
									<td>".$row['username']."</td>
									<td>".$row['date_send']."</td>
									
									
									<td>
										<a href='view.php?id=".$row['id']."'>
										<button class'btn btn-info'>Thông tin</button>
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