<?php
// ตรวจสอบว่า session ถูกเริ่มต้นหรือไม่
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// ทำลาย session
session_destroy();
header("Location: login.php");
exit;
?>
