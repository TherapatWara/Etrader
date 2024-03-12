<?php
// เชื่อมต่อฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // ส่งคำสั่ง SQL เพื่อดึงข้อมูลลูกค้าที่ต้องการแก้ไข
    $sql = "SELECT * FROM customer WHERE cus_no='$id'";
    $result = $conn->query($sql);
    echo "<a href='./adminpage.php'><button>back</button></a>";
    if ($result->num_rows > 0) {
        // แสดงฟอร์มแก้ไขข้อมูลลูกค้า
        while($row = $result->fetch_assoc()) {
            ?>
            <html>
            <head>
                <title>Edit History</title>
            </head>
            <body>
                <h2>Edit History</h2>
                <form method="post" action="updatehistory.php">
                    <label for="cus_port">Port:</label><br>
                    <input type="text" id="cus_port" name="cus_port" value="<?php echo $row['cus_port']; ?>"><br>
                    <label for="cus_port">Status:</label><br>
                    <input type="text" id="cus_status" name="cus_status" value="<?php echo $row['cus_status']; ?>"><br><br>
                    <input type="submit" value="Change status">
                </form>
            </body>
            </html>
            <?php
        }
    } else {
        echo "ไม่พบข้อมูลลูกค้า";
    }
} else {
    echo "ไม่พบค่า ID ของลูกค้าที่ต้องการแก้ไข";
}

$conn->close();
?>
