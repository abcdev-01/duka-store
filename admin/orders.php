<?php include 'header.php'; ?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Orders</b></h2>
    <p class="bg-success" style="padding:7px;"><b>Reload this page when entering to avoid stale data.</b></p>
    <a href="orders.php" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Reload</a>
    <br><br>

    <table class="table table-striped">
        <thead><tr>
            <th>No</th><th>Order ID</th><th>Customer</th><th>Status</th><th>Date</th><th>Action</th>
        </tr></thead>
        <tbody>
        <?php $no = 1;
        $r = mysqli_query($conn, "SELECT DISTINCT order_id, customer_code, status, accepted, rejected, date FROM orders GROUP BY order_id ORDER BY date DESC");
        while ($row = mysqli_fetch_assoc($r)) {
            if ($row['accepted'] == 1) { $status = "<span style='color:green;'>Accepted</span>"; }
            elseif ($row['rejected'] == 1) { $status = "<span style='color:red;'>Rejected</span>"; }
            else { $status = "<span style='color:orange;'>New Order</span>"; }
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['order_id']; ?></td>
                <td><?= $row['customer_code']; ?></td>
                <td><?= $status; ?></td>
                <td><?= date('d M Y H:i', strtotime($row['date'])); ?></td>
                <td>
                    <?php if ($row['accepted'] == 0 && $row['rejected'] == 0) { ?>
                        <a href="process/accept.php?order_id=<?= $row['order_id']; ?>" class="btn btn-success btn-sm">Accept</a>
                        <a href="process/reject.php?order_id=<?= $row['order_id']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Reject this order?')">Reject</a>
                    <?php } ?>
                    <a href="order_detail.php?order_id=<?= $row['order_id']; ?>" class="btn btn-primary btn-sm">Detail</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>