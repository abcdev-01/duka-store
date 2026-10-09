<?php
require_once __DIR__ . '/../connection/connection.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=cancellation_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

$d1 = $_POST['date1'] ?? date('Y-m-d');
$d2 = $_POST['date2'] ?? date('Y-m-d');
$r = mysqli_query($conn, "
    SELECT od.*, o.date
    FROM order_details od
    JOIN orders o ON od.order_id = o.order_id
    WHERE o.rejected = 1 AND DATE(o.date) BETWEEN '$d1' AND '$d2'
");
?>
<table border="1">
    <tr><th>No</th><th>Product</th><th>Date</th><th>Qty</th></tr>
    <?php
    $no = 1; $total = 0;
    while ($row = mysqli_fetch_assoc($r)) {
        $total += $row['qty'];
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['product_name']); ?></td>
            <td><?= $row['date']; ?></td>
            <td><?= $row['qty']; ?></td>
        </tr>
    <?php } ?>
    <tr><td colspan="3" align="right"><b>Total cancelled</b></td><td><b><?= $total; ?></b></td></tr>
</table>