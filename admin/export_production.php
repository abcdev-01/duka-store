<?php
require_once __DIR__ . '/../connection/connection.php';header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=production_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

$d1 = $_POST['date1'] ?? date('Y-m-d');
$d2 = $_POST['date2'] ?? date('Y-m-d');
$r = mysqli_query($conn, "SELECT * FROM orders WHERE accepted = 1 AND DATE(date) BETWEEN '$d1' AND '$d2'");
?>
<table border="1">
    <tr><th>No</th><th>Product</th><th>Date</th><th>Total Production</th></tr>
    <?php
    $no = 1; $total = 0;
    while ($o = mysqli_fetch_assoc($r)) {
        $details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '{$o['order_id']}'");
        while ($d = mysqli_fetch_assoc($details)) {
            $total += $d['qty'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($d['product_name']); ?></td>
                <td><?= $o['date']; ?></td>
                <td><?= $d['qty']; ?></td>
            </tr>
        <?php } } ?>
    <tr><td colspan="3" align="right"><b>Total production</b></td><td><b><?= $total; ?></b></td></tr>
</table>