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
        $error['fname'] = "First name is required";
    }
    if (empty($surname)) {
        $error['sname'] = "Surname is required";
    }
    if (empty($username)) {
        $error['uname'] = "Username is required";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "A valid email is required";
    }
    if (empty($gender)) {
        $error['gender'] = "Please select your gender";
    }
    if (empty($phone) || !is_numeric($phone)) {
        $error['phone'] = "A valid phone number is required";
    }
    if (empty($country)) {
        $error['country'] = "Please select your country";
    }
    if (empty($password)) {
        $error['pass'] = "Password is required";
    } else if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error['pass'] = "Password must be at least 8 characters long and include letters and numbers";
    }
    if ($password !== $confirm_password) {
        $error['con_pass'] = "Passwords do not match";
    }

    if (empty($error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO doctor (firstname, surname, username, email, gender, phone, country, password, salary, data_reg, status, profile) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), 'Pendding', 'doctor.jpg')";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ssssssss", $firstname, $surname, $username, $email, $gender, $phone, $country, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Application successful!');</script>";
            header("Location: doctorlogin.php");
            exit();
        } else {
            $error['general'] = "Failed to apply. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply Now</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body style="background-image: url('img/back.jpg'); background-size: cover; background-repeat: no-repeat;">
<?php include("include/header.php"); ?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 jumbotron my-3">
                <h5 class="text-center">Apply Now</h5>
                <?php if (isset($error['general'])): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $error['general']; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fname">First Name:</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($firstname ?? ''); ?>">
                        <?php if (isset($error['fname'])): ?>
                            <div class="text-danger"><?php echo $error['fname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="sname">Surname:</label>
                        <input type="text" name="sname" class="form-control" value="<?php echo htmlspecialchars($surname ?? ''); ?>">
                        <?php if (isset($error['sname'])): ?>
                            <div class="text-danger"><?php echo $error['sname']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="uname">Username:</label>
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
                        <label for="gender">Gender:</label>
                        <select name="gender" class="form-control">
                            <option value="Male" <?php echo (isset($gender) && $gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($gender) && $gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo (isset($gender) && $gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                        <?php if (isset($error['gender'])): ?>
                            <div class="text-danger"><?php echo $error['gender']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                        <?php if (isset($error['phone'])): ?>
                            <div class="text-danger"><?php echo $error['phone']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="country">Country:</label>
                        <select name="country" class="form-control">
                            <option value="">Select Country</option>
                            <option value="America" <?php echo (isset($country) && $country == 'Country1') ? 'selected' : ''; ?>>America</option>
                            <option value="Pakistan" <?php echo (isset($country) && $country == 'Country2') ? 'selected' : ''; ?>>Pakistan</option>
                            <option value="China" <?php echo (isset($country) && $country == 'Country2') ? 'selected' : ''; ?>>China</option>
                            <option value="Viet nam" <?php echo (isset($country) && $country == 'Country2') ? 'selected' : ''; ?>>Viet nam</option>
                            <option value="Japan" <?php echo (isset($country) && $country == 'Country2') ? 'selected' : ''; ?>>Japan</option>
                            <option value="Thailand" <?php echo (isset($country) && $country == 'Country2') ? 'selected' : ''; ?>>Thailand</option>
                        </select>
                        <?php if (isset($error['country'])): ?>
                            <div class="text-danger"><?php echo $error['country']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="pass">Password:</label>
                        <input type="password" name="pass" class="form-control">
                        <?php if (isset($error['pass'])): ?>
                            <div class="text-danger"><?php echo $error['pass']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="con_pass">Confirm Password:</label>
                        <input type="password" name="con_pass" class="form-control">
                        <?php if (isset($error['con_pass'])): ?>
                            <div class="text-danger"><?php echo $error['con_pass']; ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="apply" class="btn btn-primary btn-block">Apply</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>