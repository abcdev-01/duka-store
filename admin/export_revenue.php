<?php
include '../connection/connection.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=revenue_report.xls");

$d1 = $_POST['date1'] ?? date('Y-m-d');
$d2 = $_POST['date2'] ?? date('Y-m-d');
$r = mysqli_query($conn, "SELECT * FROM orders WHERE accepted = 1 AND DATE(date) BETWEEN '$d1' AND '$d2'");
?>
<table border="1">
    <tr><th>Order ID</th><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Date</th></tr>
    <?php $total = 0; while ($o = mysqli_fetch_assoc($r)) {
        $details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '{$o['order_id']}'");
        while ($d = mysqli_fetch_assoc($details)) { $sub = $d['price'] * $d['qty']; $total += $sub; ?>
            <tr>
                <td><?= $o['order_id']; ?></td>
                <td><?= htmlspecialchars($d['product_name']); ?></td>
                <td><?= $d['price']; ?></td>
                <td><?= $d['qty']; ?></td>
                <td><?= $sub; ?></td>
                <td><?= $o['date']; ?></td>
            </tr>
        <?php } } ?>
    <tr><td colspan="4" align="right"><b>Total</b></td><td colspan="2"><b><?= $total; ?></b></td></tr>
</table>