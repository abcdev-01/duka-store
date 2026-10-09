<?php
include '../../connection/connection.php';

$code = $_POST['code'];
$name = mysqli_real_escape_string($conn, $_POST['name']);
$weight = intval($_POST['weight']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$price = array_filter($_POST['price']);
$size = [];
foreach ($_POST['size'] as $i => $s) {
    if (!empty($_POST['price'][$i])) $size[] = $s;
}
$price_str = implode(",", $price);
$size_str = implode(",", $size);

$image_update = "";
if (!empty($_FILES['image']['name'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png']) && $_FILES['image']['size'] <= 1000000) {
        $new_name = uniqid() . "." . $ext;
        $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM products WHERE product_code = '$code'"));
        if (file_exists("../../image/products/" . $old['image'])) @unlink("../../image/products/" . $old['image']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../../image/products/" . $new_name);
        $image_update = ", image = '$new_name'";
    }
}

mysqli_query($conn, "
    UPDATE products
    SET name = '$name', price = '$price_str', size = '$size_str',
        weight = '$weight', description = '$description' $image_update
    WHERE product_code = '$code'
");

echo "<script>alert('Product updated');window.location='../master_products.php';</script>";
?>