<?php include 'header.php';

$new = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT order_id) c FROM orders WHERE accepted = 0 AND rejected = 0"))['c'];
$accepted = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT order_id) c FROM orders WHERE accepted = 1"))['c'];
$rejected = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT order_id) c FROM orders WHERE rejected = 1"))['c'];
?>
<div class="container">
    <div class="row">
        <div class="col-md-4"><div style="background:#dfdfdf;padding:20px;">
            <h4>NEW ORDERS</h4><h2><?= $new; ?></h2></div></div>
        <div class="col-md-4"><div style="background:#dfdfdf;padding:20px;">
            <h4>ACCEPTED</h4><h2><?= $accepted; ?></h2></div></div>
        <div class="col-md-4"><div style="background:#dfdfdf;padding:20px;">
            <h4>REJECTED</h4><h2><?= $rejected; ?></h2></div></div>
    </div>
</div>
<?php include 'footer.php'; ?>