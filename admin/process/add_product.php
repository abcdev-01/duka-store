<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
    exit;
}
require_once __DIR__ . '/../../connection/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../add_product.php');
    exit;
}

$code        = mysqli_real_escape_string($conn, $_POST['code'] ?? '');
$name        = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$weight      = intval($_POST['weight'] ?? 0);
$description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
$price_arr   = $_POST['price'] ?? [];
$size_arr    = $_POST['size'] ?? [];

if (empty($_FILES['image']['name'])) {
    echo "<script>alert('No image selected');window.location='../add_product.php';</script>";
    exit;
}

$file = $_FILES['image'];
$ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
    echo "<script>alert('Image must be JPG, JPEG, or PNG');window.location='../add_product.php';</script>";
    exit;
}
if ($file['size'] > 1000000) {
    echo "<script>alert('Image size too large (max 1 MB)');window.location='../add_product.php';</script>";
    exit;
}

$new_name = uniqid() . "." . $ext;
if (!move_uploaded_file($file['tmp_name'], "../../image/products/" . $new_name)) {
    echo "<script>alert('Failed to upload image');window.location='../add_product.php';</script>";
    exit;
}

// Combine sizes and prices, only where both are set
$sizes  = [];
$prices = [];
foreach ($price_arr as $i => $p) {
    if (!empty($p) && !empty($size_arr[$i])) {
        $prices[] = (int) $p;
        $sizes[]  = $size_arr[$i];
    }
}

$price_str = implode(",", $prices);
$size_str  = implode(",", $sizes);

$insert = mysqli_query($conn, "
    INSERT INTO products (product_code, name, price, size, weight, description, image)
    VALUES ('$code', '$name', '$price_str', '$size_str', '$weight', '$description', '$new_name')
");

if ($insert) {
    echo "<script>alert('Product added successfully');window.location='../master_products.php';</script>";
} else {
    echo "<script>alert('Failed to add product');window.location='../add_product.php';</script>";
}
exit;
?>