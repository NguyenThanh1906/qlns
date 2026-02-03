<?php
/**
 * Tính lương theo quy định khách sạn
 *
 * @param int   $salaryMonth    Lương cố định theo tháng
 * @param float $totalWork      Tổng công (vd: 26.5)
 * @param int   $daysInMonth    Tổng số ngày trong tháng
 * @param int   $allowedLeave   Số ngày phép/tháng (mặc định 2)
 * @param int   $holidayBonus   Thưởng lễ tết (nếu có)
 *
 * @return array
 */
function calculateSalary(
    int $salaryMonth,
    float $totalWork,
    int $daysInMonth,
    int $allowedLeave = 2,
    int $holidayBonus = 0
) {
    // 1 ngày = 1.0 công
    $workedDays = floor($totalWork);   // số ngày làm tròn
    $leaveDays  = $daysInMonth - $workedDays;

    // tiền lương 1 ngày (chỉ dùng để quy đổi)
    $salaryPerDay = $salaryMonth / $daysInMonth;

    $note = "";
    $finalSalary = $salaryMonth;

    // ===== LOGIC KHÁCH SẠN =====
    if ($leaveDays <= 0) {
        // không nghỉ ngày nào → thưởng 2 ngày công
        $bonus = $allowedLeave * $salaryPerDay;
        $finalSalary = $salaryMonth + $bonus;

        $note = "Không nghỉ ngày nào → thưởng {$allowedLeave} ngày công";

    } elseif ($leaveDays <= $allowedLeave) {
        // nghỉ trong phép
        $finalSalary = $salaryMonth;

        $note = "Nghỉ {$leaveDays} ngày (trong {$allowedLeave} ngày phép)";

    } else {
        // nghỉ vượt phép
        $extraLeave = $leaveDays - $allowedLeave;
        $deduct = $extraLeave * $salaryPerDay;

        $finalSalary = $salaryMonth - $deduct;

        $note = "Nghỉ {$leaveDays} ngày → vượt {$extraLeave} ngày phép, trừ lương";
    }

    // cộng thưởng lễ tết (nếu có)
    if ($holidayBonus > 0) {
        $finalSalary += $holidayBonus;
        $note .= "\nThưởng lễ/Tết: " . number_format($holidayBonus,0,",",".") . " đ";
    }

    return [
        'worked_days'   => $workedDays,
        'leave_days'    => $leaveDays,
        'salary_per_day'=> round($salaryPerDay),
        'final_salary'  => round($finalSalary),
        'note'          => $note
    ];
}
