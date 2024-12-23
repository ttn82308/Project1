<?php 
session_start();
include("../include/header.php");
include("../include/connection.php");

// Xử lý gửi báo cáo
if (isset($_POST['send'])) {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    $error = [];

    // Kiểm tra dữ liệu đầu vào
    if (empty($title)) {
        $error[] = "Title is required.";
    }
    if (empty($message)) {
        $error[] = "Message is required.";
    }

    if (empty($error)) {
        $user = isset($_SESSION['patient']) ? $_SESSION['patient'] : 'Unknown';

        // Sử dụng prepared statement để bảo mật
        $query = "INSERT INTO report (title, message, username, date_send) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "sss", $title, $message, $user);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Bạn đã gửi khiếu nại thành công.');</script>";
        } else {
            echo "<script>alert('Gửi khiếu nại thất bại. Vui lòng thử lại');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: #f8f9fa;">
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2" style="margin-left:-30px">
            <?php include("sidenav.php"); ?>
        </div>
        <!-- Main Content -->
        <div class="col-md-10">
            <h5 class="my-3">Trang chủ</h5>
            <div class="row">
                <!-- Patient Profile -->
                <div class="col-md-3 my-2 bg-info text-white text-center py-4 mx-2">
                    <h5>Thông tin cá nhân</h5>
                    <a href="profile.php"><i class="fa fa-user-circle fa-3x"></i></a>
                </div>
                <!-- Book Appointment -->
                <div class="col-md-3 my-2 bg-warning text-white text-center py-4 mx-2">
                    <h5>Đặt lịch khám</h5>
                    <a href="appointment.php"><i class="fa fa-calendar fa-3x"></i></a>
                </div>
                <!-- Invoice -->
                <div class="col-md-3 my-2 bg-success text-white text-center py-4 mx-2">
                    <h5>My Invoice</h5>
                    <a href="invoice.php"><i class="fa fa-file-invoice-dollar fa-3x"></i></a>
                </div>
            </div>

            <!-- Send Report Form -->
            <div class="row justify-content-center my-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white text-center">
                            <h5>Khiếu nại</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach ($error as $err): ?>
                                            <li><?php echo $err; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form method="post">
                                <div class="form-group">
                                    <label>Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề">
                                </div>
                                <div class="form-group">
                                    <label>Nội dung</label>
                                    <textarea name="message" class="form-control" placeholder="Nhập nội dung"></textarea>
                                </div>
                                <button type="submit" name="send" class="btn btn-success btn-block">Gửi khiếu nại</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
