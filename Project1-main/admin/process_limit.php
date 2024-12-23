<?php
include("../include/connection.php");

// Xử lý cập nhật giới hạn lịch hẹn cho từng ngày
if (isset($_POST['update_limit'])) {
    $date = $_POST['date'];
    $limit = $_POST['limit'];

    // Kiểm tra giá trị hợp lệ
    if ($limit <= 0) {
        echo "<script>alert('Limit must be a positive number.'); window.history.back();</script>";
        exit();
    }

    // Kiểm tra xem ngày đã có giới hạn hay chưa
    $check_query = "SELECT * FROM appointment_limits WHERE appointment_date = '$date'";
    $check_res = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_res) > 0) {
        // Cập nhật giới hạn nếu đã tồn tại
        $update_query = "UPDATE appointment_limits SET limit_count = '$limit' WHERE appointment_date = '$date'";
        mysqli_query($connect, $update_query);
    } else {
        // Thêm giới hạn mới nếu chưa có
        $insert_query = "INSERT INTO appointment_limits (appointment_date, limit_count) VALUES ('$date', '$limit')";
        mysqli_query($connect, $insert_query);
    }

    echo "<script>alert('Updated limit successfully!'); window.history.back();</script>";
}

// Xử lý cập nhật giới hạn cho toàn bộ tháng
if (isset($_POST['update_month_limit'])) {
    $selected_month = $_POST['month'] ?? date('Y-m');
    $start_date = $selected_month . "-01";
    $end_date = date("Y-m-t", strtotime($start_date));
    $limit = $_POST['limit'];

    // Kiểm tra giá trị hợp lệ
    if ($limit <= 0) {
        echo "<script>alert('Limit must be a positive number.'); window.history.back();</script>";
        exit();
    }

    // Lặp qua từng ngày trong tháng để cập nhật giới hạn
    $current_date = $start_date;
    while ($current_date <= $end_date) {
        $check_query = "SELECT * FROM appointment_limits WHERE appointment_date = '$current_date'";
        $check_res = mysqli_query($connect, $check_query);

        if (mysqli_num_rows($check_res) > 0) {
            // Cập nhật giới hạn nếu đã tồn tại
            $update_query = "UPDATE appointment_limits SET limit_count = '$limit' WHERE appointment_date = '$current_date'";
            mysqli_query($connect, $update_query);
        } else {
            // Thêm giới hạn mới nếu chưa có
            $insert_query = "INSERT INTO appointment_limits (appointment_date, limit_count) VALUES ('$current_date', '$limit')";
            mysqli_query($connect, $insert_query);
        }
        $current_date = date("Y-m-d", strtotime($current_date . "+1 day"));
    }

    echo "<script>alert('Updated limits for the month successfully!'); window.location.href = 'manage_appointment.php?month=$selected_month';</script>";
}