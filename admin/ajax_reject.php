<?php 
    include("../include/connection.php");

    if (isset($_POST['id'])) {
        $id = $_POST['id'];


        $query = "UPDATE doctor SET status = 'Rejected' WHERE id = ?";
        $stmt = $connect->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $id); 
            if ($stmt->execute()) {
                echo "Doctor status updated to Rejected successfully.";
            } else {
                echo "Error updating status: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $connect->error;
        }
    } else {
        echo "No ID provided.";
    }
?>
