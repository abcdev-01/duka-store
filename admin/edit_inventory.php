<?php
include 'header.php';
$code = mysqli_real_escape_string($conn, $_GET['code']);
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventory WHERE material_code = '$code'"));
?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Edit Material</b></h2>
    <form action="process/edit_inventory.php" method="POST">
        <input type="hidden" name="code" value="<?= $row['material_code']; ?>">
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Material Code</label>
                <input type="text" class="form-control" disabled value="<?= $row['material_code']; ?>">
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']); ?>">
            </div></div>
        </div>
        <div class="row">
            <div class="col-md-4"><div class="form-group">
                <label>Stock</label><input type="number" name="qty" class="form-control" value="<?= $row['qty']; ?>">
            </div></div>
            <div class="col-md-4"><div class="form-group">
                <label>Unit</label><input type="text" name="unit" class="form-control" value="<?= $row['unit']; ?>">
            </div></div>
            <div class="col-md-4"><div class="form-group">
                <label>Price</label><input type="number" name="price" class="form-control" value="<?= $row['price']; ?>">
            </div></div>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="inventory.php" class="btn btn-danger">Cancel</a>
    </form>
</div>
<?php include 'footer.php'; ?>