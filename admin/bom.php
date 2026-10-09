<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
require_once __DIR__ . '/../connection/connection.php';
include 'header.php';

$code = mysqli_real_escape_string($conn, $_GET['code'] ?? '');
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE product_code = '$code'"));

$bom = mysqli_query($conn, "
    SELECT i.name AS material_name, b.requirement, i.unit
    FROM product_bom b
    JOIN inventory i ON b.material_code = i.material_code
    WHERE b.product_code = '$code'
");
?>

<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Bill of Materials — <?= htmlspecialchars($product['name'] ?? ''); ?></b></h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Material</th>
                <th>Requirement</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($bom) === 0) { ?>
                <tr><td colspan="3" class="text-center">No BOM defined for this product.</td></tr>
            <?php } else { $no = 1; while ($b = mysqli_fetch_assoc($bom)) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($b['material_name']); ?></td>
                    <td><?= htmlspecialchars($b['requirement']) . ' ' . htmlspecialchars($b['unit']); ?></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>

    <a href="master_products.php" class="btn btn-default">Back</a>
</div>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>