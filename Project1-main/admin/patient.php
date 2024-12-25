
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Total Patient</title>
</head>
<body>
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
?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left:-30px;">
                    <?php
                    include("sidenav.php");
                    ?>
                </div>
                <div class="col-md-10">
                    <h5 class="text-center my-3">Danh sách bệnh nhân</h5>

                    <?php
                    $query = "SELECT * FROM patient";
                    $res = mysqli_query($connect, $query);

                    if (!$res) {
                        echo "<p class='text-center text-danger'>Error fetching patients: " . mysqli_error($connect) . "</p>";
                    } else {
                        $output = "
                        <table class='table table-responsive table-bordered'>
                            <thead>
                                <tr>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Tên tài khoản</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Giới tính</th>
                                    <th>Quốc tịch</th>
                                    <th>Ngày đăng kí</th>
                                    <th style='width: 10%;'></th>
                                </tr>
                            </thead>
                            <tbody>";

                        if (mysqli_num_rows($res) < 1) {
                            $output .= "<tr><td colspan='10' class='text-center'>No Patient Yet</td></tr>";
                        } else {
                            while ($row = mysqli_fetch_array($res)) {
                                $output .= "
                                <tr>
                                    <td>{$row['surname']}</td>                                
                                    <td>{$row['firstname']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['gender']}</td>
                                    <td>{$row['country']}</td>
                                    <td>{$row['date_reg']}</td>
                                    <td>
                                        <a href='view.php?id={$row['id']}'>
                                            <button class='btn btn-info'>Chi tiết</button>
                                        </a>
                                    </td>
                                </tr>";
                            }
                        }

                        $output .= "
                            </tbody>
                        </table>";

                        echo $output;
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
