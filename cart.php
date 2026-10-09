<?php
include 'header.php';

if (isset($_POST['update'])) {
    $cart_id = intval($_POST['id']);
    $qty = intval($_POST['qty']);
    mysqli_query($conn, "UPDATE cart SET qty = '$qty' WHERE cart_id = '$cart_id'");
    echo "<script>alert('Cart successfully updated');window.location='cart.php';</script>";
} else if (isset($_GET['delete'])) {
    $cart_id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id = '$cart_id'");
    echo "<script>alert('Product removed');window.location='cart.php';</script>";
}
?>

<div class="container" style="padding-bottom:300px;">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Cart</b></h2>
    <table class="table table-striped">
    <?php
    if (isset($_SESSION['user'])) {
        $customer_code = $_SESSION['customer_code'];
        $check = mysqli_query($conn, "SELECT * FROM cart WHERE customer_code = '$customer_code'");
        if (mysqli_num_rows($check) > 0) {
            ?>
            <thead>
                <tr>
                    <th>No</th><th>Image</th><th>Name</th><th>Price</th>
                    <th>Qty</th><th>Size</th><th>SubTotal</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = mysqli_query($conn, "
                SELECT c.cart_id AS cart, c.product_name AS name, c.qty, c.price, c.size, p.image
                FROM cart c
                JOIN products p ON c.product_code = p.product_code
                WHERE c.customer_code = '$customer_code'
            ");
            $no = 1; $total = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $sub = $row['price'] * $row['qty'];
                $total += $sub;
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><img src="image/products/<?= $row['image']; ?>" width="100"></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td>Rp. <?= number_format($row['price']); ?></td>
                    <td>
                        <form action="cart.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['cart']; ?>">
                            <input type="number" name="qty" value="<?= $row['qty']; ?>" class="form-control" style="width:70px;display:inline-block;">
                            <button type="submit" name="update" class="btn btn-warning btn-sm">Update</button>
                        </form>
                    </td>
                    <td><?= strtoupper($row['size']); ?></td>
                    <td>Rp. <?= number_format($sub); ?></td>
                    <td>
                        <a href="cart.php?delete=1&id=<?= $row['cart']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="8" style="text-align:right;font-weight:bold;">Grand Total = Rp. <?= number_format($total); ?></td>
            </tr>
            <tr>
                <td colspan="8" style="text-align:right;">
                    <a href="index.php" class="btn btn-success">Continue Shopping</a>
                    <a href="checkout.php" class="btn btn-primary">Checkout</a>
                </td>
            </tr>
            <?php
        } else {
            echo "<tr><td colspan='7' class='text-center bg-warning'><h5><b>YOUR CART IS EMPTY</b></h5></td></tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='text-center bg-danger'><h5><b>PLEASE LOGIN FIRST BEFORE SHOPPING</b></h5></td></tr>";
    }
    ?>
    </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>