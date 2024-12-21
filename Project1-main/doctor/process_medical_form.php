<?php
session_start();
include("../include/connection.php");

// Kiểm tra xem form có được gửi hay không
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $patient_name = $_POST['patient_name']; // ID bệnh nhân
    $exam_date = $_POST['exam_date']; // Ngày khám
    $symptoms = $_POST['symptoms']; // Triệu chứng
    $disease = $_POST['disease']; // Dự đoán loại bệnh
    $medicine_names = $_POST['medicine_name']; // Danh sách thuốc
    $medicine_quantities = $_POST['medicine_quantity']; // Số lượng thuốc
    $medicine_usages = $_POST['medicine_usage']; // Cách dùng thuốc
    $medicine_units = $_POST['medicine_unit']; // Đơn vị thuốc

    // Lưu thông tin phiếu khám vào bảng "medical_form"
    $query_insert_medical_form = "INSERT INTO medical_form (patient_id, exam_date, symptoms, disease_id) 
                                  VALUES ('$patient_name', '$exam_date', '$symptoms', '$disease')";
    if (mysqli_query($connect, $query_insert_medical_form)) {
        // Lấy ID của phiếu khám vừa tạo
        $medical_form_id = mysqli_insert_id($connect);

        // Lưu thông tin thuốc vào bảng "prescriptions"
        $prescription_values = [];
        for ($i = 0; $i < count($medicine_names); $i++) {
            $medicine_name = $medicine_names[$i];
            $quantity = $medicine_quantities[$i];
            $usage = $medicine_usages[$i];
            $unit = $medicine_units[$i];

            // Thêm thông tin thuốc vào mảng
            $prescription_values[] = "('$medical_form_id', '$medicine_name', '$quantity', '$usage', '$unit')";
        }

        // Chèn thông tin thuốc vào bảng "prescriptions"
        if (count($prescription_values) > 0) {
            $query_insert_prescriptions = "INSERT INTO prescriptions (medical_form_id, medicine_id, quantity, `usage`, unit) 
                                           VALUES " . implode(", ", $prescription_values);
            if (!mysqli_query($connect, $query_insert_prescriptions)) {
                // Nếu có lỗi khi chèn thông tin thuốc, thông báo lỗi
                $_SESSION['error'] = "Đã xảy ra lỗi khi lưu thông tin thuốc!";
                header("Location: medical_form.php");
                exit;
            }
        }

        // Thông báo thành công và chuyển hướng
        $_SESSION['message'] = "Phiếu khám đã được lưu thành công!";
        header("Location: medical_form_list.php"); // Chuyển hướng đến danh sách phiếu khám
    } else {
        // Nếu có lỗi khi chèn phiếu khám, thông báo lỗi
        $_SESSION['error'] = "Đã xảy ra lỗi khi lưu phiếu khám!";
        header("Location: medical_form.php"); // Trở lại trang form nếu có lỗi
    }
}
?>
