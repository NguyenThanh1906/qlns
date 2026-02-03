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

// 🔒 kiểm tra đã chốt chưa
$check = $conn->query("
    SELECT 1 FROM payroll_lock
    WHERE month = $month AND year = $year
");

if ($check && $check->num_rows > 0) {
    // đã chốt rồi
    header("Location: ../index.php?month=$month&year=$year");
    exit;
}

// ✅ chốt lương
$conn->query("
    INSERT INTO payroll_lock (month, year, locked_at)
    VALUES ($month, $year, NOW())
");

header("Location: ../index.php?month=$month&year=$year");
exit;
