



<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop Products - Glamour Hair Salon</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /*body {
      font-family: Arial, sans-serif;
      background-color: #f3e6f4;
      margin: 0;
      padding: 0;
    } 

    header {
      background: #111;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
    }

    .logo {
      font-size: 20px;
      font-weight: bold;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    nav a:hover {
      text-decoration: underline;
    }
    nav ul li {
      margin: 0 15px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    nav ul li a.active, nav ul li a:hover {
      color: #e99fe0;
    }*/

    section.shop {
      text-align: center;
      padding: 100px 20px;
    }

    h2 {
      color: #2b2b2b;
      margin-bottom: 50px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .product-card {
      background: white;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
      transition: 0.3s;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 14px rgba(0,0,0,0.15);
    }

    .product-card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
    }

    .product-card h3 {
      margin-top: 15px;
      color: #333;
    }

    .product-card p {
      font-size: 14px;
      color: #666;
      min-height: 40px;
    }

    .product-card span {
      display: block;
      font-weight: bold;
      color: #e67e22;
      margin: 10px 0;
    }

    .btn {
      background-color: #7a2d87;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background-color: #9b45a3;
    }

    /* Popup form overlay */
    .popup {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }

    .popup-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      width: 400px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.3);
      position: relative;
    }

    .popup-content input, .popup-content textarea {
      width: 90%;
      margin: 10px 0;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .popup-content button {
      margin-top: 10px;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 20px;
      cursor: pointer;
      color: #555;
    }

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
  <?php
session_start();
?>
<header>
  <div class="logo">Glamour Hair Salon</div>
  <nav>
    <ul>
      <li><a href="home.php#home">Home</a></li>
      <li><a href="booking.php">Book Now</a></li>
      <li><a href="product.php">Shop</a></li>

      <?php if(isset($_SESSION['user'])): ?>
        <li><a href="#" style="color:#e99fe0;">Hi, <?= $_SESSION['user']; ?></a></li>
        <li><a href="logout.php" class="logout-btn">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>


  <section class="shop">
    <h1>Salon Products for Sale</h1>

    <div class="product-grid">
      <?php
      $result = $conn->query("SELECT * FROM products");

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
          <div class='product-card'>
            <img src='images/product/{$row['image']}' alt='{$row['name']}'>
            <h3>{$row['name']}</h3>
            <p>{$row['description']}</p>
            <span>Rs {$row['price']}</span>
            <button class='btn buyBtn' data-id='{$row['id']}' data-name='{$row['name']}'>Buy Now</button>
          </div>";
        }
      } else {
        echo '<p>No products found.</p>';
      }
      ?>
    </div>
  </section>

  <!-- Popup form -->
  <div class="popup" id="orderPopup">
    <div class="popup-content">
      <span class="close-btn" id="closePopup">&times;</span>
      <h2>Order Product</h2>
      <form method="POST">
        <input type="hidden" name="product_id" id="product_id">
        <input type="text" name="customer_name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="address" placeholder="Your Delivery Address" rows="3" required></textarea>
        <input type="text" name="phone" placeholder="Phone Number">
        <button type="submit" name="order" class="btn">Submit Order</button>
      </form>
    </div>
  </div>

  <?php
  if (isset($_POST['order'])) {
    $pid = $_POST['product_id'];
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO orders (customer_name, email, address, phone, product_id)
            VALUES ('$name', '$email', '$address', '$phone', '$pid')";

    if ($conn->query($sql) === TRUE) {
      echo "<p class='confirm' style='text-align:center;color:green;font-weight:bold;'>✅ Thank you, $name! Your order has been placed.</p>";
    } else {
      echo "<p class='error' style='text-align:center;color:red;'>❌ Error: " . $conn->error . "</p>";
    }
  }
  ?>

  <footer>
    <p>&copy; 2025 Glamour Hair Salon. All rights reserved.</p>
  </footer>

  <script>
    const popup = document.getElementById('orderPopup');
    const closePopup = document.getElementById('closePopup');
    const buyBtns = document.querySelectorAll('.buyBtn');
    const productInput = document.getElementById('product_id');

    buyBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const productId = btn.getAttribute('data-id');
        productInput.value = productId;
        popup.style.display = 'flex';
      });
    });

    closePopup.addEventListener('click', () => {
      popup.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target === popup) popup.style.display = 'none';
    });
  </script>
</body>
</html>
