<?php
// แสดงข้อมูลในรูปแบบ JSON
header('Content-type: application/json');

// URL ของ API อัตราแลกเปลี่ยน
$url = 'https://api.exchangerate-api.com/v4/latest/USD';

// เรียกใช้ API และดึงข้อมูล
$response = file_get_contents($url);

// แปลงข้อมูล JSON เป็น Array
$data = json_decode($response, true);

// ตรวจสอบว่ามีข้อมูลอยู่หรือไม่
if ($data && isset($data['rates']['THB'])) {
    // ค่าอัตราแลกเปลี่ยน USD เป็น THB
    $exchange_rate = $data['rates']['THB'];

    // ราคาในดอลลาร์
    $price_in_usd = 1;

    // คำนวณราคาในบาท
    $price_in_thb = $price_in_usd * $exchange_rate;

    // แสดงผลลัพธ์
    echo json_encode(array('price_in_thb' => $price_in_thb));
} else {
    // หากไม่สามารถดึงข้อมูลได้
    echo json_encode(array('error' => 'ไม่สามารถดึงข้อมูลได้'));
}
?>
