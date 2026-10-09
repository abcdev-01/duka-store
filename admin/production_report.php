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
    <h2 style="border-bottom:4px solid gray;padding-bottom:5px;"><b>Production Report</b></h2>

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
            <form action="export_production.php" method="POST">
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
        <tr><th>No</th><th>Product</th><th>Date</th><th>Total Production</th></tr>
        <?php
        if (isset($_POST['submit'])) {
            $r = mysqli_query($conn, "SELECT * FROM orders WHERE accepted = 1 AND DATE(date) BETWEEN '$date1' AND '$date2'");
            $no = 1; $total = 0;
            while ($o = mysqli_fetch_assoc($r)) {
                $details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '{$o['order_id']}'");
                while ($d = mysqli_fetch_assoc($details)) {
                    $total += $d['qty'];
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($d['product_name']); ?></td>
                        <td><?= date('d M Y', strtotime($o['date'])); ?></td>
                        <td><?= $d['qty']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr><td colspan="4" class="text-right"><b>Total produced = <?= $total; ?></b></td></tr>
            <?php
        }
        ?>
    </table>
</div>
<br><br><br><br><br>
<?php include 'footer.php'; ?>