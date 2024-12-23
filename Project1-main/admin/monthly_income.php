<?php 
session_start();
include("../include/header.php");
include("../include/connection.php");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Lấy tháng từ yêu cầu hoặc mặc định là tháng hiện tại
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// Đếm tổng số đơn trong tháng
$order_query = "SELECT COUNT(*) AS order_count, SUM(total_price) AS total_income FROM medical_form WHERE DATE_FORMAT(exam_date, '%Y-%m') = '$month'";
$order_result = mysqli_query($connect, $order_query);
$order_data = mysqli_fetch_assoc($order_result);

// Tính toán
$order_count = $order_data['order_count'] ?? 0;
$total_income = $order_data['total_income'] ?? 0;

// Tiền khám bệnh = Số lượng đơn * 30,000 VND
$exam_income = $order_count * 30000;

// Tiền thuốc = Tổng thu nhập - Tiền khám bệnh
$medicine_income = $total_income - $exam_income;
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
        justify-content: center; /* Horizontally center the columns */
        gap: 20px;               /* Add space between the columns */
               /* Adjust top margin if needed */
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
            <!-- Form chọn tháng -->
            <div class="month-picker my-4">
                <form method="GET" class="d-flex align-items-center justify-content-center">
                    <label for="month-picker" class="mr-3 mb-0" style="font-size: 18px; font-weight: 500;">Chọn tháng:</label>
                    <input type="text" id="month-picker" name="month" class="form-control w-auto" placeholder="Chọn tháng" value="<?= htmlspecialchars($month) ?>" required>
                    <button type="submit" class="btn btn-primary btn-sm ml-2">Xem Thu Nhập</button>
                </form>
            </div>

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
