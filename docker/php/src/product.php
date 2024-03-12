<?php 
    session_start(); 
    if(!isset($_SESSION["id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with PHP Navbar</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>
<div class="bannerP">
    <div class="navbar">
        <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
        <ul>
        <li><a href="index.php">Home</a></li>
                <li><a href="./product.php">Product</a></li>
                <li><a href="pay.php">Payment</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["id"]; ?></a></li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="box">
            <h3>Expert Advisors ทั้งหมด</h3>
            <div class="greenbutt">
                <button>FOREX MT4</button>
            </div>
            <p style="color:#707070; font-weight:bold;">ALL : 5</p><br>
            <div class="symbol" >
                <img src="./pic/eurusdpic.png" width=100% ><br><br>
                <p>EURUSD I</p>
                <p style="color:#707070; font-size:15px;">For Time Frame 15min</p><br>
                <a href="./ea/eurusd15min.php">ดูรายละเอียด</a>
            </div>

            <div class="symbol">
                <img src="./pic/eurusdpic.png" width=100% ><br><br>
                <p>EURUSD II</p>
                <p style="color:#707070; font-size:15px;">For Time Frame 30min</p><br>
                <a href="./ea/eurusd30min.php">ดูรายละเอียด</a>
            </div>

            <div class="symbol">
                <img src="./pic/eurusdpic.png" width=100% ><br><br>
                <p>EURUSD III</p>
                <p style="color:#707070; font-size:15px;">For Time Frame 4hr</p><br>
                <a href="./ea/eurusd4hr.php">ดูรายละเอียด</a>
            </div>

            <div class="symbol">
                <img src="./pic/xauusd.png" width=100% ><br><br>
                <p>XAUUSD</p>
                <p style="color:#707070; font-size:15px;">For Time Frame 30min</p><br>
                <a href="./ea/xauusd30min.php">ดูรายละเอียด</a>
            </div>

            <div class="symbol">
                <img src="./pic/usdcad.png" width=100% ><br><br>
                <p>USDCAD</p>
                <p style="color:#707070; font-size:15px;">For Time Frame 1hr</p><br>
                <a href="./ea/usdcad4hr.php">ดูรายละเอียด</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
