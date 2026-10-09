<?php include 'header.php'; ?>
<div class="container">
    <h2 style="border-bottom:4px solid gray;"><b>Master Customers</b></h2>
    <table class="table table-striped">
        <thead><tr>
            <th>No</th><th>Customer Code</th><th>Name</th><th>Email</th><th>Action</th>
        </tr></thead>
        <tbody>
        <?php $no = 1; $r = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_code");
        while ($row = mysqli_fetch_assoc($r)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['customer_code']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><a href="process/delete_customer.php?code=<?= $row['customer_code']; ?>"
                       class="btn btn-danger btn-sm" onclick="return confirm('Delete this customer?')">
                       <i class="glyphicon glyphicon-trash"></i></a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>