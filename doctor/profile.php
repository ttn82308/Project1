<?php 
    session_start();
    error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Profile Page</title>
</head>
<body>

<?php 
    include("../include/header.php");
    include("../include/connection.php");
?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php 
                    include("sidenav.php");
                    include("../include/connection.php");
                ?>
            </div>

            <div class="col-md-10">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <?php 
                                    $doc = $_SESSION['doctor'];
                                    $query = "SELECT * FROM doctor WHERE username ='$doc'";
                                    $res = mysqli_query($connect, $query);
                                    $row = mysqli_fetch_array($res);

                                    if (isset($_POST['upload'])) {
                                        $img = $_FILES['img']['name'];
                                        $tmp_name = $_FILES['img']['tmp_name'];
                                        $file_type = $_FILES['img']['type'];

                                        if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/jpg'])) {
                                            echo "Only JPG, PNG, and JPEG files are allowed.";
                                        } else {
                                            $upload_path = "img/$img";
                                            if (move_uploaded_file($tmp_name, $upload_path)) {
                                                $query = "UPDATE doctor SET profile = '$img' WHERE username = '$doc'";
                                                $res = mysqli_query($connect, $query);
                                                if ($res) {
                                                    echo "Profile image updated successfully!";
                                                } else {
                                                    echo "Error updating profile image.";
                                                }
                                            } else {
                                                echo "Error uploading file.";
                                            }
                                        }
                                    }
                                ?>

                                <form method="post" enctype="multipart/form-data">
                                    <?php echo "<img src='img/".$row['profile']."' style='height: 250px;' class='my-3'>"; ?>
                                    <input type="file" name="img" class="form-control my-1">
                                    <input type="submit" name="upload" class="btn btn-success" value="Update Profile">
                                    <div class="my-3">
                                        <table class="table table-bordered">                                     
                                            <tr>
                                                <th colspan="2" class="text-center">Detail</th>
                                            </tr>
                                            <tr>
                                                <td>Firstname</td>
                                                <td><?php echo $row['firstname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Surname</td>
                                                <td><?php echo $row['surname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Username</td>
                                                <td><?php echo $row['username']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td><?php echo $row['email']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Phone No.</td>
                                                <td><?php echo $row['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Gender</td>
                                                <td><?php echo $row['gender']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Country</td>
                                                <td><?php echo $row['country']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Salary</td>
                                                <td><?php echo "$" . $row['salary']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-center my-2">Change Username</h5>
                                <?php 
                                    if (isset($_POST['change_uname'])) {
                                        $uname = $_POST['uname'];
                                        if (!empty($uname)) {
                                            $query = "UPDATE doctor SET username='$uname' WHERE username ='$doc'";
                                            $res = mysqli_query($connect, $query);
                                            if ($res) {
                                                $_SESSION['doctor'] = $uname;
                                            }
                                        }
                                    }
                                ?>
                                <form method="post">
                                    <label>Change Username</label>
                                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username"><br>
                                    <input type="submit" name="change_uname" class="btn btn-success" value="Change Username">
                                </form>
                                <br><br>

                                <h5 class="text-center my-2">Change Password</h5>

                                <?php 
                                    if (isset($_POST['change_pass'])) {
                                        $old = $_POST['old_pass'];
                                        $new = $_POST['new_pass'];
                                        $con = $_POST['con_pass'];

                                        $query = "SELECT * FROM doctor WHERE username = '$doc'";
                                        $result = mysqli_query($connect, $query);
                                        $row = mysqli_fetch_array($result);

                                        if (!password_verify($old, $row['password'])) {
                                            echo "Old password is incorrect.";
                                        } elseif (empty($new)) {
                                            echo "New password cannot be empty.";
                                        } elseif ($new != $con) {
                                            echo "New password and confirmation do not match.";
                                        } else {
                                            $new_hashed = password_hash($new, PASSWORD_DEFAULT);
                                            $update_query = "UPDATE doctor SET password = '$new_hashed' WHERE username = '$doc'";
                                            mysqli_query($connect, $update_query);
                                            echo "Password changed successfully!";
                                        }
                                    }
                                ?>

                                <form method="post">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_pass" class="form-control" autocomplete="off" placeholder="Enter Old Password">
                                    </div>

                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="new_pass" class="form-control" autocomplete="off" placeholder="Enter New Password">
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Enter Confirm Password">
                                    </div>
                                    <input type="submit" name="change_pass" class="btn btn-info" value="Change Password">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
