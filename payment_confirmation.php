<?php
require_once __DIR__ . '/connection/connection.php';
include 'header.php';
$order_id = mysqli_real_escape_string($conn, $_GET['order_id'] ?? '');
?>

<div class="container">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Payment Confirmation</b></h2>

    <p>Please transfer to:</p>
    <table class="table table-striped" style="width:400px;">
        <tr><td>Bank</td><td>BRI</td></tr>
        <tr><td>Account Name</td><td>Batik Al Barokah</td></tr>
        <tr><td>Account Number</td><td>4581321302266340</td></tr>
    </table>

    <form action="process/confirm_payment.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="order_id" value="<?= $order_id; ?>">
        <div class="form-group">
            <label>Bank</label>
            <input type="text" name="bank" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Account Name</label>
            <input type="text" name="account_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Proof of Payment</label>
            <input type="file" name="proof" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Submit Confirmation</button>
        <a href="my_orders.php" class="btn btn-default">Back</a>
    </form>
</div>

<?php include 'footer.php'; ?>