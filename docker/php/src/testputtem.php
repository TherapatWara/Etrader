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
    <title>Upload .set File</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="banner">
        <div class="navbar">
            <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
            <ul>
                <li><a href="./adminpage.php">Customer</a></li>
                <li><a href="./testputtem.php">Template</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["admin_id"]; ?></a></li>
            </ul>
        </div>
    <div class="contenttem">
        <h1>เพิ่ม template</h1><br>
        <form action="testtem.php" method="post" enctype="multipart/form-data">
            template name:
            <input type="text" name="temname"><br><br>
            Select .set file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File" name="submit">
        </form>
    </div>
</body>
</html>





        