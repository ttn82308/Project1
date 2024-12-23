<?php 
session_start();
include("../include/header.php");
include("../include/connection.php");

// Xử lý phân trang
$records_per_page = 30;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$sql_total = "SELECT COUNT(*) AS total FROM thuoc";
$result_total = mysqli_query($connect, $sql_total);
$total_rows = mysqli_fetch_assoc($result_total)['total'];
$total_pages = ceil($total_rows / $records_per_page);

$query = "SELECT * FROM thuoc LIMIT $records_per_page OFFSET $offset";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quản lý thuốc</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dashboard-card {
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
        }
        .dashboard-icon:hover {
            transform: scale(1.1);
            transition: 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2" style="margin-left:-30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <!-- Main Content -->
            <div class="col-md-10">
                <h4 class="my-2">Danh sách thuốc</h4>
                <a href="add_thuoc.php" class="btn btn-success mb-3">Thêm thuốc</a>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên thuốc</th>
                            <th>Cách sử dụng</th>
                            <th>Đơn vị</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr id='row-{$row['id']}'>
                                <td>{$row['id']}</td>
                                <td>{$row['ten_thuoc']}</td>
                                <td>{$row['cach_su_dung']}</td>
                                <td>{$row['don_vi']}</td>
                                <td>{$row['gia']}</td>
                                <td>
                                    <a href='edit_thuoc.php?id={$row['id']}' class='btn btn-primary'>Chỉnh sửa</a>
                                    <form method='post' class='d-inline' action='delete_thuoc.php'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' class='btn btn-danger' onclick=\"return confirm('Bạn có chắc chắn muốn xóa thuốc này?');\">Xóa</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Phân trang -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="manage_thuoc.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='manage_thuoc.php?page=$i'>$i</a></li>";
                        }
                        ?>
                        <?php if ($page < $total_pages) { ?>
                            <li class="page-item">
                                <a class="page-link" href="manage_thuoc.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
