<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
    exit;
}
require_once __DIR__ . '/../../connection/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../inventory.php');
    exit;
}

$code  = mysqli_real_escape_string($conn, $_POST['code'] ?? '');
$name  = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$qty   = intval($_POST['qty'] ?? 0);
$unit  = mysqli_real_escape_string($conn, $_POST['unit'] ?? '');
$price = intval($_POST['price'] ?? 0);
$date  = date('Y-m-d');

$update = mysqli_query($conn, "
    UPDATE inventory
    SET name = '$name', qty = '$qty', unit = '$unit', price = '$price', date = '$date'
    WHERE material_code = '$code'
");

if ($update) {
    echo "<script>alert('Material updated successfully');window.location='../inventory.php';</script>";
} else {
    echo "<script>alert('Failed to update material');window.location='../edit_inventory.php?code=$code';</script>";
}
exit;
?>