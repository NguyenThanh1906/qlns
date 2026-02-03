<?php
// db.php – Kết nối database

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";        // XAMPP mặc định rỗng
$DB_NAME = "qlns";    // tên database của bạn

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// kiểm tra lỗi
if ($conn->connect_error) {
    die("❌ Kết nối CSDL thất bại: " . $conn->connect_error);
}

// set charset UTF-8
$conn->set_charset("utf8mb4");
