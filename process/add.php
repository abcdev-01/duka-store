<?php
session_start();
include '../connection/connection.php';

$customer_code = $_GET['customer_code'] ?? '';
$product_code = $_GET['product'] ?? '';
$size = $_GET['size'] ?? '';
$price = $_GET['price'] ?? '';
$weight = $_GET['weight'] ?? 0;
$qty = intval($_GET['qty'] ?? 1);

if (empty($customer_code)) {
    echo "<script>alert('Please login first');window.location='../user_login.php';</script>";
    exit;
}

$prod = mysqli_query($conn, "SELECT * FROM products WHERE product_code = '$product_code'");
$row = mysqli_fetch_assoc($prod);
$product_name = $row['name'];

$check = mysqli_query($conn, "SELECT * FROM cart WHERE product_code = '$product_code' AND customer_code = '$customer_code' AND size = '$size'");
if (mysqli_num_rows($check) > 0) {
    $existing = mysqli_fetch_assoc($check);
    $new_qty = $existing['qty'] + $qty;
    mysqli_query($conn, "UPDATE cart SET qty = '$new_qty' WHERE cart_id = '{$existing['cart_id']}'");
} else {
    mysqli_query($conn, "INSERT INTO cart VALUES('','$customer_code','$product_code','$product_name','$qty','$price','$weight','$size')");
}

echo "<script>alert('Successfully added to cart');window.location='../product_detail.php?product=$product_code';</script>";
?>