<?php 
    session_start(); 
    if(!isset($_SESSION["admin_id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Website for trading</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="banner">
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

        <div class="content">
            <?php
            // ข้อมูลเชื่อมต่อฐานข้อมูล
            include "connect.php";

            // ส่งคำสั่ง SQL เพื่อแสดงรายชื่อตารางทั้งหมด
            $sql = "SELECT * FROM customer";
            $result = $conn->query($sql);

            // ตรวจสอบผลลัพธ์และแสดงรายชื่อตาราง
            if ($result->num_rows > 0) {
                echo "<table border='1' >";
                echo "<tr><th>cus_no</th><th>cus_id</th><th>cus_pwd</th><th>cus_mail</th><th>cus_port</th><th>regis_time</th><th>status</th><th>Edit</th><th>History</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["cus_no"] . "</td>";
                    echo "<td>" . $row["cus_id"] . "</td>";
                    echo "<td>" . $row["cus_pwd"] . "</td>";
                    echo "<td>" . $row["cus_mail"] . "</td>";
                    echo "<td>" . $row["cus_port"] . "</td>";
                    echo "<td>" . $row["regis_time"] . "</td>";
                    echo "<td>" . $row["cus_status"] . "</td>";
                    // เพิ่มปุ่ม Edit ในแต่ละแถว
                    echo "<td><form action='edit_customer.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["cus_no"] . "'>";
                    echo "<input type='submit' style='height:30px;width:40px' value='Edit'>";
                    echo "</form></td>";
                    echo "<td><form action='history_customer.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["cus_no"] . "'>";
                    echo "<input type='submit' style='height:30px;width:60px' value='Enter'>";
                    echo "</form></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "ไม่พบตารางในฐานข้อมูล";
            }

            // ปิดการเชื่อมต่อ
            $conn->close();
            ?>
        </div>
        
    </div>
</body>
</html>
