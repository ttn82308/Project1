<?php
session_start();
include("include/connection.php");

$error = array();

if (isset($_POST['login'])) {
    $uname = mysqli_real_escape_string($connect, $_POST['uname']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);

    if (empty($uname)) {
        $error['login'] = "Enter username.";
    } else if (empty($password)) {
        $error['login'] = "Enter password.";
    } else {

        $query = "SELECT * FROM patient WHERE username = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['patient'] = $uname; 
                echo "<script>alert('Login successful!');</script>";
                header("Location: patient/index.php");
                exit();
            } else {
                echo "<script>alert('Invalid Username or Password');</script>";
            }
        } else {
            echo "<script>alert('Invalid Username or Password');</script>";
        }

        $stmt->close();
    }
}
$show = isset($error['login']) ? "<h5 class='text-center alert alert-danger'>{$error['login']}</h5>" : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-image: url(img/back.jpg); background-repeat: no-repeat; background-size: cover;">
    <?php include("include/header.php"); ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 my-5 jumbotron">
                    <h5 class="text-center my-3">Đăng nhập</h5>

                    <form method="post">
                        <div class="form-group">
                            <label>Tài khoản</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Nhập tài khoản">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Nhập mật khẩu">
                        </div>
                        <input type="submit" name="login" class="btn btn-info my-3" value="Đăng nhập">
                        <p>Chưa có tài khoản ? <a href="register.php"> Đăng kí.</a></p>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</body>
</html>
