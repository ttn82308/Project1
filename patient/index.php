<?php
session_start();
include("../include/header.php");
include("../include/connection.php");

// Kiểm tra kết nối cơ sở dữ liệu
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Lấy dữ liệu bệnh nhân nếu cần
$patient_query = mysqli_query($connect, "SELECT * FROM patients");
$patient_count = $patient_query ? mysqli_num_rows($patient_query) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dashboard-card {
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            border-radius: 8px;
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
            <h4 class="my-3">Patient Dashboard</h4>
            <div class="row">
                <!-- My Profile -->
                <div class="col-md-3 bg-info mx-2 dashboard-card">
                    <h5>My Profile</h5>
                    <a href="profile.php">
                        <i class="fa fa-user-circle fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Book Appointment -->
                <div class="col-md-3 bg-warning mx-2 dashboard-card">
                    <h5>Book Appointment</h5>
                    <a href="appointment.php">
                        <i class="fa fa-calendar fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- My Invoice -->
                <div class="col-md-3 bg-success mx-2 dashboard-card">
                    <h5>My Invoice</h5>
                    <a href="invoice.php">
                        <i class="fa fa-file-invoice-dollar fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Send Report -->
                <div class="col-md-3 bg-danger mx-2 my-2 dashboard-card">
                    <h5>Send Report</h5>
                    <a href="report.php">
                        <i class="fa fa-flag fa-3x dashboard-icon"></i>
                    </a>
                </div>
            </div>
            <!-- Form Send Report -->
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 jumbotron bg-light my-4">
                    <h5 class="text-center my-3">Send A Report</h5>
                    <form method="post">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter report title">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter your message"></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-primary btn-block">Send Report</button>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>