<?php 
	session_start();
	if (!isset($_SESSION['admin'])) { // Check if the admin is logged in
		header("Location: ../login.php");
		exit();
	}
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
	 				<h5 class="text-center my-3">Job Requests</h5>
	 				<div id="message"></div> <!-- For user feedback -->
	 				<div id="show"></div> <!-- Dynamic content display -->
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
						$("#message").html('<div class="alert alert-danger">Failed to load job requests. Please try again.</div>');
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
						$("#message").html('<div class="alert alert-success">Request approved successfully!</div>');
						show();
					},
					error: function() {
						$("#message").html('<div class="alert alert-danger">Failed to approve request.</div>');
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
						$("#message").html('<div class="alert alert-success">Request rejected successfully!</div>');
						show();
					},
					error: function() {
						$("#message").html('<div class="alert alert-danger">Failed to reject request.</div>');
					}
				});
			});
		});
	</script>
</body>
</html>
