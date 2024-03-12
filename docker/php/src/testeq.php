<?php
// สร้างการเชื่อมต่อกับฐานข้อมูล
include "connect.php";

// สร้างคำสั่ง SQL
$sql_sum = "SELECT his_equity FROM history
            WHERE his_no IN (
                SELECT MIN(his_no) FROM history WHERE cus_port = 70286040 AND his_status = 0
                UNION ALL
                SELECT MAX(his_no) FROM history WHERE cus_port = 70286040 AND his_status = 0
            );";

// ทำการ query คำสั่ง SQL
$result = $conn->query($sql_sum);

// เช็คว่า query สำเร็จหรือไม่
if ($result === false) {
    die("Error executing query: " . $conn->error);
}
$temp = array();
$i = 0;
// ดึงข้อมูลออกมา
while ($row = $result->fetch_assoc()) {
    // ใช้ข้อมูลที่ได้ต่อไป
    $his_equity = $row['his_equity'];
    $temp[$i] = $his_equity;
    $i = $i +1;
    // echo ข้อมูล
    echo "His equity: " . $his_equity;
}
echo "<br>" . $temp[0] . ";" . $temp[1];
echo "<br>" . $temp[1]- $temp[0];

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

?>