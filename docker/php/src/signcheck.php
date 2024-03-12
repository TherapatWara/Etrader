<?php

    if(isset($_GET['user']) && isset($_GET['pass']) && isset($_GET['email']) && isset($_GET['port'])) {
        $user = $_GET['user'];
        $pass = $_GET['pass'];
        $email = $_GET['email'];
        $port = $_GET['port'];
        
        echo "user: $user <br>";
        echo "pass: $pass <br>";
        echo "email: $email <br>";
        echo "port: $port <br>";
         
        include "connect.php";

        $sql = "INSERT INTO customer (cus_no, cus_id, cus_pwd, cus_mail, cus_port, regis_time, cus_earn) VALUES (NULL, '$user', '$pass', '$email', '$port', current_timestamp(), '0');";
        //echo($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        header("Location: login.php");
    } 
    else {
        echo "Name or email not provided.";
    }
?>
