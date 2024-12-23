<?php 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Job Request</title>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>
	<?php include("../include/header.php"); ?>

	<div class="container-fluid">	
	 	<div class="col-md-12">
	 		<div class="row">
	 			<div class="col-md-2" style="margin-left: -30px;">
	 				<?php include("sidenav.php"); ?>
	 			</div>
	 			<div class="col-md-10">
	 				<h5 class="text-center my-3">Danh sách đăng kí</h5>
	 				<div id="message"></div>
	 				<div id="show"></div> 
	 				<?php 
	 				include("ajax_job_request.php");
	 				 ?>
	 			</div>
	 		</div>
	 	</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			// Load job requests
			show();

			function show(){
				$.ajax({
					url: "ajax_job_request.php",
					method: "POST",
					success: function(data){
						$("#show").html(data);
					},
					error: function() {
						console.log(data);
						$("#message").html('<div class="alert alert-danger">Có lỗi xảy ra. Vui lòng thử lại</div>');
					}
				});
			}

			// Approve request
			$(document).on('click', '.approve', function(){
				var id = $(this).data("id");

				$.ajax({
					url: "ajax_approve.php",
					method: "POST",
					data: { id: id, csrf_token: '<?php echo $_SESSION["csrf_token"]; ?>' },
					success: function(response){
						$("#message").html('<div class="alert alert-success">Xác nhận đơn thành công!</div>');
						show();
					},
					error: function() {
						$("#message").html('<div class="alert alert-danger">Có lỗi xảy ra.</div>');
					}
				});
			});

			// Reject request
			$(document).on('click', '.reject', function(){
				var id = $(this).data("id");

				$.ajax({
					url: "ajax_reject.php",
					method: "POST",
					data: { id: id, csrf_token: '<?php echo $_SESSION["csrf_token"]; ?>' },
					success: function(response){
						$("#message").html('<div class="alert alert-success">Từ chối đơn thành công!</div>');
						show();
					},
					error: function() {
						$("#message").html('<div class="alert alert-danger">Có lỗi xảy ra.</div>');
					}
				});
			});
		});
	</script>
</body>
</html>
