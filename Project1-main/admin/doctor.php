<?php
session_start(); 
include ("../include/header.php");
include ("../include/connection.php");
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['admin'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: ../adminlogin.php");
    exit();
}
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_term = "%$search%";

$query = "SELECT * FROM doctor WHERE status = 'Approved' AND (firstname LIKE ? OR surname LIKE ?) 
          ORDER BY data_reg ASC LIMIT ? OFFSET ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("ssii", $search_term, $search_term, $limit, $offset);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center">Danh sách bác sĩ</h5>
                <form method="GET">
                    <input type="text" name="search" placeholder="Search by name..." class="form-control mb-3"
                           value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                <?php if ($res->num_rows > 0): ?>
                    <table class='table table-bordered table-striped'>
                        <thead>
                        <tr>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Tên tài khoản</th>
                            <th>Giới tính</th>
                            <th>Số điện thoại</th>
                            <th>Quốc tịch</th>
                            <th>Lương</th>
                            <th>Ngày đăng kí</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $res->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['surname'], ENT_QUOTES, 'UTF-8'); ?></td>                                
                                <td><?php echo htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['salary'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['data_reg'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href='edit.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>' 
                                       class='btn btn-info'>Sửa lương</a>
                                    <a href='delete.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>' 
                                         class='btn btn-danger' 
                                            onclick="return confirm('Bạn có muốn xoá không?');">
                                                Xoá
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>


                    <?php
                    $total_query = "SELECT COUNT(*) AS total FROM doctor WHERE status = 'Approved' AND 
                                    (firstname LIKE ? OR surname LIKE ?)";
                    $total_stmt = $connect->prepare($total_query);
                    $total_stmt->bind_param("ss", $search_term, $search_term);
                    $total_stmt->execute();
                    $total_res = $total_stmt->get_result();
                    $total_row = $total_res->fetch_assoc();
                    $total_pages = ceil($total_row['total'] / $limit);
                    ?>

                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" 
                                       class="page-link"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>

                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        Hiện không có bác sĩ.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
