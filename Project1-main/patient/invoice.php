<?php 
 session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Hóa đơn</title>
</head>
<body>
    <?php 
    include("../include/header.php");
    include("../include/connection.php");
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php include("sidenav.php"); ?>
                </div>
                <div class="col-md-10">
                    <h5 class="text-center my-2">Hóa đơn của tôi</h5>

                    <?php 
                    $pat = $_SESSION['patient'];

                    $stmt = $connect->prepare("SELECT firstname FROM patient WHERE username=?");
                    $stmt->bind_param("s", $pat);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $fname = $row['firstname'];

                    $stmt_invoices = $connect->prepare("SELECT * FROM income WHERE patient=?");
                    $stmt_invoices->bind_param("s", $fname);
                    $stmt_invoices->execute();
                    $result_invoices = $stmt_invoices->get_result();

                    $output = "
                    <table class='table table-bordered table-striped table-hover'>
                        <tr>
                            <td>ID</td>
                            <td>Bác sĩ</td>
                            <td>Bệnh nhân</td>
                            <td>Ngày xuất viện</td>
                            <td>Số tiền trả</td>
                            <td>Mô tả</td>
                            <td>Action</td>
                        </tr>";

                    if ($result_invoices->num_rows < 1) {
                        $output .= "
                        <tr>
                            <td colspan='7' class='text-center'>Chưa có hóa đơn nào.</td>
                        </tr>";
                    } else {
                        while ($invoice = $result_invoices->fetch_assoc()) {
                            $output .= "
                            <tr>
                                <td>".$invoice['id']."</td>
                                <td>".$invoice['doctor']."</td>
                                <td>".$invoice['patient']."</td>
                                <td>".$invoice['date_discharge']."</td>
                                <td>".$invoice['amount_paid']."</td>
                                <td>".$invoice['description']."</td>
                                <td>
                                    <a href='view.php?id=".$invoice['id']."'>
                                        <button class='btn btn-info' title='View Invoice'>Xem</button>
                                    </a>
                                </td>
                            </tr>";
                        }
                    }

                    $output .= "</table>";
                    echo $output;


                    $stmt->close();
                    $stmt_invoices->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
