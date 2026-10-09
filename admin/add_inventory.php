<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';
include 'header.php';

$q = mysqli_query($conn, "SELECT material_code FROM inventory ORDER BY material_code DESC LIMIT 1");
$last = mysqli_fetch_assoc($q);
$num = $last ? ((int) substr($last['material_code'], 1)) + 1 : 1;
$format = "M" . str_pad($num, 4, "0", STR_PAD_LEFT);
?>

<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Add Material</b></h2>

    <form action="process/add_inventory.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Material Code</label>
                    <input type="text" class="form-control" disabled value="<?= $format; ?>">
                    <input type="hidden" name="code" value="<?= $format; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Material name" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" class="form-control" name="qty" min="1" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Unit</label>
                    <input type="text" class="form-control" name="unit" placeholder="Example: Kodi, ml" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Price per unit</label>
                    <input type="number" class="form-control" name="price" min="1" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add</button>
        <a href="inventory.php" class="btn btn-danger">Cancel</a>
    </form>
</div>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>