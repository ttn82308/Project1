<?php
// Kết nối cơ sở dữ liệu
include("../include/connection.php");

// Kiểm tra nếu có id thuốc để xóa
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Thực hiện câu lệnh DELETE để xóa thuốc
    $query = "DELETE FROM thuoc WHERE id = $id";
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Xóa thuốc thành công!'); window.location.href = 'manage_thuoc.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa thuốc.');</script>";
    }
}
?>
