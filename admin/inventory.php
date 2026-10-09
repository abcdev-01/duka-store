<?php include 'header.php'; ?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Inventory</b></h2>
    <table class="table table-striped">
        <thead><tr>
            <th>No</th><th>Material Code</th><th>Name</th><th>Stock</th><th>Unit</th><th>Price</th><th>Action</th>
        </tr></thead>
        <tbody>
        <?php $no = 1; $r = mysqli_query($conn, "SELECT * FROM inventory ORDER BY material_code");
        while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['material_code']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= $row['qty']; ?></td>
                <td><?= $row['unit']; ?></td>
                <td>Rp. <?= number_format($row['price']); ?></td>
                <td>
                    <a href="edit_inventory.php?code=<?= $row['material_code']; ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="process/delete_inventory.php?code=<?= $row['material_code']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete?')"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="add_inventory.php" class="btn btn-success">+ Add Material</a>
</div>
<?php include 'footer.php'; ?>