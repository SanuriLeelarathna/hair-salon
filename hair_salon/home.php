<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glamour Hair Salon</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Navigation -->
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


  <!-- Home Section -->
  <section id="home" class="hero" >
    <h2>Welcome to Glamour Hair Salon</h2>
    <p>Your beauty, our passion.</p>
    <a href="booking.php" class="btn">Book Appointment</a>
  </section>

  <!--  About Section -->
  <section id="about" class="about-section">
  <div class="about-container">
    <div class="about-image">
      <img src="images/7.jpeg" alt="Salon Interior">
    </div>
    <div class="about-text">
      <h2>About Us</h2>
      <p>
        At Glamor hair salon, beauty is not just what we do — it’s who we are.
        Founded on the principles of artistry and precision, our salon is home
        to a passionate team of experts dedicated to bringing out the best
        version of you. Led by Master Stylist Surith, we combine cutting-edge
        techniques with a personal touch to offer a full range of hair, beauty,
        and skin care services. We pride ourselves on creating a space where
        clients feel valued, confident, and inspired.
      </p>
      <p>
        At the heart of our philosophy is a commitment to continuous learning
        and creativity. We stay at the forefront of industry trends to offer
        our clients the most innovative solutions, ensuring every service is
        customized to perfection. Your beauty journey begins here — at Salon Zero.
      </p>
    </div>
  </div>
</section>


  <!-- Services Section -->
  <section id="services" class="services">
  <h2>Our Services</h2>
  <div class="service-list">
    <div class="service-card">
      <img src="images/sr6.jpeg" alt="Haircut">
      <h3>Professional Haircuts</h3>
      <p>We offer custom cuts for men, women, and children. Our experienced stylists ensure your haircut complements your face shape and personal style. Includes wash and style.</p>
      <span>Starting at Rs 2500/=</span>
     
    </div>
    <div class="service-card">
      <img src="images/4.jpeg" alt="Hair Coloring">
      <h3>Hair Coloring & Highlights</h3>
      <p>Transform your look with our coloring options including balayage, ombré, highlights, and full color. We use ammonia-free, salon-quality products for healthy, shiny hair.</p>
      <span>Starting at Rs 4500/=</span>
      
    </div>
    <div class="service-card">
      <img src="images/s3.jpeg" alt="Styling">
      <h3>Hair Styling & Blowouts</h3>
      <p>Get ready for your next event with a professional blowout or updo. Perfect for weddings, photoshoots, or a night out.</p>
      <span>Starting at Rs 2000/=</span>
      
    </div>
    <div class="service-card">
      <img src="images/5.jpeg" alt="Styling">
      <h3>Hair Treatments</h3>
      <p>Rejuvenate your hair with nourishing masks and keratin treatments. We help restore shine, strength, and manageability to your hair.</p>
        <span>Starting at Rs 5000/=</span>
      
    </div>

    
  </div>
  
  <a href="service.html" class="btn see-more">See More</a>
