<!DOCTYPE html>
<html>
<head>
    <title>Doctor Profile Page</title>
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
                    include("../include/connection.php");
                ?>
            </div>

            <div class="col-md-10">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <?php 
                                    $doc = $_SESSION['doctor'];
                                    $query = "SELECT * FROM doctor WHERE username ='$doc'";
                                    $res = mysqli_query($connect, $query);
                                    $row = mysqli_fetch_array($res);

                                    if (isset($_POST['upload'])) {
                                        $img = $_FILES['img']['name'];
                                        $tmp_name = $_FILES['img']['tmp_name'];
                                        $file_type = $_FILES['img']['type'];

                                        if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/jpg'])) {
                                            echo "Chỉ tải file có định dạng JPG, PNG, và JPEG.";
                                        } else {
                                            $upload_path = "img/$img";
                                            if (move_uploaded_file($tmp_name, $upload_path)) {
                                                $query = "UPDATE doctor SET profile = '$img' WHERE username = '$doc'";
                                                $res = mysqli_query($connect, $query);
                                                if ($res) {
                                                    echo "Cập nhật hồ sơ thành công!";
                                                } else {
                                                    echo "Lỗi tải ảnh cá nhân.";
                                                }
                                            } else {
                                                echo "Lỗi tải file.";
                                            }
                                        }
                                    }
                                ?>

                                <form method="post" enctype="multipart/form-data">
                                    <?php echo "<img src='img/".$row['profile']."' style='height: 250px;' class='my-3'>"; ?>
                                    <input type="file" name="img" class="form-control my-1">
                                    <input type="submit" name="upload" class="btn btn-success" value="Cập nhật ảnh">
                                    <div class="my-3">
                                        <table class="table table-bordered">                                     
                                            <tr>
                                                <th colspan="2" class="text-center">Thông tin</th>
                                            </tr>
                                            <tr>
                                                <td>Tên</td>
                                                <td><?php echo $row['firstname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Họ</td>
                                                <td><?php echo $row['surname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tài khoản</td>
                                                <td><?php echo $row['username']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td><?php echo $row['email']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Số điện thoại</td>
                                                <td><?php echo $row['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Giới tính</td>
                                                <td><?php echo $row['gender']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Quốc tịch</td>
                                                <td><?php echo $row['country']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Lương</td>
                                                <td><?php echo "$" . $row['salary']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-center my-2">Đổi tên tài khoản</h5>
                                <?php 
                                    if (isset($_POST['change_uname'])) {
                                        $uname = $_POST['uname'];
                                        if (!empty($uname)) {
                                            $query = "UPDATE doctor SET username='$uname' WHERE username ='$doc'";
                                            $res = mysqli_query($connect, $query);
                                            if ($res) {
                                                $_SESSION['doctor'] = $uname;
                                            }
                                        }
                                    }
                                ?>
                                <form method="post">
                                    <label>Đổi tên tài khoản</label>
                                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Nhập tên tài khoản mới"><br>
                                    <input type="submit" name="change_uname" class="btn btn-success" value="Xác nhận">
                                </form>
                                <br><br>

                                <h5 class="text-center my-2">Đổi mật khẩu</h5>

                                <?php 
                                    if (isset($_POST['change_pass'])) {
                                        $old = $_POST['old_pass'];
                                        $new = $_POST['new_pass'];
                                        $con = $_POST['con_pass'];

                                        $query = "SELECT * FROM doctor WHERE username = '$doc'";
                                        $result = mysqli_query($connect, $query);
                                        $row = mysqli_fetch_array($result);

                                        if (!password_verify($old, $row['password'])) {
                                            echo "Mật khẩu cũ không đúng.";
                                        } elseif (empty($new)) {
                                            echo "Mật khẩu mới không được trống.";
                                        } elseif ($new != $con) {
                                            echo "Mật khẩu xác nhận không khớp.";
                                        } else {
                                            $new_hashed = password_hash($new, PASSWORD_DEFAULT);
                                            $update_query = "UPDATE doctor SET password = '$new_hashed' WHERE username = '$doc'";
                                            mysqli_query($connect, $update_query);
                                            echo "Đổi mật khẩu thành công!";
                                        }
                                    }
                                ?>

                                <form method="post">
                                    <div class="form-group">
                                        <label>Mật khẩu cũ</label>
                                        <input type="password" name="old_pass" class="form-control" autocomplete="off" placeholder="Nhập mật khẩu cũ">
                                    </div>

                                    <div class="form-group">
                                        <label>Mật khẩu mới</label>
                                        <input type="password" name="new_pass" class="form-control" autocomplete="off" placeholder="Nhập mật khẩu mới">
                                    </div>

                                    <div class="form-group">
                                        <label>Xác nhận mật khẩu mới</label>
                                        <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Xác nhận mật khẩu mới">
                                    </div>
                                    <input type="submit" name="change_pass" class="btn btn-info" value="Đổi mật khẩu">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
