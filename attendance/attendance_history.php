<?php
include "../db.php";

$employee_id = $_GET['employee_id'] ?? "";
$month = $_GET['month'] ?? date('m');
$year  = $_GET['year'] ?? date('Y');
$days  = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// danh sách nhân viên
$employees = $conn->query("SELECT * FROM employees");

// thông tin nhân viên được chọn
$employee = null;
if ($employee_id) {
    $r = $conn->query("SELECT * FROM employees WHERE id=".(int)$employee_id);
    $employee = $r->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Lịch sử chấm công</title>
<style>
table { border-collapse:collapse; width:100% }
th,td { border:1px solid #ccc; padding:6px; text-align:center }
.off  { background:#f7c5c5 }
.half { background:#e6f7c5 }
.full { background:#c8f7c5 }
.ot   { background:#c5e1f7; font-weight:bold }
</style>
</head>
<body>

<h2>📅 LỊCH SỬ CHẤM CÔNG</h2>

<form method="get" style="margin-bottom:15px">
Nhân viên:
<select name="employee_id" required>
    <option value="">-- Chọn nhân viên --</option>
    <?php while($e=$employees->fetch_assoc()): ?>
        <option value="<?= $e['id'] ?>"
            <?= ($employee_id==$e['id']?'selected':'') ?>>
            <?= htmlspecialchars($e['name']) ?>
        </option>
    <?php endwhile; ?>
</select>

Tháng:
<select name="month">
<?php for($m=1;$m<=12;$m++): ?>
<option value="<?= $m ?>" <?= ($m==$month?'selected':'') ?>>
    <?= $m ?>
</option>
<?php endfor; ?>
</select>

Năm:
<select name="year">
<?php for($y=date('Y')-2;$y<=date('Y')+1;$y++): ?>
<option value="<?= $y ?>" <?= ($y==$year?'selected':'') ?>>
    <?= $y ?>
</option>
<?php endfor; ?>
</select>

<button>🔍 Xem</button>
</form>

<?php if($employee): ?>

<h3>👤 <?= htmlspecialchars($employee['name']) ?> — <?= "$month/$year" ?></h3>

<table>
<tr>
<?php for($d=1;$d<=$days;$d++): ?>
<th><?= $d ?></th>
<?php endfor; ?>
<th>Tổng công</th>
</tr>

<tr>
<?php
$total = 0;
for ($d=1; $d<=$days; $d++):
    $date = "$year-$month-".str_pad($d,2,"0",STR_PAD_LEFT);
    $r = $conn->query("
        SELECT work_value FROM attendance
        WHERE employee_id={$employee['id']}
        AND work_date='$date'
    ");
    $val = $r->num_rows ? floatval($r->fetch_assoc()['work_value']) : 0;
    $total += $val;

    if ($val==0.5) $class="half";
    elseif ($val==1) $class="full";
    elseif ($val==1.5) $class="ot";
    else $class="off";
?>
<td class="<?= $class ?>">
<?= $val ?: "" ?>
</td>
<?php endfor; ?>

<td><b><?= number_format($total,1) ?></b></td>
</tr>
</table>

<?php endif; ?>

<br>
<a href="../index.php">⬅ Quay lại chấm công</a>

</body>
</html>
