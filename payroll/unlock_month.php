<?php
include "../db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Method not allowed");
}

$month = intval($_POST['month'] ?? 0);
$year  = intval($_POST['year'] ?? 0);

if ($month < 1 || $month > 12 || $year < 2000) {
    die("Dữ liệu không hợp lệ");
}

// 🔓 mở chốt lương
$conn->query("
    DELETE FROM payroll_lock
    WHERE month = $month AND year = $year
");

// quay về bảng chấm công
header("Location: ../index.php?month=$month&year=$year");
exit;
