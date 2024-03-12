<?php 
    session_start(); 
    if(!isset($_SESSION["admin_id"])) {
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
    <link rel="stylesheet" href="admin.css">
    <title>ใบเสร็จ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin-left:150px;
            font-size: 30px;
            background-color: white;
            padding:30px;
            border-radius:30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        input{
            font-size:30px;
        }
    </style>
</head>
<body>
    <div class="banner1">
        <div class="navbar1">
            <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
            <ul>
                <li><a href="./adminpage.php">Customer</a></li>
                <li><a href="./adminhistory.php">History</a></li>
                <li><a href="./bill.php">Bill</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["admin_id"]; ?></a></li>
            </ul>
        </div>
    <div class="container">
        <a href="./adminpage.php"><button class="backward-button">&#9664;</button></a>
        <h2>Bill</h2>
        <form action="billtest.php" method="get">
            <label for="customer_name">Customer name:</label><br>
            <input type="text" id="customer_name" name="customer_name" required><br>
            <label for="customer_name">Customer port:</label><br>
            <input type="text" id="customer_port" name="customer_port" required><br>
            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" required><br><br>
            <input type="submit" value="Create bill">
        </form>
    </div>
</body>
</html>
