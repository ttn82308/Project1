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
                // Lấy thông tin admin hiện tại từ session
                $ad = $_SESSION['admin'];

                // Chuẩn bị truy vấn
                $query = "SELECT * FROM admin WHERE username != ?";
                $stmt = $connect->prepare($query);

                // Kiểm tra nếu chuẩn bị truy vấn thành công
                if ($stmt) {
                    $stmt->bind_param("s", $ad); // Ràng buộc tham số
                    $stmt->execute(); // Thực thi truy vấn
                    $res = $stmt->get_result(); // Lấy kết quả

                    // Khởi tạo bảng HTML
                    $output = "
                    <table class='table table-bordered'>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th style='width: 10%;'>Action</th>
                        </tr>
                    ";

                    // Kiểm tra nếu không có kết quả
                    if ($res->num_rows < 1) {
                        $output .= "<tr><td colspan='3' class='text-center text-warning'>No New Admin</td></tr>";
                    } else {
                        // Duyệt qua từng dòng kết quả
                        while ($row = $res->fetch_assoc()) {
                            $id = $row['id'];
                            $username = htmlspecialchars($row['username']); // Ngăn chặn XSS

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
                    </table>"; // Kết thúc bảng HTML
                    echo $output; // Hiển thị bảng
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
                // Kiểm tra định dạng và kích thước hình ảnh
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed_ext)) {
                    $error[] = "Only JPG, JPEG, PNG, GIF files are allowed.";
                } elseif ($_FILES['img']['size'] > 2 * 1024 * 1024) { // Giới hạn 2MB
                    $error[] = "Image size must not exceed 2MB.";
                }
            }

            // Nếu không có lỗi
            if (empty ($error)) {
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $image_new_name = uniqid() . '.' . $ext; // Tạo tên file ảnh mới
                $upload_path = "img/$image_new_name"; // Đường dẫn lưu file ảnh

                if(move_uploaded_file($image_tmp,$upload_path)){
                $stmt = $connect->prepare("INSERT INTO admin(username, password, profile) VALUES (?,?,?)");
                $stmt->bind_param("sss", $uname, $hashed_pass, $image_new_name);

                if ($stmt->execute()) {            
                    if (move_uploaded_file($image_tmp, $upload_path)) {
                        echo "<p class='text-success'>Admin added successfully!</p>";
                    } else {
                        echo "<p class='text-danger'>Failed to upload image.</p>";
                    }
                } 
                if ($stmt -> execute()) {
                    echo "<p class='text-danger'> SQL Error: " . $stmt->error . "</p>";
                }

                $stmt->close(); 
            }else{
                echo "<p class='text-danger'>Failed to upload image.</p>";
                }
            }else {
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
                        alert(data); // Hiển thị kết quả
                        location.reload(); // Tải lại trang
                    })
                    .catch(err => console.error(err));
                }
            });
        });
    });
</script>

</body>
</html>