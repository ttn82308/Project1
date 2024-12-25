<?php
session_start(); 
include ("../include/header.php");
include ("../include/connection.php");
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['doctor'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: ../doctorlogin.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2" style="margin-left:-30px;">
            <?php include("sidenav.php"); ?>
        </div>

        <div class="col-md-10">
            <h2 class="text-center my-4">Phiếu Khám Bệnh</h2>
            <form action="process_medical_form.php" method="POST">
                <!-- Patient Information -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="patient_name" class="form-label">Họ tên bệnh nhân:</label>
                        <select class="form-control" id="patient_name" name="patient_name" required>
                            <?php
                            $result_patient = mysqli_query($connect, "SELECT id, firstname, surname FROM patient");
                            if ($result_patient && mysqli_num_rows($result_patient) > 0) {
                                while ($row_patient = mysqli_fetch_assoc($result_patient)) {
                                    $full_name = $row_patient['surname'] . " " . $row_patient['firstname'];
                                    echo "<option value='{$row_patient['id']}'>{$full_name}</option>";
                                }
                            } else {
                                echo "<option value=''>Không có bệnh nhân</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exam_date" class="form-label">Ngày khám:</label>
                        <input type="date" class="form-control" id="exam_date" name="exam_date" required>
                    </div>
                </div>

                <!-- Triệu chứng -->
                <div class="mb-3">
                    <label for="symptoms" class="form-label">Triệu chứng:</label>
                    <select class="form-control" id="symptoms" name="symptoms" onchange="getDiseases()" required>
                        <option value="">Chọn triệu chứng</option>
                        <?php
                        $result_trieuchung = mysqli_query($connect, "SELECT DISTINCT trieu_chung FROM benh");
                        if ($result_trieuchung && mysqli_num_rows($result_trieuchung) > 0) {
                            while ($row_trieuchung = mysqli_fetch_assoc($result_trieuchung)) {
                                echo "<option value='{$row_trieuchung['trieu_chung']}'>{$row_trieuchung['trieu_chung']}</option>";
                            }
                        } else {
                            echo "<option value=''>Không có triệu chứng</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Dự đoán loại bệnh -->
                <div class="mb-3">
                    <label for="disease" class="form-label">Dự đoán loại bệnh:</label>
                    <select class="form-control" id="disease" name="disease" required>
                        <option value="">Chọn loại bệnh</option>
                        <!-- Dữ liệu sẽ được nạp từ AJAX -->
                    </select>
                </div>

                <!-- Danh sách thuốc -->
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thuốc</th>
                            <th>Đơn Vị</th>
                            <th>Số Lượng</th>
                            <th>Cách Dùng</th>
                        </tr>   
                    </thead>
                    <tbody id="medicine_table">
                        <tr>
                            <td>1</td>
                            <td>
                                <select class="form-control medicine-dropdown" name="medicine_name[]" required>
                                    <option value="">-- Chọn thuốc --</option>
                                    <?php
                                    $result_thuoc = mysqli_query($connect, "SELECT id, ten_thuoc FROM thuoc");
                                    while ($row_thuoc = mysqli_fetch_assoc($result_thuoc)) {
                                        echo "<option value='{$row_thuoc['id']}'>{$row_thuoc['ten_thuoc']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input type="text" class="form-control medicine-unit" name="medicine_unit[]" readonly></td>
                            <td><input type="number" class="form-control" name="medicine_quantity[]" min="1" required></td>
                            <td><input type="text" class="form-control medicine-usage" name="medicine_usage[]" readonly></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" id="add_row">Thêm thuốc</button>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const medicineTable = document.getElementById("medicine_table");

        // Sự kiện thay đổi dropdown thuốc
        medicineTable.addEventListener("change", function (e) {
            if (e.target.classList.contains("medicine-dropdown")) {
                const medicineId = e.target.value;
                const row = e.target.closest("tr");
                if (medicineId) {
                    fetch(`get_medicine_info.php?id=${medicineId}`)
                        .then(response => response.json())
                        .then(data => {
                            row.querySelector(".medicine-unit").value = data.don_vi || '';
                            row.querySelector(".medicine-usage").value = data.cach_su_dung || '';
                        })
                        .catch(err => console.error("Lỗi:", err));
                } else {
                    row.querySelector(".medicine-unit").value = '';
                    row.querySelector(".medicine-usage").value = '';
                }
            }
        });

        // Thêm dòng mới
        document.getElementById("add_row").addEventListener("click", function () {
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${medicineTable.rows.length + 1}</td>
                <td>
                    <select class="form-control medicine-dropdown" name="medicine_name[]" required>
                        <option value="">-- Chọn thuốc --</option>
                        <?php
                        $result_thuoc = mysqli_query($connect, "SELECT id, ten_thuoc FROM thuoc");
                        while ($row_thuoc = mysqli_fetch_assoc($result_thuoc)) {
                            echo "<option value='{$row_thuoc['id']}'>{$row_thuoc['ten_thuoc']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" class="form-control medicine-unit" name="medicine_unit[]" readonly></td>
                <td><input type="number" class="form-control" name="medicine_quantity[]" min="1" required></td>
                <td><input type="text" class="form-control medicine-usage" name="medicine_usage[]" readonly></td>
            `;
            medicineTable.appendChild(newRow);
        });
    });

    // Hàm lấy thông tin loại bệnh khi chọn triệu chứng
    function getDiseases() {
        const symptom = document.getElementById("symptoms").value;
        const diseaseSelect = document.getElementById("disease");
        
        if (symptom) {
            fetch("fetch_diseases.php?symptom=" + encodeURIComponent(symptom))
                .then(response => response.json())
                .then(data => {
                    diseaseSelect.innerHTML = "<option value=''>Chọn loại bệnh</option>";
                    data.forEach(disease => {
                        const option = document.createElement("option");
                        option.value = disease.id;
                        option.textContent = disease.loai_benh;
                        diseaseSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Lỗi:", error));
        } else {
            diseaseSelect.innerHTML = "<option value=''>Chọn loại bệnh</option>";
        }
    }
</script>

