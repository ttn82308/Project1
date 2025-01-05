<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1-main";

// Tạo kết nối
$connect = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($connect->connect_error) {
    die("Kết nối thất bại: " . $connect->connect_error);
}
?>