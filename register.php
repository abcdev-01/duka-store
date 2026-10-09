<?php
require_once __DIR__ . '/connection/connection.php';
 include 'header.php'; ?>

<div class="container" style="padding-bottom:250px;">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Register</b></h2>
    <form action="process/register.php" method="POST">
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" required>
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div></div>
        </div>
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username" required>
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" required>
            </div></div>
        </div>
        <div class="row">
            <div class="col-md-6"><div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
            </div></div>
            <div class="col-md-6"><div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div></div>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
    </form>
</div>

<?php include 'footer.php'; ?>