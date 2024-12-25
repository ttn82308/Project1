<?php 
session_start(); 
include ("../include/header.php");
include ("../include/connection.php");
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['doctor'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: ../doctorlogin.php");
    exit();
}
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Kiểm tra thông báo từ session
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
    unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}

// Truy vấn để lấy phí khám bệnh từ bảng settings
$query_exam_fee = "SELECT `value` FROM settings WHERE `key` = 'consultation_fee'";
$result_exam_fee = mysqli_query($connect, $query_exam_fee);
$exam_fee = 0;
if ($result_exam_fee && mysqli_num_rows($result_exam_fee) > 0) {
    $row_exam_fee = mysqli_fetch_assoc($result_exam_fee);
    $exam_fee = (float)$row_exam_fee['value']; // Lấy phí khám từ bảng settings
}

// Truy vấn để lấy danh sách phiếu khám
$query = "SELECT m.id, p.firstname, p.surname, m.exam_date, m.symptoms, d.loai_benh 
          FROM medical_form m 
          JOIN patient p ON m.patient_id = p.id 
          LEFT JOIN benh d ON m.disease_id = d.id";
$result = mysqli_query($connect, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Danh Sách Phiếu Khám</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dashboard-card {
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
        }
        .dashboard-icon:hover {
            transform: scale(1.1);
            transition: 0.3s ease;
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
            <h4 class="my-2">Danh Sách Phiếu Khám</h4>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Phiếu Khám</th>
                                <th>Bệnh Nhân</th>
                                <th>Ngày Khám</th>
                                <th>Triệu Chứng</th>
                                <th>Dự Đoán Loại Bệnh</th>
                                <th>Chi Tiết</th>
                                <th>Thành Tiền</th> <!-- Thêm cột thành tiền -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $full_name = $row['surname'] . " " . $row['firstname'];
                                    
                                    // Truy vấn để tính tổng tiền cho mỗi phiếu khám
                                    $medical_form_id = $row['id'];
                                    $query_total_price = "
                                        SELECT SUM(t.gia * p.quantity) AS total_medicine_price
                                        FROM prescriptions p
                                        JOIN thuoc t ON p.medicine_id = t.id
                                        WHERE p.medical_form_id = '$medical_form_id'
                                    ";
                                    $result_total_price = mysqli_query($connect, $query_total_price);
                                    $total_medicine_price = 0;
                                    if ($result_total_price && mysqli_num_rows($result_total_price) > 0) {
                                        $total_price_row = mysqli_fetch_assoc($result_total_price);
                                        $total_medicine_price = $total_price_row['total_medicine_price'];
                                    }
                                    
                                    // Tổng tiền (Tiền thuốc + Tiền khám lấy từ cơ sở dữ liệu)
                                    $total_price = $total_medicine_price + $exam_fee;

                                    // Cập nhật tổng tiền vào cơ sở dữ liệu (nếu chưa cập nhật)
                                    $update_query = "UPDATE medical_form SET total_price = '$total_price' WHERE id = '$medical_form_id'";
                                    mysqli_query($connect, $update_query);

                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$full_name}</td>
                                            <td>{$row['exam_date']}</td>
                                            <td>{$row['symptoms']}</td>
                                            <td>{$row['loai_benh']}</td>
                                            <td><a href='view_medical_form.php?id={$row['id']}' class='btn btn-info'>Xem Chi Tiết</a></td>
                                            <td>" . number_format($total_price, 0, ',', '.') . " VND</td> <!-- Hiển thị tổng tiền -->
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>Không có phiếu khám nào</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
