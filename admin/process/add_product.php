<?php
include '../../connection/connection.php';

$code = $_POST['code'];
$name = mysqli_real_escape_string($conn, $_POST['name']);
$price = $_POST['price'];
$size = $_POST['size'];
$weight = intval($_POST['weight']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$file = $_FILES['image'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, ['jpg','jpeg','png'])) {
    echo "<script>alert('Only JPG, JPEG, PNG allowed');window.location='../add_product.php';</script>";
    exit;
}
if ($file['size'] > 1000000) {
    echo "<script>alert('File too large');window.location='../add_product.php';</script>";
    exit;
}
$new_name = uniqid() . "." . $ext;
move_uploaded_file($file['tmp_name'], "../../image/products/" . $new_name);

$valid_price = array_filter($price);
$valid_size = [];
foreach ($size as $i => $s) {
    if (!empty($price[$i])) $valid_size[] = $s;
}

$price_str = implode(",", array_filter($price));
$size_str = implode(",", $valid_size);

mysqli_query($conn, "
    INSERT INTO products (product_code, name, price, size, weight, description, image)
    VALUES ('$code', '$name', '$price_str', '$size_str', '$weight', '$description', '$new_name')
");

echo "<script>alert('Product added successfully');window.location='../master_products.php';</script>";
?>