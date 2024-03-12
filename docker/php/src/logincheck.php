<?php
session_start();
if (isset($_GET['user']) && isset($_GET['pass'])) {
    $user = $_GET['user'];
    $pass = $_GET['pass'];

    include "connect.php";

    $sql = "SELECT * FROM customer WHERE cus_id = '$user' AND cus_pwd = '$pass'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["port"] = $row["cus_port"];
            $_SESSION["id"] = $row["cus_id"];

            $port = $row["cus_port"];
            $sql_equity = "SELECT his_equity FROM history
                            WHERE his_no IN (
                                SELECT MIN(his_no) FROM history WHERE cus_port = $port AND his_status = 0
                                UNION ALL
                                SELECT MAX(his_no) FROM history WHERE cus_port = $port AND his_status = 0
                            );";
            $result = $conn->query($sql_equity);
            $temp = array();
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $his_equity = $row['his_equity'];
                $temp[$i] = $his_equity;
                $i = $i + 1;
            }

            $_SESSION["equity0"] = $temp[0];
            $_SESSION["equity1"] = $temp[1];

            $sql_count = "SELECT COUNT(his_orderid) AS cc FROM `history` WHERE his_status = 0 AND cus_port = $port;";
            $result_count = $conn->query($sql_count);
            $row = $result_count->fetch_assoc();
            $order_count = $row['cc'];
            $_SESSION["count"] = $order_count;

            $sql_balance = "SELECT his_balance FROM history
                WHERE cus_port = $port
                ORDER BY his_no DESC
                LIMIT 1;
                ";
            $result_balance = $conn->query($sql_balance);
            $row = $result_balance->fetch_assoc();
            $balance = $row["his_balance"];
            $_SESSION["currentbalance"] = $balance;
        }

        header("Location: index.php");
        exit;
    } else {
        header("Location: admincheck.php?user=$user&pass=$pass");
        exit;
    }
} else {
    echo "Name or email not provided.";
}
?>