</section>
<!-- price section -->
<section id="pricing" class="pricing">
  <h2>Our Pricing</h2>

  <div class="pricing-tabs">
    <button class="tab active" data-tab="haircuts">Haircuts & Styling</button>
    <button class="tab" data-tab="color">Hair Color Services</button>
    <button class="tab" data-tab="chemical">Hair Chemical Services</button>
    <button class="tab" data-tab="extension">Hair Extension Services</button>
  </div>

  <!-- Haircuts & Styling -->
  <div class="pricing-content active" id="haircuts">
    <div class="pricing-table">
      <div class="row"><span>Ladies’ long Haircuts</span><span>8000.00 LKR</span></div>
      <div class="row"><span>Bob cuts & pixie cuts</span><span>9500.00 LKR</span></div>
      <div class="row"><span>Ladies hair trim</span><span>3000.00 LKR</span></div>
      <div class="row"><span>Gents' Hair cuts (by Master Surith)</span><span>2800.00 LKR</span></div>
      <div class="row"><span>Gents' Haircuts (by assistant)</span><span>1900.00 LKR</span></div>
      <div class="row"><span>Beard Trimming</span><span>1000.00 LKR</span></div>
      <div class="row"><span>Beard shaving</span><span>1200.00 LKR</span></div>
      <div class="row"><span>Ladies' Temporary Hair settings</span><span>3500.00 LKR</span></div>
      <div class="row"><span>Gents' temporary hair settings (by assistant)</span><span>1500.00 LKR</span></div>
      <div class="row"><span>Beard color</span><span>1000.00 LKR</span></div>
    </div>
  </div>

  <!-- Hair Color Services -->
  <div class="pricing-content" id="color">
    <div class="pricing-table">
      <div class="row"><span>Master Surith’s Expert Hair Coloring</span><span>30000.00 LKR</span></div>
      <div class="row"><span>Senior Assistants’ Hair Coloring</span><span>12000.00 LKR</span></div>
      <div class="row"><span>Gents’ Hair Coloring Services</span><span>5000.00 LKR</span></div>
      <div class="row"><span>Ladies’ Full Hair Root Touch-Ups</span><span>7000.00 LKR</span></div>
      <div class="row"><span>Gents’ Root Touch-Up</span><span>3500.00 LKR</span></div>
      <div class="row"><span>Ladies crown hair root touch up</span><span>5000.00 LKR</span></div>
      <div class="row"><span>Ladies’ Hair Fringe Touch-Up</span><span>3000.00 LKR</span></div>
      <div class="row"><span>Fashion Hair Color Lines</span><span>3000.00 LKR</span></div>
    </div>
  </div>

  <!-- Hair Chemical Services -->
  <div class="pricing-content" id="chemical">
    <div class="pricing-table">
      <div class="row"><span>Keratin Treatment</span><span>25000.00 LKR</span></div>
      <div class="row"><span>Hair Relaxing</span><span>15000.00 LKR</span></div>
      <div class="row"><span>Hair Perming</span><span>18000.00 LKR</span></div>
      <div class="row"><span>Protein Treatment</span><span>12000.00 LKR</span></div>
    </div>
  </div>

  <!-- Hair Extension Services -->
  <div class="pricing-content" id="extension">
    <div class="pricing-table">
      <div class="row"><span>Clip-In Hair Extensions</span><span>10000.00 LKR</span></div>
      <div class="row"><span>Tape-In Extensions</span><span>15000.00 LKR</span></div>
      <div class="row"><span>Keratin Bond Extensions</span><span>20000.00 LKR</span></div>
      <div class="row"><span>Hair Extension Removal</span><span>8000.00 LKR</span></div>
    </div>
  </div>
</section>

  <!-- Gallery Section -->
  <section id="gallery" class="gallery">
  <h2>Our Hair Style Gallery</h2>
  <div class="gallery-slider">
    <div class="slide active"><img src="images/st5.jpeg" alt="Hair Style 1"></div>
    <div class="slide"><img src="images/2.jpeg" alt="Hair Style 2"></div>
    <div class="slide"><img src="images/s3.jpeg" alt="Hair Style 3"></div>
    <div class="slide"><img src="images/sr1.jpeg" alt="Hair Style 4"></div>
    <div class="slide"><img src="images/5.jpeg" alt="Hair Style 2"></div>
    <div class="slide"><img src="images/s2.jpeg" alt="Hair Style 2"></div>
    <div class="slide"><img src="images/3.jpeg" alt="Hair Style 3"></div>
    <div class="slide"><img src="images/4.jpeg" alt="Hair Style 4"></div>
     <div class="slide"><img src="images/st2.jpeg" alt="Hair Style 4"></div>
    <button class="prev">❮</button>
    <button class="next">❯</button>
  </div>
</section>
  <!-- Review Section -->

  <section class="reviews" id="reviews">
  <h2>What Our Clients Say</h2>
  <div class="reviews-container">
    <?php
    include 'db_connect.php';
    $result = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC LIMIT 6");

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "
        <div class='review-card'>
          <p>\"{$row['comment']}\"</p>
          <div class='review-author'>
            <h4>– {$row['name']}</h4>
            <span>";
              for ($i = 0; $i < $row['rating']; $i++) echo "⭐";
        echo " </span>
          </div>
        </div>";
      }
    } else {
      echo "<p>No reviews yet. Be the first to <a href='add_review.php'>leave one!</a></p>";
    }
    ?>
  </div>
  <a href="review.php" class="btn">Write a Review</a>
</section>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".pricing-tabs .tab");
    const contents = document.querySelectorAll(".pricing-content");

    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        contents.forEach(c => c.classList.remove("active"));

        tab.classList.add("active");
        const target = document.getElementById(tab.dataset.tab);
        target.classList.add("active");
      });
    });
  });
</script>
<!-- </section>

Link your JS file 
<script src="script.js"></script>-->



  <!-- Contact Section -->
  <section id="contact" class="contact">
    <h2>Contact Us</h2>
    <p>📍 Address: 123 Main Street, Your City</p>
    <p>📞 Phone: (555) 123-4567</p>
    <p>✉️ Email: info@glamoursalon.com</p>
  </section>

  <footer>
    <p>&copy; 2025 Glamour Hair Salon. All rights reserved.</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>