<?php
require_once __DIR__ . '/../connection/connection.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=profit_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

$d1 = $_POST['date1'] ?? date('Y-m-d');
$d2 = $_POST['date2'] ?? date('Y-m-d');
$r = mysqli_query($conn, "SELECT * FROM orders WHERE accepted = 1 AND DATE(date) BETWEEN '$d1' AND '$d2'");
$gross = 0; $material_cost = 0;
?>
<table border="1">
    <tr>
        <th>No</th><th>Order ID</th><th>Product</th>
        <th>Price</th><th>Qty</th><th>Subtotal</th><th>Date</th>
    </tr>
    <?php
    $no = 1;
    while ($o = mysqli_fetch_assoc($r)) {
        $details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '{$o['order_id']}'");
        while ($d = mysqli_fetch_assoc($details)) {
            $sub = $d['price'] * $d['qty'];
            $gross += $sub;

            $bom = mysqli_query($conn, "
                SELECT b.requirement, i.price
                FROM product_bom b
                JOIN inventory i ON b.material_code = i.material_code
                WHERE b.product_code = '{$d['product_code']}'
            ");
            while ($b = mysqli_fetch_assoc($bom)) {
                $material_cost += $b['price'] * $b['requirement'] * $d['qty'];
            }
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($o['order_id']); ?></td>
                <td><?= htmlspecialchars($d['product_name']); ?></td>
                <td><?= number_format($d['price']); ?></td>
                <td><?= $d['qty']; ?></td>
                <td><?= number_format($sub); ?></td>
                <td><?= $o['date']; ?></td>
            </tr>
        <?php } } ?>
</table>

<br><br>

<table border="1">
    <tr><th>Description</th><th>Amount</th></tr>
    <tr><td>Gross Revenue</td><td><?= number_format($gross); ?></td></tr>
    <tr><td>Material Cost</td><td>-<?= number_format($material_cost); ?></td></tr>
    <tr><td><b>Net Profit</b></td><td><b><?= number_format($gross - $material_cost); ?></b></td></tr>
</table>