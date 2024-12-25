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
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Lấy tháng từ yêu cầu hoặc mặc định là tháng hiện tại
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// Kiểm tra nếu người dùng gửi form thay đổi số tiền khám bệnh
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['exam_fee'])) {
    $exam_fee = $_POST['exam_fee'];

    // Cập nhật số tiền khám bệnh vào bảng settings
    $update_fee_query = "UPDATE settings SET `value` = '$exam_fee' WHERE `key` = 'consultation_fee'";
    $update_fee_result = mysqli_query($connect, $update_fee_query);

    if ($update_fee_result) {
        // Lưu vào session thông báo thành công
        $_SESSION['message'] = "Số tiền khám bệnh đã được cập nhật thành công!";
    } else {
        // Lưu vào session thông báo lỗi
        $_SESSION['error'] = "Lỗi khi cập nhật số tiền khám bệnh!";
    }
} else {
    // Lấy số tiền khám bệnh từ cơ sở dữ liệu nếu không có thay đổi
    $query_exam_fee = "SELECT `value` FROM settings WHERE `key` = 'consultation_fee'";
    $result_exam_fee = mysqli_query($connect, $query_exam_fee);
    $exam_fee = 30000; // Mặc định nếu không có giá trị trong bảng settings
    if ($result_exam_fee && mysqli_num_rows($result_exam_fee) > 0) {
        $row_exam_fee = mysqli_fetch_assoc($result_exam_fee);
        $exam_fee = (float)$row_exam_fee['value']; // Lấy phí khám từ bảng settings
    }
}

// Đếm tổng số đơn trong tháng
$order_query = "SELECT COUNT(*) AS order_count, SUM(total_price) AS total_income FROM medical_form WHERE DATE_FORMAT(exam_date, '%Y-%m') = '$month'";
$order_result = mysqli_query($connect, $order_query);
$order_data = mysqli_fetch_assoc($order_result);

// Tiền khám bệnh = Số lượng đơn * số tiền khám bệnh (có thể thay đổi)
$order_count = $order_data['order_count'] ?? 0;
$total_income = $order_data['total_income'] ?? 0;
$exam_income = $order_count * $exam_fee; // Sử dụng số tiền khám bệnh tùy chỉnh

// Tiền thuốc: Lấy giá thuốc từ bảng thuoc và số lượng từ bảng prescriptions
$medicine_cost_query = "
    SELECT
        SUM(t.gia * p.quantity) AS total_medicine_cost
    FROM
        prescriptions p
    JOIN
        thuoc t ON p.medicine_id = t.id
    JOIN
        medical_form mf ON p.medical_form_id = mf.id
    WHERE
        DATE_FORMAT(mf.exam_date, '%Y-%m') = '$month'"; // Sử dụng tháng đã chọn
$medicine_cost_result = mysqli_query($connect, $medicine_cost_query);
$medicine_cost_data = mysqli_fetch_assoc($medicine_cost_result);
$total_medicine_cost = $medicine_cost_data['total_medicine_cost'] ?? 0;

// Tiền thuốc = Tổng thu nhập - Tiền khám bệnh
$medicine_income = $total_medicine_cost;

// Tính toán tổng thu nhập
$total_income = $exam_income + $medicine_income;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chi Tiết Thu Nhập Theo Tháng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <style>
        .row {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        body {
            background-color: #f8f9fa;
        }
        .dashboard-card {
            height: 230px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            border-radius: 10px;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.1);
        }
        .dashboard-icon:hover {
            transform: scale(1.1);
            transition: 0.3s ease;
        }
        .month-picker {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .month-picker input[type="month"] {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 5px 10px;
            font-size: 16px;
        }
        .month-picker button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2" style="margin-left:-30px;">
            <?php include("sidenav.php"); ?>
        </div>
        <!-- Main Content -->
        <div class="col-md-10">
            <h4 class="my-3">Chi Tiết Thu Nhập Theo Tháng</h4>
            
            <!-- Giao diện chọn tháng -->
            <div class="month-picker my-4">
                <form method="GET" class="d-flex align-items-center justify-content-center">
                    <label for="month-picker" class="mr-3 mb-0" style="font-size: 18px; font-weight: 500;">Chọn tháng:</label>
                    <input type="text" id="month-picker" name="month" class="form-control w-auto" placeholder="Chọn tháng" value="<?= htmlspecialchars($month) ?>" required>
                    <button type="submit" class="btn btn-primary btn-sm ml-2">Xem Thu Nhập</button>
                </form>
            </div>

            <!-- Form để thay đổi số tiền khám bệnh -->
            <form method="POST" class="mb-4">
                <label for="exam_fee" style="font-size: 18px; font-weight: 500;">Sửa số tiền khám bệnh (VND):</label>
                <input type="number" id="exam_fee" name="exam_fee" class="form-control w-auto" value="<?= number_format($exam_fee, 0, ',', '.') ?>" required>
                <button type="submit" class="btn btn-warning btn-sm mt-2">Cập Nhật</button>
            </form>

            <!-- Dashboard Cards -->
            <div class="row justify-content-center">
                <!-- Tổng tiền khám bệnh -->
                <div class="col-md-4 bg-success mx-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?= number_format($exam_income, 0, ',', '.') ?> VND</h5>
                    <h6>Tiền Khám Bệnh</h6>
                </div>
                <!-- Tổng tiền thuốc -->
                <div class="col-md-4 bg-info mx-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?= number_format($medicine_income, 0, ',', '.') ?> VND</h5>
                    <h6>Tiền Thuốc</h6>
                </div>
                <!-- Tổng thu nhập -->
                <div class="col-md-4 bg-warning mx-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?= number_format($total_income, 0, ',', '.') ?> VND</h5>
                    <h6>Tổng Thu Nhập</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#month-picker", {
            altInput: true,
            altFormat: "F Y", // Hiển thị tên tháng và năm (VD: December 2024)
            dateFormat: "Y-m", // Định dạng giá trị gửi lên server (VD: 2024-12)
            plugins: [
                new monthSelectPlugin({
                    shorthand: true, // Hiển thị tháng dưới dạng rút gọn (VD: Jan, Feb)
                    dateFormat: "Y-m", // Định dạng giá trị thực tế
                    altFormat: "F Y" // Định dạng hiển thị
                })
            ]
        });
    });
</script>
</body>
</html>
