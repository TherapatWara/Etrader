<?php 
    session_start(); 
    if(!isset($_SESSION["admin_id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }
?>

<html>
<head>
    <title>Payment page</title>
    <link rel="stylesheet" href="admin.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="banners">
    <div class="navbar">
        <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
        <ul>
                <li><a href="./adminpage.php">Customer</a></li>
                <li><a href="./adminhistory.php">History</a></li>
                <li><a href="./bill.php">Bill</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["admin_id"]; ?></a></li>
            </ul>
    </div>
    <div >
        <?php 
        if(isset($_GET['port'])) {
            $port = $_GET['port'];
           // echo $slipname;
        }
        include "connect.php";
        
        $sql_pay = "SELECT pay_name FROM payment WHERE cus_port = $port;";
        $result_pay = $conn->query($sql_pay);
        $row = $result_pay->fetch_assoc();
        $pay = $row["pay_name"];
        //echo $pay;

        
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql_payst = "SELECT cus_status FROM customer WHERE cus_port = $port;";
        $result_payst = $conn->query($sql_payst);
        $row = $result_payst->fetch_assoc();
        $payst = $row["cus_status"];

        if($payst == 1 )
        {
            $sql_equity = "SELECT his_equity FROM history
            WHERE his_no IN (
                SELECT MIN(his_no) FROM history WHERE cus_port = $port AND his_status = 0
                UNION ALL
                SELECT MAX(his_no) FROM history WHERE cus_port = $port AND his_status = 0
            );";
            $result = $conn->query($sql_equity);
            $temp = array();
            $i = 0;
            // ดึงข้อมูลออกมา
            while ($row = $result->fetch_assoc()) {
            // ใช้ข้อมูลที่ได้ต่อไป
            $his_equity = $row['his_equity'];
            $temp[$i] = $his_equity;
            $i = $i +1;
            // echo ข้อมูล
            //echo "His equity: " . $his_equity;
            }

            $equitygrow = $temp[1] - $temp[0];
            $mustpay = $equitygrow * 0.1;
            $exchange_rate = getExchangeRateFromApi();
            $bath_amount = $mustpay * $exchange_rate;
            $formatted_equity = number_format($equitygrow, 2); 
            $formatted_commit = number_format($mustpay, 2); 
            $formatted_total = number_format($bath_amount, 2); 

        echo "
            <div style='width:90%;background-color:white;padding:30px;text-align:center'>
                <div style='text-align:left; margin-left:100px;'>
                    <h1 style='color:black;'>ใบเสร็จชำระเงินของ User : $port</h1>
                    <h2 style='color:black;'>การเติบโต Equity ของ user : $temp[1] - $temp[0] = $formatted_equity $</h2>
                    <h2 style='color:black;'>จำนวนเงินที่ Userต้องจ่าย($) : $formatted_commit $</h2>
                    <h1 style='color:green;'>จำนวนเงินที่ Userต้องจ่าย : $formatted_total THB</h1>
                </div>
                <img src='./pic/slip/$pay' style='height:500px' ><br><br>
                <a href='./adminpage.php'><button class='buttonsee'>back</button></a>
                <a href='confirmbill.php?port=$port'><button class='buttonsee1'>ยืนยันการชำระเงิน</button></a>
            </div>
            ";
        }
        else{
            echo "
            <div style='width:90%;background-color:white;padding:30px;text-align:center'>
                <div style='text-align:left; margin-left:100px;'>
                    <h1 style='color:black;'>ยังไม่มีใบเสร็จชำระเงินของ User : $port</h1>

                <a href='./adminpage.php'><button class='buttonsee'>back</button></a>
                <a href='confirmbill.php?port=$port'><button class='buttonsee1'>ยืนยันการชำระเงิน</button></a>
            </div>
            ";
        }
        ?>

    </div>

</body>
</html>

<?php
// ฟังก์ชันสำหรับเรียกใช้ API เพื่อดึงข้อมูลอัตราแลกเปลี่ยน
function getExchangeRateFromApi() {
    // URL ของ API อัตราแลกเปลี่ยน
    $url = 'https://api.exchangerate-api.com/v4/latest/USD';

    // เรียกใช้งาน API เพื่อดึงข้อมูล
    $response = file_get_contents($url);

    // แปลงข้อมูล JSON เป็น Array
    $data = json_decode($response, true);

    // ตรวจสอบว่ามีข้อมูลอยู่หรือไม่
    if ($data && isset($data['rates']['THB'])) {
        // ค่าอัตราแลกเปลี่ยน USD เป็น THB
        $exchange_rate = $data['rates']['THB'];
        return $exchange_rate;
    } else {
        // หากไม่สามารถดึงข้อมูลได้
        echo json_encode(array('error' => 'ไม่สามารถดึงข้อมูลได้'));
    }
}
?>