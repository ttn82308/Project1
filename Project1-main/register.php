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

    // Validate first name
    if (empty($firstname)) {
        $error['fname'] = "Cần nhập tên.";
    } elseif (!preg_match("/^[A-Za-zÀ-ỹ ]+$/u", $firstname) || strlen($firstname) < 2) {
        $error['fname'] = "Tên phải có ít nhất 2 ký tự và không chứa ký tự đặc biệt hoặc số.";
    }

    // Validate surname
    if (empty($surname)) {
        $error['sname'] = "Cần nhập họ.";
    } elseif (!preg_match("/^[A-Za-zÀ-ỹ ]+$/u", $surname) || strlen($surname) < 2) {
        $error['sname'] = "Họ phải có ít nhất 2 ký tự và không chứa ký tự đặc biệt hoặc số.";
    }

    // Validate username
    if (empty($username)) {
        $error['uname'] = "Cần nhập tài khoản.";
    } elseif (!preg_match("/^[A-Za-z0-9_]{5,}$/", $username)) {
        $error['uname'] = "Tên tài khoản phải ít nhất 5 ký tự, chỉ chứa chữ cái, số hoặc dấu gạch dưới.";
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Cần nhập email hợp lệ.";
    }

    // Validate gender
    $allowed_genders = ['Male', 'Female', 'Other'];
    if (!in_array($gender, $allowed_genders)) {
        $error['gender'] = "Cần chọn giới tính.";
    }

    // Validate phone
    if (empty($phone) || !preg_match("/^[0-9]{10,15}$/", $phone)) {
        $error['phone'] = "Số điện thoại phải chỉ chứa số và có từ 10 đến 15 chữ số.";
    }

    // Validate country
    $allowed_countries = ['America', 'Pakistan', 'China', 'Vietnam', 'Japan', 'Thailand', 'Australia', 'France', 'Germany', 'India', 'Canada', 'South Korea', 'United Kingdom', 'Italy', 'Spain', 'Russia', 'Brazil', 'Mexico', 'South Africa', 'Argentina'];
    if (!in_array($country, $allowed_countries)) {
        $error['country'] = "Cần chọn quốc gia bạn đang ở.";
    }

    // Validate password
    if (empty($password)) {
        $error['pass'] = "Mật khẩu là bắt buộc.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$/', $password)) {
        $error['pass'] = "Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt.";
    }

    // Confirm passwords match
    if ($password !== $confirm_password) {
        $error['con_pass'] = "Mật khẩu không khớp.";
    }

    // Proceed if no errors
    if (empty($error)) {
        // Check if email already exists
        $query_check = "SELECT id FROM patient WHERE email = ?";
        $stmt_check = $connect->prepare($query_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $error['email'] = "Email này đã được đăng ký.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $query = "INSERT INTO patient (firstname, surname, username, email, gender, phone, country, password, date_reg, profile) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'patient.jpg')";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("ssssssss", $firstname, $surname, $username, $email, $gender, $phone, $country, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Đăng ký thành công!');</script>";
                header("Location: patientlogin.php");
                exit();
            } else {
                $error['general'] = "Đăng ký thất bại. Thử lại!";
            }
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
    <title>Đăng kí</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body style="background-image: url('img/back.jpg'); background-size: cover; background-repeat: no-repeat;">
<?php include("include/header.php"); ?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 bg-light p-4 rounded my-3">
                <h5 class="text-center">Tạo tài khoản</h5>
                <?php if (isset($error['general'])): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $error['general']; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="fname">Tên:</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($firstname ?? ''); ?>">
                        <?php if (isset($error['fname'])): ?>
                            <div class="text-danger"><?php echo $error['fname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="sname">Họ:</label>
                        <input type="text" name="sname" class="form-control" value="<?php echo htmlspecialchars($surname ?? ''); ?>">
                        <?php if (isset($error['sname'])): ?>
                            <div class="text-danger"><?php echo $error['sname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="uname">Tên tài khoản:</label>
                        <input type="text" name="uname" class="form-control" value="<?php echo htmlspecialchars($username ?? ''); ?>">
                        <?php if (isset($error['uname'])): ?>
                            <div class="text-danger"><?php echo $error['uname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                        <?php if (isset($error['email'])): ?>
                            <div class="text-danger"><?php echo $error['email']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="gender">Giới tính:</label>
                        <select name="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo (isset($gender) && $gender == 'Male') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Female" <?php echo (isset($gender) && $gender == 'Female') ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Other" <?php echo (isset($gender) && $gender == 'Other') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                        <?php if (isset($error['gender'])): ?>
                            <div class="text-danger"><?php echo $error['gender']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                        <?php if (isset($error['phone'])): ?>
                            <div class="text-danger"><?php echo $error['phone']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
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

                    <div class="mb-3">
                        <label for="pass">Mật khẩu:</label>
                        <input type="password" name="pass" class="form-control">
                        <?php if (isset($error['pass'])): ?>
                            <div class="text-danger"><?php echo $error['pass']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="con_pass">Nhập lại mật khẩu:</label>
                        <input type="password" name="con_pass" class="form-control">
                        <?php if (isset($error['con_pass'])): ?>
                            <div class="text-danger"><?php echo $error['con_pass']; ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="apply" class="btn btn-primary btn-block">Đăng kí</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
