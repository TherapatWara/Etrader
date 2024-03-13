<?php
    $received = trim($_GET['data']);
    $con=mysqli_connect('localhost','root', '', 'ai');
    //echo $received;
    $fileName = "./data.txt";

    file_put_contents($fileName, $received);
    $output = array();
    exec("python3 model1.py", $output);
    
    $content = file_get_contents("result.txt");
    echo $content ;
    ?>