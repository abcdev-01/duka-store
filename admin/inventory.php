<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';
include 'header.php';
?>

<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Inventory Materials</b></h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Material Code</th>
                <th scope="col">Name</th>
                <th scope="col">Stock</th>
                <th scope="col">Unit</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM inventory ORDER BY material_code ASC");
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= htmlspecialchars($row['material_code']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['qty']); ?></td>
                    <td><?= htmlspecialchars($row['unit']); ?></td>
                    <td><?= "Rp. " . number_format($row['price']) . " / " . htmlspecialchars($row['unit']); ?></td>
                    <td>
                        <a href="edit_inventory.php?code=<?= $row['material_code']; ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="process/delete_inventory.php?code=<?= $row['material_code']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this material?')"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <a href="add_inventory.php" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Material</a>
</div>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>