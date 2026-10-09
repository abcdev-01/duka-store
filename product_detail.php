<?php
require_once __DIR__ . '/connection/connection.php';
include 'header.php';
$product_code = mysqli_real_escape_string($conn, $_GET['product'] ?? '');
$result = mysqli_query($conn, "SELECT * FROM products WHERE product_code = '$product_code'");
$row = mysqli_fetch_assoc($result);
if (!$row) { echo "<script>alert('Product not found');window.location='products.php';</script>"; exit; }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="container">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Product Detail</b></h2>

    <div class="row">
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="image/products/<?= $row['image']; ?>" width="400">
            </div>
        </div>

        <div class="col-md-8">
            <form action="process/add.php" method="GET">
                <input type="hidden" name="customer_code" value="<?= $customer_code ?? ''; ?>">
                <input type="hidden" name="weight" value="<?= $row['weight']; ?>">
                <input type="hidden" id="code" name="product" value="<?= $product_code; ?>">
                <input type="hidden" name="price" id="set_price">

                <table class="table table-striped">
                    <tr><td><b>Name</b></td><td><?= htmlspecialchars($row['name']); ?></td></tr>
                    <tr>
                        <td><b>Price</b></td>
                        <td id="price">
                            <?php
                            if (strpos($row['price'], ",") === false) {
                                echo "Rp. " . number_format($row['price']);
                            } else {
                                $p = explode(",", $row['price']);
                                echo "Rp. " . number_format($p[0]) . " - " . number_format(end($p));
                            }
                            ?>
                        </td>
                    </tr>
                    <tr><td><b>Description</b></td><td><?= nl2br(htmlspecialchars($row['description'])); ?></td></tr>
                    <tr>
                        <td><b>Size</b></td>
                        <?php $sizes = explode(",", $row['size']); ?>
                        <td>
                            <select class="form-control" style="width:155px;" name="size" id="size" required>
                                <option value="">-- Select Size --</option>
                                <?php foreach ($sizes as $s) { ?>
                                    <option value="<?= $s; ?>"><?= strtoupper($s); ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Quantity</b></td>
                        <td><input class="form-control" type="number" min="1" name="qty" value="1" style="width:155px;"></td>
                    </tr>
                </table>

                <?php if (isset($_SESSION['user'])) { ?>
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</button>
                <?php } else { ?>
                    <a href="cart.php" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>
                <?php } ?>
                <a href="index.php" class="btn btn-warning">Continue Shopping</a>
            </form>
        </div>
    </div>
</div>
<br><br><br>

<script>
$(document).ready(function() {
    $("#size").change(function() {
        $.ajax({
            type: 'POST',
            url: 'check_price.php',
            data: { size: $('#size').val(), code: $('#code').val() },
            success: function(data) {
                var arr = data.split("|");
                $("#price").html(arr[0]);
                $("#set_price").val(arr[1]);
            }
        });
    });
});
</script>

<?php include 'footer.php'; ?>