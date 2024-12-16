<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>
<body>
	<?php 
	include("../include/header.php");
 ?>
 	<div class="container-fluid">
 		<div class="col-md-12">
			<div class="row">
				 <div class="col-md-2" style="margin-left: -30px;">
				<?php 
			include("sidenav.php");
			include ("../include/connection.php");
			 ?>			
		</div>
		<div class="col-md-10">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-center">All Admin</h5>

                <?php

                $ad = $_SESSION['admin'];


                $query = "SELECT * FROM admin WHERE username != ?";
                $stmt = $connect->prepare($query);


                if ($stmt) {
                    $stmt->bind_param("s", $ad); 
                    $stmt->execute(); 
                    $res = $stmt->get_result(); 


                    $output = "
                    <table class='table table-bordered'>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th style='width: 10%;'>Action</th>
                        </tr>
                    ";

 
                    if ($res->num_rows < 1) {
                        $output .= "<tr><td colspan='3' class='text-center text-warning'>No New Admin</td></tr>";
                    } else {
 
                        while ($row = $res->fetch_assoc()) {
                            $id = $row['id'];
                            $username = htmlspecialchars($row['username']); 

                            $output .= "
                            <tr>
                                <td>$id</td>
                                <td>$username</td>    
                                <td>
                                    <button id='$id' class='btn btn-danger remove'>Remove</button>
                                </td>
                            ";
                        }
                    }

                    $output .= "
                        </tr>
                    </table>"; 
                    echo $output; 
                } else {
                    echo "<p class='text-danger'>Failed to execute query.</p>";
                }
                ?>
						
					</div>

					<div class="col-md-6">
              <?php 
                if (isset($_POST['add'])) {
                    $uname = trim($_POST['uname']);
                    $pass = $_POST['pass'];
                    $image = $_FILES['img']['name'];
                    $image_tmp = $_FILES['img']['tmp_name'];

                    $error = [];

                    // Kiểm tra đầu vào
                    if (empty($uname)) {
                        $error[] = "Enter Admin Username"; 
                    } 
                    if (empty($pass)) {
                        $error[] = "Enter Admin Password";
                    }
                    if (empty($image)) {
                        $error[] = "Add Admin Picture";
                    } else {

                        $folder = 'img/';
                        
                        if (!is_dir($folder)) {
                            if (mkdir($folder, 755, true)) {
                                echo "Thư mục '$folder' create success.<br>";
                                chmod($folder, 755); /
                    echo "The directory permissions have been successfully set.<br>";
                            } else {
                                echo "Unable to create the directory. '$folder'.<br>";
                                $error[] = "Unable to create the directory to save the image.";
                            }
                        } else {
                            echo "Folder '$folder' already exists.<br>";
                        }


                        if (is_dir($folder) && !is_writable($folder)) {
                            $error[] = "The directory is not writable. Please check the directory permissions.";
                        }

                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                        if (!in_array($ext, $allowed_ext)) {
                            $error[] = "Only JPG, JPEG, PNG, GIF files are allowed.";
                        } elseif ($_FILES['img']['size'] > 2 * 1024 * 1024) { 
                            $error[] = "Image size must not exceed 2MB.";
                        }
                    }


                    if (empty($error)) {
                        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                        $image_new_name = uniqid() . '.' . $ext; 
                        $upload_path = "img/$image_new_name"; 

                        if(move_uploaded_file($image_tmp,$upload_path)){
                            $stmt = $connect->prepare("INSERT INTO admin(username, password, profile) VALUES (?,?,?)");
                            $stmt->bind_param("sss", $uname, $hashed_pass, $image_new_name);

                            if ($stmt->execute()) {            
                                echo "<p class='text-success'>Admin added successfully!</p>";
                            } else {
                                echo "<p class='text-danger'> SQL Error: " . $stmt->error . "</p>";
                            }

                            $stmt->close(); 
                        } else {
                            echo "<p class='text-danger'>Failed to upload image.</p>";
                        }
                    } else {
                        foreach ($error as $key => $value) {
                            echo "<p style='color:red;'>$value</p>";
                        }
                    }
                }
            ?>

									
						<h5 class="text-center">Add Admin</h5>
						<form method="post " enctype="multipart/form-data">
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="uname" class="form-control" autocomplete="off">
							</div>

							<div class="form-group">
								<label>Password</label>
								<input type="password" name="pass" class="form-control">	 
							</div>

							<div class="form-group">
								<label>Add Admin Picture</label>
								<input type="file"  name="img" class="form-control">
							</div><br>
							<input type="submit" name="add" value="Add New Admin" class="btn btn-success">
						</form>
					</div>
				</div>
			</div> 
		</div>
	</div> 		
 	</div>
 	</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const removeButtons = document.querySelectorAll(".remove");

        removeButtons.forEach(button => {
            button.addEventListener("click", function() {
                const adminId = this.id;

                if (confirm("Are you sure you want to remove this admin?")) {
                    fetch("remove_admin.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "id=" + adminId
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); 
                        location.reload(); 
                    })
                    .catch(err => console.error(err));
                }
            });
        });
    });
</script>

</body>
</html>