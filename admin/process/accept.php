<?php
require_once __DIR__ . '/../../connection/connection.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
    exit;
}


$order_id = mysqli_real_escape_string($conn, $_GET['order_id'] ?? '');
if ($order_id === '') {
    echo "<script>alert('No order selected');window.location='../orders.php';</script>";
    exit;
}

mysqli_query($conn, "UPDATE orders SET accepted = 1, rejected = 0, status = 'Accepted' WHERE order_id = '$order_id'");

echo "<script>alert('Order accepted');window.location='../orders.php';</script>";
exit;
?>