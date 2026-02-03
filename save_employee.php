<?php
include "db.php";

/**
 * Nhận dữ liệu
 */
$id           = $_POST['id'] ?? "";
$name         = trim($_POST['name'] ?? "");
$salary_month = intval($_POST['salary_month'] ?? 0);

if ($name === "" || $salary_month <= 0) {
    die("❌ Dữ liệu không hợp lệ");
}

/**
 * CẬP NHẬT
 */
if ($id !== "") {

    $stmt = $conn->prepare("
        UPDATE employees 
        SET name = ?, salary_month = ?
        WHERE id = ?
    ");
    $stmt->bind_param("sii", $name, $salary_month, $id);
    $stmt->execute();
    $stmt->close();

}
/**
 * THÊM MỚI
 */
else {

    $stmt = $conn->prepare("
        INSERT INTO employees (name, salary_month)
        VALUES (?, ?)
    ");
    $stmt->bind_param("si", $name, $salary_month);
    $stmt->execute();
    $stmt->close();
}

header("Location: employees.php");
exit;
