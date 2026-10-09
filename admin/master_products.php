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
    <h2 style="border-bottom:4px solid gray;"><b>Master Products</b></h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Product Code</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM products ORDER BY product_code ASC");
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['product_code']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><img src="../image/products/<?= htmlspecialchars($row['image']); ?>" width="100"></td>
                    <td>
                        <?php
                        if (strpos($row['price'], ",") === false) {
                            echo "Rp. " . number_format($row['price']);
                        } else {
                            $p = explode(",", $row['price']);
                            echo "Rp. " . number_format($p[0]) . " - " . number_format(end($p));
                        }
                        ?>
                    </td>
                    <td>
                        <a href="edit_product.php?code=<?= $row['product_code']; ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="process/delete_product.php?code=<?= $row['product_code']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this product?')"><i class="glyphicon glyphicon-trash"></i></a>
                        <a href="bom.php?code=<?= $row['product_code']; ?>" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-eye-open"></i> View BOM</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <a href="add_product.php" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Product</a>
</div>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>