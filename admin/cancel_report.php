<?php include 'header.php'; ?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Inventory Report</b></h2>
    <form method="POST" class="form-inline">
        <input type="date" name="date1" class="form-control" value="<?= $_POST['date1'] ?? date('Y-m-d'); ?>">
        —<input type="date" name="date2" class="form-control" value="<?= $_POST['date2'] ?? date('Y-m-d'); ?>">
        <button name="submit" class="btn btn-primary">Show</button>
    </form>
    <br>
    <table class="table table-striped">
        <tr><th>No</th><th>Material</th><th>Qty</th><th>Unit</th><th>Date</th></tr>
        <?php if (isset($_POST['submit'])):
            $d1 = $_POST['date1']; $d2 = $_POST['date2'];
            $r = mysqli_query($conn, "SELECT * FROM inventory WHERE date BETWEEN '$d1' AND '$d2'");
            $no = 1; $total = 0;
            while ($row = mysqli_fetch_assoc($r)): $total += (int)$row['qty']; ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= $row['qty']; ?></td>
                    <td><?= $row['unit']; ?></td>
                    <td><?= $row['date']; ?></td>
                </tr>
            <?php endwhile; ?>
            <tr><td colspan="5" align="right"><b>Total quantity: <?= $total; ?></b></td></tr>
        <?php endif; ?>
    </table>
</div>
<?php include 'footer.php'; ?>