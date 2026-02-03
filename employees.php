<?php
include "db.php";

$keyword = $_GET['keyword'] ?? "";

// tìm kiếm
$sql = "SELECT * FROM employees";
if ($keyword != "") {
    $k = $conn->real_escape_string($keyword);
    $sql .= " WHERE name LIKE '%$k%'";
}
$employees = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Quản lý nhân viên</title>
<style>
body { font-family:Arial }
table { border-collapse:collapse; width:70% }
th,td { border:1px solid #ccc; padding:6px }
th { background:#eee }
input { padding:5px }
button { padding:5px 10px }
</style>
</head>
<body>

<h2>👥 QUẢN LÝ NHÂN VIÊN (LƯƠNG THÁNG)</h2>

<!-- TÌM KIẾM -->
<form method="get">
<input type="text" name="keyword"
       placeholder="Tìm tên nhân viên..."
       value="<?= htmlspecialchars($keyword) ?>">
<button>🔍 Tìm</button>
<a href="employees.php">Reset</a>
</form>

<br>

<!-- THÊM NHÂN VIÊN -->
<form method="post" action="save_employee.php">
<input type="hidden" name="id" value="">
<input type="text" name="name"
       placeholder="Tên nhân viên" required>
<input type="number" name="salary_month"
       placeholder="Lương tháng (VNĐ)" required>
<button>➕ Thêm nhân viên</button>
</form>

<br>

<table>
<tr>
<th>ID</th>
<th>Tên nhân viên</th>
<th>Lương tháng (VNĐ)</th>
<th>Hành động</th>
</tr>

<?php while($e = $employees->fetch_assoc()): ?>
<tr>
<form method="post" action="save_employee.php">
<td>
<?= $e['id'] ?>
<input type="hidden" name="id" value="<?= $e['id'] ?>">
</td>

<td>
<input type="text" name="name"
       value="<?= htmlspecialchars($e['name']) ?>">
</td>

<td>
<input type="number" name="salary_month"
       value="<?= intval($e['salary_month']) ?>">
</td>

<td>
<button>💾 Lưu</button>
<a href="delete_employee.php?id=<?= $e['id'] ?>"
   onclick="return confirm('Xoá nhân viên này?')">
🗑 Xoá
</a>
</td>
</form>
</tr>
<?php endwhile; ?>
</table>

<br>
<a href="index.php">⬅ Quay lại chấm công</a>

</body>
</html>
