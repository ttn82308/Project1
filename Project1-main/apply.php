<?php
include("include/connection.php");

function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply'])) {
    $firstname = sanitize_input($_POST['fname'] ?? '');
    $surname = sanitize_input($_POST['sname'] ?? '');
    $username = sanitize_input($_POST['uname'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $phone = sanitize_input($_POST['phone'] ?? '');
    $country = $_POST['country'] ?? '';
    $password = $_POST['pass'] ?? '';
    $confirm_password = $_POST['con_pass'] ?? '';

    $error = [];

    // Validate Họ và Tên
    if (empty($firstname)) {
        $error['fname'] = "Cần nhập họ";
    } else if (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $firstname) || strlen($firstname) < 2) {
        $error['fname'] = "Họ phải có ít nhất 2 ký tự và không chứa ký tự đặc biệt";
    }

    if (empty($surname)) {
        $error['sname'] = "Cần nhập tên";
    } else if (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $surname) || strlen($surname) < 2) {
        $error['sname'] = "Tên phải có ít nhất 2 ký tự và không chứa ký tự đặc biệt";
    }

    // Validate tên tài khoản
    if (empty($username)) {
        $error['uname'] = "Cần nhập tên tài khoản";
    } else if (preg_match("/\s/", $username) || strlen($username) < 5) {
        $error['uname'] = "Tên tài khoản phải dài ít nhất 5 ký tự và không chứa khoảng trắng";
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Email không hợp lệ";
    } else {
        // Kiểm tra email trùng lặp
        $query_check_email = "SELECT id FROM doctor WHERE email = ?";
        $stmt_check_email = $connect->prepare($query_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_email = $stmt_check_email->get_result();

        if ($result_email->num_rows > 0) {
            $error['email'] = "Email đã được đăng ký";
        }
    }

    // Validate giới tính
    if (empty($gender)) {
        $error['gender'] = "Hãy chọn giới tính";
    }

    // Validate số điện thoại
    if (empty($phone) || !preg_match("/^\+?[0-9]{9,15}$/", $phone)) {
        $error['phone'] = "Số điện thoại phải là 9-15 chữ số và có thể bao gồm mã quốc gia";
    }

    // Validate quốc tịch
    if (empty($country)) {
        $error['country'] = "Hãy chọn quốc tịch";
    }

    // Validate mật khẩu
    if (empty($password)) {
        $error['pass'] = "Hãy nhập mật khẩu";
    } else if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || 
               !preg_match('/[0-9]/', $password) || !preg_match('/[@$!%*?&]/', $password) || 
               strlen($password) < 8) {
        $error['pass'] = "Mật khẩu phải có ít nhất 8 ký tự, gồm chữ thường, chữ hoa, số và ký tự đặc biệt";
    }

    // Xác nhận mật khẩu
    if ($password !== $confirm_password) {
        $error['con_pass'] = "Mật khẩu không khớp";
    }

    // Nếu không có lỗi, tiến hành lưu vào cơ sở dữ liệu
    if (empty($error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO doctor (firstname, surname, username, email, gender, phone, country, password, salary, data_reg, status, profile) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), 'Pending', 'doctor.jpg')";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ssssssss", $firstname, $surname, $username, $email, $gender, $phone, $country, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Tạo đơn thành công!');</script>";
            header("Location: doctorlogin.php");
            exit();
        } else {
            $error['general'] = "Tạo đơn thất bại. Thử lại sau.";
        }
    }
}
?>
<?php
// Danh sách quốc gia
$countries = [
    'America' => 'Hoa Kỳ',
    'Pakistan' => 'Pakistan',
    'China' => 'Trung Quốc',
    'Vietnam' => 'Việt Nam',
    'Japan' => 'Nhật Bản',
    'Thailand' => 'Thái Lan',
    'Australia' => 'Úc',
    'France' => 'Pháp',
    'Germany' => 'Đức',
    'India' => 'Ấn Độ',
    'Canada' => 'Canada',
    'South Korea' => 'Hàn Quốc',
    'United Kingdom' => 'Vương Quốc Anh',
    'Italy' => 'Ý',
    'Spain' => 'Tây Ban Nha',
    'Russia' => 'Nga',
    'Brazil' => 'Brazil',
    'Mexico' => 'Mexico',
    'South Africa' => 'Nam Phi',
    'Argentina' => 'Argentina'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đơn đăng ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body style="background-image: url('img/back.jpg'); background-size: cover; background-repeat: no-repeat;">
<?php include("include/header.php"); ?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 jumbotron my-3">
                <h5 class="text-center">Đơn đăng ký</h5>
                <?php if (isset($error['general'])): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $error['general']; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fname">Tên:</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($firstname ?? ''); ?>">
                        <?php if (isset($error['fname'])): ?>
                            <div class="text-danger"><?php echo $error['fname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="sname">Họ</label>
                        <input type="text" name="sname" class="form-control" value="<?php echo htmlspecialchars($surname ?? ''); ?>">
                        <?php if (isset($error['sname'])): ?>
                            <div class="text-danger"><?php echo $error['sname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="uname">Tên tài khoản:</label>
                        <input type="text" name="uname" class="form-control" value="<?php echo htmlspecialchars($username ?? ''); ?>">
                        <?php if (isset($error['uname'])): ?>
                            <div class="text-danger"><?php echo $error['uname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                        <?php if (isset($error['email'])): ?>
                            <div class="text-danger"><?php echo $error['email']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <select name="gender" class="form-control">
                            <option value="Male" <?php echo (isset($gender) && $gender == 'Male') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Female" <?php echo (isset($gender) && $gender == 'Female') ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Other" <?php echo (isset($gender) && $gender == 'Other') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                        <?php if (isset($error['gender'])): ?>
                            <div class="text-danger"><?php echo $error['gender']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                        <?php if (isset($error['phone'])): ?>
                            <div class="text-danger"><?php echo $error['phone']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="country">Quốc tịch:</label>
                        <select name="country" class="form-control">
                                <option value="">Chọn quốc gia</option>
                                <?php foreach ($countries as $key => $value): ?>
                                    <option value="<?php echo $key; ?>" <?php echo (isset($country) && $country == $key) ? 'selected' : ''; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php if (isset($error['country'])): ?>
                            <div class="text-danger"><?php echo $error['country']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="pass">Mật khẩu:</label>
                        <input type="password" name="pass" class="form-control">
                        <?php if (isset($error['pass'])): ?>
                            <div class="text-danger"><?php echo $error['pass']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="con_pass">Xác nhận mật khẩu:</label>
                        <input type="password" name="con_pass" class="form-control">
                        <?php if (isset($error['con_pass'])): ?>
                            <div class="text-danger"><?php echo $error['con_pass']; ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="apply" class="btn btn-primary btn-block">Tạo đơn</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
