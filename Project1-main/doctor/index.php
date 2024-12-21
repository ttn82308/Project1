<?php 
session_start();
include("../include/header.php");
include("../include/connection.php");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}


$doctor_query = mysqli_query($connect, "SELECT * FROM doctor");

if ($doctor_query === false) {
 
    die('Error executing query: ' . mysqli_error($connect));
}

$doctor_count = mysqli_num_rows($doctor_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Dashboard</title>
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
            <h4 class="my-2">Doctor Dashboard</h4>
            <div class="row">
                <!-- Doctor Profile-->
                <div class="col-md-3 bg-info mx-2 my-2 dashboard-card">
                    <?php 
                    $doctor = mysqli_query($connect,"SELECT * FROM doctor ");

                    $doctor_count = mysqli_num_rows($doctor);
                     ?>
                    <h5 style="font-size: 30px;"><?php echo $doctor_count; ?></h5>
                    <h6>Doctors</h6>
                    <a href="profile.php">
                        <i class="fa fa-user-circle fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Patients -->
                <div class="col-md-3 bg-warning mx-2 my-2 dashboard-card">
                    <?php 
                    $patient = mysqli_query($connect,"SELECT * FROM patient");

                    $patient_count = mysqli_num_rows($patient);
                     ?>
                    <h5 style="font-size: 30px;"><?php echo $patient_count; ?></h5>
                    <h6>Patients</h6>
                    <a href="patient.php">
                        <i class="fa fa-procedures fa-3x dashboard-icon"></i>
                    </a>
                </div>
                <!-- Appointment -->
                <div class="col-md-3 bg-success mx-2 my-2 dashboard-card">
                    <?php 
                    $appointment = mysqli_query($connect,"SELECT * FROM appointment WHERE status='Pendding'");

                    $appointment_count = mysqli_num_rows($appointment);
                    ?>
                    <h5 style="font-size: 30px;"><?php echo $appointment_count; ?></h5>
                    <h6>Appointment</h6>
                    <a href="appointment.php">
                        <i class="fa fa-calendar fa-3x dashboard-icon"></i>
                    </a>
                </div>                	
        
                    
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
