<?php
include "../db.php";
include "../salary_helper.php";

// ================== NHẬN THAM SỐ ==================
$employee_id = isset($_GET['emp']) ? intval($_GET['emp']) : 0;
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year  = isset($_GET['year'])  ? intval($_GET['year'])  : date('Y');

// ================== KIỂM TRA ==================
if ($employee_id <= 0) {
    die("❌ Thiếu nhân viên");
}

// ================== LẤY NHÂN VIÊN ==================
$sqlEmp = "SELECT * FROM employees WHERE id = $employee_id";
$resEmp = $conn->query($sqlEmp);

if (!$resEmp || $resEmp->num_rows == 0) {
    die("❌ Không tìm thấy nhân viên");
}

$emp = $resEmp->fetch_assoc();

// ================== THÁNG ==================
$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// ================== CHẤM CÔNG ==================
$total = 0;
$attendance = [];

for ($d = 1; $d <= $days; $d++) {
    $date = sprintf("%04d-%02d-%02d", $year, $month, $d);

    $r = $conn->query("
        SELECT work_value 
        FROM attendance
        WHERE employee_id = $employee_id
        AND work_date = '$date'
    ");

    $val = ($r && $r->num_rows > 0)
        ? floatval($r->fetch_assoc()['work_value'])
        : 0;

    $attendance[$date] = $val;
    $total += $val;
}

// ================== TÍNH LƯƠNG ==================
$result = calculateSalary(
    intval($emp['salary_month']),
    $total,
    $days,
    2,
    0
);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Phiếu lương <?= htmlspecialchars($emp['name']) ?></title>
<style>
body { font-family:Arial; background:#f7f7f7 }
.box { background:#fff; padding:20px; width:700px; margin:auto }
table { border-collapse:collapse; width:100%; margin-top:10px }
th,td { border:1px solid #ccc; padding:6px; text-align:center }
.total { font-weight:bold; color:green; font-size:18px }
.note { font-size:13px; color:#555; background:#eee; padding:10px }
</style>
</head>
<body>

<div class="box">
<h2>📄 PHIẾU LƯƠNG THÁNG <?= "$month/$year" ?></h2>

<b>👤 Nhân viên:</b> <?= htmlspecialchars($emp['name']) ?><br>
<b>💰 Lương cơ bản:</b> <?= number_format($emp['salary_month'],0,",",".") ?> đ<br>
<b>📅 Số ngày trong tháng:</b> <?= $days ?><br>
<b>🕒 Tổng công:</b> <?= number_format($total,1) ?>

<hr>

<b>📊 Chi tiết tính lương</b>
<div class="note">
<?= nl2br($result['note']) ?>
</div>

<hr>

<b>💵 LƯƠNG THỰC NHẬN:</b>
<span class="total">
<?= number_format($result['final_salary'],0,",",".") ?> đ
</span>

<h3>📋 Chi tiết chấm công</h3>
<table>
<tr>
    <th>Ngày</th>
    <th>Công</th>
</tr>
<?php foreach ($attendance as $date=>$val): ?>
<tr>
    <td><?= $date ?></td>
    <td><?= $val ?></td>
</tr>
<?php endforeach; ?>
</table>

<br>
<button onclick="window.print()">🖨 In phiếu lương</button>
<a href="../payroll/payroll_list.php?month=<?= $month ?>&year=<?= $year ?>">
⬅ Quay lại bảng lương
</a>
</div>

</body>
</html>
