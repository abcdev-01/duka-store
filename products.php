<?php
require_once __DIR__ . '/connection/connection.php';
 include 'header.php'; ?>

<div class="container">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Our Products</b></h2>
    <div class="row">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products GROUP BY product_code");
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="image/products/<?= $row['image']; ?>">
                    <div class="caption">
                        <h3><?= htmlspecialchars($row['name']); ?></h3>
                        <h4>
                            <?php
                            if (strpos($row['price'], ",") === false) {
                                echo "Rp. " . number_format($row['price']);
                            } else {
                                $p = explode(",", $row['price']);
                                echo "Rp. " . number_format($p[0]) . " - " . number_format(end($p));
                            }
                            ?>
                        </h4>
                        <a href="product_detail.php?product=<?= $row['product_code']; ?>" class="btn btn-warning btn-block">Detail</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>