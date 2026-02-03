<?php
include "db.php";
include "salary_helper.php";

$year = intval($_GET['year'] ?? date('Y'));

// thống kê tổng
$totalSalaryYear = 0;
$totalEmployees  = $conn->query("SELECT COUNT(*) c FROM employees")
                         ->fetch_assoc()['c'];

// chuẩn bị dữ liệu theo tháng
$monthly = [];

for ($m=1; $m<=12; $m++) {
    $days = cal_days_in_month(CAL_GREGORIAN, $m, $year);
    $sumSalary = 0;

    $employees = $conn->query("SELECT * FROM employees");

    while ($e = $employees->fetch_assoc()) {
        // tổng công tháng
        $total = 0;
        for ($d=1; $d<=$days; $d++) {
            $date = "$year-$m-" . str_pad($d,2,"0",STR_PAD_LEFT);
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

        $sumSalary += $result['final_salary'];
    }

    $monthly[$m] = $sumSalary;
    $totalSalaryYear += $sumSalary;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard lương <?= $year ?></title>
<style>
body { font-family:Arial }
.box {
    display:inline-block;
    padding:15px;
    margin:10px;
    border-radius:8px;
    background:#f4f4f4;
    min-width:220px;
    text-align:center;
}
.big { font-size:22px; font-weight:bold }
table { border-collapse:collapse; width:60%; margin-top:20px }
th,td { border:1px solid #ccc; padding:6px; text-align:center }
th { background:#eee }
</style>
</head>
<body>

<h2>📊 DASHBOARD LƯƠNG NĂM <?= $year ?></h2>

<form method="get">
    Năm:
    <select name="year">
        <?php for($y=date('Y')-3;$y<=date('Y')+1;$y++): ?>
        <option value="<?= $y ?>" <?= ($y==$year?'selected':'') ?>>
            <?= $y ?>
        </option>
        <?php endfor; ?>
    </select>
    <button>📅 Xem</button>
</form>

<div>
<div class="box">
    👥 Nhân viên<br>
    <span class="big"><?= $totalEmployees ?></span>
</div>

<div class="box">
    💰 Tổng lương năm<br>
    <span class="big">
        <?= number_format($totalSalaryYear,0,",",".") ?> đ
    </span>
</div>
</div>

<h3>📅 Lương theo tháng</h3>
<table>
<tr>
<th>Tháng</th>
<th>Tổng lương</th>
<th>Chi tiết</th>
</tr>

<?php foreach ($monthly as $m=>$salary): ?>
<tr>
<td><?= $m ?>/<?= $year ?></td>
<td style="font-weight:bold;color:green">
<?= number_format($salary,0,",",".") ?> đ
</td>
<td>
<a href="payroll/payroll_list.php?month=<?= $m ?>&year=<?= $year ?>">
📋 Xem bảng lương
</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<br>
<a href="index.php">⬅ Quay lại chấm công</a>

</body>
</html>
