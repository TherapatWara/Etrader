<?php session_start(); ?>
<html>
<head>
    <title>Login page</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="navbar">
        <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="./product.php">Product</a></li>
            <li><a href="pay.php">Payment</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </div>

    <div class="login-box">
        <img src="logo.png" class="logo">
        <h2>Sign in to E Trade</h2>
        <form method="get" action="logincheck.php">
            <input type="text" name="user" placeholder="Phone, email or username">
            <input type="text" name="pass" placeholder="Password">
            <div class="submit">
                <input type="submit"  value="Next">
            </div>
        </form>
        <!--<button style="color: black;">Forgot password?</button>-->
        <p >Don't have an account?<a href="./signup.php">Sign up</a></p>
    </div>

</body>
</html>
