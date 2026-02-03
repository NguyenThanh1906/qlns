<?php
include "../db.php";
include "../salary_helper.php";

$month = intval($_GET['month'] ?? date('m'));
$year  = intval($_GET['year'] ?? date('Y'));
$days  = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// kiểm tra đã chốt chưa (KHÔNG DÙNG id)
$locked = $conn->query("
    SELECT 1 FROM payroll_lock
    WHERE month=$month AND year=$year
")->num_rows > 0;

// danh sách nhân viên
$employees = $conn->query("SELECT * FROM employees ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bảng lương <?= "$month/$year" ?></title>
<style>
body { font-family:Arial }
table { border-collapse:collapse; width:100% }
th,td { border:1px solid #ccc; padding:6px; text-align:center }
.locked { color:red; font-weight:bold }
.open { color:green; font-weight:bold }
</style>
</head>
<body>

<h2>📋 BẢNG LƯƠNG THÁNG <?= "$month/$year" ?></h2>

<p>
Trạng thái:
<?= $locked ? '<span class="locked">🔒 Đã chốt lương</span>' : '<span class="open">🟢 Chưa chốt</span>' ?>
</p>

<table>
<tr>
<th>Nhân viên</th>
<th>Lương tháng</th>
<th>Tổng công</th>
<th>Lương thực nhận</th>
<th>Chi tiết</th>
</tr>

<?php while($e = $employees->fetch_assoc()): ?>
<?php
$total = 0;
for ($d=1; $d<=$days; $d++) {
    $date = "$year-$month-" . str_pad($d,2,"0",STR_PAD_LEFT);
    $r = $conn->query("
        SELECT work_value FROM attendance
        WHERE employee_id={$e['id']} AND work_date='$date'
    ");
    if ($r->num_rows) {
        $total += floatval($r->fetch_assoc()['work_value']);
    }
}

$result = calculateSalary(
    intval($e['salary_month']),
    $total,
    $days,
    2,
    0
);
?>
<tr>
<td><?= htmlspecialchars($e['name']) ?></td>
<td><?= number_format($e['salary_month'],0,",",".") ?> đ</td>
<td><?= number_format($total,1) ?></td>
<td style="font-weight:bold;color:green">
<?= number_format($result['final_salary'],0,",",".") ?> đ
</td>
<td>
<a href="payroll_detail.php?employee_id=<?= $e['id'] ?>&month=<?= $month ?>&year=<?= $year ?>">
🔍 Xem
</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<br>
<a href="../index.php?month=<?= $month ?>&year=<?= $year ?>">
⬅ Quay lại chấm công
</a>



</body>
</html>
