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
    <title>Document</title>
    <link rel="stylesheet" href="./editadmin.css">
</head>
<body>
<div class="navbar">
        <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
        <ul>
        <li><a href="./adminpage.php">Customer</a></li>
                <li><a href="./testputtem.php">Template</a></li>
                <li><a href="logout.php">Logout</a></li>>
                <li><a><?php echo $_SESSION["admin_id"]; ?></a></li>

                
            </ul>
</div>
<div class="container">
<?php
// เชื่อมต่อฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // ส่งคำสั่ง SQL เพื่อดึงข้อมูลลูกค้าที่ต้องการแก้ไข
    $sql = "SELECT * FROM customer WHERE cus_no='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // แสดงฟอร์มแก้ไขข้อมูลลูกค้า
        ?>
        <html>
        <head>
            <title>Edit Customer</title>
        </head>
        <body>
            <h2>Edit Customer</h2>
            <form method="post" action="update_customer.php">
            <?php
            while($row = $result->fetch_assoc()) {
            ?>
                <input type="hidden" name="id" value="<?php echo $row['cus_no']; ?>">
                <label for="cus_id">Customer ID:</label><br>
                <input type="text" id="cus_id" name="cus_id" value="<?php echo $row['cus_id']; ?>"><br>
                <label for="cus_pwd">Password:</label><br>
                <input type="text" id="cus_pwd" name="cus_pwd" value="<?php echo $row['cus_pwd']; ?>"><br>
                <label for="cus_mail">Email:</label><br>
                <input type="text" id="cus_mail" name="cus_mail" value="<?php echo $row['cus_mail']; ?>"><br>
                <label for="cus_port">Port:</label><br>
                <input type="text" id="cus_port" name="cus_port" value="<?php echo $row['cus_port']; ?>"><br>
                <label for="cus_port">Status:</label><br>
                <input type="text" id="cus_status" name="cus_status" value="<?php echo $row['cus_status']; ?>"><br><br>
                <input type="submit" value="Submit">
            <?php
            }
            ?>
            </form>
            <a href="./adminpage.php"><button>Back</button></a>
        </body>
        </html>
        <?php
    } else {
        echo "ไม่พบข้อมูลลูกค้า";
    }
} else {
    echo "ไม่พบค่า ID ของลูกค้าที่ต้องการแก้ไข";
}

$conn->close();
?>

</div>
</body>
</html>
