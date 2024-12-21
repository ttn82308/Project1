<?php 

include("../include/connection.php");

$query = "SELECT * FROM doctor WHERE status='Pendding' ORDER BY data_reg ASC";
$res = mysqli_query($connect, $query);

$output = "";

$output .= "
<table class='table table-bordered'>
    <tr>
        <th>ID</th>
        <th>Firstname</th>
        <th>Surname</th>
        <th>Username</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Country</th>
        <th>Data Register</th>
        <th>Action</th>
    </tr>
";

if (mysqli_num_rows($res) < 1) {
    $output .= "
        <tr>
            <td colspan='9'>No Job request.</td>
        </tr>
    ";
} else {
    while ($row = mysqli_fetch_assoc($res)) {
        $output .= "
        <tr>
            <td>".htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($row['surname'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($row['data_reg'], ENT_QUOTES, 'UTF-8')."</td>
            <td>
                <div class='row'>
                    <div class='col-md-6'>
                        <button data-id='".htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8')."' class='btn btn-success approve'>Approve</button>
                    </div>
                    <div class='col-md-6'>
                        <button data-id='".htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8')."' class='btn btn-danger reject'>Reject</button>
                    </div>
                </div>
            </td>
        </tr>
        ";
    }
}

$output .= "</table>";
echo $output;

?>

<!-- Thêm đoạn JavaScript xử lý sự kiện nút -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Xử lý nút Approve
        $(".approve").click(function () {
            let id = $(this).data("id");

            $.ajax({
                url: "process_request.php", // Tệp PHP xử lý yêu cầu
                method: "POST",
                data: { id: id, action: "approve" },
                success: function (response) {
                    alert(response); // Thông báo kết quả
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                },
                error: function () {
                    alert("Error processing request.");
                }
            });
        });

        // Xử lý nút Reject
        $(".reject").click(function () {
            let id = $(this).data("id");

            $.ajax({
                url: "process_request.php", // Tệp PHP xử lý yêu cầu
                method: "POST",
                data: { id: id, action: "reject" },
                success: function (response) {
                    alert(response); // Thông báo kết quả
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                },
                error: function () {
                    alert("Error processing request.");
                }
            });
        });
    });
</script>
