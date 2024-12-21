<?php
include("../include/connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT don_vi, cach_su_dung FROM thuoc WHERE id = $id";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
