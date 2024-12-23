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

    if (empty($firstname)) {
        $error['fname'] = "Cần nhập họ";
    }
    if (empty($surname)) {
        $error['sname'] = "Cần nhập tên";
    }
    if (empty($username)) {
        $error['uname'] = "Cần nhập tên tài khoản";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Email không hợp lệ";
    }
    if (empty($gender)) {
        $error['gender'] = "Hãy chọn giới tính";
    }
    if (empty($phone) || !is_numeric($phone)) {
        $error['phone'] = "Số điện thoại không hợp lệ";
    }
    if (empty($country)) {
        $error['country'] = "Hãy chọn quốc tịch";
    }
    if (empty($password)) {
        $error['pass'] = "Hãy nhập mật khẩu";
    } else if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error['pass'] = "Mật khẩu cần bao gồm 8 kí tự số và chữ";
    }
    if ($password !== $confirm_password) {
        $error['con_pass'] = "Mật khẩu không khớp";
    }

    if (empty($error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO doctor (firstname, surname, username, email, gender, phone, country, password, salary, data_reg, status, profile) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), 'Pendding', 'doctor.jpg')";
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
    // Thêm các quốc gia khác nếu cần
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
