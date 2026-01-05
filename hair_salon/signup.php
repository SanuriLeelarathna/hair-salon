<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - Salon Near Me</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class ="body-sign">
  <div class="auth-container">
    
      <h2>Sign Up</h2>
      <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="mobile" placeholder="Mobile number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm" placeholder="Confirm Password" required>
        <button type="submit" name="signup">Sign Up</button>
        <p>Already a member? <a href="login.php">Sign In</a></p>
      </form>

      <?php
      if (isset($_POST['signup'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];

        if ($password !== $confirm) {
          echo "<p class='error'>❌ Passwords do not match!</p>";
        } else {
          $hash = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO users (name, email, mobile, password, role)
        VALUES ('$name', '$email', '$mobile', '$hash', 'user')";

          if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>✅ Account created successfully! <a href='login.php'>Login</a></p>";
          } else {
            echo "<p class='error'>❌ Error: $conn->error</p>";
          }
        }
      }
      ?>
    </div>
  </div>
</body>
</html>
