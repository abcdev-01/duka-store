<?php
session_start();
include '../../connection/connection.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

$q = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
if (mysqli_num_rows($q) === 1) {
    $row = mysqli_fetch_assoc($q);
    if (password_verify($password, $row['password'])) {
        $_SESSION['admin'] = true;
        header('location:../dashboard.php');
        exit;
    }
}
echo "<script>alert('Wrong username or password');window.location='../index.php';</script>";
?>