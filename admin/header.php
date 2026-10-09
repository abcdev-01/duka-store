<?php
session_start();
require_once __DIR__ . '/../connection/connection.php';
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin — Batik Al Barokah</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default" style="padding:5px;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#admin-menu">
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="admin-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-folder-close"></i> Master Data <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="master_products.php">Master Products</a></li>
                        <li><a href="master_customers.php">Master Customers</a></li>
                        <li><a href="inventory.php">Inventory</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-retweet"></i> Transactions <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="orders.php">Orders</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-stats"></i> Reports <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="revenue_report.php">Sales Report</a></li>
                        <li><a href="cancel_report.php">Cancellation Report</a></li>
                        <li><a href="profit_report.php">Profit Report</a></li>
                        <li><a href="inventory_report.php">Inventory Report</a></li>
                    </ul>
                </li>
                <li><a href="dashboard.php">Dashboard</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Maintenance <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../DATABASE/backup.php">Backup Database</a></li>
                        <li><a href="../DATABASE/retrieve.php">Retrieve Database</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Admin <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="process/logout.php">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>