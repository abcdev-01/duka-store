<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';
include 'header.php';

$order_id = mysqli_real_escape_string($conn, $_GET['order_id'] ?? '');
$o = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE order_id = '$order_id'"));
if (!$o) {
    echo "<script>alert('Order not found');window.location='orders.php';</script>";
    exit;
}
$c = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM customers WHERE customer_code = '{$o['customer_code']}'"));
$details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '$order_id'");
?>

<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Order Detail #<?= htmlspecialchars($o['order_id']); ?></b></h2>

    <h4>Customer</h4>
    <table class="table table-striped">
        <tr><td>Name</td><td><?= htmlspecialchars($c['name'] ?? '-'); ?></td></tr>
        <tr><td>Address</td><td><?= htmlspecialchars($o['address'] . ', ' . $o['city'] . ', ' . $o['province'] . ' ' . $o['postal_code']); ?></td></tr>
        <tr><td>Phone</td><td><?= htmlspecialchars($c['phone'] ?? '-'); ?></td></tr>
    </table>

    <h4>Shipping</h4>
    <table class="table table-striped">
        <tr><th>Courier</th><th>Service</th><th>Cost</th><th>ETD</th></tr>
        <tr>
            <td><?= strtoupper(htmlspecialchars($o['courier'])); ?></td>
            <td><?= htmlspecialchars($o['service']); ?></td>
            <td>Rp. <?= number_format($o['shipping_cost']); ?></td>
            <td><?= htmlspecialchars($o['etd']); ?> days</td>
        </tr>
    </table>

    <h4>Items</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th><th>Product</th><th>Size</th>
                <th>Price</th><th>Qty</th><th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $grand = 0; while ($d = mysqli_fetch_assoc($details)) {
                $sub = $d['price'] * $d['qty'];
                $grand += $sub;
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($d['product_name']); ?></td>
                    <td><?= strtoupper(htmlspecialchars($d['size'])); ?></td>
                    <td>Rp. <?= number_format($d['price']); ?></td>
                    <td><?= $d['qty']; ?></td>
                    <td>Rp. <?= number_format($sub); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="6" align="right"><b>Grand Total (incl. shipping): Rp. <?= number_format($grand + $o['shipping_cost']); ?></b></td>
            </tr>
        </tbody>
    </table>

    <h4>Payment Proof</h4>
    <?php if (!empty($o['payment_proof'])) { ?>
        <img src="../image/payments/<?= htmlspecialchars($o['payment_proof']); ?>" width="300">
        <table class="table table-striped" style="width:400px;margin-top:10px;">
            <tr><td>Bank</td><td><?= htmlspecialchars($o['payment_bank']); ?></td></tr>
            <tr><td>Account Name</td><td><?= htmlspecialchars($o['payment_account_name']); ?></td></tr>
            <tr><td>Amount</td><td>Rp. <?= number_format($o['payment_amount']); ?></td></tr>
        </table>
    <?php } else { ?>
        <p>No payment proof uploaded yet.</p>
    <?php } ?>

    <br>
    <a href="orders.php" class="btn btn-default">Back</a>
</div>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>