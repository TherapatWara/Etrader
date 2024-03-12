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
    <script src="search_customer.js"></script>
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
        

        <div class="content">
            <!-- แบบฟอร์มค้นหา -->
            <form id="searchForm" style="display: flex; align-items: center;margin-bottom:20px">
                <label for="cus_port" style="margin-right: 10px;">Search by cus_port:</label>
                <input type="text" id="cus_port" name="cus_port" style="padding: 5px; margin-right: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <input type="submit" value="Search" style="padding: 5px 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                <button type="button" class="buttclear" onclick="refreshPage()" style="padding: 5px 10px; margin-left: 10px; background-color: #dc3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Clear</button>
            </form>
            <script>
                function refreshPage() {
                    location.reload(); // โหลดหน้าใหม่
                }
            </script>
         

            <!-- ส่วนที่แสดงผลลัพธ์ -->
            <div id="customerResult"></div>
            <?php
            // ข้อมูลเชื่อมต่อฐานข้อมูล
            include "connect.php";

            // ส่งคำสั่ง SQL เพื่อแสดงรายชื่อตารางที่มี status = 1 ด้านบน
            $sql = "SELECT * FROM customer WHERE cus_status = 1";
            $result = $conn->query($sql);

            // ตรวจสอบผลลัพธ์และแสดงรายชื่อตารางที่มี status = 1 ด้านบน
            if ($result->num_rows > 0) {
                echo "<table border='1' >";
                echo "<tr><th>cus_no</th><th>cus_id</th><th>cus_pwd</th><th>cus_mail</th><th>cus_port</th><th>regis_time</th><th>status</th><th>Edit</th><th>Bill</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["cus_no"] . "</td>";
                    echo "<td>" . $row["cus_id"] . "</td>";
                    echo "<td>" . $row["cus_pwd"] . "</td>";
                    echo "<td>" . $row["cus_mail"] . "</td>";
                    echo "<td>" . $row["cus_port"] . "</td>";
                    $port = $row["cus_port"];
                    echo "<td>" . $row["regis_time"] . "</td>";
                    echo "<td>" . $row["cus_status"] . "</td>";
                    // เพิ่มปุ่ม Edit ในแต่ละแถว
                    echo "<td><form action='edit_customer.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["cus_no"] . "'>";
                    echo "<input type='submit' style='padding: 5px; background-color: #f7b220; color: black; border: none; border-radius: 5px; cursor: pointer;margin:0px;width:100%' value='Edit'>";
                    echo "</form></td>";
                    echo "<td><a href='seebill.php?port=$port'><button style='padding: 5px; background-color: green; color: #fff; border: none; border-radius: 5px; cursor: pointer;margin:0px;width:100%'>See bill</button></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "ไม่พบตารางในฐานข้อมูล";
            }

            // ส่งคำสั่ง SQL เพื่อแสดงรายชื่อตารางที่มี status เป็น 0 หรือ 2 ด้านล่าง
            $sql = "SELECT * FROM customer WHERE cus_status IN (0, 2)";
            $result = $conn->query($sql);

            // ตรวจสอบผลลัพธ์และแสดงรายชื่อตารางที่มี status เป็น 0 หรือ 2 ด้านล่าง
            if ($result->num_rows > 0) {
                echo "<table border='1' >";
                echo "<tr><th>cus_no</th><th>cus_id</th><th>cus_pwd</th><th>cus_mail</th><th>cus_port</th><th>regis_time</th><th>status</th><th>Edit</th><th>Bill</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["cus_no"] . "</td>";
                    echo "<td>" . $row["cus_id"] . "</td>";
                    echo "<td>" . $row["cus_pwd"] . "</td>";
                    echo "<td>" . $row["cus_mail"] . "</td>";
                    echo "<td>" . $row["cus_port"] . "</td>";
                    $port = $row["cus_port"];
                    echo "<td>" . $row["regis_time"] . "</td>";
                    echo "<td>" . $row["cus_status"] . "</td>";
                    // เพิ่มปุ่ม Edit ในแต่ละแถว
                    echo "<td><form action='edit_customer.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["cus_no"] . "'>";
                    echo "<input type='submit' style='padding: 5px; background-color: #f7b220; color: black; border: none; border-radius: 5px; cursor: pointer;margin:0px;width:100%' value='Edit'>";
                    echo "</form></td>";
                    echo "<td><a href='seebill.php?port=$port'><button style='padding: 5px; background-color: green; color: #fff; border: none; border-radius: 5px; cursor: pointer;margin:0px;width:100%'>See bill</button></a></td>";
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
