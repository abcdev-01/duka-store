<?php
include '../../connection/connection.php';
$code = mysqli_real_escape_string($conn, $_POST['code']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$qty = intval($_POST['qty']);
$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$price = intval($_POST['price']);
$date = date('Y-m-d');
mysqli_query($conn, "INSERT INTO inventory VALUES('$code','$name','$qty','$unit','$price','$date')");
echo "<script>alert('Material added');window.location='../inventory.php';</script>";
?>