<?php 
    session_start(); 
    if(!isset($_SESSION["id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }
?>

<html>
<head>
    <title>Payment page</title>
    <link rel="stylesheet" href="payment.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <?php 
        if(isset($_GET['slip'])) {
            $slipname = $_GET['slip'];
           // echo $slipname;
        }
        echo "
            <div style='width:90%;background-color:white;padding:30px;text-align:center'>
                <h1 style='color:green;'>ชำระเงินสำเร็จ</h1>
                <img src='./pic/slip/$slipname' style='height:500px' ><br>
                <a href='./pay.php'>back</a>
            </div>
            ";
        ?>

    </div>

</body>
</html>