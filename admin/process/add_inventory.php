<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
    exit;
}
require_once __DIR__ . '/../../connection/connection.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../add_inventory.php');
    exit;
}

$code  = mysqli_real_escape_string($conn, $_POST['code'] ?? '');
$name  = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$qty   = intval($_POST['qty'] ?? 0);
$unit  = mysqli_real_escape_string($conn, $_POST['unit'] ?? '');
$price = intval($_POST['price'] ?? 0);
$date  = date('Y-m-d');

$insert = mysqli_query($conn, "INSERT INTO inventory VALUES('$code', '$name', '$qty', '$unit', '$price', '$date')");

if ($insert) {
    echo "<script>alert('Material added successfully');window.location='../inventory.php';</script>";
} else {
    echo "<script>alert('Failed to add material');window.location='../add_inventory.php';</script>";
}
exit;
?>