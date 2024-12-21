<?php 
session_start();
include("../include/header.php");
include("../include/connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
</head>
<body>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center">Edit Doctor</h5>
                <?php 
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $id = intval($_GET['id']);

                    $stmt = $connect->prepare("SELECT * FROM doctor WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    } else {
                        echo "<p class='text-danger'>Doctor not found.</p>";
                        exit;
                    }
                } else {
                    echo "<p class='text-danger'>Invalid doctor ID.</p>";
                    exit;
                }
                ?>

                <div class="row">
                    <div class="col-md-8">
                        <h5 class="text-center">Doctor Details</h5>
                        <h5 class="col-md-3">ID: <?php echo htmlspecialchars($row['id']); ?></h5>
                        <h5 class="col-md-3">Firstname: <?php echo htmlspecialchars($row['firstname']); ?></h5>
                        <h5 class="col-md-3">Surname: <?php echo htmlspecialchars($row['surname']); ?></h5>
                        <h5 class="col-md-3">Username: <?php echo htmlspecialchars($row['username']); ?></h5>
                        <h5 class="col-md-3">Phone: <?php echo htmlspecialchars($row['phone']); ?></h5>
                        <h5 class="col-md-3">Country: <?php echo htmlspecialchars($row['country']); ?></h5>
                        <h5 class="col-md-3">Salary: $<?php echo htmlspecialchars($row['salary']); ?></h5>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-center">Update Salary</h5>
                        <?php 
                        if (isset($_POST['update'])) {
                            $salary = trim($_POST['salary']);

                            if (!is_numeric($salary) || $salary <= 0) {
                                echo "<p class='text-danger'>Invalid salary amount. Please enter a positive number.</p>";
                            } else {
                                $stmt = $connect->prepare("UPDATE doctor SET salary = ? WHERE id = ?");
                                $stmt->bind_param("di", $salary, $id);

                                if ($stmt->execute()) {
                                    echo "<p class='text-success'>Salary updated successfully!</p>";
                                } else {
                                    echo "<p class='text-danger'>Failed to update salary.</p>";
                                }
                            }
                        }
                        ?>
                        <form method="post">
                            <label for="salary">Enter Doctor Salary</label>
                            <input type="number" id="salary" name="salary" class="form-control" placeholder="Enter Doctor Salary" 
                                value="<?php echo htmlspecialchars($row['salary']); ?>" required>
                            <input type="submit" name="update" class="btn btn-info my-3" value="Update Salary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
