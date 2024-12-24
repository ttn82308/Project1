<?php
include('../include/connection.php');
include('../include/header.php');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê thuốc theo tháng</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-light " style="margin-left:-30px;">
                <?php include("sidenav.php"); ?>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <h3 class="text-center my-4">Thống kê thuốc sử dụng theo tháng</h3>

                <!-- Form chọn tháng -->
                <div class="card p-4 mb-4">
                    <form method="POST">
                        <div class="form-row align-items-center">
                            <div class="col-md-6">
                                <label for="month">Chọn tháng (YYYY-MM):</label>
                                <input 
                                    type="month" 
                                    id="month" 
                                    name="month" 
                                    class="form-control" 
                                    required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="view_stats" class="btn btn-primary mt-4">Xem thống kê</button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['view_stats'])) {
                    $month = $_POST['month']; // Format: YYYY-MM
                    $start_date = $month . "-01";
                    $end_date = date("Y-m-t", strtotime($start_date)); // Get the last date of the month

                    // Format the month to display (e.g., "Tháng 12/2024")
                    $formatted_month = date("m/Y", strtotime($start_date));

                    // SQL query
                    $query = "SELECT 
                                t.ten_thuoc AS MedicineName, 
                                COUNT(p.medicine_id) AS UsageCount, 
                                SUM(p.quantity) AS TotalQuantity, 
                                DATE_FORMAT(mf.exam_date, '%Y-%m') AS UsageMonth
                              FROM 
                                prescriptions p
                              JOIN 
                                medical_form mf ON p.medical_form_id = mf.id
                              JOIN 
                                thuoc t ON p.medicine_id = t.id
                              WHERE 
                                mf.exam_date BETWEEN '$start_date' AND '$end_date'
                              GROUP BY 
                                p.medicine_id, UsageMonth
                              ORDER BY 
                                TotalQuantity DESC";

                    $result = $connect->query($query);

                    // Display results
                    if ($result->num_rows > 0) {
                        echo "<h5 class='text-center my-4'>Báo cáo sử dụng thuốc tháng $formatted_month</h5>";
                        echo "<div class='table-responsive'>
                                <table class='table table-bordered table-striped'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th>Tên thuốc</th>
                                            <th>Số lần sử dụng</th>
                                            <th>Tổng số lượng</th>
                                            <th>Tháng</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['MedicineName']}</td>
                                    <td>{$row['UsageCount']}</td>
                                    <td>{$row['TotalQuantity']}</td>
                                    <td>{$row['UsageMonth']}</td>
                                  </tr>";
                        }
                        echo "  </tbody>
                              </table>
                              </div>";
                    } else {
                        echo "<div class='alert alert-warning text-center'>Không có dữ liệu cho tháng $formatted_month.</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
