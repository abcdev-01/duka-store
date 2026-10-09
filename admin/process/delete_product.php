<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
    exit;
}
require_once __DIR__ . '/../../connection/connection.php';

$code = mysqli_real_escape_string($conn, $_GET['code'] ?? '');
if ($code === '') {
    echo "<script>alert('No product selected');window.location='../master_products.php';</script>";
    exit;
}

// Delete product image
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM products WHERE product_code = '$code'"));
if ($row && !empty($row['image']) && file_exists("../../image/products/" . $row['image'])) {
    @unlink("../../image/products/" . $row['image']);
}

// Delete BOM and product
mysqli_query($conn, "DELETE FROM product_bom WHERE product_code = '$code'");
mysqli_query($conn, "DELETE FROM products WHERE product_code = '$code'");

echo "<script>alert('Product deleted successfully');window.location='../master_products.php';</script>";
exit;
?>