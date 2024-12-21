<?php
include("../include/connection.php");

if (isset($_GET['symptom'])) {
    $symptom = mysqli_real_escape_string($connect, $_GET['symptom']);
    $query = "SELECT id, loai_benh FROM benh WHERE trieu_chung = '$symptom'";
    $result = mysqli_query($connect, $query);
    $diseases = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $diseases[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($diseases);
}
?>
