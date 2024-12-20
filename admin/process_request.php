<?php
include("../include/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == "approve") {
        $query = "UPDATE doctor SET status='Approved' WHERE id=?";
    } elseif ($action == "reject") {
        $query = "UPDATE doctor SET status='Rejected' WHERE id=?";
    } else {
        echo "Invalid action.";
        exit;
    }

    // Chuẩn bị câu truy vấn an toàn
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo ucfirst($action) . "d successfully."; // Phản hồi kết quả
    } else {
        echo "Error updating status.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>
