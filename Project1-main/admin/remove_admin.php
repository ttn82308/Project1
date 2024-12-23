<?php
session_start();
include("../include/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']); 
    $current_admin = $_SESSION['admin'];


    $stmt = $connect->prepare("SELECT * FROM admin WHERE id = ? AND username != ?");
    $stmt->bind_param("is", $id, $current_admin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $delete_stmt = $connect->prepare("DELETE FROM admin WHERE id = ?");
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            echo "Xoá thành công.";
        } else {
            echo "Không thể xoá.";
        }
        $delete_stmt->close();
    } else {
        echo "Không thể tìm thấy hoặc không thể xoá bản thân.";
    }

    $stmt->close();
}
?>

