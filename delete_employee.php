<?php
include "db.php";

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    die("ID nhân viên không hợp lệ");
}

// (tuỳ chọn) kiểm tra có dữ liệu chấm công không
$hasAttendance = $conn->query("
    SELECT id FROM attendance WHERE employee_id = $id
")->num_rows > 0;

if ($hasAttendance) {
    // nếu muốn CHẶN xoá khi đã có công
    // die("Nhân viên đã có dữ liệu chấm công, không thể xoá");

    // hoặc xoá luôn công (đang dùng cách này)
    $conn->query("DELETE FROM attendance WHERE employee_id = $id");
}

// xoá nhân viên
$conn->query("DELETE FROM employees WHERE id = $id");

// quay lại trang nhân viên
header("Location: employees.php");
exit;
