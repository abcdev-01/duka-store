<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('location:dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" style="margin-top:100px;max-width:500px;">
    <h2 class="text-center">Admin Login</h2>
    <form action="process/login.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning btn-block">Login</button>
    </form>
</div>
</body>
</html>