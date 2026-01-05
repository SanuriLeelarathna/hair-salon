<?php
session_start();
include 'db_connect.php'; // Make sure this file connects to your database properly
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}


// ============================
//  ADMIN DASHBOARD SECTION
// ============================

// Fetch statistics
$bookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'] ?? 0;
$products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'] ?? 0;
$reviews = $conn->query("SELECT COUNT(*) AS total FROM reviews")->fetch_assoc()['total'] ?? 0;

// Logout logic
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: admin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Glamour Salon</title>
<style>
body {
  margin: 0; font-family: 'Poppins', sans-serif; background: #f9f7fb; display: flex;
}
.sidebar {
  width: 250px; background: #3e1940; color: white;
  height: 100vh; padding: 30px 20px; position: fixed;
}
.sidebar h2 {
  text-align: center; color: #fff; margin-bottom: 30px;
}
.sidebar a {
  display: block; color: white; text-decoration: none;
  padding: 12px; margin: 8px 0; border-radius: 6px;
  transition: 0.3s;
}
.sidebar a:hover { background: #e5b9f0; color: #3e1940; }

.main {
  margin-left: 270px; padding: 30px; flex: 1;
}
header {
  display: flex; justify-content: space-between; align-items: center;
  border-bottom: 2px solid #eee; padding-bottom: 10px;
}
header h1 { margin: 0; color: #3e1940; }
.logout {
  background: #fdfdfd0c; color: white; border color: #3e1940 ;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer; 
  font-weight: bold;
  color :  #3e1940 ;
}
.cards {
  display: flex; gap: 20px; margin-top: 30px; flex-wrap: wrap;
}
.card {
  flex: 1 1 250px;
  background: white; padding: 25px; border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  text-align: center; transition: 0.3s;
}
.card:hover { transform: translateY(-5px); }
.card h3 { color: #512b58; margin-bottom: 10px; }
.card p { font-size: 2rem; font-weight: bold; color: #333; }
</style>
</head>
<body>
  <div class="sidebar">
  <h2>Admin Panel</h2>
 
  <a href="manage_bookings.php">Manage Bookings</a>
  <a href="manage_products.php">Manage Products</a>  <!-- ✅ FIX -->
  <a href="manage_reviews.php">Manage Reviews</a>
  <a href="manage_product_orders.php">Manage Orders</a>

  <a href="?logout=1">Logout</a>
</div>

  <div class="main">
    <header>
      <h1>Welcome, <?= htmlspecialchars($_SESSION['user']) ?></h1>
      <form method="get"><button class="logout" name="logout">Logout</button></form>
    </header>

    <div class="cards">
      <div class="card">
        <h3>Total Bookings</h3>
        <p><?= $bookings ?></p>
      </div>
      <div class="card">
        <h3>Total Products</h3>
        <p><?= $products ?></p>
      </div>
      <div class="card">
        <h3>Total Reviews</h3>
        <p><?= $reviews ?></p>
      </div>
    </div>
  </div>
</body>
</html>


