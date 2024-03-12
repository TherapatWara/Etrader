<?php

// ตั้งค่า API Key
$apiKey = "YOUR_API_KEY";

// ดึงข้อมูลดัชนี SET
$setIndexUrl = "https://api.set.or.th/api/mkt/index/SET";
$setIndexResponse = file_get_contents($setIndexUrl);
$setIndexData = json_decode($setIndexResponse, true);

// ดึงข้อมูล ETF
$etfUrl = "https://api.set.or.th/api/mkt/etf/list";
$etfResponse = file_get_contents($etfUrl);
$etfData = json_decode($etfResponse, true);

// ดึงข้อมูลคริปโต
$cryptoUrl = "https://api.coinmarketcap.com/v1/ticker/?limit=10";
$cryptoResponse = file_get_contents($cryptoUrl);
$cryptoData = json_decode($cryptoResponse, true);

// ดึงข้อมูลฟอเร็กซ์
$forexUrl = "https://api.exchangeratesapi.io/latest?base=THB";
$forexResponse = file_get_contents($forexUrl);
$forexData = json_decode($forexResponse, true);

// ดึงข้อมูลหุ้น
$stockUrl = "https://api.set.or.th/api/mkt/stock/list";
$stockResponse = file_get_contents($stockUrl);
$stockData = json_decode($stockResponse, true);

// ดึงข้อมูลพันธบัตร
$bondUrl = "https://api.thaibma.or.th/api/bond/yield/daily";
$bondResponse = file_get_contents($bondUrl);
$bondData = json_decode($bondResponse, true);

?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ข้อมูลตลาดแบบเรียลไทม์</title>
</head>
<body>
  <h1>สรุปภาพรวมตลาด</h1>

  <table border="1" cellpadding="5" cellspacing="0">
    <tr>
      <th>ดัชนี</th>
      <th>ราคา</th>
      <th>% เปลี่ยนแปลง</th>
    </tr>
    <tr>
      <td>SET Index</td>
      <td><?php echo $setIndexData['marketIndex']['close']; ?></td>
      <td><?php echo $setIndexData['marketIndex']['changePercent']; ?></td>
    </tr>
    <tr>
      <td>S&P 500</td>
      <td><?php echo $etfData['data'][0]['nav']; ?></td>
      <td><?php echo $etfData['data'][0]['changePercent']; ?></td>
    </tr>
    <tr>
      <td>Nasdaq 100</td>
      <td><?php echo $etfData['data'][1]['nav']; ?></td>
      <td><?php echo $etfData['data'][1]['changePercent']; ?></td>
    </tr>
    <tr>
      <td>Dow Jones 30</td>
      <td><?php echo $etfData['data'][2]['nav']; ?></td>
      <td><?php echo $etfData['data'][2]['changePercent']; ?></td>
    </tr>
    <tr>
      <td>Nikkei 225</td>
      <td><?php echo $etfData['data'][3]['nav']; ?></td>
      <td><?php echo $etfData['data'][3]['changePercent']; ?></td>
    </tr>
  </table>

  <h2>คริปโต</h2>

  <table border="1" cellpadding="5" cellspacing="0">
    <tr>
      <th>ชื่อ</th>
      <th>ราคา</th>
      <th>% เปลี่ยนแปลง</th>
    </tr>
    <?php foreach ($cryptoData as $crypto) { ?>
    <tr>
      <td><?php echo $crypto['name']; ?></td>
      <td><?php echo $crypto['price_usd']; ?></td>
      <td><?php echo <span class="math-inline">crypto\['percent\_change\_24h'\]; ?\></td\>
</tr\>
<?php \} ?\>
</table\>
<h2\>ฟอเร็กซ์</h2\>
<table border\="1" cellpadding\="5" cellspacing\="0"\>
<tr\>
<th\>สกุลเงิน</th\>
<th\>อัตราแลกเปลี่ยน</th\>
</tr\>
<?php foreach \(</span>
