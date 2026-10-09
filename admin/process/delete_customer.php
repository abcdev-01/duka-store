<?php
require_once __DIR__ . '/../../connection/connection.php';

if (!isset($_GET['code'])) {
    echo "<script>alert('No customer selected');window.location='../master_customers.php';</script>";
    exit;
}

$code = mysqli_real_escape_string($conn, $_GET['code']);

/* Delete everything tied to this customer, then the customer itself. */

// 1. Cart items
mysqli_query($conn, "DELETE FROM cart WHERE customer_code = '$code'");

// 2. Order details (child of orders)
mysqli_query($conn, "
    DELETE FROM order_details
    WHERE order_id IN (SELECT order_id FROM orders WHERE customer_code = '$code')
");

// 3. Orders
mysqli_query($conn, "DELETE FROM orders WHERE customer_code = '$code'");

// 4. Customer
$delete = mysqli_query($conn, "DELETE FROM customers WHERE customer_code = '$code'");

if ($delete) {
    echo "<script>alert('Customer deleted successfully');window.location='../master_customers.php';</script>";
} else {
    echo "<script>alert('Failed to delete customer');window.location='../master_customers.php';</script>";
}
?>