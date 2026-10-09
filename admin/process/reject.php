<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
    exit;
}
require_once __DIR__ . '/../../connection/connection.php';

$order_id = mysqli_real_escape_string($conn, $_GET['order_id'] ?? '');
if ($order_id === '') {
    echo "<script>alert('No order selected');window.location='../orders.php';</script>";
    exit;
}

mysqli_query($conn, "UPDATE orders SET rejected = 1, accepted = 0, status = 'Rejected' WHERE order_id = '$order_id'");

echo "<script>alert('Order rejected');window.location='../orders.php';</script>";
exit;
?>