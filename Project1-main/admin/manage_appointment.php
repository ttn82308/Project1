<?php
session_start();
include("../include/header.php");
include("../include/connection.php");

// Kiểm tra nếu admin chưa đăng nhập
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('process_limit.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
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
                    <h5 class="text-center my-3">Quản lý lịch hẹn</h5>

                    <!-- Hàng chứa Select Month và Set Limit for Entire Month -->
                    <div class="row align-items-center mb-3">
                        <!-- Form lọc theo tháng -->
                        <div class="col-md-6">
                            <form method="get" class="form-inline">
                                <label for="month" class="mr-2">Chọn tháng:</label>
                                <input 
                                    type="month" 
                                    name="month" 
                                    id="month" 
                                    class="form-control mr-2" 
                                    min="<?php echo date('Y-m', strtotime('-2 months')); ?>" 
                                    max="<?php echo date('Y-m', strtotime('+12 months')); ?>" 
                                    required>
                                <button type="submit" class="btn btn-success">Xác nhận</button>
                            </form>
                        </div>

                        <!-- Form đặt giới hạn cho cả tháng -->
                        <div class="col-md-6">
                            <form method="post" class="form-inline">
                                <label for="month-limit" class="mr-2">Đặt giới hạn lịch hẹn cho tháng:</label>
                                <input 
                                    type="number" 
                                    name="limit" 
                                    id="month-limit" 
                                    class="form-control mr-2" 
                                    placeholder="Nhập giới hạn" 
                                    min="1" 
                                    required>
                                <button type="submit" name="update_month_limit" class="btn btn-success">Xác nhận</button>
                            </form>
                        </div>
                    </div>

                    <?php
                    // Lấy tháng được chọn từ form hoặc mặc định là tháng hiện tại
                    $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

                    // Lấy ngày đầu và cuối của tháng
                    $start_date = $selected_month . "-01";
                    $end_date = date("Y-m-t", strtotime($start_date)); // Tính ngày cuối cùng trong tháng

                    // Xử lý cập nhật giới hạn cho cả tháng
                    if (isset($_POST['update_month_limit'])) {
                        $limit = $_POST['limit'];

                        // Kiểm tra giá trị giới hạn
                        if ($limit <= 0) {
                            echo "<script>alert('Limit must be a positive number.'); window.location.href = 'manage_appointment.php?month=$selected_month';</script>";
                            exit();
                        }

                        // Lặp qua từng ngày trong tháng và cập nhật giới hạn
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

                        echo "<script>alert('Đã cập nhật giới hạn cho tháng!'); window.location.href = 'manage_appointment.php?month=$selected_month';</script>";
                    }

                    // Hiển thị bảng lịch hẹn từ ngày đầu đến ngày cuối
                    $query = "
                        SELECT DATE_FORMAT(dates.date, '%Y-%m-%d') AS appointment_date,
                               COUNT(a.id) AS total_appointments,
                               l.limit_count
                        FROM (
                            SELECT DATE('$start_date') + INTERVAL (n.n) DAY AS date
                            FROM (
                                SELECT 0 n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                                UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
                                UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
                                UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
                                UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19
                                UNION ALL SELECT 20 UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23
                                UNION ALL SELECT 24 UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27
                                UNION ALL SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30 UNION ALL SELECT 31
                            ) n
                            WHERE DATE('$start_date') + INTERVAL (n.n) DAY <= DATE('$end_date')
                        ) dates
                        LEFT JOIN appointment a ON DATE(dates.date) = a.appointment_date
                        LEFT JOIN appointment_limits l ON DATE(dates.date) = l.appointment_date
                        GROUP BY dates.date
                        ORDER BY dates.date
                    ";
                    $res = mysqli_query($connect, $query);

                    echo "<table class='table table-bordered'>
                        <tr>
                            <th>Ngày hẹn khám</th>
                            <th>Tổng lịch hẹn</th>
                            <th>Giới hạn lịch</th>
                            <th></th>
                            <th>Chi tiết</th>
                        </tr>";

                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $limit = isset($row['limit_count']) ? $row['limit_count'] : "No Limit Set";

                            echo "<tr>
                                <td>" . $row['appointment_date'] . "</td>
                                <td>" . $row['total_appointments'] . "</td>
                                <td>" . $limit . "</td>
                                <td>
                                    <form method='post' class='form-inline'>
                                        <input type='hidden' name='date' value='" . $row['appointment_date'] . "'>
                                        <!-- Chỉ cho phép nhập số dương -->
                                        <input type='number' name='limit' class='form-control' placeholder='Set Limit' min='1' required>
                                        <button type='submit' name='update_limit' class='btn btn-warning ml-2'>Cập nhật</button>
                                    </form>
                                </td>
                                <td>
                                    <a href='appointment_details.php?date=" . $row['appointment_date'] . "'>
                                        <button class='btn btn-info'>Chi tiết</button>
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr>
                            <td colspan='5' class='text-center'>Không có lịch hẹn nào</td>
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
