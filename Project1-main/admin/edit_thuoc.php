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
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID thuốc không hợp lệ');
}

$id = $_GET['id'];

// Lấy thông tin thuốc từ cơ sở dữ liệu
$query = "SELECT * FROM thuoc WHERE id = $id";
$result = mysqli_query($connect, $query);
$thuoc = mysqli_fetch_assoc($result);

if (!$thuoc) {
    die('Không tìm thấy thuốc với ID này');
}

// Xử lý lưu thay đổi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_thuoc = $_POST['ten_thuoc'];
    $cach_su_dung = $_POST['cach_su_dung'];
    $don_vi = $_POST['don_vi'];
    $gia = $_POST['gia'];

    $update_query = "UPDATE thuoc SET ten_thuoc = '$ten_thuoc', cach_su_dung = '$cach_su_dung', don_vi = '$don_vi', gia = '$gia' WHERE id = $id";

    if (mysqli_query($connect, $update_query)) {
        echo "<script>alert('Cập nhật thuốc thành công!'); window.location.href = 'manage_thuoc.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật thuốc.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chỉnh sửa thuốc</title>
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
                <h4 class="my-2">Chỉnh sửa thuốc</h4>
                <form method="POST" action="edit_thuoc.php?id=<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="ten_thuoc">Tên thuốc:</label>
                        <input type="text" class="form-control" id="ten_thuoc" name="ten_thuoc" value="<?php echo $thuoc['ten_thuoc']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cach_su_dung">Cách sử dụng:</label>
                        <select class="form-control" id="cach_su_dung" name="cach_su_dung" required>
                            <option value="Uống trước khi ăn" <?php echo ($thuoc['cach_su_dung'] == 'Uống trước khi ăn') ? 'selected' : ''; ?>>Uống trước khi ăn</option>
                            <option value="Uống sau khi ăn" <?php echo ($thuoc['cach_su_dung'] == 'Uống sau khi ăn') ? 'selected' : ''; ?>>Uống sau khi ăn</option>
                            <option value="Tiêm" <?php echo ($thuoc['cach_su_dung'] == 'Tiêm') ? 'selected' : ''; ?>>Tiêm</option>
                            <option value="Thoa" <?php echo ($thuoc['cach_su_dung'] == 'Thoa') ? 'selected' : ''; ?>>Thoa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="don_vi">Đơn vị:</label>
                        <select class="form-control" id="don_vi" name="don_vi" required>
                            <option value="Viên" <?php echo ($thuoc['don_vi'] == 'Viên') ? 'selected' : ''; ?>>Viên</option>
                            <option value="Chai" <?php echo ($thuoc['don_vi'] == 'Chai') ? 'selected' : ''; ?>>Chai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gia">Giá:</label>
                        <input type="number" class="form-control" id="gia" name="gia" value="<?php echo $thuoc['gia']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="manage_thuoc.php" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
