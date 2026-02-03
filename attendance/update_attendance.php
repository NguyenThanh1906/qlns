<?php
include "../db.php";

$employee_id = intval($_POST['employee_id']);
$date = $_POST['date'];
$value = $_POST['value'] === "" ? NULL : floatval($_POST['value']);

$month = intval(date('m', strtotime($date)));
$year  = intval(date('Y', strtotime($date)));

/* 🔒 KIỂM TRA THÁNG ĐÃ CHỐT CHƯA */
$locked = $conn->query("
    SELECT 1 FROM payroll_lock
    WHERE month = $month AND year = $year
")->num_rows > 0;

if ($locked) {
    http_response_code(403);
    exit("Tháng đã chốt lương");
}

/* GHI / UPDATE CÔNG */
$conn->query("
    INSERT INTO attendance (employee_id, work_date, work_value)
    VALUES ($employee_id, '$date', ".($value===NULL?'NULL':$value).")
    ON DUPLICATE KEY UPDATE work_value = ".($value===NULL?'NULL':$value)."
");
