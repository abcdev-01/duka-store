<?php include 'header.php'; ?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Sales Report</b></h2>

    <form action="" method="POST" class="form-inline">
        <input type="date" name="date1" class="form-control" value="<?= $_POST['date1'] ?? date('Y-m-d'); ?>">
        &nbsp;—&nbsp;
        <input type="date" name="date2" class="form-control" value="<?= $_POST['date2'] ?? date('Y-m-d'); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Show</button>
    </form>
    <br>

    <table class="table table-striped">
        <tr><th>No</th><th>Order ID</th><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Date</th></tr>
        <?php if (isset($_POST['submit'])):
            $d1 = $_POST['date1']; $d2 = $_POST['date2'];
            $r = mysqli_query($conn, "SELECT * FROM orders WHERE accepted = 1 AND DATE(date) BETWEEN '$d1' AND '$d2'");
            $no = 1; $total = 0; $qty_total = 0;
            while ($row = mysqli_fetch_assoc($r)):
                $details = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = '{$row['order_id']}'");
                while ($d = mysqli_fetch_assoc($details)):
                    $sub = $d['price'] * $d['qty']; $total += $sub; $qty_total += $d['qty']; ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['order_id']; ?></td>
                        <td><?= htmlspecialchars($d['product_name']); ?></td>
                        <td>Rp. <?= number_format($d['price']); ?></td>
                        <td><?= $d['qty']; ?></td>
                        <td>Rp. <?= number_format($sub); ?></td>
                        <td><?= date('d M Y', strtotime($row['date'])); ?></td>
                    </tr>
                <?php endwhile;
            endwhile; ?>
            <tr><td colspan="7" align="right"><b>Total items: <?= $qty_total; ?></b></td></tr>
            <tr><td colspan="7" align="right"><b>Total revenue: Rp. <?= number_format($total); ?></b></td></tr>
        <?php endif; ?>
    </table>
</div>
<?php include 'footer.php'; ?>