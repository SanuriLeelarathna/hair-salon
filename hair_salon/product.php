<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Shop Products - Glamour Hair Salon</title>
<link rel="stylesheet" href="style.css">

<style>
/* =========================
   SHOP SECTION
========================= */
 body { background: #D9D9D9; margin: 0; padding: 0; }

section.shop {
  text-align: center;
  padding: 100px 20px;
}

h2 {
  color: #2b2b2b;
  margin-bottom: 50px;
}

/* =========================
   PRODUCT GRID
========================= */
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
}

/* =========================
   PRODUCT CARD (FIXED)
========================= */
.product-card {
  background: white;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);

  height: 540px;                 /* FIXED HEIGHT */
  display: flex;                 /* IMPORTANT */
  flex-direction: column;        /* IMPORTANT */

  text-align: center;
  transition: 0.3s;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

/* =========================
   IMAGE FIXED
========================= */
.product-card img {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-radius: 10px;
}

/* =========================
   TITLE FIXED HEIGHT
========================= */
.product-card h3 {
  margin: 15px 0 5px;
  color: #333;
  min-height: 48px;
}

/* =========================
   DESCRIPTION FIXED HEIGHT
========================= */
.product-card p {
  font-size: 14px;
  color: #666;
  min-height: 48px;
  overflow: hidden;
}

/* =========================
   PRICE
========================= */
.product-card strong {
  font-size: 18px;
  color: #0c0c0cff;
  margin: 10px 0;
}

/* =========================
   BUTTON FIXED AT BOTTOM
========================= */
.product-card .btn {
  margin-top: auto;              /* 🔥 KEY LINE */
  background-color: #482450ff;
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s;
}

.product-card .btn:hover {
  background-color: #9b45a3;
}

/* =========================
   POPUP
========================= */
.popup {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
}

.popup-content {
  background: white;
  padding: 30px;
  border-radius: 10px;
  width: 400px;
  position: relative;
}

.popup-content input,
.popup-content textarea {
  width: 100%;
  margin: 10px 0;
  padding: 10px;
}

/* =========================
   CLOSE BUTTON
========================= */
.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
  cursor: pointer;
}

/* =========================
   FOOTER
========================= */
footer {
  text-align: center;
  padding: 20px;
  background: #111;
  color: #ccc;
  margin-top: 50px;
}
</style>

</head>

<body>

<header>
  <div class="logo">
  <img src="images/glmr.png" alt="Glamour Hair Salon Logo">
  </div>
  <nav>
    <ul>
      <li><a href="home.php#home" class="active">Home</a></li>
      <li><a href="booking.php">Book Now</a></li>
      <li><a href="product.php">Shop</a></li>

      <?php if(isset($_SESSION['user'])): ?>
        <li>
          <a href="profile.php" style="color:#e99fe0;">
            Hi, <?= $_SESSION['user']; ?>
          </a>
        </li>
        <li><a href="logout.php" class="logout-btn">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>


<section class="shop">
<h2>Hair Care</h2>

<div class="product-grid">
<?php
$products = $conn->query("SELECT * FROM products");
while($row = $products->fetch_assoc()):
?>
  <div class="product-card">
    <img src="images/product/<?= $row['image']; ?>">
    <h3><?= $row['name']; ?></h3>
    <p><?= $row['description']; ?></p>
    <strong>Rs <?= $row['price']; ?></strong><br><br>

    <?php if(isset($_SESSION['user'])): ?>
      <button class="btn buyBtn" data-id="<?= $row['id']; ?>">Buy Now</button>
    <?php else: ?>
      <a href="login.php" class="btn">Login to Buy</a>
    <?php endif; ?>
  </div>
<?php endwhile; ?>
</div>
</section>

<!-- ORDER POPUP -->
<div class="popup" id="orderPopup">
  <div class="popup-content">
    <span class="close-btn">&times;</span>
    <h3>Place Order</h3>

    <form method="POST">
      <input type="hidden" name="product_id" id="product_id">
      <input type="number" name="quantity" value="1" min="1" required>
      <textarea name="address" placeholder="Delivery Address" required></textarea>
      <input type="text" name="phone" placeholder="Phone Number">
      <button class="btn" name="order">Confirm Order</button>
    </form>
  </div>
</div>

<!-- SUCCESS POPUP -->
<div class="popup" id="successPopup">
  <div class="popup-content">
    <h2>✅ Order Placed</h2>
    <p>Your order has been placed successfully.</p>
    <p><strong>Status:</strong> Processing</p>
    <button class="btn" onclick="window.location.href='profile.php'">
      View My Orders
    </button>
  </div>
</div>

<?php
if (isset($_POST['order'])) {

  $pid = $_POST['product_id'];
  $qty = $_POST['quantity'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];

  $name = $_SESSION['user'];
  $email = $_SESSION['email'] ?? '';

  $sql = "INSERT INTO p_orders
  (customer_name,email,product_id,quantity,address,phone,status)
  VALUES
  ('$name','$email','$pid','$qty','$address','$phone','Processing')";

  if ($conn->query($sql)) {
    echo "
    <script>
      window.onload = () => {
        document.getElementById('successPopup').style.display = 'flex';
      }
    </script>
    ";
  }
}
?>

<footer>
<p>&copy; 2025 Glamour Hair Salon</p>
</footer>

<script>
const popup = document.getElementById('orderPopup');
const successPopup = document.getElementById('successPopup');
const closeBtn = document.querySelector('.close-btn');
const productInput = document.getElementById('product_id');

document.querySelectorAll('.buyBtn').forEach(btn => {
  btn.onclick = () => {
    productInput.value = btn.dataset.id;
    popup.style.display = 'flex';
  }
});

closeBtn.onclick = () => popup.style.display = 'none';
window.onclick = e => {
  if (e.target === popup) popup.style.display = 'none';
}
</script>

</body>
</html>
