<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login Page</title>
</head>
<body>
	<?php
	include("include/header.php");?>
	<div style="margin-top:60px"></div>
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3"></div>
					<div class="col-md-6 jumbotron">
					<form method="post">
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="username" class="form-control"
							autocomplete="off" placeholder="Enter Username">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="pass" class="form-control">
						</div>
						<input type="submit" name="login" class="btn btn-success">
					</div>
				</div>
			</div>

</body>
</html>