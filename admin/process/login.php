<?php
session_start();
require_once __DIR__ . '/../../connection/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../index.php');
    exit;
}

$username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$q = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
if (mysqli_num_rows($q) !== 1) {
    echo "<script>alert('Wrong username or password');window.location='../index.php';</script>";
    exit;
}

$row = mysqli_fetch_assoc($q);
if (!password_verify($password, $row['password'])) {
    echo "<script>alert('Wrong username or password');window.location='../index.php';</script>";
    exit;
}

// Regenerate session id to prevent session fixation
session_regenerate_id(true);

$_SESSION['admin'] = true;
header('location:../dashboard.php');
exit;
?>