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
    <title>Admin Login — Batik Al Barokah</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" style="max-width:500px;margin-top:100px;">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title"><b>Admin Login</b></h3></div>
        <div class="panel-body">
            <form action="process/login.php" method="POST" autocomplete="off">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning btn-block">Login</button>
            </form>
        </div>
    </div>
    <p class="text-center text-muted">Batik Al Barokah — Admin Panel</p>
</div>
</body>
</html>