<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';
include 'header.php';

$new      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT order_id) c FROM orders WHERE accepted = 0 AND rejected = 0"))['c'];
$accepted = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT order_id) c FROM orders WHERE accepted = 1"))['c'];
$rejected = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT order_id) c FROM orders WHERE rejected = 1"))['c'];
$customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM customers"))['c'];
$products  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM products"))['c'];
?>

<div class="container">
    <h2 style="border-bottom:4px solid gray;padding-bottom:5px;"><b>Dashboard</b></h2>

    <div class="row">
        <div class="col-md-4">
            <div style="background:#dfdfdf;padding:20px;">
                <h4>NEW ORDERS</h4>
                <h2 style="font-size:56pt;"><b><?= $new; ?></b></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background:#dfdfdf;padding:20px;">
                <h4>ACCEPTED ORDERS</h4>
                <h2 style="font-size:56pt;"><b><?= $accepted; ?></b></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background:#dfdfdf;padding:20px;">
                <h4>REJECTED ORDERS</h4>
                <h2 style="font-size:56pt;"><b><?= $rejected; ?></b></h2>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-6">
            <div style="background:#dfdfdf;padding:20px;">
                <h4>TOTAL CUSTOMERS</h4>
                <h2 style="font-size:40pt;"><b><?= $customers; ?></b></h2>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background:#dfdfdf;padding:20px;">
                <h4>TOTAL PRODUCTS</h4>
                <h2 style="font-size:40pt;"><b><?= $products; ?></b></h2>
            </div>
        </div>
    </div>
</div>

<br><br><br><br><br><br><br>

<?php include 'footer.php'; ?>