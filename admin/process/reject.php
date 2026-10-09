<?php
include '../../connection/connection.php';
$id = mysqli_real_escape_string($conn, $_GET['order_id']);
mysqli_query($conn, "UPDATE orders SET rejected = 1, status = 'Rejected' WHERE order_id = '$id'");
echo "<script>alert('Order rejected');window.location='../orders.php';</script>";
?>