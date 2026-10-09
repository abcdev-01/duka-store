<?php
include '../../connection/connection.php';
$code = mysqli_real_escape_string($conn, $_POST['code']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$qty = intval($_POST['qty']);
$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$price = intval($_POST['price']);
$date = date('Y-m-d');
mysqli_query($conn, "UPDATE inventory SET name = '$name', qty = '$qty', unit = '$unit', price = '$price', date = '$date' WHERE material_code = '$code'");
echo "<script>alert('Material updated');window.location='../inventory.php';</script>";
?>