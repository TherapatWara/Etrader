<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with PHP Navbar</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="login.css">
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
        <img src="logo.png" class="logo" style="width:120px;">
        <h2>Sign up</h2>
        <form method="get" action="signcheck.php">
            <input type="text" name="user" placeholder="Phone, email or username">
            <input type="text" name="pass" placeholder="Password">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="port" placeholder="Login number">
            <div class="submit">
                <input type="submit"  value="Sign up">
            </div>
        </form>
        <p >Already have an account?<a href="./login.html">Sign in</a></p>
    </div><br><br><br>
</body>
</html>
