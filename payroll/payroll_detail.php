<?php
include "../db.php";
include "../salary_helper.php";

$employee_id = intval($_GET['employee_id'] ?? 0);
$month = intval($_GET['month'] ?? date('m'));
$year  = intval($_GET['year'] ?? date('Y'));

if ($employee_id <= 0) {
    die("Thiếu nhân viên");
}

$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// lấy thông tin nhân viên
$emp = $conn->query("
    SELECT * FROM employees WHERE id = $employee_id
")->fetch_assoc();

if (!$emp) {
    die("Nhân viên không tồn tại");
}

// tổng công & danh sách ngày nghỉ
$totalWork = 0;
$leaveDates = [];

for ($d = 1; $d <= $days; $d++) {
    $date = "$year-$month-" . str_pad($d, 2, "0", STR_PAD_LEFT);

    $r = $conn->query("
        SELECT work_value FROM attendance
        WHERE employee_id = $employee_id AND work_date = '$date'
    ");

    if ($r->num_rows) {
        $val = floatval($r->fetch_assoc()['work_value']);
        $totalWork += $val;
    } else {
        $leaveDates[] = $date;
    }
}

// tính lương theo quy định khách sạn
$result = calculateSalary(
    intval($emp['salary_month']),
    $totalWork,
    $days,
    2, // 2 ngày phép / tháng
    0  // thưởng lễ sẽ cộng riêng sau
);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Phiếu lương <?= htmlspecialchars($emp['name']) ?></title>
<style>
body { font-family:Arial; }
.box { border:1px solid #ccc; padding:15px; width:600px }
h2 { margin-top:0 }
table { width:100%; border-collapse:collapse }
td { padding:6px }
.label { color:#555 }
.value { font-weight:bold }
.note { background:#f9f9f9; padding:10px; margin-top:10px }
</style>
</head>
<body>

<div class="box">
<h2>📄 PHIẾU LƯƠNG THÁNG <?= "$month/$year" ?></h2>

<table>
<tr>
<td class="label">Nhân viên</td>
<td class="value"><?= htmlspecialchars($emp['name']) ?></td>
</tr>

<tr>
<td class="label">Lương tháng</td>
<td class="value"><?= number_format($emp['salary_month'],0,",",".") ?> đ</td>
</tr>

<tr>
<td class="label">Tổng công</td>
<td class="value"><?= number_format($totalWork,1) ?></td>
</tr>

<tr>
<td class="label">Ngày phép</td>
<td class="value">2 ngày / tháng</td>
</tr>

<tr>
<td class="label">Ngày nghỉ thực tế</td>
<td class="value"><?= count($leaveDates) ?> ngày</td>
</tr>

<tr>
<td class="label">Lương thực nhận</td>
<td class="value" style="color:green">
<?= number_format($result['final_salary'],0,",",".") ?> đ
</td>
</tr>
</table>

<div class="note">
<b>🧾 Giải thích lương</b><br>
<?= $result['note'] ?>
</div>

<?php if(count($leaveDates) > 0): ?>
<div class="note">
<b>📅 Ngày nghỉ:</b><br>
<?= implode(", ", $leaveDates) ?>
</div>
<?php endif; ?>

<br>
<a href="../index.php?month=<?= $month ?>&year=<?= $year ?>">
⬅ Quay lại chấm công
</a>

</div>

</body>
</html>
