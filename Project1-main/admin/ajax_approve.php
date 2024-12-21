<?php
include("../include/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = trim($_POST['id']);

 
    if (!is_numeric($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid ID format.'
        ]);
        exit();
    }


    $query = "UPDATE doctor SET status = ? WHERE id = ?";
    $stmt = $connect->prepare($query);

    if ($stmt) {
        $status = 'Approved';
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Doctor status successfully updated to Approved.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update status. Please try again later.'
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to prepare the query: ' . $connect->error
        ]);
    }

    $connect->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request. ID is required.'
    ]);
}
?>
