<?php
include '../connection/connection.php';

$order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
$bank = mysqli_real_escape_string($conn, $_POST['bank']);
$account_name = mysqli_real_escape_string($conn, $_POST['account_name']);
$amount = intval($_POST['amount']);

$proof = $_FILES['proof']['name'];
$tmp = $_FILES['proof']['tmp_name'];
$ext = strtolower(pathinfo($proof, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {
    echo "<script>alert('Only JPG, JPEG, PNG allowed');window.location='../payment_confirmation.php?order_id=$order_id';</script>";
    exit;
}

$new_name = uniqid() . "." . $ext;
$dir = '../image/payments/';
if (!is_dir($dir)) mkdir($dir, 0777, true);
move_uploaded_file($tmp, $dir . $new_name);

mysqli_query($conn, "
    UPDATE orders
    SET status = 'Waiting Confirmation',
        payment_proof = '$new_name',
        payment_date = NOW(),
        payment_amount = '$amount',
        payment_bank = '$bank',
        payment_account_name = '$account_name'
    WHERE order_id = '$order_id'
");

echo "<script>alert('Payment confirmation submitted');window.location='../my_orders.php';</script>";
?>