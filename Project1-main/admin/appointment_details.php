<?php
session_start(); 
include ("../include/header.php");
include ("../include/connection.php");
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['admin'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: ../adminlogin.php");
    exit();
}
// Lấy ngày từ URL
$date = isset($_GET['date']) ? $_GET['date'] : null;

if (!$date) {
    echo "<script>alert('No date provided!'); window.location.href = 'manage_appointments.php';</script>";
    exit();
}

// Xử lý phân công bác sĩ hoặc cập nhật trạng thái
if (isset($_POST['update'])) {
    $appointment_id = $_POST['appointment_id'];
    $doctor_id = $_POST['doctor_id'];
    $status = $_POST['status'];

    // Cập nhật lịch hẹn
    $update_query = "UPDATE appointment SET doctor_id = '$doctor_id', status = '$status' WHERE id = '$appointment_id'";
    if (mysqli_query($connect, $update_query)) {
        echo "<script>alert('Appointment updated successfully!'); window.location.href = 'appointment_details.php?date=$date';</script>";
    } else {
        echo "<script>alert('Error updating appointment.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointment Details</title>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php include("sidenav.php"); ?>
                </div>
                <div class="col-md-10">
                    <h5 class="text-center my-3">Appointments on <?php echo $date; ?></h5>
                    <?php
                    // Lấy danh sách lịch hẹn trong ngày
                    $query = "SELECT * FROM appointment WHERE appointment_date = '$date'";
                    $res = mysqli_query($connect, $query);

                    echo "<table class='table table-bordered'>
                        <tr>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Giới tính</th>
                            <th>Số điện thoại</th>
                            <th>Triệu chứng gặp phải</th>
                            <th>Trạng thái</th>
                            <th>Bác sĩ phụ trách</th>
                        </tr>";

                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>" . $row['surname'] . "</td>
                                <td>" . $row['firstname'] . "</td>
                                <td>" . $row['gender'] . "</td>
                                <td>" . $row['phone'] . "</td>
                                <td>" . $row['symptoms'] . "</td>
                                <td>" . $row['status'] . "</td>
                                <td>" . (!empty($row['doctor_id']) ? $row['doctor_id'] : "Not Assigned") . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr>
                            <td colspan='9' class='text-center'>No Appointments Found</td>
                        </tr>";
                    }

                    echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
