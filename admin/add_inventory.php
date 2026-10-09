<?php
include 'header.php';
$q = mysqli_query($conn, "SELECT material_code FROM inventory ORDER BY material_code DESC LIMIT 1");
$last = mysqli_fetch_assoc($q);
$num = $last ? ((int)substr($last['material_code'], 1)) + 1 : 1;
$code = "M" . str_pad($num, 4, "0", STR_PAD_LEFT);
?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Add Material</b></h2>
    <form action="process/add_inventory.php" method="POST">
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Material Code</label>
                <input type="text" class="form-control" value="<?= $code; ?>" disabled>
                <input type="hidden" name="code" value="<?= $code; ?>">
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div></div>
        </div>
        <div class="row">
            <div class="col-md-4"><div class="form-group">
                <label>Stock</label><input type="number" name="qty" class="form-control" min="1" required>
            </div></div>
            <div class="col-md-4"><div class="form-group">
                <label>Unit</label><input type="text" name="unit" class="form-control" required>
            </div></div>
            <div class="col-md-4"><div class="form-group">
                <label>Price per unit</label><input type="number" name="price" class="form-control" min="1" required>
            </div></div>
        </div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="inventory.php" class="btn btn-danger">Cancel</a>
    </form>
</div>
<?php include 'footer.php'; ?>