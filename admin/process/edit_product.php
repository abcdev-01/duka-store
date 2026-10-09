<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
    exit;
}
require_once __DIR__ . '/../../connection/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../master_products.php');
    exit;
}

$code        = mysqli_real_escape_string($conn, $_POST['code'] ?? '');
$name        = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$weight      = intval($_POST['weight'] ?? 0);
$description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
$price_arr   = $_POST['price'] ?? [];
$size_arr    = $_POST['size'] ?? [];

// Combine sizes and prices
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

$image_sql = "";

if (!empty($_FILES['image']['name'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
        echo "<script>alert('Image must be JPG, JPEG, or PNG');window.location='../edit_product.php?code=$code';</script>";
        exit;
    }
    if ($_FILES['image']['size'] > 1000000) {
        echo "<script>alert('Image size too large (max 1 MB)');window.location='../edit_product.php?code=$code';</script>";
        exit;
    }
    $new_name = uniqid() . "." . $ext;
    if (move_uploaded_file($_FILES['image']['tmp_name'], "../../image/products/" . $new_name)) {
        $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM products WHERE product_code = '$code'"));
        if ($old && !empty($old['image']) && file_exists("../../image/products/" . $old['image'])) {
            @unlink("../../image/products/" . $old['image']);
        }
        $image_sql = ", image = '$new_name'";
    }
}

$update = mysqli_query($conn, "
    UPDATE products
    SET name = '$name', price = '$price_str', size = '$size_str',
        weight = '$weight', description = '$description' $image_sql
    WHERE product_code = '$code'
");

if ($update) {
    echo "<script>alert('Product updated successfully');window.location='../master_products.php';</script>";
} else {
    echo "<script>alert('Failed to update product');window.location='../edit_product.php?code=$code';</script>";
}
exit;
?>