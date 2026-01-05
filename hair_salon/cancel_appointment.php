<?php
include 'db_connect.php';

$id=$_GET['id'];

$check=$conn->prepare(
 "SELECT email FROM bookings WHERE id=? AND status='active'"
);
$check->bind_param("i",$id);
$check->execute();
$res=$check->get_result();

if ($res->num_rows==0) {
 echo "<h2 style='color:red;text-align:center'>
 Appointment not found or already cancelled</h2>";
 exit;
}

$email=$res->fetch_assoc()['email'];

$cancel=$conn->prepare(
 "UPDATE bookings SET status='cancelled' WHERE id=?"
);
$cancel->bind_param("i",$id);
$cancel->execute();

@mail($email,"Appointment Cancelled",
"Your appointment #AP$id has been cancelled",
"From: salon@gmail.com");

echo "<h2 style='color:green;text-align:center'>
✔ Appointment #AP$id Cancelled</h2>";
