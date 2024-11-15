<?php 
session_start();
include("../include/header.php");
include("../include/connection.php");

// Kiểm tra kết nối cơ sở dữ liệu
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Truy vấn và kiểm tra lỗi
$admin_query = mysqli_query($connect, "SELECT * FROM admin");

if ($admin_query === false) {
    // Nếu có lỗi trong truy vấn SQL, dừng và hiển thị thông báo lỗi
    die('Error executing query: ' . mysqli_error($connect));
}

$admin_count = mysqli_num_rows($admin_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            <h4 class="my-2">Admin Dashboard</h4>
            <div class="row">
                <!-- Admin Card -->
                <div class="col-md-3 bg-success mx-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?php echo $admin_count; ?></h5>
                    <h6>Total Admin</h6>
                    <a href="admin.php">
                        <i class="fa fa-user-cog fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Doctors -->
                <div class="col-md-3 bg-info mx-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?php echo $doctor_count = 0; ?></h5>
                    <h6>Doctors</h6>
                    <a href="doctor.php">
                        <i class="fa fa-user-md fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Patients -->
                <div class="col-md-3 bg-warning mx-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?php echo $patient_count = 0; ?></h5>
                    <h6>Patients</h6>
                    <a href="patient.php">
                        <i class="fa fa-user-injured fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Report -->
                <div class="col-md-3 bg-danger mx-2  my-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?php echo $report_count = 0; ?></h5>
                    <h6>Report</h6>
                    <a href="report.php">
                        <i class="fa fa-flag fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Job Request -->
                <div class="col-md-3 bg-warning mx-2  my-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?php echo $request_count = 0; ?></h5>
                    <h6>Job Requests</h6>
                    <a href="Request.php">
                        <i class="fa fa-user-edit fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Incoming -->
                <div class="col-md-3 bg-info mx-2  my-2 dashboard-card">
                    <h5 style="font-size: 30px;"><?php echo $income_count = 0; ?></h5>
                    <h6>Incomes</h6>
                    <a href="income.php">
                        <i class="fa fa-money-check-alt fa-3x dashboard-icon"></i>
                    </a>
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
