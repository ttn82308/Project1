<?php
session_start();
include("include/connection.php");

$error = array();

if (isset($_POST['login'])) {
    $uname = mysqli_real_escape_string($connect, $_POST['uname']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);

    if (empty($uname)) {
        $error['login'] = "Enter username.";
    } elseif (empty($password)) {
        $error['login'] = "Enter password.";
    } else {
        $query = "SELECT * FROM doctor WHERE username = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($row['status'] == "Pendding") {
                $error['login'] = "Please wait for the administrator to confirm.";
            } elseif ($row['status'] == "Rejected") {
                $error['login'] = "The account has been denied. Please try again later.";
            } elseif (password_verify($password, $row['password'])) {
                // Đăng nhập thành công
                $_SESSION['doctor'] = $uname;
                echo "<script>alert('Login successful!');</script>";
                header("Location: doctor/index.php");
                exit();
            } else {
                $error['login'] = "Incorrect username or password.";
            }
        } else {
            $error['login'] = "The username or password is incorrect.";
        }
    }
}

$show = isset($error['login']) ? "<h5 class='text-center alert alert-danger'>{$error['login']}</h5>" : "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-image: url('img/back.jpg'); background-size: cover; background-repeat: no-repeat;">
    <?php include("include/header.php"); ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 jumbotron my-3">
                    <h5 class="text-center my-2">Doctor Login</h5>
                    <div>
                        <?php echo $show; ?>
                    </div>
                    <form method="post">
                        <div class="form-group">
                            <label>User name</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Enter Password">
                        </div>
                        <input type="submit" name="login" class="btn btn-success" value="Login">
                        <p>Don't have an account yet? <a href="apply.php">Apply</a></p>
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
