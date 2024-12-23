<?php
session_start();
include("include/connection.php");

$error = array();

if (isset($_POST['login'])) {
    $uname = mysqli_real_escape_string($connect, $_POST['uname']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    //$_SESSION['doctor'] = $doctor['uname']; // Lưu username của bác sĩ
    //$_SESSION['doctor_id'] = $doctor['id']; // Lưu ID của bác sĩ


    if (empty($uname)) {
        $error['login'] = "Nhập tài khoản.";
    } else if (empty($password)) {
        $error['login'] = "Nhập mật khẩu.";
    } else {
        $query = "SELECT * FROM doctor WHERE username = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($row['status'] == "Pendding") {
                $error['login'] = "Hãy đợi quản trị viên xác nhận đơn đăng kí.";
            } elseif ($row['status'] == "Rejected") {
                $error['login'] = "Đơn đăng kí đã bị từ chối.";
            } elseif (password_verify($password, $row['password'])) {
                $_SESSION['doctor'] = $uname;
                echo "<script>alert('Đăng nhập thành công!');</script>";
                header("Location: doctor/index.php");
                exit();
            } else {
                $error['login'] = "Tên tài khoản hoặc mật khẩu không đúng.";
            }
        } else {
            $error['login'] = "Tên tài khoản hoặc mật khẩu không đúng.";
        }
    }
}

$show = isset($error['login']) ? "<h5 class='text-center alert alert-danger'>{$error['login']}</h5>" : "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-image: url('img/back.jpg'); background-size: cover; background-repeat: no-repeat;">
    <?php include("include/header.php"); ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 jumbotron my-3">
                    <h5 class="text-center my-2">Đăng Nhập</h5>
                    <div>
                        <?php echo $show; ?>
                    </div>
                    <form method="post">
                        <div class="form-group">
                            <label>Tài khoản</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Nhập tài khoản">
                        </div>

                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Nhập mật khẩu">
                        </div>
                        <input type="submit" name="login" class="btn btn-success" value="Đăng nhập">
                        <p>Chưa có tài khoản ? <a href="apply.php"> Đăng kí</a></p>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
