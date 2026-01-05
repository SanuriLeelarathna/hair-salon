<?php
session_start();
include 'db_connect.php';

/*if (!isset($_SESSION['admin_id'])) {
  header("Location: admin.php");
  exit();
}*/


/* DELETE PRODUCT */
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];

  // delete image from folder
  $imgRes = $conn->query("SELECT image FROM products WHERE id=$id");
  if ($imgRes && $imgRes->num_rows > 0) {
    $img = $imgRes->fetch_assoc()['image'];
    if (file_exists("images/product/$img")) {
      unlink("images/product/$img");
    }
  }

  $conn->query("DELETE FROM products WHERE id=$id");
  header("Location: manage_products.php");
  exit();
}

/* ADD PRODUCT */
$message = "";
if (isset($_POST['add_product'])) {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];

  $imageName = time() . "_" . $_FILES['image']['name'];
  $imageTmp = $_FILES['image']['tmp_name'];

  if (move_uploaded_file($imageTmp, "images/product/$imageName")) {
    $stmt = $conn->prepare(
      "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssds", $name, $desc, $price, $imageName);

    if ($stmt->execute()) {
      $message = "✅ Product added successfully!";
    } else {
      $message = "❌ Database error!";
    }
  } else {
    $message = "❌ Image upload failed!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Products</title>
<style>

.container-vertical {
  display: flex;
  flex-direction: column; /* stack items vertically */
  align-items: flex-start; /* align children to left, not stretched */
  gap: 40px; /* space between form and table */
  padding: 20px;
}

.add-product-form {
  width: 350px; /* narrower form */
}

.product-list {
  width: 100%; /* table takes full width */
  overflow-x: auto; /* horizontal scroll if table too wide */
}

form {
  background: white;
  padding: 20px;
  border-radius: 10px;
}

.product-list table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: center;
}

th {
  background: #3e1940;
  color: #fff;
}

img{
  width:75px;
  border-radius:8px}
.btn{
  padding:6px 10px;
  background:red;
  color:white;
  border-radius:5px;
  text-decoration:none
}

input,textarea,button{
  width:100%;
  padding:10px;
  margin:8px 0
}
button{background:#3e1940;color:white;border:none;border-radius:6px;font-weight:bold}
.success{color:green}

</style>
</head>
<body>
<div class="container-vertical">
  <div class="add-product-form">
<h2>➕ Add New Product</h2>

<form method="POST" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Product Name" required>
  <textarea name="description" placeholder="Description" required></textarea>
  <input type="number" step="0.01" name="price" placeholder="Price" required>
  <input type="file" name="image" required>
  <button type="submit" name="add_product">Add Product</button>
</form>
</div>
<?php if ($message): ?>
  <p class="success"><?= $message ?></p>
<?php endif; ?>
 <div class="product-list">
<h2 style="margin-top:40px;">📦 Product List</h2>

<table>
<tr>
<th>ID</th><th>Image</th><th>Name</th><th>Price</th><th>Action</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM products ORDER BY id DESC");
while ($p = $res->fetch_assoc()):
?>
<tr>
<td><?= $p['id'] ?></td>
<td><img src="images/product/<?= htmlspecialchars($p['image']) ?>"></td>
<td><?= htmlspecialchars($p['name']) ?></td>
<td>$<?= $p['price'] ?></td>
<td>
<a class="btn" href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete product?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>
</div>
</body>
</html>
