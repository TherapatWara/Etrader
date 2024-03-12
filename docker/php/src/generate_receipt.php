<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST["customer_name"];
    $item = $_POST["item"];
    $price = $_POST["price"];
    
    // สร้างหมายเลขใบเสร็จ
    $receipt_number = uniqid('RPT');

    // พิมพ์ใบเสร็จ
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>ใบเสร็จ</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            .container {
                width: 50%;
                margin: 0 auto;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>ใบเสร็จ</h2>
            <p><strong>หมายเลขใบเสร็จ:</strong> $receipt_number</p>
            <table>
                <tr>
                    <th>รายการ</th>
                    <th>ราคา</th>
                </tr>
                <tr>
                    <td>$item</td>
                    <td>$price บาท</td>
                </tr>
            </table>
            <p><strong>ชื่อลูกค้า:</strong> $customer_name</p>
        </div>
    </body>
    </html>";
}
?>
