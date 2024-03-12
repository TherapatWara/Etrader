<?php
$target_dir = "uploads/"; // โฟลเดอร์ที่จะเก็บไฟล์ที่อัปโหลด
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // ชื่อของไฟล์ที่จะถูกบันทึก
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // นามสกุลของไฟล์

// ตรวจสอบว่าไฟล์ภาพหรือไม่
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "ไฟล์เป็นรูปภาพ - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "ไฟล์ไม่ใช่รูปภาพ.";
        $uploadOk = 0;
    }
}

// ตรวจสอบว่าไฟล์มีอยู่หรือไม่
if (file_exists($target_file)) {
    echo "ขอโทษ, ไฟล์ที่อัปโหลดมีอยู่แล้ว.";
    $uploadOk = 0;
}

// ตรวจสอบขนาดของไฟล์
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "ขอโทษ, ไฟล์ที่อัปโหลดใหญ่เกินไป.";
    $uploadOk = 0;
}

// อนุญาตให้รูปภาพเฉพาะแบบไฟล์
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "ขอโทษ, เฉพาะไฟล์ JPG, JPEG, PNG & GIF ได้รับอนุญาตเท่านั้น.";
    $uploadOk = 0;
}

// เช็คว่า $uploadOk เป็น 0 หรือไม่
if ($uploadOk == 0) {
    echo "ขอโทษ, ไฟล์ของคุณไม่ได้ถูกอัปโหลด.";
// ถ้าทุกอย่างเป็นไปตามที่ต้องการ ให้ลองอัปโหลดไฟล์
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "ไฟล์ ". basename( $_FILES["fileToUpload"]["name"]). " ได้ถูกอัปโหลดเรียบร้อยแล้ว.";
    } else {
        echo "ขอโทษ, เกิดข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ.";
    }
}
?>
