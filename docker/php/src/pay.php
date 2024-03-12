<?php 
    session_start(); 
    if(!isset($_SESSION["id"])) {
        // ถ้าไม่มี session ให้เปลี่ยนเส้นทางไปยังหน้า login.php
        header("Location: login.php");
        exit;
    }
?>

<html>
<head>
    <title>Payment page</title>
    <link rel="stylesheet" href="./payment.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="bannerP">
    <div class="navbar">
        <img src="logo.png" class="logo" style="height: 60px; width: 200px;">
        <ul>
        <li><a href="index.php">Home</a></li>
                <li><a href="./product.php">Product</a></li>
                <li><a href="pay.php">Payment</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a><?php echo $_SESSION["id"]; ?></a></li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="box">
            <?php 
            $number = ($_SESSION["equity1"]-$_SESSION["equity0"])*0.1;
            $exchange_rate = getExchangeRateFromApi();
            $bath_amount = $number * $exchange_rate;
            $formatted_number = number_format($bath_amount, 2); 

            

            
            
            include "connect.php";
            
            $port = $_SESSION['port'];
            
            $sql_stcheck = "SELECT cus_status FROM customer WHERE cus_port = $port";
            $result_stcheck = $conn->query($sql_stcheck);
            $rowc = $result_stcheck->fetch_assoc();
            $customerST = $rowc['cus_status'];
            //echo $customerST;
            if($customerST==1)
            {
                $cusstatus = 'รอดำเนินการ';
            }
            else if($customerST==2)
            {
                $cusstatus = 'ชำระเงินแล้ว';
            }
            else{
                $cusstatus = 'ยังไม่ชำระเงิน';
            }
            //echo "<br><a href='./bill.php'>กลับไปยังหน้าที่แล้ว</a>";
            ?>
            <div class="paybox">
                <h1>Payment</h1>
                <img src="./logo.png" style="height:70px; margin-bottom:10px">
                <p>User port: <?php $_SESSION['port']?></p>
                <p>Order quantity: <?php $_SESSION['count']?></p>
                <p>Equity growth: <?php echo number_format($_SESSION['equity1'] - $_SESSION['equity0'], 2) ?> $</p>
                <p>Current balance: <?php $_SESSION['currentbalance']?> $</p>
                <p>Current equity: <?php $_SESSION['equity1']?></p>
                <p>Billing date: <?php date('Y-m-d')?></p>
                <h3>Amount to be paid: <?php $formatted_number?> THB</h3>
                <img src="./pic/promtpay.jpg" style="height:250px;margin-top:-340px;margin-left:400px">
            <div>

            <?php 
            if($customerST==2){
                echo "<div class='buttslipwait' style='background-color:#99FF99;font-weight:bold;border-color:white'>$cusstatus</div><br>";
            }
            else if($customerST==1){
                echo "<div class='buttslipwait' style='background-color:#FFD700;font-weight:bold;border-color:white'>$cusstatus</div><br>";
            }
            else{
                echo "<div class='buttslipwait' style='background-color:#FF9999;font-weight:bold;border-color:white'>$cusstatus</div><br>";
            }

            ?>
            
            <div >
                <?php 
                    if($customerST==0)
                    {
                        echo "
                        <form action='./uploadslip.php' method='post' enctype='multipart/form-data'>
                        <input type='file' name='fileToUpload' id='fileToUpload'>
                        <input type='submit' value='Upload File' name='submit'>
                        </form>
                        ";
                    };
                ?>

            </div>

            <!--<br><h2>โอนเลขบัญชี(Promt pay): 0122412826</h2>
            <h2>สแกน LINE เพื่อส่งสลิป </h2>
            <img src="./pic/currentline.jpg" width=50% >-->
            
            


        </form>
        </div>
    </div>
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
