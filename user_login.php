<?php include 'header.php'; ?>

<div class="container" style="padding-bottom:250px;">
    <h2 style="border-bottom:4px solid #ff8680;"><b>Login</b></h2>
    <form action="process/login.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" required style="width:500px;">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" required style="width:500px;">
        </div>
        <button type="submit" class="btn btn-success">Login</button>
        <a href="register.php" class="btn btn-primary">Register</a>
    </form>
</div>

<?php include 'footer.php'; ?>