<?php
session_start(); 
include ("../include/header.php");
include ("../include/connection.php");
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['patient'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: ../patientlogin.php");
    exit();
}

$username = $_SESSION['patient']; // Lấy username từ session

// Truy vấn lịch hẹn của người dùng
$query = "SELECT * FROM appointment WHERE phone = (SELECT phone FROM patient WHERE username = ?)";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kiểm tra lịch hẹn</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: #f8f9fa;">

<div class="container-fluid">
    <div class="row">
        <!-- Thanh điều hướng bên -->
        <div class="col-md-2" style="margin-left:-30px;">
            <?php include("sidenav.php"); ?>
        </div>

        <!-- Nội dung chính -->
        <div class="col-md-9">
            <h3 class="my-4 text-center">Danh sách lịch hẹn của bạn</h3>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Họ và tên</th>
                        <th>Ngày hẹn</th>
                        <th>Triệu chứng</th>
                        <th>Trạng thái</th>
                        <th>Bác sĩ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['surname']); ?></td>
                                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['symptoms']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo htmlspecialchars($row['doctor_id']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Không có lịch hẹn nào được tìm thấy.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($connect);
?>