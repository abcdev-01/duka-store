<?php
session_start();
include 'connection/connection.php';
$customer_code = $_SESSION['customer_code'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Batik Al Barokah</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row top">
        <center>
            <div class="col-md-4"><span><i class="glyphicon glyphicon-earphone"></i> +6223-3334-4445</span></div>
            <div class="col-md-4"><span><i class="glyphicon glyphicon-envelope"></i> albarokah.batik@gmail.com</span></div>
            <div class="col-md-4"><span>Batik Al-Barokah Sumenep</span></div>
        </center>
    </div>
</div>

<nav class="navbar" style="padding:5px;background-color:#4d0000;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php" style="color:#fff;"><b>Batik Al Barokah</b></a>
        </div>

        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="nav navbar-nav navbar-right links">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="how_to_order.php">How to Order</a></li>

                <?php
                if ($customer_code) {
                    $check = mysqli_query($conn, "SELECT product_code FROM cart WHERE customer_code = '$customer_code'");
                    $count = mysqli_num_rows($check);
                    echo "<li><a href='cart.php'><i class='glyphicon glyphicon-shopping-cart'></i> <b>[ $count ]</b></a></li>";
                } else {
                    echo "<li><a href='cart.php'><i class='glyphicon glyphicon-shopping-cart'></i> [0]</a></li>";
                }

                if (!isset($_SESSION['user'])) {
                    echo "
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='glyphicon glyphicon-user'></i> Account <span class='caret'></span></a>
                        <ul class='dropdown-menu'>
                            <li><a href='user_login.php'>Login</a></li>
                            <li><a href='register.php'>Register</a></li>
                        </ul>
                    </li>";
                } else {
                    echo "
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='glyphicon glyphicon-user'></i> " . htmlspecialchars($_SESSION['user']) . " <span class='caret'></span></a>
                        <ul class='dropdown-menu'>
                            <li><a href='process/logout.php'>Log Out</a></li>
                            <li><a href='my_orders.php'>My Orders</a></li>
                        </ul>
                    </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>