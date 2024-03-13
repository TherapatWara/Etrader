<?php
    //$output = array();
    //exec("python3 model1.py", $output);
    
    // แสดงผลลัพธ์
    
    $con = mysqli_connect('localhost', 'root' , '', 'ai');
    $send = "";
    if(mysqli_connect_error()){
        echo "Failer connected";
        echo mysqli_connect_error();
    }else
    {
        $result = mysqli_query($con,"SELECT * FROM customer");
        while($row=mysqli_fetch_array($result)){
        $port=$row['cus_port'];


        $send=$send."$port" . ",";
        }
    }

    mysqli_close($con);
    //$content = file_get_contents("result.txt");
    //echo $content . "<br>";
    echo $send;


?>