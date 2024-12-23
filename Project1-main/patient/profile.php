<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Patient Profile Page</title>
</head>
<body>

<?php 
    include("../include/header.php");
    include("../include/connection.php");
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
                                    $patient = $_SESSION['patient'];
                                    $query = "SELECT * FROM patient WHERE username ='$patient'";
                                    $res = mysqli_query($connect, $query);
                                    $row = mysqli_fetch_array($res);

                                    if (isset($_POST['upload'])) {
                                        $img = $_FILES['img']['name'];
                                        $tmp_name = $_FILES['img']['tmp_name'];
                                        $file_type = $_FILES['img']['type'];

                                        if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/jpg'])) {
                                            echo "Only JPG, PNG, and JPEG files are allowed.";
                                        } else {
                                            $upload_path = "img/$img";
                                            if (move_uploaded_file($tmp_name, $upload_path)) {
                                                $query = "UPDATE patient SET profile = '$img' WHERE username = '$patient'";
                                                $res = mysqli_query($connect, $query);
                                                if ($res) {
                                                    echo "Cập nhật avatar thành công";
                                                } else {
                                                    echo "Cập nhật avatar thất bại";
                                                }
                                            } else {
                                                echo "Lỗi khi tải ảnh!!! ";
                                            }
                                        }
                                    }
                                ?>

                                <form method="post" enctype="multipart/form-data">
                                    <?php echo "<img src='img/".$row['profile']."' style='height: 250px;' class='my-3'>"; ?>
                                    <input type="file" name="img" class="form-control my-1">
                                    <input type="submit" name="upload" class="btn btn-success" value="Cập nhật ảnh đại diện">
                                    <div class="my-3">
                                        <table class="table table-bordered">                                     
                                            <tr>
                                                <th colspan="2" class="text-center">Thông tin cá nhân</th>
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
                                                <td>Tên tài khoản</td>
                                                <td><?php echo $row['username']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td><?php echo $row['email']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Số điện thoai</td>
                                                <td><?php echo $row['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Giới tính</td>
                                                <td><?php echo $row['gender']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Quốc gia</td>
                                                <td><?php echo $row['country']; ?></td>
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
                                            $query = "UPDATE patient SET username='$uname' WHERE username ='$patient'";
                                            $res = mysqli_query($connect, $query);
                                            if ($res) {
                                                $_SESSION['patient'] = $uname;
                                            }
                                        }
                                    }
                                ?>
                                <form method="post">
                                    <label>Đổi tên tài khoản</label>
                                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Nhập tên tài khoản"><br>
                                    <input type="submit" name="change_uname" class="btn btn-success" value="Đổi tên">
                                </form>
                                <br><br>

                                <h5 class="text-center my-2">Đổi mật khẩu</h5>

                                <?php 
                                    if (isset($_POST['change_pass'])) {
                                        $old = $_POST['old_pass'];
                                        $new = $_POST['new_pass'];
                                        $con = $_POST['con_pass'];

                                        $query = "SELECT * FROM patient WHERE username = '$patient'";
                                        $result = mysqli_query($connect, $query);
                                        $row = mysqli_fetch_array($result);

                                        if (!password_verify($old, $row['password'])) {
                                            echo "Mật khẩu cũ không đúng";
                                        } elseif (empty($new)) {
                                            echo "không để trống mật khẩu mới.";
                                        } elseif ($new != $con) {
                                            echo "Mật khẩu mới và mật khẩu xác nhận  không khớp.";
                                        } else {
                                            $new_hashed = password_hash($new, PASSWORD_DEFAULT);
                                            $update_query = "UPDATE patient SET password = '$new_hashed' WHERE username = '$patient'";
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
                                        <label>Mật khảo mới</label>
                                        <input type="password" name="new_pass" class="form-control" autocomplete="off" placeholder="Nhập mật khẩu mới">
                                    </div>

                                    <div class="form-group">
                                        <label>Xác nhận mật khẩu</label>
                                        <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Nhập lại mật khẩu mới">
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
