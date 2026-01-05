<?php
include 'db_connect.php';
session_start();

if (isset($_POST['reviews'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $query = "INSERT INTO reviews (name, rating, comment) VALUES ('$name', '$rating', '$comment')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Thank you for your review!'); window.location.href='home.php#reviews';</script>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Write a Review - Glamour Hair Salon</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="auth-container">
    <h2>Leave a Review</h2>
    <form method="POST">
      <input type="text" name="name" placeholder="Your Name" required>
      <select name="rating" required>
        <option value="">Select Rating</option>
        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
        <option value="4">⭐⭐⭐⭐ Good</option>
        <option value="3">⭐⭐⭐ Average</option>
        <option value="2">⭐⭐ Poor</option>
        <option value="1">⭐ Very Bad</option>
      </select>
      <textarea name="comment" placeholder="Write your review..." rows="4" required></textarea>
      <button type="submit" name="reviews">Submit Review</button>
    </form>
    <p><a href="home.php">Back to Home</a></p>
  </div>
</body>
</html>
