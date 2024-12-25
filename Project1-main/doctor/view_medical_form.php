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
if (isset($_GET['id'])) {
    $medical_form_id = $_GET['id'];

    // Truy vấn để lấy thông tin phiếu khám và thông tin bệnh nhân
    $query = "SELECT m.id, p.firstname, p.surname, m.exam_date, m.symptoms, b.loai_benh
              FROM medical_form m
              JOIN patient p ON m.patient_id = p.id
              LEFT JOIN benh b ON m.disease_id = b.id
              WHERE m.id = '$medical_form_id'";

    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $medical_form = mysqli_fetch_assoc($result);

        // Truy vấn để lấy thông tin thuốc và giá
        $query_prescriptions = "SELECT t.ten_thuoc, p.quantity, p.usage, p.unit, t.gia
                                FROM prescriptions p
                                JOIN thuoc t ON p.medicine_id = t.id
                                WHERE p.medical_form_id = '$medical_form_id'";
        $result_prescriptions = mysqli_query($connect, $query_prescriptions);
    } else {
        $_SESSION['error'] = "Không tìm thấy phiếu khám!";
        header("Location: medical_form_list.php");
        exit;
    }

    // Lấy phí khám từ bảng settings
    $query_exam_fee = "SELECT `value` FROM settings WHERE `key` = 'consultation_fee'";
    $result_exam_fee = mysqli_query($connect, $query_exam_fee);
    $exam_fee = 0;
    if ($result_exam_fee && mysqli_num_rows($result_exam_fee) > 0) {
        $row_exam_fee = mysqli_fetch_assoc($result_exam_fee);
        $exam_fee = (float)$row_exam_fee['value']; // Lấy phí khám từ bảng settings
    }

} else {
    $_SESSION['error'] = "Không có mã phiếu khám!";
    header("Location: medical_form_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Phiếu Khám</title>
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
            <h4 class="my-2">Chi Tiết Phiếu Khám</h4>
            
            <!-- Hiển thị thông báo -->
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
                unset($_SESSION['message']);
            }

            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
                unset($_SESSION['error']);
            }
            ?>

            <div class="card my-3">
                <div class="card-body">
                    <h5><strong>Bệnh Nhân:</strong> <?php echo $medical_form['surname'] . " " . $medical_form['firstname']; ?></h5>
                    <p><strong>Ngày Khám:</strong> <?php echo $medical_form['exam_date']; ?></p>
                    <p><strong>Triệu Chứng:</strong> <?php echo $medical_form['symptoms']; ?></p>
                    <p><strong>Dự Đoán Loại Bệnh:</strong> <?php echo isset($medical_form['loai_benh']) ? $medical_form['loai_benh'] : 'Không có thông tin'; ?></p>
                </div>
            </div>

            <h4>Danh Sách Thuốc</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên Thuốc</th>
                        <th>Số Lượng</th>
                        <th>Cách Dùng</th>
                        <th>Đơn Vị</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_medicine_price = 0; // Biến lưu tổng tiền thuốc
                    if (isset($result_prescriptions) && mysqli_num_rows($result_prescriptions) > 0) {
                        while ($row_prescription = mysqli_fetch_assoc($result_prescriptions)) {
                            // Tính giá tổng của thuốc
                            $total_price = $row_prescription['gia'] * $row_prescription['quantity'];
                            $total_medicine_price += $total_price; // Cộng dồn vào tổng tiền thuốc

                            echo "<tr>
                                    <td>{$row_prescription['ten_thuoc']}</td>
                                    <td>{$row_prescription['quantity']}</td>
                                    <td>{$row_prescription['usage']}</td>
                                    <td>{$row_prescription['unit']}</td>
                                    <td>" . number_format($total_price, 0, ',', '.') . " VND</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Không có thuốc nào được kê cho phiếu khám này</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Dòng tính thành tiền -->
            <h5 class="text-right">Tổng Tiền Thuốc: <?php echo number_format($total_medicine_price, 0, ',', '.') . " VND"; ?></h5>
            <h5 class="text-right">Tiền Khám: <?php echo number_format($exam_fee, 0, ',', '.') . " VND"; ?></h5>
            <h4 class="text-right">Tổng Cộng: <?php echo number_format($total_medicine_price + $exam_fee, 0, ',', '.') . " VND"; ?></h4>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
