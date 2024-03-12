<?php 
    session_start(); 
    if(!isset($_SESSION["id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }
?>

<?php
$targetDirectory = "./pic/slip/"; // โฟลเดอร์ที่จะบันทึกไฟล์
$targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]); // ชื่อไฟล์ที่จะบันทึก

// ตรวจสอบว่าไฟล์ถูกอัปโหลดหรือไม่
if(isset($_POST["submit"])) {
    $uploadOk = 1;
    // ตรวจสอบว่าไฟล์มีอยู่หรือไม่
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // ตรวจสอบขนาดของไฟล์
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // อนุญาตให้บางประเภทของไฟล์เท่านั้น
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    if(!in_array($fileExtension, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.";
        $uploadOk = 0;
    }
    // ตรวจสอบว่า $uploadOk เป็น 0 หรือไม่
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // ถ้าทุกอย่างถูกต้อง พยายามอัปโหลดไฟล์
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

            include "connect.php";

            $fileName = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
            $port = $_SESSION["port"]; // รับค่าจากเซสชัน
            $sql = "INSERT INTO payment (pay_name, cus_port) VALUES (?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $fileName, $port);
                if ($stmt->execute()) {
                    echo "The file $fileName has been uploaded and saved to the database. <a href='./pay.php'>back</a>";
                    $sql_upstatus = "UPDATE customer SET cus_status = 1 WHERE cus_port = $port;";
                    $conn->query($sql_upstatus);
                    header("Location: uploadsuccess.php?slip=$fileName");
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $stmt->close();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}







?>
