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
    <h2 style="border-bottom:4px solid gray;"><b>Orders</b></h2>
    <p class="bg-success" style="padding:7px;"><b>Reload this page every time you enter to avoid stale data.</b></p>
    <a href="orders.php" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Reload</a>
    <br><br>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Order ID</th>
                <th scope="col">Customer Code</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $result = mysqli_query($conn, "
            SELECT DISTINCT order_id, customer_code, status, accepted, rejected, date
            FROM orders
            GROUP BY order_id
            ORDER BY date DESC
        ");
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['accepted'] == 1) {
                $status = "<span style='color:green;font-weight:bold;'>Accepted</span>";
            } elseif ($row['rejected'] == 1) {
                $status = "<span style='color:red;font-weight:bold;'>Rejected</span>";
            } else {
                $status = "<span style='color:orange;font-weight:bold;'>New Order</span>";
            }
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['order_id']); ?></td>
                <td><?= htmlspecialchars($row['customer_code']); ?></td>
                <td><?= $status; ?></td>
                <td><?= date('d M Y H:i', strtotime($row['date'])); ?></td>
                <td>
                    <?php if ($row['accepted'] == 0 && $row['rejected'] == 0) { ?>
                        <a href="process/accept.php?order_id=<?= $row['order_id']; ?>" class="btn btn-success btn-sm">
                            <i class="glyphicon glyphicon-ok-sign"></i> Accept
                        </a>
                        <a href="process/reject.php?order_id=<?= $row['order_id']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to reject this order?')">
                            <i class="glyphicon glyphicon-remove-sign"></i> Reject
                        </a>
                    <?php } ?>
                    <a href="order_detail.php?order_id=<?= $row['order_id']; ?>" class="btn btn-primary btn-sm">
                        <i class="glyphicon glyphicon-eye-open"></i> Detail
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>