<?php
session_start();
include '../connection/connection.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM customers WHERE username = '$username'");
if (mysqli_num_rows($query) !== 1) {
    echo "<script>alert('Wrong username or password');window.location='../user_login.php';</script>";
    exit;
}
$row = mysqli_fetch_assoc($query);
if (!password_verify($password, $row['password'])) {
    echo "<script>alert('Wrong username or password');window.location='../user_login.php';</script>";
    exit;
}
$_SESSION['user'] = $row['name'];
$_SESSION['customer_code'] = $row['customer_code'];
header('location:../index.php');
?>