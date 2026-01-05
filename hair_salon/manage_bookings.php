<?php
session_start();
include 'db_connect.php';

/*if (!isset($_SESSION['admin_id'])) {
  header("Location: admin.php");
  exit();
}*/

// Delete booking
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $conn->query("DELETE FROM bookings WHERE id=$id");
  header("Location: manage_bookings.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Bookings</title>
<style>
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border:1px solid #ccc;text-align:center}
th{background:#3e1940;color:#fff}
a.btn{padding:6px 10px;background:red;color:#fff;border-radius:5px;text-decoration:none}

</style>
</head>
<body>

<h2>Manage Bookings</h2>

<table>
<tr>
<th>ID</th><th>Name</th><th>Email</th><th>Date</th><th>Service</th><th>Time</th><th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
while($row = $result->fetch_assoc()):
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= $row['date'] ?></td>
<td><?= $row['service'] ?></td>
<td><?= $row['time'] ?></td>
<td>
<a class="btn" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete booking?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
