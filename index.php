<?php include 'header.php'; ?>

<div class="container-fluid" style="margin:0;padding:0;">
    <div style="margin-top:-21px;">
        <img src="image/home/1.jpg" style="width:100%;height:530px;object-fit:cover;">
    </div>
</div>
<br><br>

<div class="container">
    <h4 class="text-center" style="font-family:arial;padding:10px;font-style:italic;line-height:29px;border-top:8px double #d9b712;border-bottom:8px double #d9b712;">
        Batik Al Barokah is a traditional hand-drawn batik center in Pakandangan Barat Village, Bluto, Sumenep, Madura. It has existed since the Dutch colonial era and the Sumenep Kingdom. Until now, this batik center is still surviving. While maintaining the tradition of hand-drawn batik, they continue to follow the development of motifs and designs in batik making.
    </h4>

    <h2 style="border-bottom:4px solid #d9b712;color:#4d0000;margin-top:80px;"><b>Our Products</b></h2>

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
<br><br><br><br>

<?php include 'footer.php'; ?>