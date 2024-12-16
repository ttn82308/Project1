<?php 	

	include("../include/connection.php");


	$query = "SELECT * FROM doctor WHERE status='Pendding' ORDER BY data_reg ASC";
	$res = mysqli_query($connect,$query);

	$output ="";

	$output .="
	<table class ='table table-bordered'>
		<tr>
			<th>ID</th>
			<th>Firtname</th>
			<th>Surname</th>
			<th>Username</th>
			<th>Gender</th>
			<th>Phone</th>
			<th>Country</th>
			<th>Data Register</th>
			<th>Action</th>
		</tr>
	";

	if (mysqli_num_row($res) < 1) {
		$output .="
			<tr>
			<td colspan ='8'>No Job request.</td>
			</tr>
		";
	}

	while($row = mysqli_fetch_array($res)){
		$output .="

		<tr>
		<td>".$row['id']."</td>
		<td>".$row['firtname']."</td>
		<td>".$row['surname']."</td>
		<td>".$row['username']."</td>
		<td>".$row['gender']."</td>
		<td>".$row['phone']."</td>
		<td>".$row['country']."</td>
		<td>".$row['data_reg']."</td>
		<td>
			<div class = 'col-md-12'>
			<div class = 'row'>
			<div class = 'col-md-6'>
				<button id ='".$row['id']."' class = 'btn btn-success approve'>Approve</button>
			</div>
			<div class = 'col-md-6'>
				<button id ='".$row['id']."' class = 'btn btn-dander reject'>Reject</button>
			</div>
			</div>
			</div>
		</td>
		";
	}

	$output .="
	</tr>
	</table>
	";
	echo $output;


 ?>