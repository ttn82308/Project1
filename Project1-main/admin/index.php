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


$admin_query = mysqli_query($connect, "SELECT * FROM admin");

if ($admin_query === false) {
 
    die('Error executing query: ' . mysqli_error($connect));
}

$admin_count = mysqli_num_rows($admin_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
            <h4 class="my-2">Trang chủ</h4>
            <div class="row">
                <!-- Admin Card -->
                <div class="col-md-3 bg-success mx-2 dashboard-card">
                     <?php 
                    $admin = mysqli_query($connect,"SELECT * FROM admin");

                    $admin_count = mysqli_num_rows($admin);
                     ?>
                    <h5 style="font-size: 30px;"><?php echo $admin_count; ?></h5>
                    <h6>Admin</h6>
                    <a href="admin.php">
                        <i class="fa fa-user-cog fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Doctors -->
                <div class="col-md-3 bg-info mx-2 dashboard-card">
                    <?php 
                    $doctor = mysqli_query($connect,"SELECT * FROM doctor WHERE status ='Approved'");

                    $doctor_count = mysqli_num_rows($doctor);
                     ?>
                    <h5 style="font-size: 30px;"><?php echo $doctor_count; ?></h5>
                    <h6>Bác sĩ</h6>
                    <a href="doctor.php">
                        <i class="fa fa-user-md fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Patients -->
                <div class="col-md-3 bg-warning mx-2 dashboard-card">
                    <?php 
                    $patient = mysqli_query($connect,"SELECT * FROM patient");

                    $patient_count = mysqli_num_rows($patient);
                     ?>
                    <h5 style="font-size: 30px;"><?php echo $patient_count; ?></h5>
                    <h6>Bệnh nhân</h6>
                    <a href="patient.php">
                        <i class="fa fa-user-injured fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Report -->
                <div class="col-md-3 bg-danger mx-2  my-2 dashboard-card">
                    <?php 
                    $report = mysqli_query($connect,"SELECT * FROM report");

                    $report_count = mysqli_num_rows($report);
                     ?>
                    <h5 style="font-size: 30px;"><?php echo $report_count; ?></h5>
                    <h6>Khiếu nại</h6>
                    <a href="report.php">
                        <i class="fa fa-flag fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Job Request -->
                <div class="col-md-3 bg-warning mx-2  my-2 dashboard-card">
                    <?php 
                        $job = mysqli_query($connect,"SELECT * FROM doctor WHERE status = 'Pendding'");

                        $request_count = mysqli_num_rows($job);

                     ?>
                    <h5 style="font-size: 30px;"><?php echo $request_count; ?></h5>
                    <h6>Đơn đăng kí</h6>
                    <a href="job_request.php">
                        <i class="fa fa-user-edit fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Incoming -->
                <div class="col-md-3 bg-info mx-2  my-2 dashboard-card">
                     <?php 
                        $income = mysqli_query($connect,"SELECT * FROM income");

                        $in_count = mysqli_num_rows($income);

                     ?>
                    <h6>Thống kê doanh thu</h6>
                    <a href="monthly_income.php">
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
