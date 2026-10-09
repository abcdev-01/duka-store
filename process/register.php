<?php
include '../connection/connection.php';

// Generate next customer code
$q = mysqli_query($conn, "SELECT customer_code FROM customers ORDER BY customer_code DESC LIMIT 1");
$last = mysqli_fetch_assoc($q);
$num = $last ? ((int)substr($last['customer_code'], 1)) + 1 : 1;
$code = "C" . str_pad($num, 4, "0", STR_PAD_LEFT);

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

if ($password !== $confirm) {
    echo "<script>alert('Password confirmation does not match');window.location='../register.php';</script>";
    exit;
}

$check = mysqli_query($conn, "SELECT username FROM customers WHERE username = '$username'");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Username already used');window.location='../register.php';</script>";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$insert = mysqli_query($conn, "INSERT INTO customers VALUES('$code','$name','$email','$username','$hash','$phone')");

if ($insert) {
    echo "<script>alert('Registration successful');window.location='../user_login.php';</script>";
} else {
    echo "<script>alert('Registration failed');window.location='../register.php';</script>";
}
?>