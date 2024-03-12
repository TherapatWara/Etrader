<?php 
    session_start(); 
    if(!isset($_SESSION["admin_id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="banner1">
        <div class="navbar1">
            <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
            <ul>
                <li><a href="./adminpage.php">Customer</a></li>
                <li><a href="./adminhistory.php">History</a></li>
                <li><a href="./bill.php">Bill</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["admin_id"]; ?></a></li>
            </ul>
        </div>

        <div class="billbox">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $customer_name = $_GET["customer_name"];
            $user = $_GET["customer_name"];
            $port = $_GET["customer_port"];
            $price = $_GET["price"];

            // สร้างหมายเลขใบเสร็จ
            $receipt_number = uniqid('RPT');

            // สร้างภาพใบเสร็จ
            $image_width = 600; // ปรับขนาดภาพให้ใหญ่ขึ้น
            $image_height = 400; // ปรับขนาดภาพให้ใหญ่ขึ้น
            $image = imagecreatetruecolor($image_width, $image_height);
            
            // สร้างพื้นหลังให้กับภาพ
            $background_color = imagecolorallocate($image, 254, 254, 254); // กำหนดสีพื้นหลัง
            imagefill($image, 0, 0, $background_color);
            
            // เพิ่มรูปภาพหรือโลโก้ (ตัวอย่างเท่านั้น)
            $logo = imagecreatefrompng('logo.png'); // เปลี่ยน 'logo.png' เป็นชื่อไฟล์ของโลโก้ของคุณ

            // ปรับขนาดโลโก้ให้เต็มหน้าต่าง
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            $logo_aspect_ratio = $logo_width / $logo_height;

            $new_logo_width = $image_width / 4; // ปรับขนาดโลโก้ให้เล็กลงเพื่อให้พอดีกับความกว้างของภาพ
            $new_logo_height = $new_logo_width / $logo_aspect_ratio;

            $resized_logo = imagescale($logo, $new_logo_width, $new_logo_height); // ปรับขนาดโลโก้

            // กำหนดตำแหน่งใหม่ของโลโก้
            $logo_margin_top = 65; // ระยะห่างจากขอบบนของภาพ
            $logo_margin_left = 240; // ระยะห่างจากขอบซ้ายของภาพ

            $logo_x = $logo_margin_left; // ตำแหน่ง X ของโลโก้
            $logo_y = $logo_margin_top; // ตำแหน่ง Y ของโลโก้

            imagecopy($image, $resized_logo, $logo_x, $logo_y, 0, 0, $new_logo_width, $new_logo_height);

            // เพิ่มหัวข้อหน้าบิล
            $text_color = imagecolorallocate($image, 0, 0, 0);
            $title_font = 'C:\Windows\Fonts\Arial.ttf'; // เปลี่ยนเป็นชื่อแบบอักษรที่คุณต้องการ
            imagettftext($image, 24, 0, 200, 50, $text_color, $title_font, "Payment Receipt");

            // เพิ่มข้อมูลบิล
            $bill_data_font = 'C:\Windows\Fonts\Arial.ttf'; // เปลี่ยนเป็นชื่อแบบอักษรที่คุณต้องการสำหรับข้อมูลบิล
            imagettftext($image, 14, 0, 50, 150, $text_color, $bill_data_font, "Customer Name: $user");
            imagettftext($image, 14, 0, 50, 200, $text_color, $bill_data_font, "Port: $port");
            imagettftext($image, 14, 0, 50, 250, $text_color, $bill_data_font, "Price: $price THB");
            imagettftext($image, 14, 0, 50, 300, $text_color, $bill_data_font, "Date: " . date('Y-m-d'));

            // บันทึกภาพเป็นไฟล์ PNG
            $output_file = 'receipt.png';
            imagepng($image, $output_file);
            imagedestroy($image);

            echo "บันทึกใบเสร็จเป็นไฟล์ PNG สำเร็จ: <a href='$output_file' target='_blank'>เปิดรูปใบเสร็จ</a>";
            echo "<br><a href='./bill.php'>กลับไปยังหน้าที่แล้ว</a>";
        }
        ?>
        </div>
</body>
</html>