<?php
session_start();
include("../include/header.php");
include("../include/connection.php");

// Kiểm tra nếu admin chưa đăng nhập
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

// Lấy ngày từ URL
$date = isset($_GET['date']) ? $_GET['date'] : null;

if (!$date) {
    echo "<script>alert('No date provided!'); window.location.href = 'manage_appointments.php';</script>";
    exit();
}

// Xử lý phân công bác sĩ hoặc cập nhật trạng thái
if (isset($_POST['update'])) {
    $appointment_id = $_POST['appointment_id'];
    $doctor_id = $_POST['doctor_id'];
    $status = $_POST['status'];

    // Cập nhật lịch hẹn
    $update_query = "UPDATE appointment SET doctor_id = '$doctor_id', status = '$status' WHERE id = '$appointment_id'";
    if (mysqli_query($connect, $update_query)) {
        echo "<script>alert('Appointment updated successfully!'); window.location.href = 'appointment_details.php?date=$date';</script>";
    } else {
        echo "<script>alert('Error updating appointment.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointment Details</title>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php include("sidenav.php"); ?>
                </div>
                <div class="col-md-10">
                    <h5 class="text-center my-3">Appointments on <?php echo $date; ?></h5>
                    <?php
                    // Lấy danh sách lịch hẹn trong ngày
                    $query = "SELECT * FROM appointment WHERE appointment_date = '$date'";
                    $res = mysqli_query($connect, $query);

                    echo "<table class='table table-bordered'>
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Symptoms</th>
                            <th>Status</th>
                            <th>Doctor Assigned</th>
                            <th>Action</th>
                        </tr>";

                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['firstname'] . "</td>
                                <td>" . $row['surname'] . "</td>
                                <td>" . $row['gender'] . "</td>
                                <td>" . $row['phone'] . "</td>
                                <td>" . $row['symptoms'] . "</td>
                                <td>" . $row['status'] . "</td>
                                <td>" . (!empty($row['doctor_id']) ? $row['doctor_id'] : "Not Assigned") . "</td>
                                <td>
                                    <form method='post'>                                                          
                                        <select name='status' class='form-control my-2' required>
                                            <option value='Pendding' " . ($row['status'] == 'Pendding' ? 'selected' : '') . ">Pendding</option>
                                            <option value='Approved' " . ($row['status'] == 'Approved' ? 'selected' : '') . ">Approved</option>
                                            <option value='Cancelled' " . ($row['status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                                        </select>
                                        <button type='submit' name='update' class='btn btn-success'>Update</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr>
                            <td colspan='9' class='text-center'>No Appointments Found</td>
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
