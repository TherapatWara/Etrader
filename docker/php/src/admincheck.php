<?php
session_start();
ob_start(); // เริ่มต้นการเก็บข้อมูลไว้ก่อนการส่ง

if(isset($_GET['user']) && isset($_GET['pass'])) {
    $user = $_GET['user'];
    $pass = $_GET['pass'];
    
    include "connect.php";

    $sql = "SELECT * FROM admins WHERE admin_id = '$user' AND admin_pwd = '$pass'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $_SESSION["admin_id"] = $row["admin_id"];
            header("Location: adminpage.php");
            exit;
        }
    } else { 
        header("Location: login.php");
        exit;
    }
} else {
    echo "Name or email not provided.";
}

ob_end_flush(); // สิ้นสุดการเก็บข้อมูลและส่งออกทั้งหมดที่เก็บไว้
?>
