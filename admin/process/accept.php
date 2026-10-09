<?php
include '../../connection/connection.php';
$id = mysqli_real_escape_string($conn, $_GET['order_id']);
mysqli_query($conn, "UPDATE orders SET accepted = 1, status = 'Accepted' WHERE order_id = '$id'");
echo "<script>alert('Order accepted');window.location='../orders.php';</script>";
?>