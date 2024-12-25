<?php 
ob_start(); 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Danh sách Admin</title>
</head>
<body>
    <?php 
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
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php include("sidenav.php"); ?>         
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
                                            <th>Tên tài khoản</th>
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
                                                <td>$username</td>    
                                                <td>
                                                    <button id='$id' class='btn btn-danger remove'>Xoá</button>
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
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
                                    $uname = trim($_POST['uname']);
                                    $pass = $_POST['pass'];
                                    $image = $_FILES['img']['name'];
                                    $image_tmp = $_FILES['img']['tmp_name'];

                                    $error = [];

                                    if (empty($uname)) $error[] = "Nhập tên tài khoản"; 
                                    if (empty($pass)) $error[] = "Nhập mật khẩu";
                                    if (empty($image)) $error[] = "Add Admin Picture";

                                    $folder = 'img/';
                                    if (!is_dir($folder)) mkdir($folder, 0755, true);

                                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                                    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                                    if (!in_array($ext, $allowed_ext)) $error[] = "Only JPG, JPEG, PNG, GIF files are allowed.";
                                    if ($_FILES['img']['size'] > 2 * 1024 * 1024) $error[] = "Image size must not exceed 2MB.";

                                    if (empty($error)) {
                                        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                                        $image_new_name = uniqid() . '.' . $ext; 
                                        $upload_path = "$folder$image_new_name"; 

                                        if (move_uploaded_file($image_tmp, $upload_path)) {
                                            $stmt = $connect->prepare("INSERT INTO admin(username, password, profile) VALUES (?,?,?)");
                                            $stmt->bind_param("sss", $uname, $hashed_pass, $image_new_name);

                                            if ($stmt->execute()) {
                                                // Redirect to avoid duplicate form submission
                                                header("Location: " . $_SERVER['PHP_SELF']);
                                                exit();
                                            } else {
                                                echo "<p class='text-danger'>SQL Error: " . $stmt->error . "</p>";
                                            }
                                            $stmt->close();
                                        } else {
                                            echo "<p class='text-danger'>Failed to upload image.</p>";
                                        }
                                    } else {
                                        foreach ($error as $value) echo "<p style='color:red;'>$value</p>";
                                    }
                                }
                                ?>

                                <h5 class="text-center">Add Admin</h5>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Tên tài khoản</label>
                                        <input type="text" name="uname" class="form-control" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label>Mật khẩu</label>
                                        <input type="password" name="pass" class="form-control">     
                                    </div>

                                    <div class="form-group">
                                        <label>Thêm ảnh</label>
                                        <input type="file" name="img" class="form-control">
                                    </div><br>
                                    <input type="submit" name="add" value="Xác nhận" class="btn btn-success">
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
<?php
ob_end_flush();
?>
