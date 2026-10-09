<?php include 'header.php'; ?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Master Products</b></h2>
    <table class="table table-striped">
        <thead><tr>
            <th>No</th><th>Product Code</th><th>Name</th><th>Image</th><th>Price</th><th>Action</th>
        </tr></thead>
        <tbody>
        <?php $no = 1; $r = mysqli_query($conn, "SELECT * FROM products");
        while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['product_code']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><img src="../image/products/<?= $row['image']; ?>" width="100"></td>
                <td>
                    <?php
                    if (strpos($row['price'], ",") === false) echo "Rp. " . number_format($row['price']);
                    else { $p = explode(",", $row['price']); echo "Rp. " . number_format($p[0]) . " - " . number_format(end($p)); }
                    ?>
                </td>
                <td>
                    <a href="edit_product.php?code=<?= $row['product_code']; ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="process/delete_product.php?code=<?= $row['product_code']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this product?')"><i class="glyphicon glyphicon-trash"></i></a>
                    <a href="bom.php?code=<?= $row['product_code']; ?>" class="btn btn-primary btn-sm">View BOM</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="add_product.php" class="btn btn-success">+ Add Product</a>
</div>
<br><br><br>
<?php include 'footer.php'; ?>