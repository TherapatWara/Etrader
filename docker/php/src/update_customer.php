<?php
// เชื่อมต่อฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีการส่งค่า ID และข้อมูลที่ต้องการแก้ไขมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['cus_id']) && isset($_POST['cus_pwd']) && isset($_POST['cus_mail']) && isset($_POST['cus_port'])
&& isset($_POST['cus_status'])) {
    $id = $_POST['id'];
    $cus_id = $_POST['cus_id'];
    $cus_pwd = $_POST['cus_pwd'];
    $cus_mail = $_POST['cus_mail'];
    $cus_port = $_POST['cus_port'];
    $cus_status = $_POST['cus_status'];

    // ส่งคำสั่ง SQL เพื่ออัปเดตข้อมูลลูกค้า
    $sql = "UPDATE customer SET cus_id='$cus_id', cus_pwd='$cus_pwd', cus_mail='$cus_mail', cus_port='$cus_port', cus_status='$cus_status' WHERE cus_no='$id'";

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
