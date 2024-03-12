<?php
    // phpconnect.php
    // ข้อมูลเชื่อมต่อฐานข้อมูล
    $servername = "db";
    $username = "root";
    $password = "ttt";
    $database = "ai";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>