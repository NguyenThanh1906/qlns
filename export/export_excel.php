<?php
include "db.php";
include "salary_helper.php";

$month = $_GET['month'] ?? date('m');
$year  = $_GET['year']  ?? date('Y');
$days  = cal_days_in_month(CAL_GREGORIAN, $month, $year);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=bang_luong_{$month}_{$year}.xls");

echo "<meta charset='utf-8'>";
echo "<table border='1'>
<tr>
<th>Nhân viên</th>
<th>Tổng công</th>
<th>Số ngày nghỉ</th>
<th>Giải thích lương</th>
<th>Lương thực nhận</th>
</tr>";

$employees = $conn->query("SELECT * FROM employees");

while ($e = $employees->fetch_assoc()) {

    // tính tổng công
    $sum = $conn->query("
        SELECT SUM(work_value) t
        FROM attendance
        WHERE employee_id={$e['id']}
        AND MONTH(work_date)=$month
        AND YEAR(work_date)=$year
    ")->fetch_assoc();

    $total = floatval($sum['t']);
    $salaryMonth = intval($e['salary_month']);

    $result = calculateSalary(
        $salaryMonth,
        $total,
        $days,
        2,
        0
    );

    echo "<tr>
        <td>{$e['name']}</td>
        <td>{$total}</td>
        <td>{$result['leave_days']}</td>
        <td>{$result['note']}</td>
        <td><b>".number_format($result['final_salary'])."</b></td>
    </tr>";
}

echo "</table>";
