<?php
include 'header.php';
$code = mysqli_real_escape_string($conn, $_GET['code']);
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE product_code = '$code'"));
$sizes = explode(",", $row['size']);
$prices = explode(",", $row['price']);
?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Edit Product</b></h2>
    <form action="process/edit_product.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <img src="../image/products/<?= $row['image']; ?>" width="100">
            <input type="file" name="image">
            <p class="help-block">Leave empty to keep current image</p>
        </div>
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Product Code</label>
                <input type="text" class="form-control" disabled value="<?= $row['product_code']; ?>">
                <input type="hidden" name="code" value="<?= $row['product_code']; ?>">
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($row['name']); ?>">
            </div></div>
        </div>

        <?php for ($i = 0; $i < count($sizes); $i++) { ?>
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Size <?= $i+1; ?></label>
                <select name="size[]" class="form-control">
                    <?php foreach (['s','m','l','xl','xxl'] as $s) { ?>
                        <option value="<?= $s; ?>" <?= ($sizes[$i] === $s) ? 'selected' : ''; ?>><?= strtoupper($s); ?></option>
                    <?php } ?>
                </select>
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Price <?= $i+1; ?></label>
                <input type="number" name="price[]" class="form-control" value="<?= $prices[$i] ?? ''; ?>">
            </div></div>
        </div>
        <?php } ?>

        <div class="form-group">
            <label>Weight (gram)</label>
            <input type="number" name="weight" class="form-control" value="<?= $row['weight']; ?>">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($row['description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="master_products.php" class="btn btn-danger">Cancel</a>
    </form>
</div>
<?php include 'footer.php'; ?>