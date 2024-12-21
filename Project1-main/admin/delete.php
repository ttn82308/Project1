<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
    </div>
<?php endif; ?>
<?php
session_start();
include("../include/connection.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Xóa bản ghi dựa trên ID
    $query = "DELETE FROM doctor WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Doctor deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete doctor. Please try again.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Quay lại trang danh sách
header("Location: doctor.php");
exit;
?>
