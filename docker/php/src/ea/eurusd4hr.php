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
    <link rel="stylesheet" href="../product.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="bannerP">
    <div class="navbar">
        <img src="../logo.png" class="logo" style="height: 60px; width: 200px;">
        <ul>
        <li><a href="index.php">Home</a></li>
                <li><a href="../product.php">Product</a></li>
                <li><a href="../pay.php">Payment</a></li>
                <li><a href="../logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["id"]; ?></a></li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="box">
            <a href="../product.php"><button class="backward-button">&#9664;</button></a>
            <h3>ผลการ Back test EURUSD 4hr ตลอด 30 เดือน</h3><br>
            <img src="../pic/eur4graph.jpg" width=100% ><br><br>
            <img src="../pic/eur4report.jpg" width=100% ><br><br>
            <p>Symbol : EURUSD</p>
            <p>Time frame : 4hr.</p>
            <a href="../download/E-trader.EurusdH4LongPos.zip" download><button class="download-button" >Download Now</button></a>


        </div>
    </div>
</div>
</body>
</html>
