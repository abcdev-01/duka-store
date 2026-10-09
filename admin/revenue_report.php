<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';
include 'header.php';

$first_day = date('Y-m-01');
$today = date('Y-m-d');
$date1 = $_POST['date1'] ?? $first_day;
$date2 = $_POST['date2'] ?? $today;
?>

<style type="text/css">
    @media print { .print { display: none; } }
</style>

<div class="container">
    <h2 style="border-bottom:4px solid gray;padding-bottom:5px;"><b>Sales Report</b></h2>

    <div class="row print">
        <div class="col-md-9">
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <tr>
                        <td><input type="date" name="date1" class="form-control" value="<?= htmlspecialchars($date1); ?>"></td>
                        <td>&nbsp; - &nbsp;</td>
                        <td><input type="date" name="date2" class="form-control" value="<?= htmlspecialchars($date2); ?>"></td>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" class="btn btn-primary" value="Show"></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="col-md-3">
            <form action="export_revenue.php" method="POST">
                <table>
                    <tr>
                        <td><input type="hidden" name="date1" value="<?= htmlspecialchars($date1); ?>"></td>
                        <td><input type="hidden" name="date2" value="<?= htmlspecialchars($date2); ?>"></td>
                        <td><button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save-file"></i> Export to Excel</button></td>
                        <td>&nbsp;</td>
                        <td><a href="" onclick="window.print()" class="btn btn-default"><i class="glyphicon glyphicon-print"></i> Print</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <br><br>

    <table class="table table-striped">
        <tr>
            <th>No</th><th>Order ID</th><th>Product</th>
            <th>Price</th><th>Qty</th><th>Subtotal</th><th>Date</th>
        </tr>
        <?php
        if (isset($_POST['submit'])) {
            $r = mysqli_query($conn, "SELECT * FROM orders WHERE accepted = 1 AND DATE(date) BETWEEN '$date1' AND '$date2'");
            $no = 1; $total = 0; $qty_total = 0;
            while ($o = mysqli_fetch_assoc($r)) {
                $details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '{$o['order_id']}'");
                while ($d = mysqli_fetch_assoc($details)) {
                    $sub = $d['price'] * $d['qty'];
                    $total += $sub;
                    $qty_total += $d['qty'];
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($o['order_id']); ?></td>
                        <td><?= htmlspecialchars($d['product_name']); ?></td>
                        <td>Rp. <?= number_format($d['price']); ?></td>
                        <td><?= $d['qty']; ?></td>
                        <td>Rp. <?= number_format($sub); ?></td>
                        <td><?= date('d M Y', strtotime($o['date'])); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr><td colspan="7" class="text-right"><b>Total items = <?= $qty_total; ?></b></td></tr>
            <tr><td colspan="7" class="text-right alert-success"><b>Total revenue = Rp. <?= number_format($total); ?></b></td></tr>
            <?php
        }
        ?>
    </table>
</div>
<br><br><br><br><br>
<?php include 'footer.php'; ?>