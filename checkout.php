<?php
include 'header.php';

if (!isset($_SESSION['customer_code'])) {
    echo "<script>alert('Please login first');window.location='user_login.php';</script>";
    exit;
}

$customer_code = $_SESSION['customer_code'];
$cart_query = mysqli_query($conn, "
    SELECT c.*, p.weight AS product_weight
    FROM cart c
    JOIN products p ON c.product_code = p.product_code
    WHERE c.customer_code = '$customer_code'
");

if (mysqli_num_rows($cart_query) === 0) {
    echo "<script>alert('Your cart is empty');window.location='cart.php';</script>";
    exit;
}

$total = 0; $total_weight = 0;
$items = [];
while ($row = mysqli_fetch_assoc($cart_query)) {
    $items[] = $row;
    $total += $row['price'] * $row['qty'];
    $total_weight += $row['product_weight'] * $row['qty'];
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="container" style="padding-bottom:200px;">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Checkout</b></h2>

    <h4>Order Summary</h4>
    <table class="table table-striped">
        <tr><th>Name</th><th>Size</th><th>Price</th><th>Qty</th><th>SubTotal</th></tr>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']); ?></td>
                <td><?= strtoupper($item['size']); ?></td>
                <td>Rp. <?= number_format($item['price']); ?></td>
                <td><?= $item['qty']; ?></td>
                <td>Rp. <?= number_format($item['price'] * $item['qty']); ?></td>
            </tr>
        <?php } ?>
        <tr><td colspan="5" style="text-align:right;font-weight:bold;">Grand Total = Rp. <?= number_format($total); ?></td></tr>
    </table>

    <form action="process/checkout.php" method="POST" id="checkout-form">
        <input type="hidden" name="total" value="<?= $total; ?>">
        <input type="hidden" name="weight" value="<?= $total_weight; ?>">
        <input type="hidden" name="province_name" id="province_name">
        <input type="hidden" name="city_name" id="city_name">
        <input type="hidden" name="shipping_cost" id="shipping_cost">
        <input type="hidden" name="etd" id="etd">

        <div class="row">
            <div class="col-md-6">
                <label>Province</label>
                <select name="province_id" id="province_id" class="form-control" required>
                    <option value="">-- Select Province --</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>City / Regency</label>
                <select name="city_id" id="city_id" class="form-control" required>
                    <option value="">-- Select City --</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;">
            <div class="col-md-6">
                <label>Courier</label>
                <select name="courier" id="courier" class="form-control" required>
                    <option value="">-- Select Courier --</option>
                    <option value="jne">JNE</option>
                    <option value="pos">POS Indonesia</option>
                    <option value="tiki">TIKI</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Package</label>
                <select name="package" id="package" class="form-control" required>
                    <option value="">-- Select Package --</option>
                </select>
            </div>
        </div>
        <div class="form-group" style="margin-top:10px;">
            <label>Full Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Postal Code</label>
                <input type="text" name="postal_code" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Place Order</button>
        <a href="cart.php" class="btn btn-default">Back to Cart</a>
    </form>
</div>

<script>
$(document).ready(function() {
    $.ajax({ url: 'check_province.php', success: function(d) { $('#province_id').html(d); } });

    $('#province_id').change(function() {
        $.ajax({
            type: 'GET',
            url: 'check_city.php',
            data: { province_id: $(this).val() },
            success: function(d) { $('#city_id').html(d); }
        });
    });

    $('#city_id').change(function() {
        var opt = $(this).find('option:selected');
        $('#province_name').val(opt.attr('province_name'));
        $('#city_name').val(opt.attr('city_name'));
    });

    $('#city_id, #courier').change(function() {
        var city_id = $('#city_id').val();
        var courier = $('#courier').val();
        var weight = <?= $total_weight ?>;
        if (city_id && courier) {
            $.ajax({
                type: 'POST',
                url: 'check_shipping.php',
                data: { city_id: city_id, courier: courier, weight: weight },
                success: function(d) { $('#package').html(d); }
            });
        }
    });

    $('#package').change(function() {
        var opt = $(this).find('option:selected');
        $('#shipping_cost').val(opt.attr('shipping_cost'));
        $('#etd').val(opt.attr('etd'));
    });
});
</script>

<?php include 'footer.php'; ?>