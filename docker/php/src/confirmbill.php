<?php 
    session_start(); 
    if(!isset($_SESSION["admin_id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }

?>

<html>
<head>
    <title>Payment page</title>
    <link rel="stylesheet" href="admin.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="banners">
    <div class="navbar">
        <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
        <ul>
                <li><a href="./adminpage.php">Customer</a></li>
                <li><a href="./adminhistory.php">History</a></li>
                <li><a href="./bill.php">Bill</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["admin_id"]; ?></a></li>
            </ul>
    </div>
    
    <div >
        <?php 
        if(isset($_GET['port'])) {
            $port = $_GET['port'];
           // echo $slipname;
        }
        include "connect.php";
        
        $sql_his = "UPDATE history SET his_status = 0 WHERE cus_port = $port;";
        $conn->query($sql_his);
        $sql_cus = "UPDATE customer SET cus_status = 0 WHERE cus_port = $port;";
        $conn->query($sql_cus);
        $sql_cus = "UPDATE payment SET pay_status = 0 WHERE cus_port = $port;";
        $conn->query($sql_cus);
        echo "
            <div style='width:90%;background-color:white;padding:30px;text-align:center'>
                <h1 style='color:green;'>ยืนยันการชำระเงินของ User : $port เรียบร้อย</h1>
                <img src='./pic/checksuccess.jpg' style='height:500px' ><br><br>
                <a href='adminpage.php'><button class='buttonsee1'>กลับสู่หน้าหลัก</button></a>
            </div>
            ";
        ?>

    </div>

</body>
</html>