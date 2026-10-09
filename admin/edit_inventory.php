<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';
include 'header.php';

$code = mysqli_real_escape_string($conn, $_GET['code'] ?? '');
$row  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventory WHERE material_code = '$code'"));
if (!$row) {
    echo "<script>alert('Material not found');window.location='inventory.php';</script>";
    exit;
}
?>

<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Edit Material</b></h2>

    <form action="process/edit_inventory.php" method="POST">
        <input type="hidden" name="code" value="<?= $row['material_code']; ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Material Code</label>
                    <input type="text" class="form-control" disabled value="<?= $row['material_code']; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($row['name']); ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" class="form-control" name="qty" value="<?= $row['qty']; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Unit</label>
                    <input type="text" class="form-control" name="unit" value="<?= htmlspecialchars($row['unit']); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Price per unit</label>
                    <input type="number" class="form-control" name="price" value="<?= $row['price']; ?>">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> Update</button>
        <a href="inventory.php" class="btn btn-danger">Cancel</a>
    </form>
</div>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>