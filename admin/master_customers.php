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
    <h2 style="border-bottom:4px solid gray;"><b>Master Customers</b></h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Customer Code</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_code ASC");
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= htmlspecialchars($row['customer_code']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td>
                        <a href="process/delete_customer.php?code=<?= $row['customer_code']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this customer?')">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<br><br><br><br><br><br><br><br><br>

<?php include 'footer.php'; ?>