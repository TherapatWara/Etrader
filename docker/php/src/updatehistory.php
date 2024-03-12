<?php
// เชื่อมต่อฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีการส่งค่า ID และข้อมูลที่ต้องการแก้ไขมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cus_port'])) {
    $port = $_POST['cus_port'];


    // ส่งคำสั่ง SQL เพื่ออัปเดตข้อมูลลูกค้า
    $sql = "UPDATE history SET his_status = 1 WHERE cus_port = $port;";

    if ($conn->query($sql) === TRUE) {
        echo "อัปเดตข้อมูลลูกค้าเรียบร้อยแล้ว";
        header("Location: adminpage.php");

    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
    }
} else {
    echo "กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน";
}

$conn->close();
?>
