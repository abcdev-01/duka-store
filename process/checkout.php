<?php
session_start();
include '../connection/connection.php';

if (!isset($_SESSION['customer_code'])) {
    header('location:../user_login.php');
    exit;
}
$customer_code = $_SESSION['customer_code'];

$total = intval($_POST['total']);
$weight = intval($_POST['weight']);
$courier = mysqli_real_escape_string($conn, $_POST['courier']);
$package = mysqli_real_escape_string($conn, $_POST['package']);
$shipping_cost = intval($_POST['shipping_cost']);
$etd = mysqli_real_escape_string($conn, $_POST['etd']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$province = mysqli_real_escape_string($conn, $_POST['province_name']);
$city = mysqli_real_escape_string($conn, $_POST['city_name']);
$postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

$order_id = 'INV' . date('YmdHis') . rand(10, 99);

$insert = mysqli_query($conn, "
    INSERT INTO orders
    (order_id, customer_code, date, total, weight, courier, service, shipping_cost, etd, address, province, city, postal_code, phone, status)
    VALUES
    ('$order_id', '$customer_code', NOW(), '$total', '$weight', '$courier', '$package', '$shipping_cost', '$etd', '$address', '$province', '$city', '$postal_code', '$phone', 'New Order')
");

if (!$insert) {
    echo "<script>alert('Failed to place order');window.location='../checkout.php';</script>";
    exit;
}

$cart = mysqli_query($conn, "SELECT * FROM cart WHERE customer_code = '$customer_code'");
while ($row = mysqli_fetch_assoc($cart)) {
    mysqli_query($conn, "
        INSERT INTO order_details
        (order_id, product_code, product_name, qty, price, size)
        VALUES
        ('$order_id', '{$row['product_code']}', '{$row['product_name']}', '{$row['qty']}', '{$row['price']}', '{$row['size']}')
    ");
}

mysqli_query($conn, "DELETE FROM cart WHERE customer_code = '$customer_code'");
$_SESSION['inv'] = $order_id;
$_SESSION['new_order'] = true;

echo "<script>alert('Order placed successfully');window.location='../my_orders.php';</script>";
?>