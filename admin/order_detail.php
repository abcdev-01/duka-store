<?php include 'header.php';
$id = mysqli_real_escape_string($conn, $_GET['order_id']);
$o = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE order_id = '$id'"));
$c = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM customers WHERE customer_code = '{$o['customer_code']}'"));
$details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '$id'");
?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Order Detail #<?= $o['order_id']; ?></b></h2>

    <h4>Customer</h4>
    <table class="table table-striped">
        <tr><td>Name</td><td><?= htmlspecialchars($c['name']); ?></td></tr>
        <tr><td>Address</td><td><?= htmlspecialchars($o['address'] . ', ' . $o['city'] . ', ' . $o['province'] . ' ' . $o['postal_code']); ?></td></tr>
        <tr><td>Phone</td><td><?= htmlspecialchars($c['phone']); ?></td></tr>
    </table>

    <h4>Shipping</h4>
    <table class="table table-striped">
        <tr><th>Courier</th><th>Service</th><th>Cost</th><th>ETD</th></tr>
        <tr>
            <td><?= strtoupper($o['courier']); ?></td>
            <td><?= $o['service']; ?></td>
            <td>Rp. <?= number_format($o['shipping_cost']); ?></td>
            <td><?= $o['etd']; ?> days</td>
        </tr>
    </table>

    <h4>Items</h4>
    <table class="table table-striped">
        <tr><th>No</th><th>Product</th><th>Size</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
        <?php $no = 1; $grand = 0; while ($d = mysqli_fetch_assoc($details)) {
            $sub = $d['price'] * $d['qty']; $grand += $sub; ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($d['product_name']); ?></td>
                <td><?= strtoupper($d['size']); ?></td>
                <td>Rp. <?= number_format($d['price']); ?></td>
                <td><?= $d['qty']; ?></td>
                <td>Rp. <?= number_format($sub); ?></td>
            </tr>
        <?php } ?>
        <tr><td colspan="6" align="right"><b>Grand Total: Rp. <?= number_format($grand + $o['shipping_cost']); ?></b></td></tr>
    </table>

    <h4>Payment Proof</h4>
    <?php if (!empty($o['payment_proof'])) { ?>
        <img src="../image/payments/<?= $o['payment_proof']; ?>" width="300">
    <?php } else { ?>
        <p>No payment proof uploaded yet.</p>
    <?php } ?>

    <br><br><a href="orders.php" class="btn btn-default">Back</a>
</div>
<?php include 'footer.php'; ?>