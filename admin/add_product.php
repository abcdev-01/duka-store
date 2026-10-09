<?php
include 'header.php';
$q = mysqli_query($conn, "SELECT product_code FROM products ORDER BY product_code DESC LIMIT 1");
$last = mysqli_fetch_assoc($q);
$num = $last ? ((int)substr($last['product_code'], 1)) + 1 : 1;
$format = "P" . str_pad($num, 4, "0", STR_PAD_LEFT);
?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Add Product</b></h2>
    <form action="process/add_product.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" required>
            <p class="help-block">JPG, JPEG, PNG — max 1MB</p>
        </div>
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Product Code</label>
                <input type="text" class="form-control" disabled value="<?= $format; ?>">
                <input type="hidden" name="code" value="<?= $format; ?>">
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" name="name" required>
            </div></div>
        </div>

        <?php for ($i = 0; $i < 5; $i++) { ?>
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Size <?= $i+1; ?></label>
                <select name="size[]" class="form-control">
                    <option value="">-- Select --</option>
                    <option value="s">S</option><option value="m">M</option>
                    <option value="l">L</option><option value="xl">XL</option>
                    <option value="xxl">XXL</option>
                </select>
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Price <?= $i+1; ?></label>
                <input type="number" name="price[]" class="form-control">
            </div></div>
        </div>
        <?php } ?>

        <div class="form-group">
            <label>Weight (gram)</label>
            <input type="number" name="weight" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="master_products.php" class="btn btn-danger">Cancel</a>
    </form>
</div>
<br><br><br>
<?php include 'footer.php'; ?>