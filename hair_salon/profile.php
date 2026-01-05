<?php
session_start();
include 'db_connect.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

// =================== HANDLE ORDER CANCELLATION ===================
if (isset($_POST['cancel_id'])) {
    $order_id = $_POST['cancel_id'];
    
    // Verify order belongs to user and is within 5 days & not delivered
    $order = $conn->query("SELECT order_date, status FROM p_orders WHERE id=$order_id AND customer_name='$user'")->fetch_assoc();
    if ($order) {
        $orderDate = strtotime($order['order_date']);
        $today = time();
        $daysPassed = ($today - $orderDate) / (60*60*24);
        
        if ($daysPassed <= 5 && strtolower($order['status']) != 'delivered') {
           $conn->query("UPDATE p_orders SET status='Cancelled', cancelled_by_user=1 WHERE id=$order_id");

            echo "<script>alert('Order cancelled successfully');window.location='profile.php';</script>";
        } else {
            echo "<script>alert('This order cannot be cancelled');window.location='profile.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Profile</title>
<link rel="stylesheet" href="style.css">
<style>
body {
  font-family: Arial, sans-serif;
  background: #D9D9D9;
  margin: 0;
  padding: 0;
}

header {
  background: #3a003a;
  padding: 15px;
}

header a {
  color: white;
  text-decoration: none;
  margin-left: 15px;
}

.container {
  width: 90%;
  margin: 40px auto;
}

.flex-container {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
}

/* Appointment & Orders Columns */
.column {
  flex: 1;
  min-width: 300px;
  background: white;
  padding: 20px;
  border-radius: 10px;
}

.section-title {
  font-size: 20px;
  font-weight: bold;
  margin: 20px 0 10px 0;
  color: #444;
}

.card {
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 12px;
  background: #fff;
}

.card p {
  margin: 5px 0;
}

.status {
  font-weight: bold;
  text-transform: capitalize;
}

.status.pending { color: orange; }
.status.processing { color: orange; }
.status.delivered { color: green; }
.status.cancelled { color: red; }

.appointment-date {
  font-size: 16px;
  font-weight: bold;
  color: #3a003a;
}

.appointment-time {
  font-size: 16px;
  font-weight: bold;
  color: #3a003a;
  margin-top: 5px;
}


.cancel-btn {
  margin-top: 8px;
  background: #c0392b;
  color: white;
  padding: 6px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.cancel-btn:hover {
  background: #e74c3c;
}
</style>
</head>

<body>

<header>
  <div class="logo">
  <img src="images/glmr.png" alt="Glamour Hair Salon Logo">
  </div>
  <nav>
    <ul style="list-style: none; display: flex; padding: 0; margin: 0;">
      <li><a href="home.php#home">Home</a></li>
      <li><a href="booking.php">Book Now</a></li>
      <li><a href="product.php">Shop</a></li>

      <?php if(isset($_SESSION['user'])): ?>
        <li><a href="profile.php" style="color: #e99fe0;">Hi, <?= $_SESSION['user']; ?></a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<div class="container">
  <div class="flex-container">

    <!-- APPOINTMENTS COLUMN -->
    <div class="column">
      <div class="section-title">📅 My Appointments</div>

      <?php
      $apps = $conn->query("SELECT * FROM bookings WHERE name='$user'");

      if ($apps->num_rows == 0) {
        echo "<p style='padding:10px;'>You have no appointments yet.</p>";
      }

      while ($a = $apps->fetch_assoc()):
      ?>
        <div class="card">
          <p><strong>Service:</strong> <?= htmlspecialchars($a['service']); ?></p>
          <p class="appointment-date"><strong>Date:</strong> <?= date('F j, Y', strtotime($a['date'])); ?></p>
          <p class="appointment-time"><strong>Time:</strong> <?= htmlspecialchars($a['time']); ?></p>

          <p><strong>Status:</strong> <span class="status <?= strtolower($a['status']); ?>"><?= htmlspecialchars($a['status']); ?></span></p>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- ORDERS COLUMN -->
    <div class="column">
      <div class="section-title">🛒 My Orders</div>

      <?php
      $orders = $conn->query("
        SELECT p_orders.*, products.name AS product_name
        FROM p_orders
        JOIN products ON products.id=p_orders.product_id
        WHERE customer_name='$user'
        ORDER BY p_orders.order_date DESC
      ");

      if ($orders->num_rows == 0) {
        echo "<p style='padding:10px;'>You haven’t placed any orders yet.</p>";
      }

      while ($o = $orders->fetch_assoc()):
          // Calculate if order can be cancelled (within 5 days & not delivered)
          $orderDate = strtotime($o['order_date']);
          $today = time();
          $daysPassed = ($today - $orderDate) / (60*60*24);
          $canCancel = $daysPassed <= 5 && strtolower($o['status']) != 'delivered' && strtolower($o['status']) != 'cancelled';

          // Map status to CSS class
          $status_class = '';
          switch(strtolower($o['status'])){
              case 'pending': $status_class = 'pending'; break;
              case 'process': $status_class = 'processing'; break;
              case 'delivered': $status_class = 'delivered'; break;
              case 'cancelled': $status_class = 'cancelled'; break;
          }
      ?>
        <div class="card">
          <p><strong>Product:</strong> <?= htmlspecialchars($o['product_name']); ?></p>
          <p><strong>Quantity:</strong> <?= htmlspecialchars($o['quantity']); ?></p>
          <p><strong>Status:</strong> <span class="status <?= $status_class ?>"><?= htmlspecialchars($o['status']); ?></span></p>

          <?php if ($canCancel): ?>
          <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
              <input type="hidden" name="cancel_id" value="<?= $o['id']; ?>">
              <button type="submit" class="cancel-btn">Cancel Order</button>
          </form>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>

  </div>
</div>

</body>
</html>
