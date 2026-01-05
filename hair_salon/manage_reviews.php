<?php
session_start();
include 'db_connect.php';

/*if (!isset($_SESSION['admin_id'])) {
  header("Location: admin.php");
  exit();
}*/

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $conn->query("DELETE FROM reviews WHERE id=$id");
  header("Location: manage_reviews.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Reviews</title>
<style>
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border:1px solid #ccc;text-align:center}
th{background:#3e1940;color:#fff}
.btn{padding:6px 10px;background:red;color:white;border-radius:5px;text-decoration:none}
</style>
</head>
<body>

<h2>Manage Reviews</h2>

<table>
<tr>
<th>ID</th><th>Name</th><th>Rating</th><th>Comment</th><th>Action</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM reviews ORDER BY id DESC");
while($r = $res->fetch_assoc()):
?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= htmlspecialchars($r['name']) ?></td>
<td><?= $r['rating'] ?>/5</td>
<td><?= htmlspecialchars($r['comment']) ?></td>
<td>
<a class="btn" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Delete review?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
