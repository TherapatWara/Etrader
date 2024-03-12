<?php
// search_customer.php

// ข้อมูลเชื่อมต่อฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีการส่งค่า cus_port มาหรือไม่
if(isset($_GET['cus_port'])) {
    $cus_port = $_GET['cus_port'];
    // ส่งคำสั่ง SQL เพื่อค้นหาข้อมูลที่มี cus_port ตรงกับค่าที่ระบุ
    $sql = "SELECT * FROM customer WHERE cus_port LIKE '$cus_port%'";
    $result = $conn->query($sql);

    // ตรวจสอบผลลัพธ์และแสดงรายการที่พบ
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
        echo "ไม่พบผู้ใช้ที่ตรงกับ cus_port: $cus_port";
    }
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
