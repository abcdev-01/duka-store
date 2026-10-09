<?php
include '../../connection/connection.php';
$code = mysqli_real_escape_string($conn, $_GET['code']);

mysqli_query($conn, "DELETE FROM product_bom WHERE material_code = '$code'");
mysqli_query($conn, "DELETE FROM inventory WHERE material_code = '$code'");

echo "<script>alert('Material deleted');window.location='../inventory.php';</script>";
?>