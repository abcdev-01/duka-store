<?php
include '../../connection/connection.php';
$code = mysqli_real_escape_string($conn, $_GET['code']);
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM products WHERE product_code = '$code'"));
if ($row && file_exists("../../image/products/" . $row['image'])) @unlink("../../image/products/" . $row['image']);
mysqli_query($conn, "DELETE FROM products WHERE product_code = '$code'");
echo "<script>alert('Product deleted');window.location='../master_products.php';</script>";
?>