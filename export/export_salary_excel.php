<?php
include "../db.php";
include "../salary_helper.php";

$month = intval($_GET['month'] ?? date('m'));
$year  = intval($_GET['year'] ?? date('Y'));

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=bang_luong_$month-$year.xls");

echo "<table border='1'>";
echo "<tr>
        <th>Nhân viên</th>
        <th>Tổng công</th>
        <th>Giải thích</th>
        <th>Lương thực nhận</th>
      </tr>";

$employees = $conn->query("SELECT * FROM employees ORDER BY name");

while ($e = $employees->fetch_assoc()) {

    // tính tổng công
    $total = 0;
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    for ($d = 1; $d <= $days; $d++) {
        $date = "$year-$month-" . str_pad($d, 2, "0", STR_PAD_LEFT);
        $r = $conn->query("
            SELECT work_value FROM attendance
            WHERE employee_id = {$e['id']} AND work_date = '$date'
        ");
        if ($r->num_rows) {
            $total += floatval($r->fetch_assoc()['work_value']);
        }
    }

    // tính lương
    $result = calculateSalary(
        intval($e['salary_month']),
        $total,
        $days,
        2,
        0
    );

    echo "<tr>";
    echo "<td>".htmlspecialchars($e['name'])."</td>";
    echo "<td>$total</td>";
    echo "<td>".nl2br($result['note'])."</td>";
    echo "<td>".number_format($result['final_salary'],0,",",".")."</td>";
    echo "</tr>";
}

echo "</table>";
