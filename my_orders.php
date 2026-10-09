<?php
include 'header.php';

if (!isset($_SESSION['customer_code'])) {
    echo "<script>alert('Please login first');window.location='user_login.php';</script>";
    exit;
}
$customer_code = $_SESSION['customer_code'];

$result = mysqli_query($conn, "SELECT * FROM orders WHERE customer_code = '$customer_code' ORDER BY date DESC");
?>

<div class="container" style="padding-bottom:300px;">
    <h2 style="border-bottom:4px solid #ff8680;"><b>My Orders</b></h2>

    <table class="table table-striped">
        <thead><tr>
            <th>Order ID</th><th>Date</th><th>Total</th><th>Status</th><th>Action</th>
        </tr></thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['order_id']; ?></td>
                <td><?= date('d M Y H:i', strtotime($row['date'])); ?></td>
                <td>Rp. <?= number_format($row['total'] + $row['shipping_cost']); ?></td>
                <td><?= htmlspecialchars($row['status']); ?></td>
                <td>
                    <a href="order_detail.php?order_id=<?= $row['order_id']; ?>" class="btn btn-warning btn-sm">Detail</a>
                    <a href="payment_confirmation.php?order_id=<?= $row['order_id']; ?>" class="btn btn-primary btn-sm">Confirm Payment</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>