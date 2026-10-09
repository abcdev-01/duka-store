<?php
require_once __DIR__ . '/../connection/connection.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=inventory_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

$date1 = $_POST['date1'] ?? date('Y-m-d');
$date2 = $_POST['date2'] ?? date('Y-m-d');
?>
<table border="1">
    <tr>
        <th>No</th>
        <th>Material Name</th>
        <th>Qty</th>
        <th>Unit</th>
        <th>Date</th>
    </tr>
    <?php
    $result = mysqli_query($conn, "SELECT * FROM inventory WHERE date BETWEEN '$date1' AND '$date2'");
    $no = 1;
    $total = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $total += (int) $row['qty'];
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['qty']); ?></td>
            <td><?= htmlspecialchars($row['unit']); ?></td>
            <td><?= htmlspecialchars($row['date']); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="4" align="right"><b>Total of all materials</b></td>
        <td><b><?= $total; ?></b></td>
    </tr>
</table>