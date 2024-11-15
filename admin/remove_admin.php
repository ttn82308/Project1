<?php
include ("../include/connection.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']); 

    $query = "DELETE FROM admin WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Admin removed successfully.";
    } else {
        echo "Failed to remove admin.";
    }
    $stmt->close();
}
?>
