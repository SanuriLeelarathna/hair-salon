<?php
include 'db_connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Salon Near Me</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class ="body-sign">
  <div class="auth-container">
    
      <h2>Sign In</h2>
      <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="remember">
          <label><input type="checkbox"> Remember me</label>
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" name="login">Sign In</button>
        <p>Not a member yet? <a href="signup.php">Sign Up</a></p>
      </form>

      <?php
      if (isset($_POST['login'])) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM users WHERE email='$email'");

  if ($result->num_rows == 1) {

    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {

      $_SESSION['user_id'] = $row['id'];
      $_SESSION['user'] = $row['name'];
      $_SESSION['role'] = $row['role'];

      if ($row['role'] === 'admin') {
        header("Location: admin.php");
      } else {
        header("Location: home.php");
      }
      exit();

    } else {
      echo "<p class='error'>❌ Incorrect password</p>";
    }

  } else {
    echo "<p class='error'>❌ User not found</p>";
  }
}

      ?>
    </div>
  </div>
</body>
</html>
