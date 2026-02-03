<?php
include "db.php";
include "salary_helper.php";

/**
 * Tháng / năm đang xem
 */

$month = $_GET['month'] ?? date('m');
$year  = $_GET['year'] ?? date('Y');
$days  = cal_days_in_month(CAL_GREGORIAN, $month, $year);
function getThu($date) {
    $thu = (int) date('N', strtotime($date)); // ÉP KIỂU INT
    return match ($thu) {
        1 => 'T2',
        2 => 'T3',
        3 => 'T4',
        4 => 'T5',
        5 => 'T6',
        6 => 'T7',
        7 => 'CN',
    };
}
/**
 * Kiểm tra tháng đã chốt chưa
 */
$locked = $conn->query("
    SELECT 1 FROM payroll_lock 
    WHERE month=$month AND year=$year
")->num_rows > 0;

/**
 * Lấy nhân viên
 */
$employees = $conn->query("SELECT * FROM employees ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bảng chấm công & lương tháng</title>
<link rel="stylesheet" href="css/main.css">
 
</head>
<body>
    
<div class="page-header">
    <div class="title">
    <h2>📋 CHẤM CÔNG & TÍNH LƯƠNG THÁNG <?= "$month/$year" ?></h2>
</div>

<!-- CHỌN THÁNG -->
<div class="filter">
<form method="get">
    Tháng:
    <select name="month">
        <?php for($m=1;$m<=12;$m++): ?>
            <option value="<?= $m ?>" <?= ($m==$month?'selected':'') ?>><?= $m ?></option>
        <?php endfor; ?>
    </select>

    Năm:
    <select name="year">
        <?php for($y=date('Y')-1;$y<=date('Y')+1;$y++): ?>
            <option value="<?= $y ?>" <?= ($y==$year?'selected':'') ?>><?= $y ?></option>
        <?php endfor; ?>
    </select>

     <button type="submit">📅 Xem</button>
</form>
</div>

<!-- CHỐT LƯƠNG -->
<div style="margin-bottom:15px">
<?php if(!$locked): ?>
    <form method="post" action="payroll/lock_month.php"
          onsubmit="return confirm('Chốt lương tháng <?= "$month/$year" ?>?')">
        <input type="hidden" name="month" value="<?= $month ?>">
        <input type="hidden" name="year" value="<?= $year ?>">
        <button style="background:#faa">🔒 Chốt lương</button>
    </form>
<?php else: ?>
    <span class="lock">⛔ Tháng đã chốt lương</span>
    <form method="post" action="payroll/unlock_month.php" style="display:inline"
          onsubmit="return confirm('Mở chốt tháng <?= "$month/$year" ?>?')">
        <input type="hidden" name="month" value="<?= $month ?>">
        <input type="hidden" name="year" value="<?= $year ?>">
        <button style="background:#cfc">🔓 Mở chốt</button>
    </form>
<?php endif; ?>
</div>

<!-- MENU -->
<div class="menu">
    <a href="employees.php">👥 Nhân viên</a>
    <a href="export/export_salary_excel.php?month=<?= $month ?>&year=<?= $year ?>">⬇ Xuất lương</a>
    <a href="dashboard.php">📊 Dashboard</a>
</div>

<br><br>

<!-- CHÚ THÍCH -->
<div class="note-box">
<b>📌 Quy ước:</b>
Nghỉ | 0.5 = 1 ca | 1 = 2 ca | 1.5 = OT
</div>


<br>

<div class="attendance-table">

    <!-- ===== CỘT NHÂN VIÊN (CỐ ĐỊNH) ===== -->
    <table class="fixed-left">
        <tr>
            <th class="emp-col diagonal">
                <div class="diagonal">
                    <span class="top">Ngày</span>
                    <span class="bottom">Nhân viên</span>
                </div>
            </th>
        </tr>
      
        <?php
        mysqli_data_seek($employees, 0);
        while($e = $employees->fetch_assoc()):
        ?>
        <tr>
            <td class="emp-col"><?= htmlspecialchars($e['name']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>


    <!-- ===== PHẦN NGÀY (KÉO NGANG) ===== -->
    <div class="scroll-days">
        <table class="days-table">

            <!-- HEADER NGÀY + THỨ -->
            <tr>
            <?php for($d=1;$d<=$days;$d++):
                $date = "$year-$month-" . str_pad($d,2,"0",STR_PAD_LEFT);
            ?>
                <th>
                    <div class="day-box">
                        <div class="day"><?= $d ?></div>
                        <div class="dow"><?= getThu($date) ?></div>
                    </div>
                </th>
            <?php endfor; ?>
            </tr>
        
            <!-- DỮ LIỆU CÔNG -->
            <?php
            mysqli_data_seek($employees, 0);
            while($e = $employees->fetch_assoc()):
            ?>
            <tr>
                <?php for($d=1;$d<=$days;$d++):
                    $date = "$year-$month-" . str_pad($d,2,"0",STR_PAD_LEFT);

                    $r = $conn->query("
                        SELECT work_value FROM attendance
                        WHERE employee_id={$e['id']} AND work_date='$date'
                    ");
                    $val = $r->num_rows ? floatval($r->fetch_assoc()['work_value']) : "";

                    $class = "off";
                    if ($val==0.5) $class="half";
                    elseif ($val==1) $class="full";
                    elseif ($val==1.5) $class="ot";
                ?>
                <td class="work <?= $class ?>"
                    <?php if(!$locked): ?>
                    onclick="editCell(this,<?= $e['id'] ?>,'<?= $date ?>')"
                    <?php endif; ?>
                >
                    <?= $val ?: "" ?>
                </td>
                <?php endfor; ?>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>


    <!-- ===== CỘT PHẢI: TỔNG + LƯƠNG ===== -->
    <table class="fixed-right">
        <tr>
            <th>Tổng công</th>
            <th>Lương thực nhận</th>
        </tr>
       
        <?php
        mysqli_data_seek($employees, 0);
        while($e = $employees->fetch_assoc()):
            $total = 0;

            for ($d=1;$d<=$days;$d++) {
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
            <td><b><?= number_format($total,1) ?></b></td>
            <td class="salary">
                <?= number_format($result['final_salary'],0,",",".") ?> đ
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>

<script>
function editCell(td, emp, date){
    let c = td.innerText.trim();
    let n = "";
    if(c==="") n="0.5";
    else if(c==="0.5") n="1";
    else if(c==="1") n="1.5";
    else n="";

   fetch("attendance/update_attendance.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:`employee_id=${emp}&date=${date}&value=${n}`
    }).then(()=>location.reload());
}
</script>

</body>
</html>
