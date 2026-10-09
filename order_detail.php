<?php
require_once __DIR__ . '/connection/connection.php';
include 'header.php';

$order_id = mysqli_real_escape_string($conn, $_GET['order_id'] ?? '');
$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE order_id = '$order_id'"));
if (!$order) { echo "<script>alert('Order not found');window.location='my_orders.php';</script>"; exit; }
$details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '$order_id'");
?>

<div class="container">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Order Detail #<?= $order['order_id']; ?></b></h2>

    <p><b>Status:</b> <?= htmlspecialchars($order['status']); ?></p>
    <p><b>Address:</b> <?= htmlspecialchars($order['address'] . ', ' . $order['city'] . ', ' . $order['province'] . ' ' . $order['postal_code']); ?></p>
    <p><b>Courier:</b> <?= strtoupper($order['courier']); ?> — <?= $order['service']; ?> (<?= $order['etd']; ?> days)</p>

    <table class="table table-striped">
        <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Size</th><th>Subtotal</th></tr></thead>
        <tbody>
        <?php $total = 0; while ($d = mysqli_fetch_assoc($details)) {
            $sub = $d['price'] * $d['qty']; $total += $sub; ?>
            <tr>
                <td><?= htmlspecialchars($d['product_name']); ?></td>
                <td>Rp. <?= number_format($d['price']); ?></td>
                <td><?= $d['qty']; ?></td>
                <td><?= strtoupper($d['size']); ?></td>
                <td>Rp. <?= number_format($sub); ?></td>
            </tr>
        <?php } ?>
        <tr><td colspan="4" align="right">Shipping Cost</td><td>Rp. <?= number_format($order['shipping_cost']); ?></td></tr>
        <tr><td colspan="4" align="right"><b>Grand Total</b></td>
            <td><b>Rp. <?= number_format($total + $order['shipping_cost']); ?></b></td></tr>
        </tbody>
    </table>

    <a href="my_orders.php" class="btn btn-default">Back</a>
</div>

<?php include 'footer.php'; ?>