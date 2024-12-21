<?php
session_start();
include("../include/connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $doctor = $_SESSION['doctor']; // Lấy tên bác sĩ từ session

    if ($doctor) {
        // Cập nhật trạng thái và bác sĩ phụ trách
        $query = "UPDATE appointment SET doctor_id='$doctor', status='Approved' WHERE id='$id'";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>alert('Đã xác nhận thành công!'); window.location.href='appointment.php';</script>";
        } else {
            echo "<script>alert('Xác nhận thất bại, vui lòng thử lại.'); window.location.href='appointment.php';</script>";
        }
    } 
}
?>

