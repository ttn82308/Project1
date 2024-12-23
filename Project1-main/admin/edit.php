<?php 
session_start();
include("../include/header.php");
include("../include/connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
</head>
<body>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center">Chỉnh sửa</h5>
                <?php 
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $id = intval($_GET['id']);

                    $stmt = $connect->prepare("SELECT * FROM doctor WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    } else {
                        echo "<p class='text-danger'>Không tìm thấy bác sĩ.</p>";
                        exit;
                    }
                } else {
                    echo "<p class='text-danger'>Bác sĩ không tồn tại.</p>";
                    exit;
                }
                ?>

                <div class="row">
                    <div class="col-md-8">
                        <h5 class="text-center">Thông tin</h5>
                        <h5 class="col-md-3">Họ: <?php echo htmlspecialchars($row['surname']); ?></h5>
                        <h5 class="col-md-3">Tên: <?php echo htmlspecialchars($row['firstname']); ?></h5>
                        <h5 class="col-md-3">Tên tài khoản: <?php echo htmlspecialchars($row['username']); ?></h5>
                        <h5 class="col-md-3">Số điện thoại: <?php echo htmlspecialchars($row['phone']); ?></h5>
                        <h5 class="col-md-3">Quốc tịch: <?php echo htmlspecialchars($row['country']); ?></h5>
                        <h5 class="col-md-3">Lương hiện tại: $<?php echo htmlspecialchars($row['salary']); ?></h5>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-center">Cập nhật lương</h5>
                        <?php 
                        if (isset($_POST['update'])) {
                            $salary = trim($_POST['salary']);

                            if (!is_numeric($salary) || $salary <= 0) {
                                echo "<p class='text-danger'>Số đã nhập không hợp lệ.</p>";
                            } else {
                                $stmt = $connect->prepare("UPDATE doctor SET salary = ? WHERE id = ?");
                                $stmt->bind_param("di", $salary, $id);

                                if ($stmt->execute()) {
                                    echo "<p class='text-success'>Cập nhật thành công!</p>";
                                } else {
                                    echo "<p class='text-danger'>Có lỗi xảy ra.</p>";
                                }
                            }
                        }
                        ?>
                        <form method="post">
                            <label for="salary">Thay đổi lương</label>
                            <input type="number" id="salary" name="salary" class="form-control" placeholder="Nhập số lương" 
                                value="<?php echo htmlspecialchars($row['salary']); ?>" required>
                            <input type="submit" name="update" class="btn btn-info my-3" value="Xác nhận">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
