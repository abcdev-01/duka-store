<?php include 'header.php'; ?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Profit Report</b></h2>
    <form method="POST" class="form-inline">
        <input type="date" name="date1" class="form-control" value="<?= $_POST['date1'] ?? date('Y-m-d'); ?>">
        —<input type="date" name="date2" class="form-control" value="<?= $_POST['date2'] ?? date('Y-m-d'); ?>">
        <button name="submit" class="btn btn-primary">Show</button>
    </form>
    <br>

    <?php if (isset($_POST['submit'])):
        $d1 = $_POST['date1']; $d2 = $_POST['date2'];
        $r = mysqli_query($conn, "SELECT * FROM orders WHERE accepted = 1 AND DATE(date) BETWEEN '$d1' AND '$d2'");
        $gross = 0; $material_cost = 0;

        $rows = [];
        while ($o = mysqli_fetch_assoc($r)) {
            $details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '{$o['order_id']}'");
            while ($d = mysqli_fetch_assoc($details)) {
                $gross += $d['price'] * $d['qty'];
                $bom = mysqli_query($conn, "
                    SELECT b.requirement, i.price
                    FROM product_bom b JOIN inventory i ON b.material_code = i.material_code
                    WHERE b.product_code = '{$d['product_code']}'
                ");
                while ($b = mysqli_fetch_assoc($bom)) {
                    $material_cost += $b['price'] * $b['requirement'] * $d['qty'];
                }
                $rows[] = $d;
            }
        }
        $net = $gross - $material_cost;
        ?>
        <h4>Gross Revenue: Rp. <?= number_format($gross); ?></h4>
        <h4>Material Cost: Rp. <?= number_format($material_cost); ?></h4>
        <h3 class="bg-success" style="padding:10px;">Net Profit: Rp. <?= number_format($net); ?></h3>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>