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
    <title>Website for trading</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="banner">
        <div class="navbar" >
            <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="./product.php">Product</a></li>
                <li><a href="pay.php">Payment</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["id"]; ?></a></li>
            </ul>
        </div>
        <div style="margin-bottom:100px"></div>
        <div class="content">
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <div class="tradingview-widget-copyright"></div>
            <div style="width:70%;text-align:center;margin:0 auto">
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
            {
            "width": "100%",
            "height": "610",
            "symbol": "FX:EURUSD",
            "interval": "D",
            "timezone": "Etc/UTC",
            "theme": "dark",
            "style": "1",
            "locale": "en",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "calendar": false,
            "support_host": "https://www.tradingview.com/"
            }
            </script>
            </div>
            <!-- TradingView Widget END -->
            <!--?php echo $_SESSION["port"] ;?> -->
            <br>
            <div>
                <a href="./product.php"><button type="button" style="width:400px;font-size:20px"><span></span>Robot trade auto click here</button></a>
            </div>
        </div>
        
    </div>
</body>
</html>
