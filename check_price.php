<?php
include 'connection/connection.php';
$size = $_POST['size'] ?? '';
$code = $_POST['code'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM products WHERE product_code = '$code'");
$row = mysqli_fetch_assoc($result);

$sizes = explode(",", $row['size']);
$prices = explode(",", $row['price']);
$count = count($sizes);

$raw = "";
$formatted = "";

for ($i = 0; $i < $count; $i++) {
    if ($size === $sizes[$i]) {
        $raw = $prices[$i];
        $formatted = "Rp. " . number_format($prices[$i]);
    }
    if ($size === "") {
        if (strpos($row['price'], ",") === false) {
            $raw = $row['price'];
            $formatted = "Rp. " . number_format($row['price']);
        } else {
            $p = explode(",", $row['price']);
            $raw = $p[0] . " - " . end($p);
            $formatted = "Rp. " . number_format($p[0]) . " - " . number_format(end($p));
        }
    }
}

echo $formatted . "|" . $raw;
?>